<?php
namespace app\index\controller;
use think\Controller;
class Login extends Controller
{
  public function index()
  {
    return $this->fetch();
  }
  
  public function dologin()
  {
    $param = input('post.');
    if(empty($param['user_name'])){
      $this->error('用戶名不能為空');
    }
     if(empty($param['user_pwd'])){
      $this->error('密碼不能為空');
    }
    //驗證用戶名
    $has = db('users')->where('user_name',$param['user_name'])->find();
    if(empty($has)){
      $this->error('查無此用戶');
    }
    //驗證密碼
    if($has['user_pwd']!=md5($param['user_pwd'])){
      $this->error('密碼錯誤');
    }
    //紀錄用戶登入信息
    cookie('user_id', $has['id'], 3600); //效期1小時
    cookie('user_name', $has['user_name'], 3600); //效期1小時

    $this->redirect(url('index/index'));
  }
  
  public function loginOut()
  {
    cookie('user_id', null); 
    cookie('user_name', null); 

    $this->redirect(url('login/index'));
  }
  
}