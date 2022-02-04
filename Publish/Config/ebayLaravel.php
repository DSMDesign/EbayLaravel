<?php

return [
    // Current package
    'version'         => '0.0.1',

    // Ebay keys
    'ebay_is_live'         => env('ebay_is_live', false),
    'ebay_client_id'       => env('EBAY_CLIENT_ID', ''),
    'ebay_dev_id'          => env('EBAY_DEV_ID', ''),
    'ebay_secret_id'       => env('EBAY_SECRET_ID', ''),
    // You can get this in this link https://developer.ebay.com/my/auth/?env=sandbox&index=0
    // Create a new Get a Token from eBay via Your Application
    'ebay_first_login_url' => 'mario_tarosso-mariotar-larave-gdyqs',

    // Ebay marketplaces id more information check ///#3 https://developer.ebay.com/my/api_test_tool?index=0
    'ebay_marketplace_id' => env('EBAY_MARKETPLACE_ID', 'EBAY_GB'),
    // Ebay api scopes
    'ebay_api_scopes' => 'https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly'
];
