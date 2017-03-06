<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;


/**
 * Class HomeController
 * @package App\Http\Controllers\Frontend
 */
class HomeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {

    }


    /**
     *
     */
    function index()
    {
        return view('frontend.home');
    }

    function memberList() {
        return view('frontend.member_list', [
            'expDrivers' => User::getExpdrivers(),
            'paidMembers' => User::getPaidMembers()
        ]);
    }

    function memberRegister() {
        return view('frontend.register');
    }

}
