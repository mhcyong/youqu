<?php
header("Access-Control-Allow-Origin: *");

require_once '../../../../config.inc.php';
/** 载入API支持 */
require_once '../../../../var/Typecho/Common.php';
/** 初始化组件 */
Typecho_Widget::widget('Widget_Init');
/** 程序初始化 */
Typecho_Common::init();

//获取Gravatar头像 QQ邮箱取用qq头像
function getGravatar($email, $s = 96, $d = 'retro', $r = 'g')
{
	if($email){
		$smail=strtolower($email);
		$f=str_replace('@qq.com','',$smail);
		if(strstr($smail,"qq.com")&&is_numeric($f)&&strlen($f)<11&&strlen($f)>4){
			$url= '//q1.qlogo.cn/g?b=qq&nk='.$f.'&s=640';
		}else{
			$dmail=md5($smail);
			$url="https://gravatar.loli.net/avatar/".$dmail."?s=$s&d=$d&r=$r";
		}
	}else{
		$url = '/usr/themes/youqudesk/assets/no-user.png';
	}
	return  $url;
}

date_default_timezone_set("Asia/Shanghai");   //设置时区 
function time_tran($the_time) { 
    $now_time = date("Y-m-d H:i:s", time()); 
    //echo $now_time; 
    $now_time = strtotime($now_time); 
    $show_time = strtotime($the_time); 
    $dur = $now_time - $show_time; 
    if ($dur < 0) { 
        return $the_time; 
    } else { 
        if ($dur < 60) { 
            return $dur . '秒前'; 
        } else { 
            if ($dur < 3600) { 
                return floor($dur / 60) . '分钟前'; 
            } else { 
                if ($dur < 86400) { 
                    return floor($dur / 3600) . '小时前'; 
                } else { 
                    if ($dur < 259200) {//3天内 
                        return floor($dur / 86400) . '天前'; 
                    } else { 
                        return $the_time; 
                    } 
                } 
            } 
        } 
    } 
} 


$db = Typecho_Db::get();

//通过tid获取文章作者id
$rspost=$db->fetchRow($db->select("authorId")->from('table.contents')->where('table.contents.cid=?',trim($_POST['tid']))->limit(1));
$ownerId = $rspost['authorId'];

if($_POST['all'] = "yes"){
	$rscomment=$db->fetchAll($db->select()->from ('table.comments')->where('status = ?',"approved")->where('cid = ?',trim($_POST['tid']))->order('table.comments.created',Typecho_Db::SORT_ASC));
}else{
	$rscomment=$db->fetchAll($db->select()->from ('table.comments')->where('status = ?',"approved")->where('cid = ?',trim($_POST['tid']))->order('table.comments.created',Typecho_Db::SORT_ASC)->limit(10));
}

$html1 = '<div id="comments_list" style="display: block;">
			<div style="margin-bottom: 10px;padding-top:8px;">
				<span class="readall" style=""><a href="/" onclick="readrefresh('.$_POST['tid'].'); return false;">刷新评论</a></span>
			</div>';
			
$html2 = "";

foreach($rscomment as $value){
	$email=$value['mail']; $imgUrl = getGravatar($email);
	$html2 = $html2.'
	<div class="comment-item comment-item-s" id="reply_'.$value['coid'].'">  
		<div class="icon-s">
			<a href="/author/'.$value['authorId'].'">
				<img src="'.$imgUrl.'" alt="'.$value['author'].'">
			</a>
		</div>
		<div class="content-s">
			<p>
			<a class="to" href="/author/'.$value['authorId'].'">'.$value['author'].'</a>
			<span class="comment-time">'.time_tran(date('Y-m-d H:i:s',$value['created'])).'</span>
			</p>
			<p>
			<span class="comment-text">'.$value['text'].'</span>
			</p>
		</div>
	</div>';
}

$html3 = '</div>';

$comments_approved = $html1.$html2.$html3;

$json=json_encode(array("topic_status"=>"no","html"=>$comments_approved,"msg"=>"55"));
echo $json;

?>