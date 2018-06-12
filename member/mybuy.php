<?php
session_start();
require_once("../duomiphp/common.php");
require_once(duomi_INC.'/core.class.php');
if($cfg_user==0)
{
	ShowMsg('系统已关闭会员功能!','-1');
	exit();
}

$action = isset($action) ? trim($action) : '';
$pg = isset($pg) ? intval($pg) : 1;
$uname=$_SESSION['duomi_user_name'];
if(empty($_SESSION['duomi_user_id']))
{
	showMsg("请先登录","login.php?next=/member/mybuy.php");
	exit();
}

if($dm=='mybuy')
{
	$page = $_GET["page"];
	$pcount = 10;
	$row=$dsql->getOne("select count(u_name) as dd from wanshi_play_history where u_name='$uname'");
	$rcount=$row['dd'];	
	$page_count = ceil($rcount/$pcount); 
	if(empty($_GET['page'])||$_GET['page']<0){ 
	$page=1; 
	}else { 
	$page=$_GET['page']; 
	}
	$select_limit = $pcount; 
	$select_from = ($page - 1) * $pcount.','; 
	$pre_page = ($page == 1)? 1 : $page - 1; 
	$next_page= ($page == $page_count)? $page_count : $page + 1 ; 
	$dsql->setQuery("select * from wanshi_play_history where u_name='$uname' order by p_time desc limit ".($page-1)*$pcount.",$pcount");
	$dsql->Execute('buylist');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>我的购买</title>
<link href="css/style.css" rel="stylesheet">
<style>
table{border: 1px solid #E3E3E3;border-bottom:0;margin-top:0px}
table tr{height:35px;line-height:35px;}
table tr td{font-size:14px;border-bottom:1px solid #E3E3E3;}
table tr td a{color:#555;}
.foot{padding-top:20px;font-size:14px;text-align:center;color:#555}
.foot a{color:#000}
</style>
</head>
<form id="favform" name="favform" action="?dm=1" method="post">
    <table width="100%" cellspacing="0" cellspaddng="0">
	<tr align="center" style="background:#f5f5f5">
        <td width="15%">影片名称</td>
        <td width="15%">播放时间</td>
        <td width="10%">操作</td>
	</tr>
    <?php
        while($row=$dsql->getArray('buylist'))
        {
            $v_id = substr($row['p_url'], strpos($row['p_url'], "/video/?") + 8);
            $ep = substr($v_id, strrpos($v_id, "-") + 1);
            $ep = substr($ep, 0, strpos($ep, ".html"));
            $v_id = substr($v_id, 0, strpos($v_id, "-"));
            $episodes = $dsql->GetOne("select body from duomi_playdata where v_id=$v_id");
    ?>
    <tr align="center">
        <td width="15%"><?php echo $row['p_info']?></td>
        <td width="15%"><?php echo date('Y-m-d H:i:s',$row['p_time'])?></td>
        <td width="10%">
            <span style="display: <?php $born = strlen($episodes[0]) == 0 ? "block" : "none"; echo $born; ?>;">影片已不存在</span>
            <a style="display: <?php $born = strlen($episodes[0]) == 0 ? "none" : ""; echo $born; ?>;" href="<?php echo $row['p_url']; ?>" target="_blank">播放</a>
            <?php
                if($ep + 1 < substr_count($episodes["body"], "期") != False or
                    $ep + 1 < substr_count($episodes["body"], "集") != False){
                    $ep += 1;
                    if(strlen($episodes[0]) != 0){
                        echo "| <a href='/video/?$v_id-0-$ep.html' target='_blank'>下一集</a>";
                    }
                }
            ?>
        </td>
	</tr>
    <?php }?>
   </table>
</form>
      </div>
      <div class="foot">
        <?php
		echo <<<EOT
      第 $page 页 / 共 $page_count 页
                <a href="?dm=mybuy&page=1" class="btn">首页</a> 
				<a href="?dm=mybuy&page={$pre_page}">上一页</a> 
                <a href="?dm=mybuy&page={$next_page}">下一页</a>
				<a href="?dm=mybuy&page={$page_count}">尾页</a>
EOT;
		  ?>
      </div>
</body>
</html>
<?php
}
else
{
$tempfile = duomi_ROOT."/member/html/mybuy.html";
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
	exit();
}