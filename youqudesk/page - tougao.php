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

//判断是不是VIP会员
$rsvips=$db->fetchRow($db->select()->from('table.tepass_vips')->where('table.tepass_vips.vip_uid=?',$user->uid)->limit(1));

//取出所有的标签供使用
$queryTags= $db->select()->from('table.metas')->where('table.metas.type = ?',"tag")->order('table.metas.mid',Typecho_Db::SORT_DESC); 
$rowTags = $db->fetchAll($queryTags);
?>
<?php $this->need('header.php'); ?>

<div class="container" style="background-color: white;">
    <!--主体-->
        <div class="home-header radius_top radius-both">
            <div style="padding: 5px; color: #808080;">
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
        </div>
		<div class="add" style="padding: 5px;">
			<?php if($this->user->hasLogin()): //判断是否登录 
				if($post_status == "to_many"){
					echo '<div class="post">24小时内发帖次数太多，出去走一走吧</div>';
				}elseif($post_status == "to_short"){
					echo '<div class="post">发帖间隔太短，去休息几分钟吧</div>';
				}else{
					if($this->user->pass('contributor', true)){
				?> 
			
					<div class="post"> <!--按个人CSS的更改-->     
						<form action="<?php $security->index('/action/contents-post-edit'); ?>" method="post" name="write_post">  
							<div class="item">
								<input type="text" id="title" name="title" class="text" maxlength="30" value="" />
								<span style="color: #808080; margin-left: 5px; font-size: 12px;">标题不少于5个字</span>
							</div>
							<div class="item">
								<textarea id="text" name="text" autocomplete="off" style="width: 100%; height: 343px; overflow: hidden;"></textarea>
							</div>
							<div id="item">
								添加标签:
								<?php
								if(!empty($rowTags)){
								  foreach($rowTags as $value){
								?>
                                <a class="default" href="#" onclick="document.getElementById('aa').value=this.innerHTML;"><?php echo $value["name"]; ?></a>
                                <?php
								  }
								}
								?>
                                <style>
                                ul{list-style:none}
                                ul li{display:block;height:28px;}
                                .default{
                                    color:#000;
                                }
                                .checked{
                                    color:#f00;
                                    border:1px solid #18b90a;
                                    padding: 0 5px;
                                }
                                </style>
                                <script>
                                $(function(){
                                    $("#item a").each(function(){
                                        $(this).click(function(){
                                            $("#item a").addClass("default").removeClass("checked");
                                            $(this).addClass("checked").removeClass("default");
                                        })
                                    });
                                })
                                </script>
                                
								<div style="display:none;" id="tag_input">
									<input id="aa" name="tags" class="text" maxlength="2" type="text" value="" readonly>
								</div>
							</div>
							<input type="hidden" id="allowComment" name="allowComment" value="1" checked="true" /><!--允许评论-->     
							<input type="hidden" name="do" value="publish" /><!--公开，可以无视-->      
							<section class="typecho-post-option visibility-option" style="display:none;">
								<select id="visibility" name="category[]">
									<option value="1" selected>散记</option>
								</select>
							</section>					
							<input type="submit" class="s2 tougao_bottom" value="提交笔记" />
							<span style="color: #808080;margin-left: 15px;font-size: 12px;padding-top: 5px;">笔记提交后需审核才能公开</span>
							<input type="hidden" name="markdown" value="1">					
						</form>                          
					</div>     
					<?php 
					}else{
						echo '<div class="post">权限不足，请前往<a href="/setting.html">个人设置</a>验证邮箱开通发表话题权限。</div>';
					}
				}
			endif; ?>
		</div>
   
</div>
<?php $this->need('footer.php'); ?>
<script type="text/javascript" src="<?php $this->options->themeUrl('assets/add.js')?>"></script>