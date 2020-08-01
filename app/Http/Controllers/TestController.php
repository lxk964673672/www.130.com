<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class TestController extends Controller
{
    //向api发送加密数据
    public function aes1(){

        $method='AES-256-CBC';
        $key='1911api';
        $iv='aaaabbbbccccxxxx';
        $option=OPENSSL_RAW_DATA;

        $url='http://api.140.com/test/dec'; //api接口地址
        $data='hellow word'; //待加密数据

        $enc_data=openssl_encrypt($data,$method,$key,$option,$iv);
//        echo "密文: ".$enc_data;echo '</br>';
        $b64_str=base64_encode($enc_data); //base64编码
//        echo "base64: ".$b64_str;echo '</br>';
        $client=new Client();
        $response=$client->request('POST',$url,[
            'form_params'=>[
               'data'=> $b64_str
            ]
        ]);
        echo $response->getBody(); //响应数据
    }

    public  function aesdec(){


        $priv_key=openssl_get_publickey(file_get_contents(storage_path('keys/priv.key')));
        openssl_private_decrypt($enc_data,$dec_data,$priv_key);
        echo '解密:'.$dec_data;
    }

    //签名测试
    public function sign1(){
        $data="Hello world";
        $key='1911api';

        $sign_str=sha1($data . $key); //签名

        //发送数据 （数据+签名）
        $url='http://api.140.com/test/sign1?data='.$data.'&sign='.$sign_str;
        $response=file_get_contents($url);
        echo $response;
    }

    //header传参
    public function  header1(){

        $url="http://api.140.com/test1";
        $uid=999999;
        $token='abcd';
        //header 传参
        $headers=[
            'uid:'.$uid,
//            'token:'.$token,
        ];
        //curl
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);//header 头部传参
        curl_exec($ch);
        curl_close($ch);

    }
    //跳转支付宝支付
    public function pay(Request $request)
    {
        $oid = $request->get('oid');
        //echo '订单ID： '. $oid;
        //根据订单查询到订单信息  订单号  订单金额

        //调用 支付宝支付接口

        // 1 请求参数
        $param2 = [
            'out_trade_no'      => time().mt_rand(11111,99999),
            'product_code'      => 'FAST_INSTANT_TRADE_PAY',
            'total_amount'      => 0.01,
            'subject'           => '1911-测试订单-'.Str::random(16),
        ];

        // 2 公共参数
        $param1 = [
            'app_id'        => '2016102000727763',
            'method'        => 'alipay.trade.page.pay',
            'return_url'    => 'http://1911lxk.comcto.com/return',   //同步通知地址
            'charset'       => 'utf-8',
            'sign_type'     => 'RSA2',
            'timestamp'     => date('Y-m-d H:i:s'),
            'version'       => '1.0',
            'notify_url'    => 'http://1911lxk.comcto.com/notify',   // 异步通知
            'biz_content'   => json_encode($param2),
        ];

        //echo '<pre>';print_r($param1);echo '</pre>';
        // 计算签名
        ksort($param1);
        //echo '<pre>';print_r($param1);echo '</pre>';

        $str = "";
        foreach($param1 as $k=>$v)
        {
            $str .= $k . '=' . $v . '&';
        }

        $str = rtrim($str,'&');     // 拼接待签名的字符串

        $sign = $this->sign($str);
        echo $sign;echo '<hr>';

        //沙箱测试地址
        $url = 'https://openapi.alipaydev.com/gateway.do?'.$str.'&sign='.urlencode($sign);
        return redirect($url);
        //echo $url;
    }



    protected function sign($data)
    {
//        if ($this->checkEmpty($this->rsaPrivateKeyFilePath)) {
//            $priKey = $this->rsaPrivateKey;
//
//            $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
//                wordwrap($priKey, 64, "\n", true) .
//                "\n-----END RSA PRIVATE KEY-----";
//        } else {
//            $priKey = file_get_contents($this->rsaPrivateKeyFilePath);
//            $res = openssl_get_privatekey($priKey);
//        }

        $priKey = file_get_contents(storage_path('keys/ali_priv.key'));
        $res = openssl_get_privatekey($priKey);
        var_dump($res);echo '<hr>';

        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');

        openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        openssl_free_key($res);
        $sign = base64_encode($sign);
        return $sign;
    }
    public function goods(){
        return view('goods');
    }
}