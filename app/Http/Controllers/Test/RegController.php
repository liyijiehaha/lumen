<?php
namespace  App\Http\Controllers\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Laravel\Lumen\Routing\Controller as BaseController;
class RegController extends BaseController
{
//    public function reg(){
//        $data=file_get_contents("php://input");
//        $enc_data=base64_decode($data);
//        $jk=openssl_get_publickey('file://'.storage_path('app/keys/public.pem'));
//        openssl_public_decrypt($enc_data,$dec_data,$jk);
//        $response=[
//            'errno'=>0,
//            'msg'=>'ok',
//            'data'=>[
//                'data'=>$dec_data
//            ]
//        ];
//        die(json_encode($response,JSON_UNESCAPED_UNICODE));
//    }
//    public function login(Request $request){
//       return view('login/login');
//    }
//    public function logindo(Request $request){
//        $email=$request->input('email');
//        $pwd=$request->input('pwd');
//        $res= DB::table('api_users')->where(['email'=>$email])->first();
//        if($res){//账号存在
//            if(password_verify($pwd,$res->pwd)){//密码正确
//                $token=$this->user_token($res->id);
//                $redis_token_key='login_token:id'.$res->id;
//                Redis::set($redis_token_key,$token);
//                Redis::expire($redis_token_key,604800);
//                $reponse=[
//                    'errno'=>0,
//                    'msg'=>'ok',
//                    'data'=>[
//                        'token'=>$token
//                    ]
//                ];
//            }else{//密码错误
//                $reponse=[
//                    'errno'=>50002,
//                    'msg'=>'账号或密码错误',
//                ];
//            }
//        }else{//账号不存在
//            $reponse=[
//                'errno'=>50001,
//                'msg'=>'账号或密码错误',
//            ];
//        }
//        die(json_encode($reponse,JSON_UNESCAPED_UNICODE));
//    }

    public function regdo(Request $request){
        $data=$request->input();
        $method='AES-256-CBC';
        $key='xxyyzz';
        $option=OPENSSL_RAW_DATA;
        $iv='qwertyuiopasdfgh';
        $data=json_encode($data);
        $enc_str=openssl_encrypt($data,$method,$key,$option,$iv);
        $base64=base64_encode($enc_str);
        $url='https://lyjapi.chenyys.com/reg/regdo';
        $ch=curl_init();
        //设置curl
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$base64);
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plain']);
        //抓取curl
        $res=curl_exec($ch);
        $code=curl_errno($ch);
        //关闭curl资源
        curl_close($ch);
    }
    public function loginadddo(Request $request){
        $data=$request->input();
        $method='AES-256-CBC';
        $key='xxyyzz';
        $option=OPENSSL_RAW_DATA;
        $iv='qwertyuiopasdfgh';
        $data=json_encode($data);
        $enc_str=openssl_encrypt($data,$method,$key,$option,$iv);
        $base64=base64_encode($enc_str);
        $url='https://lyjapi.chenyys.com/reg/logindo';
        $ch=curl_init();
        //设置curl
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$base64);
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plain']);
        //抓取curl
        $res=curl_exec($ch);
        $code=curl_errno($ch);
        //关闭curl资源
        curl_close($ch);

    }
    public function userinfo(Request $request)
    {
        $id=$_GET['id'];
        $res=DB::table('api_users')->where(['id'=>$id])->first();
    }
}