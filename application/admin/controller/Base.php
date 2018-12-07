<?php
namespace app\admin\controller;
use think\Controller;
use think\facade\Session;
class Base extends Controller
{
	 // 初始化
    protected function initialize()
    {

    }
    protected function isLogin()
    {
    	if (!Session::has('user_id')){
            $this->error('请您先登录','admin/login');
        }
    }

}