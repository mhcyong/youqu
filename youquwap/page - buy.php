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
	<div style="padding: 15px 0; color: #808080;text-align:center;width:100%;float:left;margin-bottom:20px;border-bottom:1px solid #e2e2e2;">
        <?php $this->user->screenName(); ?> 购买VIP会员
    </div>
	
    <div class="item">
		<?php echo TePass_Plugin::getBuyVip(); ?>
	</div>  
	

    <div style="padding: 15px 8px; text-align: center;">
	</div>

</div>