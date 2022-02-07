<?php

return [
    // Current package
    'version'         => '0.0.1',

    // Ebay keys
    'ebay_is_live'         => env('EBAY_IS_LIVE', false),
    'ebay_client_id'       => env('EBAY_CLIENT_ID', ''),
    'ebay_dev_id'          => env('EBAY_DEV_ID', ''),
    'ebay_secret_id'       => env('EBAY_SECRET_ID', ''),
    // Demo mode if true anyone can acess the demo rotues
    'demo_mode'       => true,

    // You can get this in this link click add ebay redirect URL ///#3 https://developer.ebay.com/my/auth/?env=sandbox&index=0
    'ebay_runame' => '', // Required generete this in the link abot only workd in https

    // Ebay marketplaces id more information check ///#3 https://developer.ebay.com/my/api_test_tool?index=0
    'ebay_marketplace_id' => env('EBAY_MARKETPLACE_ID', 'EBAY_GB'),   // Uk Default
    'content_language'    => env('EBAY_MARKETPLACE_ID', 'GB'),        // Uk Default
    'ebay_currency'       => env('EBAY_CURRENCY', 'GBP'),             // Uk Default

    // Ebay api scopes more information check the documentation
    'ebay_api_scopes' => 'https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly'
];
