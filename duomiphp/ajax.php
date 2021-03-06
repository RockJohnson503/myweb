﻿<?php
/**
 * ajax
 *
 * @version        2015年7月12日Z by 海东青
 * @package        DuomiCms.Administrator
 * @copyright      Copyright (c) 2015, SamFea, Inc.
 * @link           http://www.duomicms.net
 */
require_once('common.php');

AjaxHead();
$action = isset($action) ? trim($action) : '';
$id = (isset($id) && is_numeric($id)) ? $id : 0;
if($action=="" or empty($action))
{
	exit();
}
switch ($action) {
	case "digg":
	case "tread":
	case "score":
		echo scoreVideo($action);
	break;
	case "diggnews":
	case "treadnews":
	case "scorenews":
		echo scoreNews($action);
	break;
	case "hit":
		echo updateHit();
	break;
	case "hitnews":
		echo updateHitNews();
	break;
	case "addfav":
		echo addfav();
	break;
	case "videoscore":
	case "newsscore":
		echo getScore($action);
	break;
	case "vpingfen":
		echo vpingfen($action);
	break;
	case "npingfen":
		echo npingfen($action);
	break;
	case "member":
		echo member();
	break;
    case "playhistory":
        echo playhistory(isset($video) ? trim($video) : '',
            isset($url) ? trim($url) : '',
            isset($v_id) ? trim($v_id) : '');
    break;
    case "checkreg":
        echo checkreg();
    break;
    case "checkcaptcha":
        echo checkcaptcha();
    break;
}

function checkreg()
{
    $lifeTime = 600;
    session_set_cookie_params($lifeTime);

    $email = $_POST['email'];

    $param = str_pad(mt_rand(0, 999999), 6, "0", STR_PAD_BOTH);

    $_SESSION["param"] = $param;
    return send($email, $param);
}

function checkcaptcha(){
    $captcha = $_POST['param'];

    if ($captcha != $_SESSION["param"])
    {
        return 1;
    }
}

function playhistory($video, $url, $v_id){
       global $dsql;
       $user_name = $_SESSION["duomi_user_name"];
       if($user_name == ""){
           $user_name = GetIP();
       }
       $time = time();
       $system = get_system();
       $sql = "select 2 from wanshi_play_history where u_name='$user_name' and p_url = '$url'";
       $res = $dsql->ExecuteNoneQuery2($sql);
       if($res > 0){
           $sql = "update wanshi_play_history set p_time='$time', u_sys='$system' where u_name='$user_name' and p_url='$url'";
       }else{
           $sql = "insert into wanshi_play_history(u_name, u_sys, p_info, p_time, p_url, v_id) values('$user_name', '$system', '$video', $time, '$url', '$v_id')";
       }
       $res = $dsql->ExecuteNoneQuery2($sql);
       if($res > 0){
           return "ok";
       }else{
           return "err";
       }
}

function getScore($operType){
	global $id,$dsql;
	if($operType=="videoscore")
	{
		$sql="select v_digg,v_tread,v_score,v_scorenum from duomi_data where v_id=".$id;
		$row=$dsql->GetOne($sql);
		if(is_array($row))
		{
			return "[".$row['v_digg'].",".$row['v_tread'].",".$row['v_score'].",".$row['v_scorenum']."]";
		}else{
			return 0;
		}
	}elseif($operType=="newsscore")
	{
		$sql="select n_digg,n_tread,n_score,n_scorenum from duomi_news where n_id=".$id;
		$row=$dsql->GetOne($sql);
		if(is_array($row))
		{
			return "[".$row['n_digg'].",".$row['n_tread'].",".$row['n_score'].",".$row['n_scorenum']."]";
		}else{
			return 0;
		}
	}else{
		return "err";
	}
}

function scoreVideo($operType){
	global $id,$dsql,$score;
	
	if($id < 1) return "err";
	if ($operType=="digg") {
		if(GetCookie("sduomi2_score".$id)=="ok") return "havescore";
		$dsql->ExecuteNoneQuery("Update `duomi_data` set v_digg = v_digg + 1 where v_id=$id");
		$row = $dsql->GetOne("Select v_digg From `duomi_data` where v_id=$id ");
		if(is_array($row))
		{
			$digg=$row['v_digg'];
		}else{
			$digg=0;
		}
		PutCookie("sduomi2_score".$id,"ok",3600 * 24,'/');
		return $digg;
	}elseif($operType=="tread"){
		if(GetCookie("sduomi2_score".$id)=="ok") return "havescore";
		$dsql->ExecuteNoneQuery("Update `duomi_data` set v_tread = v_tread + 1 where v_id=$id");
		$row = $dsql->GetOne("Select v_tread From `duomi_data` where v_id=$id ");
		if(is_array($row))
		{
			$tread=$row['v_tread'];
		}else{
			$tread=0;
		}
		PutCookie("sduomi2_score".$id,"ok",3600 * 24,'/');
		return $tread;
	}elseif($operType=="score"){
		if(GetCookie("sduomi3_score".$id)=="ok") return "havescore";
		$dsql->ExecuteNoneQuery("Update `duomi_data` set v_scorenum=v_scorenum+1,v_score=v_score+".$score." where v_id=$id");
		PutCookie("sduomi3_score".$id,"ok",3600 * 24,'/');
		return '';
	}else{
		return "err";
	}
}

