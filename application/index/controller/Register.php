<?php
namespace app\index\controller;
use think\Controller;
class Register extends Controller
{
  public function index()
  {
    return $this->fetch();
  }
  
  public function doregister()
  {
    $param = input('post.');
    if(empty($param['user_name'])){
      $this->error('用戶名不能為空');
    }    
    //驗證用戶名是否存在
    $has = db('users')->where('user_name',$param['user_name'])->find();
    if(!empty($has)){
      $this->error('該用戶名已有人使用');
    }
    if(empty($param['user_pwd'])){
      $this->error('密碼不能為空');
    }
    if($param['user_pwd']!=$param['user_pwd_again']){
      $this->error('兩次密碼輸入不一致');
    }
    
    $data = ['user_name' => $param['user_name'], 'user_pwd' => md5($param['user_pwd'])];
	db('users')->insert($data);
    
	echo'註冊成功 ,<a href="'.url('login/index').'">登入</a>';
	
  }
}