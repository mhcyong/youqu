<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form) {
    $tuijian = new Typecho_Widget_Helper_Form_Element_Text('tuijian', NULL, NULL, _t('<hr>首页2个推荐位置'), _t(''));
    $form->addInput($tuijian);
	
    $icp = new Typecho_Widget_Helper_Form_Element_Text('icp', NULL, NULL, _t('ICP备案号'), _t(''));
    $form->addInput($icp);
}
/**
 * 文章链接新窗口打开
 */
function uericoimg($userid){ 
        $obj = Helper::options()->uerico;	
        return $obj;
 }

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

/**
* 评论者主页链接新窗口打开
* 调用<?php CommentAuthor($comments); ?>
*/
function CommentAuthor($obj, $autoLink = NULL, $noFollow = NULL) {    //后两个参数是原生函数自带的，为了保持原生属性，我并没有删除，原版保留
    $options = Helper::options();
    $autoLink = $autoLink ? $autoLink : $options->commentsShowUrl;    //原生参数，控制输出链接（开关而已）
    $noFollow = $noFollow ? $noFollow : $options->commentsUrlNofollow;    //原生参数，控制输出链接额外属性（也是开关而已...）
    if ($obj->url && $autoLink) {
        echo '<a href="'.$obj->url.'"'.($noFollow ? ' rel="external nofollow"' : NULL).(strstr($obj->url, $options->index) == $obj->url ? NULL : ' target="_blank"').'>'.$obj->author.'</a>';
    } else {
        echo $obj->author;
    }
}


// 获取浏览器信息
function getBrowser($agent)
{
    if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs)) {
        $outputer = 'Internet Explore';
    } else if (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs)) {
		$str1 = explode('Firefox/', $regs[0]);
		$FireFox_vern = explode('.', $str1[1]);
        $outputer = 'FireFox';
    } else if (preg_match('/Maxthon([\d]*)\/([^\s]+)/i', $agent, $regs)) {
		$str1 = explode('Maxthon/', $agent);
		$Maxthon_vern = explode('.', $str1[1]);
        $outputer = 'MicroSoft Edge';
    } else if (preg_match('#360([a-zA-Z0-9.]+)#i', $agent, $regs)) {
		$outputer = '360极速浏览器';
    } else if (preg_match('/Edge([\d]*)\/([^\s]+)/i', $agent, $regs)) {
        $str1 = explode('Edge/', $regs[0]);
		$Edge_vern = explode('.', $str1[1]);
        $outputer = 'MicroSoft Edge';
    } else if (preg_match('/UC/i', $agent)) {
        $str1 = explode('rowser/',  $agent);
		$UCBrowser_vern = explode('.', $str1[1]);
        $outputer = 'UC浏览器';
    }  else if (preg_match('/QQ/i', $agent, $regs)||preg_match('/QQBrowser\/([^\s]+)/i', $agent, $regs)) {
        $str1 = explode('rowser/',  $agent);
		$QQ_vern = explode('.', $str1[1]);
        $outputer = 'QQ浏览器';
    } else if (preg_match('/UBrowser/i', $agent, $regs)) {
        $str1 = explode('rowser/',  $agent);
		$UCBrowser_vern = explode('.', $str1[1]);
        $outputer = 'UC浏览器';
    }  else if (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs)) {
        $outputer = 'Opera';
    } else if (preg_match('/Chrome([\d]*)\/([^\s]+)/i', $agent, $regs)) {
		$str1 = explode('Chrome/', $agent);
		$chrome_vern = explode('.', $str1[1]);
        $outputer = 'Chrome';
    } else if (preg_match('/safari\/([^\s]+)/i', $agent, $regs)) {
        $str1 = explode('Version/',  $agent);
		$safari_vern = explode('.', $str1[1]);
        $outputer = 'Safari';
    } else{
        $outputer = 'Google Chrome';
    }
    echo $outputer;
}
// 获取操作系统信息
function getOs($agent)
{
    $os = false;
 
    if (preg_match('/win/i', $agent)) {
        if (preg_match('/nt 6.0/i', $agent)) {
            $os = '&nbsp;&nbsp;Win Vista&nbsp;/&nbsp;';
        } else if (preg_match('/nt 6.1/i', $agent)) {
            $os = '&nbsp;&nbsp;Win 7&nbsp;/&nbsp;';
        } else if (preg_match('/nt 6.2/i', $agent)) {
            $os = '&nbsp;&nbsp;Win 8&nbsp;/&nbsp;';
        } else if(preg_match('/nt 6.3/i', $agent)) {
            $os = '&nbsp;&nbsp;Win 8.1&nbsp;/&nbsp;';
        } else if(preg_match('/nt 5.1/i', $agent)) {
            $os = '&nbsp;&nbsp;Win XP&nbsp;/&nbsp;';
        } else if (preg_match('/nt 10.0/i', $agent)) {
            $os = '&nbsp;&nbsp;Win 10&nbsp;/&nbsp;';
        } else{
            $os = '&nbsp;&nbsp;Win X64&nbsp;/&nbsp;';
        }
    } else if (preg_match('/android/i', $agent)) {
    if (preg_match('/android 9/i', $agent)) {
            $os = '&nbsp;&nbsp;Android&nbsp;/&nbsp;';
        }
    else if (preg_match('/android 8/i', $agent)) {
            $os = '&nbsp;&nbsp;Android&nbsp;/&nbsp;';
        }
    else{
            $os = '&nbsp;&nbsp;Android&nbsp;/&nbsp;';
    }
    }
    else if (preg_match('/ubuntu/i', $agent)) {
        $os = '&nbsp;&nbsp;Ubuntu&nbsp;/&nbsp;';
    } else if (preg_match('/linux/i', $agent)) {
        $os = '&nbsp;&nbsp;Linux&nbsp;/&nbsp;';
    } else if (preg_match('/iPhone/i', $agent)) {
        $os = '&nbsp;&nbsp;iPhone&nbsp;/&nbsp;';
    } else if (preg_match('/mac/i', $agent)) {
        $os = '&nbsp;&nbsp;MacOS&nbsp;/&nbsp;';
    }else if (preg_match('/fusion/i', $agent)) {
        $os = '&nbsp;&nbsp;Android&nbsp;/&nbsp;';
    } else {
        $os = '&nbsp;&nbsp;Linux&nbsp;/&nbsp;';
    }
    echo $os;
}



