<?php

require_once '../../../../config.inc.php';
/** 载入API支持 */
require_once '../../../../var/Typecho/Common.php';
/** 初始化组件 */
Typecho_Widget::widget('Widget_Init');
/** 程序初始化 */
Typecho_Common::init();

include('Parsedown.php');

$db = Typecho_Db::get();

//通过tid获取文章作者id
$rspost=$db->fetchRow($db->select("text")->from('table.contents')->where('table.contents.cid=?',trim($_POST['tid']))->limit(1));

$Parsedown = new Parsedown();
$html = $Parsedown->text(substr($rspost['text'],15));

$json=json_encode(array("topic_status"=>"ok","html"=>$html));
echo $json;

?>