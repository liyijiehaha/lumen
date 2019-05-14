<?php
namespace  App\Http\Controllers\Test;
use Laravel\Lumen\Routing\Controller as BaseController;
class TestController extends   BaseController{
    public function code(){
        $method='AES-256-CBC';
        $key='xxyyzz';
        $option=OPENSSL_RAW_DATA;
        $iv='qwertyuiopasdfgh';
        $data=file_get_contents("php://input");
        $enc_str=base64_decode($data);
        $data=openssl_decrypt($enc_str,$method,$key,$option,$iv);
        var_dump($data);
    }
    public function fcode(){
        $data=file_get_contents("php://input");
        $enc_data=base64_decode($data);
        var_dump($enc_data);
        $jk=openssl_get_publickey('file://'.storage_path('app/keys/public.pem'));
        openssl_public_decrypt($enc_data,$dec_data,$jk);
        var_dump($dec_data).'<hr>';
    }
    public function testsign(){
       echo'<pre>'; print_r($_GET);echo '</pre>';
       $str=file_get_contents("php://input");
       echo'<pre>'; print_r($str);echo '</pre>';
       $rec_sign=$_GET['sign'];
       $pk=openssl_get_publickey('file://'.storage_path('app/keys/public.pem'));
       $rs=openssl_verify($str,base64_decode($rec_sign),$pk);
       var_dump($rs);
        if($rs != 1){
            die('验签错误');
        }else{
            "ok";
        }
    }
}