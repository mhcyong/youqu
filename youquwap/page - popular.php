<?php
/**
* 首页模板
*
* @package custom
*/
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>


<div class="main container">

	<?php 
	$tuijian = $this->options->tuijian;
	$hang = explode(",", $tuijian);
	$n=count($hang);
	$html="";
	for($i=0;$i<$n;$i++){
		$this->widget('Widget_Archive@tuijian'.$i, 'pageSize=1&type=post', 'cid='.$hang[$i])->to($tui);
		$email=$tui->author->mail; 
		$imgUrl = getGravatar($email);
		$tuitag = get_tag_by_cid($tui->cid);
		if($tui->commentsNum > 0){
		    $show_commentNum = '<td width="30" class="comments-count">
					<a href="'.$tui->permalink.'#r'.$tui->commentsNum.'">'.$tui->commentsNum.'</a>
				</td>';
		}else{
		    $show_commentNum = "";
		}
		$html=$html.'
		<div class="item">
		<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tbody><tr>
				<td class="avatar">
					<a href="/author/'.$tui->authorId.'">
						<img src="'.$imgUrl.'" srcset="'.$imgUrl.'" class="avatar avatar-140 photo" height="46" width="46">
					</a>
				</td>
				<td class="title">
					<a href="'.$tui->permalink.'#r'.$tui->commentsNum.'">'.$tui->title.'</a>
				</td>'.$show_commentNum.'
			</tr>
		</tbody></table>
	</div>';
	}
	echo $html;
	?>

	<?php 
	$db = Typecho_Db::get();
	$result = $db->fetchAll($db->select()->from('table.contents')
		->where('status = ?','publish')
		->where('type = ?', 'post')
		->where('created <= unix_timestamp(now())', 'post') //添加这一句避免未达到时间的文章提前曝光
		->limit(64)
		->order('views', Typecho_Db::SORT_DESC)
	);
	?>
	
	<?php if($result){
	foreach($result as $val){
		$rsuserinfo = get_userinfo_by_uid($val['authorId']);
		?>
		<div class="item">
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
				<tbody><tr>
					<td class="avatar">
						<a href="/author/<?php echo $val['authorId']; ?>">
							<?php $email=$rsuserinfo['mail']; $imgUrl = getGravatar($email);echo '<img src="'.$imgUrl.'" srcset="'.$imgUrl.'" class="avatar avatar-140 photo" height="46" width="46">'; ?>
						</a>
					</td>
					<td class="title">
						<a href="/note/<?php echo $val['cid'] ?>#r<?php echo $val['commentsNum']; ?>"><?php echo $val['title'] ?></a>
					</td>
					<td width="30" class="comments-count">
					<?php if($val['commentsNum'] > 0): ?>
						<a href="/note/<?php echo $val['cid'] ?>#r<?php echo $val['commentsNum']; ?>"><?php echo $val['commentsNum']; ?></a>
					<?php endif; ?>
					</td>
				</tr>
			</tbody></table>
		</div>
	<?php      }
		} ?>
	<div style="padding: 15px 8px; text-align: center;">
        <a style="text-decoration:none; color: #808080;" class="more_item" href="/last">更多笔记</a>
    </div>
</div>


<!-- footer -->
<?php $this->need('footer.php'); ?>
<!-- end footer -->