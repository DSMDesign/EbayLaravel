<?php

namespace Mariojgt\EbayLaravel\Controllers;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class EbayController extends Controller
{
    public $bearerToken;
    public $endPoint;

    public function __construct()
    {
        // Request the bearer token using the eBay API client and secret
        $this->bearerToken = $this->generateAcessTokenClient();
    }

    public function firstAuthAppToken()
    {
        if (config('ebayLaravel.ebay_is_live')) {
            $firstEndpoint = 'https://auth.ebay.com/';
        } else {
            $firstEndpoint = 'https://auth.sandbox.ebay.com/';
        }

        $url = $firstEndpoint . "oauth2/authorize?client_id=" . config('ebayLaravel.ebay_client_id') . "&response_type=code&redirect_uri=" . config('ebayLaravel.ebay_first_login_url') . "&scope=" . config('ebayLaravel.ebay_api_scopes');
        return $url;
    }

    /**
     * /#1 Get the bearer token from the eBay using API client and secret
     * @return [type]
     */
    public function generateAcessTokenClient()
    {
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
                    'grant_type' => 'client_credentials',
                    // 'scope'      => config('ebayLaravel.ebay_api_scopes'),
                ]
            );

        if ($response->status() == 200) {
            return $response->json();
        } else {
            throw new \Exception('Ebay CLient or Secret is not valid please generate one following on this link https://developer.ebay.com/my/keys');
        }
    }

    public function addItemForSale($productSKu)
    {
        $productData = [
            'product' => [
                'title' => 'Test listing - do not bid or buy - awesome Apple watch test 2',
                'aspects' => [
                    'brands' => [
                        'Apple',
                    ],
                    'color' => [
                        'Black',
                    ],
                    'material' => [
                        'Plastic',
                    ],
                ],
                'description' => 'My product description',
                'upc' => ['888462079525'],
                'imageUrls' => [
                    "http://store.storeimages.cdn-apple.com/4973/as-images.apple.com/is/image/AppleInc/aos/published/images/S/1/S1/42/S1-42-alu-silver-sport-white-grid?wid=332&hei=392&fmt=jpeg&qlt=95&op_sharpen=0&resMode=bicub&op_usm=0.5,0.5,0,0&iccEmbed=0&layer=comp&.v=1472247758975",
                    "http://store.storeimages.cdn-apple.com/4973/as-images.apple.com/is/image/AppleInc/aos/published/images/4/2/42/stainless/42-stainless-sport-white-grid?wid=332&hei=392&fmt=jpeg&qlt=95&op_sharpen=0&resMode=bicub&op_usm=0.5,0.5,0,0&iccEmbed=0&layer=comp&.v=1472247760390",
                    "http://store.storeimages.cdn-apple.com/4973/as-images.apple.com/is/image/AppleInc/aos/published/images/4/2/42/ceramic/42-ceramic-sport-cloud-grid?wid=332&hei=392&fmt=jpeg&qlt=95&op_sharpen=0&resMode=bicub&op_usm=0.5,0.5,0,0&iccEmbed=0&layer=comp&.v=1472247758007"
                ]
            ],
            'condition' => 'NEW',
            'packageWeightAndSize' => [
                'dimensions' => [
                    'height' => 5,
                    'length' => 10,
                    'width' => 15,
                    'unit' => 'INCH'
                ],
                'packageType' => 'MAILING_BOX',
                'weight' => [
                    'value' => 2,
                    'unit' => 'POUND'
                ]
            ],
            'availability' => [
                'shipToLocationAvailability' => [
                    'quantity' => 10
                ]
            ]
        ];

        // Sedn the request to the xero controller with aplication/json and send the invoice array
        $responseProductCreation = Http::acceptJson()
            ->withHeaders([
                'Content-Language' => 'en-US',
            ])
            ->withToken($this->bearerToken) // This is the token comes from the xero controller
            ->withBody(json_encode($productData), 'application/json')
            ->put($this->endPoint . 'sell/inventory/v1/inventory_item/' . $productSKu); // End point
        dd($responseProductCreation->json());
    }
}
