<?php

namespace Mariojgt\EbayLaravel\Controllers;

use App\Http\Controllers\Controller;
use Mariojgt\EbayLaravel\Controllers\EbayController;

class EbayDemoController extends Controller
{
    /**
     * @return [blade view]
     */
    public function index()
    {
        $ebayManager    = new EbayController();
        $firstAuthLogin = $ebayManager->firstAuthAppToken();
        dd($firstAuthLogin);
    }
}