//获取评论的锚点链接
function get_comment_at($coid)
{
    $db   = Typecho_Db::get();
    $prow = $db->fetchRow($db->select('parent,status')->from('table.comments')
        ->where('coid = ?', $coid));//当前评论
    $mail = "";
    $parent = @$prow['parent'];
    if ($parent != "0") {//子评论
        $arow = $db->fetchRow($db->select('author,status,mail')->from('table.comments')
            ->where('coid = ?', $parent));//查询该条评论的父评论的信息
        @$author = @$arow['author'];//作者名称
        $mail = @$arow['mail'];
        if(@$author && $arow['status'] == "approved"){//父评论作者存在且父评论已经审核通过
            if (@$prow['status'] == "waiting"){
                echo '<p class="commentReview">'._mt("（评论审核中）").'</p>';
            }
            echo '<a href="#comment-' . $parent . '">@' . $author . '</a>';
        }else{//父评论作者不存在或者父评论没有审核通过
            if (@$prow['status'] == "waiting"){
                echo '<p class="commentReview">'._mt("（评论审核中）").'</p>';
            }else{
                echo '';
            }

        }

    } else {//母评论，无需输出锚点链接
        if (@$prow['status'] == "waiting"){
            echo '<p class="commentReview">'._mt("（评论审核中）").'</p>';
        }else{
            echo '';
        }
    }


}

//通过cid获取一个tag
function get_tag_by_cid($cid){
	$db = Typecho_Db::get();
	$rstag = $db->fetchRow($db->select()->from('table.metas')->join('table.relationships', 'table.relationships.mid = table.metas.mid', Typecho_Db::LEFT_JOIN)->where('table.relationships.cid=?',$cid)->where('table.metas.type=?',"tag")->limit(1));	
	if(!empty($rstag['name'])){
		//echo '<a class="tag tag_9" href="/tag/'.$rstag['name'].'">'. $rstag['name'] .'</a>';
		return $rstag['name'];
	}
}

//通过uid获取用户信息
function get_userinfo_by_uid($uid){
	$db = Typecho_Db::get();
	$userinfo = $db->fetchRow($db->select()->from('table.users')->where('table.users.uid=?',$uid)->limit(1));	
	//if(!empty($rstag['mail'])){
		//echo '<a class="tag tag_9" href="/tag/'.$rstag['name'].'">'. $rstag['name'] .'</a>';
		return $userinfo;
	//}
}



/**
* 阅读统计
* 调用<?php get_post_view($this); ?>
*/
function Postviews($archive) {
    $db = Typecho_Db::get();
    $cid = $archive->cid;
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `'.$db->getPrefix().'contents` ADD `views` INT(10) DEFAULT 876;');
    }
    $exist = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid))['views'];
    if ($archive->is('single')) {
        $cookie = Typecho_Cookie::get('contents_views');
        $cookie = $cookie ? explode(',', $cookie) : array();
        if (!in_array($cid, $cookie)) {
            $db->query($db->update('table.contents')
                ->rows(array('views' => (int)$exist+1))
                ->where('cid = ?', $cid));
            $exist = (int)$exist+1;
            array_push($cookie, $cid);
            $cookie = implode(',', $cookie);
            Typecho_Cookie::set('contents_views', $cookie);
        }
    }
    echo $exist == 0 ? '0' : $exist.' ';
}
