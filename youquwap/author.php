<?php
/**
 * 柔弱的猫手机版
 *
 * @package WeakCat
 * @author 柔弱的猫
 * @version 1.0.0
 * @link https://weakcat.com
 */
 
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
$db = Typecho_Db::get();

$str=$_SERVER["REQUEST_URI"];
if(preg_match('/\d+/',$str,$arr)){
$uid=$arr[0];
}
?>

<?php $rsvips=$db->fetchRow($db->select()->from('table.tepass_vips')->where('table.tepass_vips.vip_uid=?',$uid)->limit(1)); ?>
<?php $rsuser=$db->fetchRow($db->select()->from('table.users')->where('table.users.uid=?',$uid)->limit(1)); ?>

<div class="main container">
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tbody><tr>
            <td style="width: 120px;">
                <a href="/author/<?php echo $rsvips['vip_uid']; ?>" style="display:block;">
                    <?php $email=$rsuser['mail']; $imgUrl = getGravatar($email);echo '<img src="'.$imgUrl.'" srcset="'.$imgUrl.'" class="avatar-140 photo" height="100" width="100">'; ?>
                </a>
            </td>
            <td>
                <div style="color:#636A86"><?php echo $rsuser['screenName']; ?></div>
				
                <div style="margin-top: 10px; color: #808080; word-wrap: break-word;overflow: hidden;"><?php echo htmlspecialchars($rsvips["vip_desc"]);?></div>
                <div style="margin-top: 10px; color:#636A86; font-size: 12px; color: #a0a0a0;">第<?php echo $uid; ?>位成员</div>
            </td>
        </tr>
    </tbody></table>
	<div style="padding: 15px 0; color: #808080;text-align:center;width:100%;float:left;margin-bottom:20px;border-bottom:1px solid #e2e2e2;">
       <?php echo $rsuser['screenName']; ?> 撰写的笔记
    </div>
	
	<?php while($this->next()): ?>
    <div class="item">
		<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tbody><tr>
				<td class="avatar">
					<a href="<?php $this->author->permalink(); ?>">
						<?php $email=$this->author->mail; $imgUrl = getGravatar($email);echo '<img src="'.$imgUrl.'" srcset="'.$imgUrl.'" class="avatar avatar-140 photo" height="46" width="46">'; ?>
					</a>
				</td>
				<td class="title">
					<a href="<?php $this->permalink() ?>#r<?php $this->commentsNum('%d'); ?>"><?php $this->title() ?></a>
				</td>
				<td width="30" class="comments-count">
					<a href="<?php $this->permalink() ?>#r<?php $this->commentsNum('%d'); ?>"><?php $this->commentsNum('%d'); ?></a>
				</td>
			</tr>
		</tbody></table>
	</div>
	<?php endwhile; ?>

    <div style="padding: 15px 8px; text-align: center;">
		<a style="text-decoration:none; color: #808080;" class="more_item" href="/?start=64">更多笔记</a>
	</div>

</div>