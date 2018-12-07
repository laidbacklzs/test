<?php
namespace app\admin\controller;
use think\facade\Session;
use app\admin\model\User;
use app\admin\model\Article;
class Index extends Base
{
    public function index()
    {
        $this->isLogin();
        $username=Session::get('user_name');
        $this->assign('user_name',$username);
        return $this->fetch('index');
    }
    public function welcome()
    {
        //获取用户数量
        $userCount=User::Count();
        $artCount=Article::Count();
        $this->assign('userCount',$userCount);
        $this->assign('artCount',$artCount);
        return $this->fetch('welcome');
    }
}
