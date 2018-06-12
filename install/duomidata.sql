INSERT INTO `duomi_arcrank` VALUES (1, 0, '开放浏览', 5, 0, 0, ''),
(2, 10, '注册会员', 5, 0, 100, ''),
(3, 50, '中级会员', 5, 300, 200, ''),
(4, 100, '高级会员', 5, 800, 500, '');

INSERT INTO `duomi_mytag` VALUES('1','areasearch','地区搜索','1251590919','<a href=\'/{duomicms:sitepath}search.php?searchtype=2&searchword=大陆\' target=\"_blank\">大陆</a> \r\n<a href=\'/{duomicms:sitepath}search.php?searchtype=2&searchword=香港\'target=\"_blank\">香港</a> \r\n<a href=\'/{duomicms:sitepath}search.php?searchtype=2&searchword=台湾\'target=\"_blank\">台湾</a> \r\n<a href=\'/{duomicms:sitepath}search.php?searchtype=2&searchword=日本\' target=\"_blank\">日本</a> \r\n<a href=\'/{duomicms:sitepath}search.php?searchtype=2&searchword=韩国\' target=\"_blank\">韩国</a> \r\n<a href=\'/{duomicms:sitepath}search.php?searchtype=2&searchword=欧美\' target=\"_blank\">欧美</a> \r\n<a href=\'/{duomicms:sitepath}search.php?searchtype=2&searchword=其它\' target=\"_blank\">其它</a>');
INSERT INTO `duomi_mytag` VALUES('2','yearsearch','按发行年份查看电影','1251509338','<a href=\'/{duomicms:sitepath}search.php?searchtype=3&searchword=2009\' target=\"_blank\">2009</a> \r\n<a href=\'/{duomicms:sitepath}search.php?searchtype=3&searchword=2008\'target=\"_blank\">2008</a> \r\n<a href=\'/{duomicms:sitepath}search.php?searchtype=3&searchword=2007\' target=\"_blank\">2007</a> \r\n<a href=\'/{duomicms:sitepath}search.php?searchtype=3&searchword=2006\' target=\"_blank\">2006</a> \r\n<a href=\'/{duomicms:sitepath}search.php?searchtype=3&searchword=2005\' target=\"_blank\">2005</a> \r\n<a href=\'/{duomicms:sitepath}search.php?searchtype=3&searchword=2004\' target=\"_blank\">2004</a> \r\n<a href=\'/{duomicms:sitepath}search.php?searchtype=3&searchword=2003\' target=\"_blank\">2003</a> \r\n<a href=\'/{duomicms:sitepath}search.php?searchtype=3&searchword=2002\' target=\"_blank\">2002</a> \r\n<a href=\'/{duomicms:sitepath}search.php?searchtype=3&searchword=2001\' target=\"_blank\">2001</a>');
INSERT INTO `duomi_mytag` VALUES('3','actorsearch','演员名字','1251590973','<a href=\'/{duomicms:sitepath}search.php?searchtype=1&searchword=成龙\' target=\"_blank\">成龙</a> \r\n<a href=\'/{duomicms:sitepath}search.php?searchtype=1&searchword=周星驰\'target=\"_blank\">周星驰</a> ');

INSERT INTO `duomi_co_cls` (`id`, `clsname`, `sysclsid`,`cotype`) VALUES (1, '大陆', 0,0);
INSERT INTO `duomi_co_cls` (`id`, `clsname`, `sysclsid`,`cotype`) VALUES (2, '香港', 0,0);
INSERT INTO `duomi_co_cls` (`id`, `clsname`, `sysclsid`,`cotype`) VALUES (3, '台湾', 0,0);
INSERT INTO `duomi_co_cls` (`id`, `clsname`, `sysclsid`,`cotype`) VALUES (4, '日本', 0,0);
INSERT INTO `duomi_co_cls` (`id`, `clsname`, `sysclsid`,`cotype`) VALUES (5, '韩国', 0,0);
INSERT INTO `duomi_co_cls` (`id`, `clsname`, `sysclsid`,`cotype`) VALUES (6, '欧美', 0,0);
INSERT INTO `duomi_co_cls` (`id`, `clsname`, `sysclsid`,`cotype`) VALUES (7, '日韩', 0,0);
INSERT INTO `duomi_co_cls` (`id`, `clsname`, `sysclsid`,`cotype`) VALUES (8, '美国', 0,0);

INSERT INTO `duomi_myad` VALUES (1,'article-right-ad','article-right-ad',1444999917,'内容页右侧广告位300*300','document.writeln("<img src=\"\/duomiui\/default\/images\/ad-300.jpg\">")');

INSERT INTO `duomi_type` (`tid`, `upid`, `tname`, `tenname`, `torder`, `templist`,`templist_1`,`keyword`,`description`, `ishidden`, `unionid`, `tptype`) VALUES
(1,0,'电影','video',1,'channel.html','content.html','','',0,'31_1',0),
(2,0,'电视剧','tv',2,'channel.html','content.html','','',0,'',0),
(3,0,'综艺','variety',3,'channel.html','content.html','','',0,'',0),
(4,0,'动漫','animation',4,'channel.html','content.html','','',0,'',0),
(5,1,'动作片','action',5,'channel.html','content.html','','',0,'',0),
(6,1,'喜剧片','comedy',6,'channel.html','content.html','','',0,'',0),
(7,1,'爱情片','love',7,'channel.html','content.html','','',0,'',0),
(8,1,'科幻片','fiction',8,'channel.html','content.html','','',0,'',0),
(9,1,'剧情片','plot',9,'channel.html','content.html','','',0,'',0),
(10,1,'恐怖片','terror',10,'channel.html','content.html','','',0,'',0),
(11,1,'战争片','warfare',11,'channel.html','content.html','','',0,'',0),
(12,2,'大陆剧','mainland',13,'channel.html','content.html','','',0,'',0),
(13,2,'港台剧','gangtai',14,'channel.html','content.html','','',0,'',0),
(14,2,'日韩剧','rihan',15,'channel.html','content.html','','',0,'',0),
(15,2,'欧美剧','oumei',16,'channel.html','content.html','','',0,'',0),
(16,0,'影视资讯','videonews',17,'newspage.html','news.html','','',0,'',1),
(17,0,'剧情介绍','videoplot',18,'newspage.html','news.html','','',0,'',1);

INSERT INTO `duomi_jqtype` (`tid`, `tname`, `ishidden`) VALUES
(1, '爱情', 0),
(2, '校园', 0),
(3, '乡村', 0),
(4, '少儿', 0),
(5, '都市', 0),
(6, '娱乐', 0);

INSERT INTO `duomi_member_group` (`gid`, `gname`, `gtype`, `g_auth`, `g_upgrade`) VALUES ('1', '游客用户', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15', '1,2,3', '0');
INSERT INTO `duomi_member_group` (`gid`, `gname`, `gtype`, `g_auth`, `g_upgrade`) VALUES ('2', '普通会员', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15', '1,2,3', '10');