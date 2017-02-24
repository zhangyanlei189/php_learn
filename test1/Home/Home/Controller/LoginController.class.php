<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/28
 * Time: 11:29
 */
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {

    //登陆
    public function  index(){
        if(IS_POST){
            $name = $_POST["username"];
            $password = $_POST["password"];
            $m = M("user");
            $where = array(name=>$name,password=>md5($password));
            $user = $m->where($where)->find();
            if ($user){
                echo json_encode(array(flag=>true,mess=>"登陆成功"));
            }else{
                $result["flag"] = false;
                $result["mess"] = "账号或密码错误";
                echo json_encode($result);
            }
        }else{
            $this->display();
        }
    }
    //注册
    public function  register(){
        if(IS_POST){
            $name = $_POST["username"];
            $password = $_POST["password"];
            $pass = md5($password);
            $m = M("user");
            $userData = array(name=>$name,password=>$pass,level=>2);
            $addInfo = $m->add($userData);
            if($addInfo){
                echo json_encode(array(flag=>true,mess=>"添加成功"));
            }else{
                echo json_encode(array(flag=>false,mess=>"添加失败"));
            }
        }else{
            $this->display();
        }
    }

    //找回密码
    public  function findPass(){
        if(IS_POST){

        }else{
            $this->display();
        }
    }
}