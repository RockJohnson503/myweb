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
    $row1=$dsql->GetOne("select username from duomi_member where username='$username'");
    if($row1['username'] == $username)
    {
        ShowMsg('用户已存在','reg.php');
        exit();
    }

    $row2=$dsql->GetOne("select email from duomi_member where email='$email'");
    if($row2['email'] == $email){
        ShowMsg('邮箱已注册','reg.php');
        exit();
    }

	$pwd = substr(md5($m_pwd),5,20);
	if($username) {
		$res = $dsql->ExecuteNoneQuery2("insert into duomi_member(username, nickname,password,email,regtime,state,gid,points)
                values('$username', '$username','$pwd','$email','$dtime','1','2','0')");
        if($res == 1){
            $row1=$dsql->GetOne("select * from duomi_member where username='$username'");
            $_SESSION['duomi_user_id'] = $row1['id'];
            $_SESSION['duomi_user_name'] = $row1['username'];
            $_SESSION['duomi_nick_name'] = $row1['nickname'];
            $_SESSION['duomi_user_group'] = $row1['gid'];
            $ip = GetIP();
            $system = get_system();
            $sql = "insert into wanshi_login_info(u_name, l_ip, l_time, l_sys)
                    values('$username', '$ip', " . time() . ", '$system')";
            $dsql->ExecuteNoneQuery($sql);

            ShowMsg("注册成功！", "/member",0,1000);
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
	$t=str_replace("{duomicms:member}", front_member(),$t);
	echo $t;
} 