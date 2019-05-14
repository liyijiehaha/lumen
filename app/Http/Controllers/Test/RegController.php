<?php
namespace  App\Http\Controllers\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Laravel\Lumen\Routing\Controller as BaseController;
class RegController extends BaseController
{
    public function reg(){
        $data=file_get_contents("php://input");
        $enc_data=base64_decode($data);
        $jk=openssl_get_publickey('file://'.storage_path('app/keys/public.pem'));
        openssl_public_decrypt($enc_data,$dec_data,$jk);
        $response=[
            'errno'=>0,
            'msg'=>'ok',
            'data'=>[
                'data'=>$dec_data
            ]
        ];
        die(json_encode($response,JSON_UNESCAPED_UNICODE));
    }
    public function login(Request $request){
       return view('login/login');
    }
    public function logindo(Request $request){
        $email=$request->input('email');
        $pwd=$request->input('pwd');
        $res= DB::table('api_users')->where(['email'=>$email])->first();
        if($res){//账号存在
            if(password_verify($pwd,$res->pwd)){//密码正确
                $token=$this->user_token($res->id);
                $redis_token_key='login_token:id'.$res->id;
                Redis::set($redis_token_key,$token);
                Redis::expire($redis_token_key,604800);
                $reponse=[
                    'errno'=>0,
                    'msg'=>'ok',
                    'data'=>[
                        'token'=>$token
                    ]
                ];
            }else{//密码错误
                $reponse=[
                    'errno'=>50002,
                    'msg'=>'账号或密码错误',
                ];
            }
        }else{//账号不存在
            $reponse=[
                'errno'=>50001,
                'msg'=>'账号或密码错误',
            ];
        }
        die(json_encode($reponse,JSON_UNESCAPED_UNICODE));
    }
    public function user_token($id){
        return $token=substr(md5($id.time().Str::random(10)),5,20);
    }
    public function regdo(Request $request){
        header('Access-Control-Allow-Origin:*');
        $email=$request->input('email');
        $pwd=$request->input('pwd');
        $repwd=$request->input('repwd');
        //检测密码是否一致
        if($pwd != $repwd){
            $reponse=[
                'errno'=>40001,
                'msg'=>'两次密码输入不一致',
            ];
            die(json_encode($reponse,JSON_UNESCAPED_UNICODE));
        }
        $email=DB::table('api_users')->where(['email'=>$email])->first();
        if($email){
            $reponse=[
                'errno'=>40003,
                'msg'=>'邮箱已存在',
            ];
            die(json_encode($reponse,JSON_UNESCAPED_UNICODE));
        }
        //密码加密处理
        $hash_pwd=password_hash($pwd,PASSWORD_DEFAULT);
        $data=[
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'pwd'=>$hash_pwd,
            'age'=>$request->input('age'),
            'sex'=>$request->input('sex'),
            'create_time'=>time()
        ];
        $res=DB::table('api_users')->insert($data);
        if($res){
            echo '成功';
        }else{
            //TODO
            $reponse=[
                'errno'=>40002,
                'msg'=>'添加失败',
            ];
            die(json_encode($reponse,JSON_UNESCAPED_UNICODE));
        }
    }
    public function loginadddo(Request $request){
        $email=$request->input('email');
        $pwd=$request->input('pwd');
        $res= DB::table('api_users')->where(['email'=>$email])->first();
        if($res){//账号存在
            if(password_verify($pwd,$res->pwd)){//密码正确
                $token=$this->user_token($res->id);
                $redis_token_key='login_token:id'.$res->id;
                Redis::set($redis_token_key,$token);
                Redis::expire($redis_token_key,604800);
                $reponse=[
                    'errno'=>0,
                    'msg'=>'ok',
                    'data'=>[
                        'token'=>$token
                    ]
                ];
            }else{//密码错误
                $reponse=[
                    'errno'=>50002,
                    'msg'=>'账号或密码错误',
                ];
            }
        }else{//账号不存在
            $reponse=[
                'errno'=>50001,
                'msg'=>'账号或密码错误',
            ];
        }
        die(json_encode($reponse,JSON_UNESCAPED_UNICODE));
    }
}