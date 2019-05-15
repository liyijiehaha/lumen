<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class Checklogin
{
    public function handle($request, Closure $next)
    {
        $id=$_GET['id'];
        $token=$_GET['token'];
        $res=DB::table('api_users')->where(['id'=>$id])->first();
        if(empty($token) || empty($id)){
            $response=[
                'errno'=>60004,
                'msg'=>'参数不完整',
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        $key='login_token:id'.$request->input('id');
        $local_token=Redis::get($key);
        if($token){
            if($token==$local_token){//token有效
                //记录日志
                $content = json_encode($_GET);
                $time = date('Y-m-d H:i:s');
                is_dir('logs')or mkdir('logs',0777,true);
                $str = $time.$content."\n";
                file_put_contents("logs/token.log",$str,FILE_APPEND);
                $response=[
                    'errno'=>0,
                    'msg'=>'ok',
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }else{//token无效
                $response=[
                    'errno'=>60002,
                    'msg'=>'token无效',
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }
        }else{
            $response=[
                'errno'=>60003,
                'msg'=>'请先登录',
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }

    }

}
