<?php
/**
* 个人中心
*
* @package custom
*/
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
if(!$this->user->hasLogin()){
	header("Location: /tepass/signin"); 
}
$db = Typecho_Db::get();
?>


<div class="main container">
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tbody><tr>
            <td style="width: 120px;">
                <a href="/author/<?php $this->user->uid(); ?>" style="display:block;">
                    <?php $email=$this->user->mail; $imgUrl = getGravatar($email);echo '<img src="'.$imgUrl.'" srcset="'.$imgUrl.'" class="avatar-140 photo" height="100" width="100">'; ?>
                </a>
            </td>
            <td>
                <div style="color:#636A86"><?php $this->user->screenName(); ?></div>
				<?php $rsvips=$db->fetchRow($db->select()->from('table.tepass_vips')->where('table.tepass_vips.vip_uid=?',$this->user->uid)->limit(1)); ?>
				
                <div style="margin-top: 10px; color: #808080; word-wrap: break-word;overflow: hidden;"><?php echo htmlspecialchars($rsvips["vip_desc"]);?></div>
                <div style="margin-top: 10px; color:#636A86; font-size: 12px; color: #a0a0a0;">第<?php $this->user->uid(); ?>位成员</div>
            </td>
        </tr>
    </tbody></table>
	<div style="padding: 15px 0; color: #808080;text-align:center;width:100%;float:left;margin-bottom:20px;border-bottom:1px solid #e2e2e2;">
        <?php $this->user->screenName(); ?> 发表的话题
    </div>
	<?php
		$result = $db->fetchAll($db->select()->from('table.contents')
			->where('status = ?','publish')
			->where('table.contents.type = ?', 'post')
			->where('authorId = ?', $this->user->uid)
			->where('created <= unix_timestamp(now())', 'post') //添加这一句避免未达到时间的文章提前曝光
			->limit(50)
			->order('commentsNum', Typecho_Db::SORT_DESC)
		);
		if($result){
			foreach($result as $val){            
				$val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
				$post_title = htmlspecialchars($val['title']);
				$permalink = $val['permalink'];
		?>	
    <div class="item">
		<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tbody><tr>
				<td class="avatar">
					<a href="/author/<?php echo $val['authorId'];?>">
						<?php $email=$this->user->mail; $imgUrl = getGravatar($email);echo '<img src="'.$imgUrl.'" srcset="'.$imgUrl.'" class="avatar avatar-140 photo" height="46" width="46">'; ?>
					</a>
				</td>
				<td class="title">
					<a href="<?php echo $permalink; ?>#r<?php echo $val['commentsNum']; ?>"><?php echo $post_title; ?></a>
				</td>
				<td width="30" class="comments-count">
					<a href="<?php echo $permalink; ?>#r<?php echo $val['commentsNum']; ?>"><?php echo $val['commentsNum']; ?></a>
				</td>
			</tr>
		</tbody></table>
	</div>  
		<?php
			}
		}
		?>	

    <div style="padding: 15px 8px; text-align: center;">
		<a style="text-decoration:none; color: #808080;" class="more_item" href="/?start=64">更多话题</a>
	</div>

</div>
<!-- footer -->
<?php $this->need('footer.php'); ?>
<!-- end footer -->