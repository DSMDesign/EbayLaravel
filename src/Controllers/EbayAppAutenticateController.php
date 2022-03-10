<?php

namespace EbayIntegration\EbayLaravel\Controllers;

use App\Http\Controllers\Controller;
use EbayIntegration\EbayLaravel\Controllers\EbayController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class EbayAppAutenticateController extends Controller
{
    /**
     *! This fuction will redirect the user to the eBay login page and when comes back we will get the code
     *! used to get the token.
     * @return [external url]
     */
    public function index()
    {
        // Start the ebay class
        $ebayManager   = new EbayController();
        // Check if the user has autorized the appliacation
        $isAutenticate = $ebayManager->applicationAuthenticated();
        if ($isAutenticate == true) {
            // If the user has autorized the appliacation we will redirect to the 404 page
            return abort(404);
        } else {
            // Regenrate the url we goin to use to redirect the user
            $firstAuthLoginUrl = $ebayManager->firstAplicationUse();
            // Redirect the user to this url
            return Redirect::to($firstAuthLoginUrl);
        }
    }

    /**
     * Once the user authorized the application we will get the code and get the token
     * @return [blade view]
     */
    public function autenticateToken(Request $request)
    {
        // Start the ebay helper class
        $ebayManager    = new EbayController();
        // Check if the user has autorized the appliacation
        $isAutenticate = $ebayManager->applicationAuthenticated();
        if ($isAutenticate == true) {
            // If the user has autorized the appliacation we will redirect to the 404 page
            return abort(404);
        } else {
            // Get the token from the request
            $code           = Request('code');
            // Get the request code and call ebay to autenticate the code and generate a token
            $ebayManager->generateFullAcessToken($code);
            // Once this token is generate we can use to call ebay api request
            // Return a view
            return view('ebay.ebay_autenticated');
        }
    }
}