function scoreNews($operType){
	global $id,$dsql,$score;
	
	if($id < 1) return "err";
	if ($operType=="diggnews") {
		if(GetCookie("sduomi2_newsscore".$id)=="ok") return "havescore";
		$dsql->ExecuteNoneQuery("Update `duomi_news` set n_digg = n_digg + 1 where n_id=$id");
		$row = $dsql->GetOne("Select n_digg From `duomi_news` where n_id=$id ");
		if(is_array($row))
		{
			$digg=$row['n_digg'];
		}else{
			$digg=0;
		}
		PutCookie("sduomi2_newsscore".$id,"ok",3600 * 24,'/');
		return $digg;
	}elseif($operType=="treadnews"){
		if(GetCookie("sduomi2_newsscore".$id)=="ok") return "havescore";
		$dsql->ExecuteNoneQuery("Update `duomi_news` set n_tread = n_tread + 1 where n_id=$id");
		$row = $dsql->GetOne("Select n_tread From `duomi_news` where n_id=$id ");
		if(is_array($row))
		{
		$tread=$row['n_tread'];
		}else{
			$tread=0;
		}
		PutCookie("sduomi2_newsscore".$id,"ok",3600 * 24,'/');
		return $tread;
	}elseif($operType=="scorenews"){
		if(GetCookie("sduomi3_newsscore".$id)=="ok") return "havescore";
		$dsql->ExecuteNoneQuery("Update `duomi_news` set n_scorenum=n_scorenum+1,n_score=n_score+".$score." where n_id=$id");
		PutCookie("sduomi3_newsscore".$id,"ok",3600 * 24,'/');
		return '';
	}else{
		return "err";
	}
}

function updateHit(){
	global $id,$dsql;
	if($id < 1) return "err";
	$dsql->ExecuteNoneQuery("update `duomi_data` set v_hit = v_hit + 1, v_dayhit = v_dayhit + 1, v_weekhit = v_weekhit + 1, v_monthhit = v_monthhit + 1 where v_id=$id");
	$row = $dsql->GetOne("select v_hit from `duomi_data` where v_id=$id ");
	if(is_array($row))
	{
		$hit=$row['v_hit'];
	}else{
		return "err";
	}
	return $hit;
}

function updateHitNews(){
	global $id,$dsql;
	if($id < 1) return "err";
	$dsql->ExecuteNoneQuery("Update `duomi_news` set n_hit = n_hit + 1 where n_id=$id");
	$row = $dsql->GetOne("Select n_hit From `duomi_news` where n_id=$id ");
	if(is_array($row))
	{
		$hit=$row['n_hit'];
	}else{
		return "err";
	}
	return $hit;
}

function addfav(){
	global $id,$uid,$dsql;
	if(intval($uid) < 1) return "err";
	$row = $dsql->GetOne("Select id From `duomi_favorite` where vid=$id and uid=$uid ");
	if(!is_array($row))
	{
		$dsql->ExecuteNoneQuery("insert into `duomi_favorite` values('','$uid','$id','".time()."')");
	}
	return "ok";
}

function vpingfen(){
	global $id,$dsql;
	$row = $dsql->GetOne("Select v_score,v_scorenum From `duomi_data` where v_id=$id ");
	$num=$row['v_scorenum']; 
	$sum=$row['v_score']; 
	$sc=number_format($sum/$num,1);
	return "$num,$sum,$sc";
}

function npingfen(){
	global $id,$dsql;
	$row = $dsql->GetOne("Select n_score,n_scorenum From `duomi_news` where n_id=$id ");
	$num=$row['n_scorenum']; 
	$sum=$row['n_score']; 
	$sc=number_format($sum/$num,1);
	return "$num,$sum,$sc";
}
function member()
{
	@session_start();
	global $cfg_user;
	if($cfg_user==0) return '';
	global $cfg_phpurl;
	if(!empty($_SESSION['duomi_user_id'])) {
		
		$member = "您好<font color='red'>".$_SESSION['duomi_nick_name']." </font><br/>[<a href='".$cfg_phpurl."../member/'>会员中心</a>][<a href='".$cfg_phpurl."../member/cpwd.php'>修改密码</a>]
		[<a href='../member/myshow.php'>我的收藏</a>][<a href='".$cfg_phpurl."../member/exit.php'>退出</a>]";
	} else {
		$member = "<a href='/member/login.php'>马上登录</a> | <a href='/member/reg.php'>立即注册</a>";
	}
	return $member;
}
?>