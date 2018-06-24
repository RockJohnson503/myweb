<?php
require_once("../duomiphp/common.php");
require_once(duomi_INC."/core.class.php");
if($cfg_user==0)
{
	ShowMsg('系统已关闭会员功能，正在转向网站首页','/',0,2000);
	exit();
}

if($_SESSION['duomi_user_name'] != ''){
    $turl = $_SERVER['HTTP_REFERER'];
    if($turl == ""){
        $turl = "/";
    }
    header("Location:".$turl);;
    exit();
}

$svali = $_SESSION['duomi_ckstr'];
if($dopost=='login')
{
	$validate = empty($validate) ? '' : strtolower(trim($validate));
	if(($validate=='' || $validate != $svali) and $_SESSION['cfg_ac'] != "app")
	{
		ResetVdValue();
		ShowMsg('验证码不正确!','login.php');
		exit();
	}
	if($userid=='')
	{
		ShowMsg('请输入用户名!','login.php');
		exit();
	}
	if($pwd=='')
	{
		ShowMsg('请输入密码!','login.php');
		exit();
	}

    $pwd = substr(md5($pwd),5,20);
    $row1=$dsql->GetOne("select * from duomi_member where username='$userid' or email='$userid'");
    if(($row1['username']==$userid or $row1['email'] == $userid) and $row1['password']==$pwd)
    {
        $_SESSION['duomi_user_id'] = $row1['id'];
        $_SESSION['duomi_user_name'] = $row1['username'];
        $_SESSION['duomi_nick_name'] = $row1['nickname'];
        $_SESSION['duomi_user_group'] = $row1['gid'];
        $ip = GetIP();
        $system = get_system();
        $userid = $row1['username'];
        $sql = "insert into wanshi_login_info(u_name, l_ip, l_time, l_sys)
                values('$userid', '$ip', " . time() . ", '$system')";
        $dsql->ExecuteNoneQuery($sql);

        header("Location:/");
        exit();

    }
    else
    {
        if($row1['username']==$userid or $row1['email'] == $userid){
            header("Location:/member/login.php?err=1");
        }else{
            header("Location:/member/login.php?err=2");
        }
        exit();
    }
}
else
{
    $tempfile = duomi_ROOT."/member/html/login.html";
    if($_SESSION['cfg_ac'] == "app"){
        $tempfile = duomi_ROOT."/member/html/wanshi_login.html";
    }
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
	$pwderr = $iderr = "";
	if($err == 1){
	    $pwderr = "密码错误了!";
    }elseif($err == 2){
	    $iderr = "账号或邮箱不存在啊!";
    }
    $t=str_replace("{wanshi:pwderr}", $pwderr, $t);
	$t=str_replace("{wanshi:iderr}", $iderr,$t);
	$t=str_replace("{duomicms:member}", front_member(),$t);
    echo $t;
	exit();
}