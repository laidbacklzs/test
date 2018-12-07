<?php

namespace app\admin\controller;

use think\facade\Session;
use think\Request;
use app\admin\model\User;

class admin extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //

    }
    //显示登录页
    public function login()
    {
        return $this->fetch('login');
    }
    //
    public function checkLogin(Request $request)
    {
        $data=$request->param();
        //设置查询条件
        $map=['name'=>$data['name'],'password'=>sha1($data['password']),'status'=>1];
        $res=User::get(function ($query)use($data,$map){
            $query->where($map);
        });
        if ($res){
            Session::set('user_id',$res->id);
            Session::set('user_name',$res->name);
            Session::set('user_level',$res->is_admin);
            return ['message'=>'登录成功','status'=>1];
        }
        return ['message'=>'用户名或密码不正确','status'=>0];
    }
    public function logout()
    {
        Session::clear();
        $this->success('退出成功','login');
    }
    public function adminList()
    {
        $user=User::all();
        $count=User::count();
        $this->assign('user',$user);
        $this->assign('count',$count);
        return $this->fetch('admin_list');
    }

    /**
     * 显示添加用户页.
     *
     * @return \think\Response
     */
    public function add()
    {
       return $this->fetch('admin_add');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data=$request->param();
        $data['password']=sha1($data['password']);
        $res = User::create($data);
        if (is_null($res)){
             return ['message'=>'添加用户失败'];
        }
        return ['message'=>'添加成功'];
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit(Request $request)
    {
        $id=$request->param('id');
        $res=User::get(function ($query)use($id){
            $query->where(['id'=>$id]);
        });
        //模板赋值
        $this->assign('user',$res);
        //渲染编辑页面
        return $this->fetch('admin_edit');
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request)
    {

        $data = $request->param();
        $data['password']=sha1($data['password']);
        //设置条件
        $map=['id'=>$data['id']];
        $res=User::update($data,$map);
        if ($res){
            return ['message'=>'修改成功','status'=>1];
        }
        return ['status'=>0,'message'=>'修改失败'];
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
        $res=User::destroy($id)? '删除成功':'删除失败';
        return['message'=>$res];
    }
}
