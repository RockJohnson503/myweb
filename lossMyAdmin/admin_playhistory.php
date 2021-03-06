﻿<?php
/**
 * 播放记录
 * Created by PhpStorm.
 * User: rock
 * Date: 18-6-6
 * Time: 下午1:48
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview();
if(empty($ac))
{
	$ac = '';
}

if($ac=='list')
{
    if($uname == '')
	{
		$wheresql = "";
	}else
	{
		$wheresql = "where";
        $u_name = str_replace('*','%',$uname);
        $wheresql .= " u_name like '$u_name'";
	}
	$wheresql = rtrim($wheresql,'and');

    if($vid != "")
	{
		$wheresql = "where";
        $wheresql .= " v_id = '$vid'";
	}
	$wheresql = rtrim($wheresql,'and');

    if($vname != "")
	{
		$wheresql = "where";
        $vname = str_replace('*','%',$vname);
        $wheresql .= " p_info like '%$vname%'";
	}
	$wheresql = rtrim($wheresql,'and');

    $numPerPage = 15;
    $page = isset($page) ? intval($page) : 1;
    if($page==0) $page=1;

    $dsql->SetQuery("select 1 from wanshi_play_history group by u_name");
    $dsql->Execute('search_user');
    $urow = array();
	while($row=$dsql->GetArray('search_user'))
	{
		$urow[] = $row;
	}

    $rowTotal = $dsql->GetOne("select count(1) as dd from wanshi_play_history $wheresql");
    if(is_array($rowTotal)){
        $TotalResult = $rowTotal['dd'];
    }else{
        $TotalResult = 0;
    }
    $TotalPage = ceil($TotalResult/$numPerPage);

    if($page>$TotalPage) $page=$TotalPage;
    $limitstart = ($page-1) * $numPerPage;

    if($limitstart<0) $limitstart=0;

	$sql = "select * from wanshi_play_history $wheresql order by p_time desc limit $limitstart, $numPerPage";
	$dsql->SetQuery($sql);
	$dsql->Execute('search_list');
	$srow = array();
	while($row=$dsql->GetArray('search_list'))
	{
		$srow[] = $row;
	}
}else if($ac == 'del'){
    $turl= $_SERVER['HTTP_REFERER'];
    $sql = "delete from wanshi_play_history where h_id=$hid";
    $dsql->ExecuteNoneQuery($sql);
    ShowMsg("删除成功", $turl);
    exit();
}
include(duomi_ADMIN.'/html/admin_playhistory.html');
exit();