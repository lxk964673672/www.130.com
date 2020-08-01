<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class OauthController extends Controller
{
    //github登录 回跳地址
    public function git(){
        echo '<pre>';print_r($_GET);echo '</pre>';
    }
}