<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * UserController Class
 * @category            Controller
 * @DateOfCreation      19 March 2018 04:00 PM
 * @ShortDescription    This class shows the guest welcome and contains all functionality which are availble
 *                      without login too
 */
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function index()
    {
        return view('home.welcome');
    }
}
