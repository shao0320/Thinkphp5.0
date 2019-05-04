<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
class Login extends Controller
{
    public function register()
    {

        return  $this->fetch('register');
    }
    //登录页面
    public function login()
    {
        return $this->fetch('login');
    }
    public function logout()
    {
        //请求token信息验证信息
        $token = isset($_COOKIE['360_token']) ? $_COOKIE['360_token'] : "";
        echo $token;exit;
        $url = config('api_url');//请求接口的域名地址
        //调用退出的接口
        httpCurl($url."/api/logout","post", ['token'=>$token]);
        return $this->redirect('/index/login/login');
    }
}