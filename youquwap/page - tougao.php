<?php
/**
* 用户投稿
*
* @package custom
*/
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
require_once("libs/common.php");
if(!$this->user->hasLogin()){
	header("Location: /tepass/signin"); 
}


/**
1、贡献者才能打开，否则就是一个提示提示权限的按钮；
2、24小时发帖最多5个，发帖间隔为5分钟。
**/


$db = Typecho_Db::get();
$Total_Posts = $db->fetchAll($db->select()->from('table.contents')->where('authorId = ?', $this->user->uid)->where('created > ?', Typecho_Date::gmtTime()-86400));
$Total_Posts_Count = count($Total_Posts);
if($Total_Posts_Count > 5){
	//超过5次，当天不允许
	$post_status = "to_many";
}

$One_Posts = $db->fetchAll($db->select()->from('table.contents')->where('authorId = ?', $this->user->uid)->where('created > ?', Typecho_Date::gmtTime()-300));
$One_Posts_Count = count($One_Posts);
if($One_Posts_Count > 1){
	//5分钟超过1次，就不可以再发表
	$post_status = "to_short";
}


$this->need('header.php');
?>

<div class="container topic_add">
<!--主体-->
 
    <div style="color: #A8B1BA;margin-bottom: 10px;">
        <span>
		   <?php 
				$h2 = array(   
						'随便说说',   
						'随时随地分享身边的新鲜事~',   
						'来，说说你在想什么，做什么',   
						'今天心情很好~',   
						'嘀咕一下'   
					);    
			?>      
			撰写新笔记<strong style="float: right;"><?php echo $h2[(array_rand($h2))]; ?></strong>
		</span>
    </div>
    <div style="color: #A8B1BA;margin: 25px 1px;padding-top: 15px;">
		<?php if($this->user->hasLogin()): //判断是否登录 
			if($post_status == "to_many"){
				echo '<div class="post">24小时内发帖次数太多，出去走一走吧</div>';
			}elseif($post_status == "to_short"){
				echo '<div class="post">发帖间隔太短，去休息几分钟吧</div>';
			}else{
				if($this->user->pass('contributor', true)){
			?> 
			<form action="<?php $security->index('/action/contents-post-edit'); ?>" method="post" name="write_post">  
				<div class="item">
					<input type="text" id="title" name="title" class="s1" maxlength="30" value="" />
					<span style="color: #808080; margin-left: 5px; font-size: 12px;">(不少于5个字)</span>
				</div>
				<div class="item">
					<textarea id="text" name="text" autocomplete="off" class="m2"></textarea>
				</div>
				<input type="hidden" id="allowComment" name="allowComment" value="1" checked="true" /><!--允许评论-->     
				<input type="hidden" name="do" value="publish" /><!--公开，可以无视-->       
				<section class="typecho-post-option visibility-option" style="display:none;">
					<select id="visibility" name="category[]">
						<option value="1" selected>散记</option>
					</select>
				</section>						           
				<input type="submit" class="s2 reg_bottom" value="提交笔记" />  
				<input type="hidden" name="markdown" value="1">					
			</form>    
				<?php 
				}else{
					echo '<div class="post">权限不足，请前往<a href="/setting.html">个人设置</a>验证邮箱开通发表话题权限。</div>';
				}
			}
		endif; ?>
    </div>

</div>

<!-- footer -->
<?php $this->need('footer.php'); ?>
<!-- end footer -->