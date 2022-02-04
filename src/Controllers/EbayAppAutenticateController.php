<?php

namespace Mariojgt\EbayLaravel\Controllers;

use App\Http\Controllers\Controller;
use Mariojgt\EbayLaravel\Controllers\EbayController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class EbayAppAutenticateController extends Controller
{
    /**
     * This fusction will redirect the user to the eBay login page and when comes back we will get the token
     * @return [external url]
     */
    public function index()
    {
        $ebayManager       = new EbayController();
        $firstAuthLoginUrl = $ebayManager->firstAplicationUse();
        return Redirect::to($firstAuthLoginUrl);
    }

    /**
     * @return [blade view]
     */
    public function autenticateToken(Request $request)
    {
        // Get the token from the request
        $code           = Request('code');
        $ebayManager    = new EbayController();
        $firstAuthLogin = $ebayManager->generateFullAcessToken($code);

        // Return a view
        return view('ebay.ebay_autenticated');
    }
}
