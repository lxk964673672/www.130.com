<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class OauthController extends Controller
{
    //github登录 回跳地址
    public function git(){
        //接受code
        $code=$_GET['code'];
        //换取access_token
        $this->getToken($code);
        echo '<pre>';print_r($_GET);echo '</pre>';
    }
//根据code 换取token
    protected function getToken($token){
           $url='https://github.com/login/oauth/access_token';


        //post接口 Guzzle or curl
        $token="";
        //拿到token 获取用户信息

        $this->getGithubUserInfo($token);
    }
    protected function  getGithubUserInfo($token){
        $url='https://api.github.com/user';
        //GET请求接口

    }
}