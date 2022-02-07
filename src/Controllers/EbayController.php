<?php

namespace Mariojgt\EbayLaravel\Controllers;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Storage;
use File;

/**
 * This Controller will manage the ebay integration for us in order to use you need to create a new app in ebay and get the keys
 * @author Mario jose goes tarosso <
 * This api is organiae in the order you need to use it
 * [Description EbayController]
 */
class EbayController extends Controller
{
    public $bearerToken;
    public $endPoint;
    private $tokenTxtFile = 'ebay_token.txt';

    /**
     * ///#1 This fuction will redirect the user to ebay and once is autenticate it will return back to this page with the token
     * This fuction will create a urel that we have to redirect the user to and on return we will get the token
     * @return [type]
     */
    public function firstAplicationUse()
    {
        // Note that is a diferencet endpoint in here
        if (config('ebayLaravel.ebay_is_live')) {
            $firstEndpoint = 'https://auth.ebay.com/';
        } else {
            $firstEndpoint = 'https://auth.sandbox.ebay.com/';
        }
        // Build the login url
        $url = $firstEndpoint . "/oauth2/authorize?client_id=" . config('ebayLaravel.ebay_client_id') . "&redirect_uri=" . config('ebayLaravel.ebay_runame') . "&response_type=code&scope=" . config('ebayLaravel.ebay_api_scopes') . "&prompt=login";
        return $url;
    }

    /**
     * ///#2 - Base on the code of return we goin to get the token
     * This fuction will get the user token back from the login screen and we will autenticate with ebay and return the full token
     * @return [type]
     */
    public function generateFullAcessToken($code)
    {
        // If the file exists we will just return the file data
        if ($this->readEbayToken()['status']) {
            return $this->readEbayToken()['data'];
        }
        // Check if is in live or sandbox mode
        if (config('ebayLaravel.ebay_is_live')) {
            $this->endPoint = 'https://api.ebay.com/';
        } else {
            $this->endPoint = 'https://api.sandbox.ebay.com/';
        }

        // Sending the request to xero with the normal authorization and form data
        $response = Http::withBasicAuth(config('ebayLaravel.ebay_client_id'), config('ebayLaravel.ebay_secret_id'))
            ->asForm()
            ->post(
                $this->endPoint . 'identity/v1/oauth2/token',
                [
                    'grant_type'   => 'authorization_code',
                    'code'         => $code,
                    'redirect_uri' => config('ebayLaravel.ebay_runame'),
                ]
            );

        // If there is an error we will return the error
        if (!empty($response->json()['error'])) {
            throw new \Exception($response->json()['error_description'] . ' Try Login again, or contact the developers');
        } else {
            // Now we will save the token in the in the storate as a text file
            $txtFileData = json_encode($response->json());
            $fileName    = 'ebay_token.txt';
            Storage::put($fileName, $txtFileData);

            return $response->json();
        }
    }

    /**
     * ///#2 - This function will read the token from the file and return it bue we goin to use this in other requests
     * //* This Fuction will get the token from the storage file and return it the data
     * @return [type]
     */
    private function readEbayToken()
    {
        // Just for reference
        //File::get(storage_path('app/' . $this->tokenTxtFile))
        $result = File::exists(storage_path('app/' . $this->tokenTxtFile));
        if ($result) {
            return [
                'status' => true,
                'data'   => json_decode(Storage::get($this->tokenTxtFile)),
            ];
        } else {
            return [
                'status' => false
            ];
        }
    }

    /**
     * We goin to use this fuction so we can prevent other user to autenticate ebay
     *
     * @return [type]
     */
    public function applicationAuthenticated()
    {
        return $this->readEbayToken()['data'];
    }

