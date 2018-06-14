<?php
/**
 * 用户
 *
 * @version        2015年7月12日Z by 海东青
 * @package        DuomiCms.Administrator
 * @copyright      Copyright (c) 2015, SamFea, Inc.
 * @link           http://www.duomicms.net
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview();
if(empty($ac))
{
	$ac = '';
}

if($ac=='list')
{
	if(empty($uid) && $uname == "")
	{
		$wheresql = "";
	}else
	{
		$wheresql = "where";
		if(!empty($uid)) $wheresql .= " id in ($uid) and";
		if($uname != "")
		{
			$uname = str_replace('*','%',$uname);
			$wheresql .= " username like '$uname'";
		}
	}
	$wheresql = rtrim($wheresql,'and');

	$numPerPage = 15;
    $page = isset($page) ? intval($page) : 1;
    if($page==0) $page=1;

    $uTotal = $dsql->GetOne("select count(1) as dd from duomi_member");
    if(is_array($uTotal)){
        $Totalu = $uTotal['dd'];
    }else{
        $Totalu = 0;
    }

    $rowTotal = $dsql->GetOne("select count(1) as dd from duomi_member $wheresql");
    if(is_array($rowTotal)){
        $TotalResult = $rowTotal['dd'];
    }else{
        $TotalResult = 0;
    }
    $TotalPage = ceil($TotalResult/$numPerPage);

    if($page>$TotalPage) $page=$TotalPage;
    $limitstart = ($page-1) * $numPerPage;

    if($limitstart<0) $limitstart=0;

	$sql = "select * from duomi_member $wheresql order by id limit $limitstart, $numPerPage";
	$dsql->SetQuery($sql);
	$dsql->Execute('search_list');
	$srow = array();
	while($row=$dsql->GetArray('search_list'))
	{
		$srow[] = $row;
	}
}
elseif($ac=='clear')
{
	if(empty($uid1)&&empty($uname1))
	{
		ShowMsg("抱歉，没有搜索到需要删除的用户",'-1');
		exit();
	}else
	{
		$wheresql = "where";
		if(!empty($uid1)) $wheresql .= " uid in ($uid1) and";
		if(!empty($uname1)) 
		{
			$uname1 = str_replace('*','%',$uname1);
			$wheresql .= " username like '$uname1'";
		}
	}
	$sql = "delete from duomi_member $wheresql";
	$ret = $dsql->ExecuteNoneQuery2($sql);
	if($ret==0)
	{
		ShowMsg("抱歉，没有搜索到需要删除的用户",'-1');
		exit();
	}elseif($ret==-1)
	{
		ShowMsg("请正确填写条件",'-1');
		exit();
	}
	else
	{
		ShowMsg("删除成功",'-1');
		exit();
	}
}elseif($ac=='edit')
{
	$row = $dsql->GetOne("select * from duomi_member where id='$id'");
}
elseif($ac=='editsave')
{
	$gid = intval($gid);
	$upoints = intval($upoints);
	$ustate = intval($ustate);
	if($dsql->ExecuteNoneQuery("update duomi_member set gid=$gid,points=$upoints,state=$ustate where id=$id"))
	{
		ShowMsg("更新成功",'admin_members.php');
	}
	else
	{
		ShowMsg("更新失败，请检查输入是否正确",'-1');
	}
		exit();
}elseif($ac == "uinfo") {
    if($uname == "")
	{
		$wheresql = "";
	}else
	{
		$wheresql = "where";
		if($uname != "")
		{
			$uname = str_replace('*','%',$uname);
			$wheresql .= " u_name like '$uname'";
		}
	}
	$wheresql = rtrim($wheresql,'and');

    $numPerPage = 15;
    $page = isset($page) ? intval($page) : 1;
    if($page==0) $page=1;

    $rowTotal = $dsql->GetOne("select count(1) as dd from wanshi_login_info $wheresql");
    if(is_array($rowTotal)){
        $TotalResult = $rowTotal['dd'];
    }else{
        $TotalResult = 0;
    }
    $TotalPage = ceil($TotalResult/$numPerPage);

    if($page>$TotalPage) $page=$TotalPage;
    $limitstart = ($page-1) * $numPerPage;

    if($limitstart<0) $limitstart=0;

	$sql = "select * from wanshi_login_info $wheresql order by l_time desc limit $limitstart, $numPerPage";
    $dsql->SetQuery($sql);
    $dsql->Execute('search_list');
	$srow = array();
	while($row=$dsql->GetArray('search_list'))
	{
		$srow[] = $row;
	}
}elseif($ac=='del')
{	
	$sql = "delete from duomi_member where id='$id'";
	if($dsql->ExecuteNoneQuery($sql))
	{
		ShowMsg("删除成功",'admin_members.php');
	}else
	{
		ShowMsg("删除失败",'admin_members.php');
	}
	exit();
}
elseif($ac=='delall')
{	
	if(empty($uidarray))
	{
		ShowMsg("请选择要删除的用户",'-1');
		exit();
	}
	foreach($uidarray as $id)
	{
		$sql = "delete from duomi_member where id='$id'";
		$dsql->ExecuteNoneQuery($sql);
	}
	ShowMsg("删除成功",'admin_members.php');
	exit();
}
include(duomi_ADMIN.'/html/admin_members.htm');
exit();
