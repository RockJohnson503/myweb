<?php
session_start();
require_once("../duomiphp/common.php");
require_once(duomi_INC.'/core.class.php');
if($cfg_user==0)
{
	ShowMsg('系统已关闭会员功能，正在转向网站首页','/',0,2000);
	exit();
}

$svali = $_SESSION['duomi_ckstr'];
$action = isset($action) ? trim($action) : '';
if($action=='reg')
{
$dtime = time();
$ip = GetIp();

$validate = empty($validate) ? '' : strtolower(trim($validate));

if($validate=='' || $validate != $svali)
	{
		ResetVdValue();
		ShowMsg('验证码不正确!','reg.php');
		exit();
	}

if(trim($m_pwd)<>trim($m_pwd2) || trim($m_pwd)=='')
	{
		ShowMsg('两次输入密码不一致或密码为空','reg.php');	
		exit();	
	}	
	
$username = $m_user;
$row1=$dsql->GetOne("select username  from duomi_member where username='$username'");
if($row1['username']==$username)
{
		ShowMsg('用户已存在','reg.php');	
		exit();	
}

	$pwd = substr(md5($m_pwd),5,20);
	if($username) {
		$res = $dsql->ExecuteNoneQuery2("INSERT INTO `duomi_member`(id,username, nickname,password,email,regtime,loginip,state,gid,points,logintime)
                  VALUES ('','$username', '$username','$pwd','$email','$dtime','$ip','1','2','0','$dtime')");
                if($res == 1){
		      ShowMsg('恭喜您，注册成功！','login.php',0,1000);
         	      exit();
                }else{
                      ShowMsg('注册失败', 'reg.php', 0, 1000);
                }
	}
}
else
{
	$tempfile = duomi_ROOT."/member/html/reg.html";
	$content=loadFile($tempfile);
	$t=$content;
	$t=$mainClassObj->parseTopAndFoot($t);
	$t=$mainClassObj->parseHistory($t);
	$t=$mainClassObj->parseSelf($t);
	$t=$mainClassObj->parseGlobal($t);
	$t=$mainClassObj->parduomireaList($t);
	$t=$mainClassObj->parseMenuList($t,"");
	$t=$mainClassObj->parseVideoList($t,-444);
	$t=$mainClassObj->parseNewsList($t,-444);
	$t=$mainClassObj->parseTopicList($t);
	$t=replaceCurrentTypeId($t,-444);
	$t=$mainClassObj->parseIf($t);
	$t=str_replace("{duomicms:member}",front_member(),$t);
	echo $t;

} 