    /**
     * /#1 Get the bearer token from the eBay using API client and secret
     * @return [type]
     */
    public function getRefreshToken()
    {
        $userRefreshToken = $this->readEbayToken()['data']->refresh_token;
        // Check if is in live or sandbox mode
        if (config('ebayLaravel.ebay_is_live')) {
            $this->endPoint = 'https://api.ebay.com/';
        } else {
            $this->endPoint = 'https://api.sandbox.ebay.com/';
        }

        // Sending the request to xero with the normal authorization and form data
        $response = Http::withBasicAuth(config('ebayLaravel.ebay_client_id'), config('ebayLaravel.ebay_secret_id'))
            ->asForm()
            ->post(
                $this->endPoint . 'identity/v1/oauth2/token',
                [
                    'grant_type'    => 'refresh_token',
                    'refresh_token' => $userRefreshToken,
                    'scope'         => config('ebayLaravel.ebay_api_scopes'),
                ]
            );

        // Return the refresh token so we can use in other request
        if ($response->status() == 200) {
            // Set the acesstoken in the header so we can use it in the next requests
            $this->bearerToken = $response->json()['access_token'];
            return $response->json();
        } else {
            throw new \Exception('Ebay CLient or Secret is not valid please generate one following on this link https://developer.ebay.com/my/keys');
        }
    }

    public function ContentLanguage()
    {
    }

    // This function will create the or replace the inventory item in ebay ,basicly we will create or update a product
    public function createInventoryItem($productSKu, $productData)
    {
        // Sedn the request to the xero controller with aplication/json and send the invoice array
        $responseProductCreation = Http::acceptJson()
            ->withHeaders([
                'Content-Language' => 'en-' . config('ebayLaravel.content_language'),
            ])
            ->withToken($this->bearerToken) // This is the token comes from the xero controller
            ->withBody(json_encode($productData), 'application/json')
            ->put($this->endPoint . 'sell/inventory/v1/inventory_item/' . $productSKu); // End point
        // Get the response code
        $responseCode = $responseProductCreation->status();

        return $responseProductCreation->json();
    }

    /**
     * Create a inventory location so we can Offer products
     * @param mixed $inventoryItemLocation
     *
     * @return [type]
     */
    public function createInventoryLocation($location, $inventoryItemLocation)
    {
        // Sedn the request to the xero controller with aplication/json and send the invoice array
        $responseProductCreation = Http::acceptJson()
            ->withHeaders([
                'Content-Language' => 'en-' . config('ebayLaravel.content_language'),
            ])
            ->withToken($this->bearerToken) // This is the token comes from the xero controller
            ->withBody($inventoryItemLocation, 'application/json')
            ->post($this->endPoint . 'sell/inventory/v1/location/' . $location); // End point

        return $responseProductCreation;
    }

    /**
     * Get the inventory item from ebay
     * @param mixed $productSKu
     * @param mixed $productData
     *
     * @return [type]
     */
    public function getInventoryItemId($productSKu)
    {
        // Sedn the request to the xero controller with aplication/json and send the invoice array
        $responseProductCreation = Http::acceptJson()
            ->withHeaders([
                'Content-Language' => 'en-' . config('ebayLaravel.content_language'),
            ])
            ->withToken($this->bearerToken) // This is the token comes from the xero controller
            ->get($this->endPoint . 'sell/inventory/v1/inventory_item/' . $productSKu); // End point
        // Get the response code
        $responseCode = $responseProductCreation->status();

        return $responseProductCreation->json();
    }

    /**
     * Create a offer on ebay for the product
     * @param mixed $offerItem
     *
     * @return [type]
     */
    public function createOffer($offerItem)
    {
        // Sedn the request to the xero controller with aplication/json and send the invoice array
        $responseProductCreation = Http::acceptJson()
            ->withHeaders([
                'Content-Language' => 'en-' . config('ebayLaravel.content_language'),
            ])
            ->withToken($this->bearerToken) // This is the token comes from the xero controller
            ->withBody($offerItem, 'application/json')
            ->post($this->endPoint . 'sell/inventory/v1/offer'); // End point

        return $responseProductCreation;
    }

    /**
     * Publish the offer on ebay
     * @param mixed $offerItem
     *
     * @return [type]
     */
    public function publishOffer($offerId)
    {
        // Sedn the request to the xero controller with aplication/json and send the invoice array
        $response = Http::acceptJson()
            ->withHeaders([
                'Content-Language' => 'en-' . config('ebayLaravel.content_language'),
            ])
            ->withToken($this->bearerToken) // This is the token comes from the xero controller
            ->post($this->endPoint . 'sell/inventory/v1/offer/' . $offerId . '/publish'); // End point

        return $response;
    }
}
