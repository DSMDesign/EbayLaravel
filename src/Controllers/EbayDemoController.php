<?php

namespace Mariojgt\EbayLaravel\Controllers;

use App\Http\Controllers\Controller;
use Mariojgt\EbayLaravel\Controllers\EbayController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class EbayDemoController extends Controller
{
    /**
     * This fuction will be use to demontrage how to create new products using the api on ebay
     * @return [type]
     */
    public function index()
    {
        // Return a view
        return view('ebay.ebay_demo_create_product');
    }

    /**
     * Send the dummy date to the ebay api to create a new product
     * @param Request $request
     *
     * @return [type]
     */
    public function store(Request $request)
    {
        // Get the values from the request
        $title               = Request('title');
        $product_slug        = Request('product_slug');
        $brands              = Request('brands');
        $colors              = Request('colors');
        $product_description = Request('product_description');
        $upc                 = Request('upc');
        $condition           = Request('condition');
        $qty                 = Request('qty');

        // Start the ebay helper class
        $ebayManager       = new EbayController();
        // Request a new valid token to ebay api so we can use in the next request
        $ebayManager->getRefreshToken();

        // The product array we goin to send to ebay
        $productData = [
            'product' => [
                'title' => $title,
                'aspects' => [
                    'brands' => [
                        explode(',', $brands)
                    ],
                    'color' => [
                        explode(',', $colors)
                    ]
                ],
                'description' => $product_description,
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
                    'width'  => 15,
                    'unit'   => 'INCH'
                ],
                'packageType' => 'LETTER',
                'weight' => [
                    'value' => 2,
                    'unit'  => 'POUND'
                ]
            ],
            'availability' => [
                'shipToLocationAvailability' => [
                    'quantity' => 10
                ]
            ]
        ];

        // Create the inventory item on ebay not the product Offer
        $inventoryItem = $ebayManager->createInventoryItem($product_slug, $productData);

        // Create the location need to json type data
        $inventoryItemLocation = '
        {
            "location": {
                "address": {
                    "addressLine1": "2055 Hamilton Ave",
                    "addressLine2": "Building 3",
                    "city": "San Jose",
                    "stateOrProvince": "CA",
                    "postalCode": "95125",
                    "country": "US"
                }
            },
            "locationInstructions": "Open for drop-off only.",
            "name": "Warehouse-1",
            "merchantLocationStatus": "ENABLED",
            "locationTypes": [
                "WAREHOUSE"
            ],
            "operatingHours": [
                {
                    "dayOfWeek": "MONDAY",
                    "intervals": [
                        {
                            "open": "09:00:00",
                            "close": "12:00:00"
                        },
                        {
                            "open": "13:00:00",
                            "close": "18:00:00"
                        }
                    ]
                },
                {
                    "dayOfWeek": "TUESDAY",
                    "intervals": [
                        {
                            "open": "09:00:00",
                            "close": "15:00:00"
                        }
                    ]
                }
            ],
            "specialHours": [
                {
                    "date": "2016-10-19T00:09:00.000Z",
                    "intervals": [
                        {
                            "open": "09:00:00",
                            "close": "11:00:00"
                        }
                    ]
                }
            ]
        }';

        $locationStore = 'locationtest';
        // Create the inventory location if exist does nothing
        $responseInventory = $ebayManager->createInventoryLocation($locationStore, $inventoryItemLocation);

        // Create your offer on ebay
        $ebayOffer = '{
            "sku": "' . $product_slug . '",
            "marketplaceId": "' . config('ebayLaravel.ebay_marketplace_id') . '",
            "format": "FIXED_PRICE",
            "listingDescription": "<ul><li><font face=\"Arial\"><span style=\"font-size: 18.6667px;\"><p class=\"p1\">Test listing - do not bid or buy&nbsp;<\/p><\/span><\/font><\/li><li><p class=\"p1\">Built-in GPS.&nbsp;<\/p><\/li><li><p class=\"p1\">Water resistance to 50 meters.<\/p><\/li><li><p class=\"p1\">&nbsp;A new lightning-fast dual-core processor.&nbsp;<\/p><\/li><li><p class=\"p1\">And a display that\u2019s two times brighter than before.&nbsp;<\/p><\/li><li><p class=\"p1\">Full of features that help you stay active, motivated, and connected, Apple Watch Series 2 is designed for all the ways you move<\/p><\/li><\/ul>",
            "availableQuantity": 50,
            "quantityLimitPerBuyer": 1,
            "pricingSummary": {
                "price": {
                    "value": 0.99,
                    "currency": "' . config('ebayLaravel.ebay_currency') . '"
                }
            },
            "listingPolicies": {
                "fulfillmentPolicyId": "78842674011",
                "paymentPolicyId": "61019561011",
                "returnPolicyId": "61019560011"
            },
            "categoryId": "178086",
            "merchantLocationKey": "' . $locationStore . '",
            "tax": {
                "vatPercentage": 10.2,
                "applyTax": true,
                "thirdPartyTaxCategory": "Electronics"
            }
        }';

        // Get the response offer
        $responseOffer = $ebayManager->createOffer($ebayOffer);

        $offerId = null;
        // CHeckk if there is any errors
        if (!empty($responseOffer->json()['errors'])) {
            if ($responseOffer->json()['errors'][0]['message'] == 'A user error has occurred. Offer entity already exists.') {
                // means that the offer is alread places
                $offerId = $responseOffer->json()['errors'][0]['parameters'][0]['value'];
            }
        } else {
            $offerId = $responseOffer->json()['offerId'];
        }

        return view('ebay.ebay_demo_product_created', compact('offerId'));

        // Publish the offer in here
        $responseOffer = $ebayManager->publishOffer($offerId);
    }
}
