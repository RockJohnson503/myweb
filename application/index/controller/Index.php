<?php
namespace app\index\controller;

use think\response\View;
use think\Db;
use think\Controller;
class Index extends Controller
{
    public function index()
    {

       return view();

         }
    public function video(){


        return view();
    }
    public  function login(){

        return View();


    }
    public function login1(){
         $date=input();
        dump($date);

        $num=$date["num"];

        $code1=Db::table('qquser')->where('num',$num)->select();


        if ($code1!=null){
            $this->success('登陆成功', "Index/index?num=$num");

        }else{
            $code=Db::table('qquser')->insert($date);
            $this->success('登陆成功', "Index/index?num=$num");
        }




//        if($code>1){
//
//        }else{
//            $this->error('登录失败');
//        }




    }



}
