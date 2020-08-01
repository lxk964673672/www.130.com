<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function login(){
        return view('user.reg');
    }
    public function reg(){
        return view('user.login');
    }
}