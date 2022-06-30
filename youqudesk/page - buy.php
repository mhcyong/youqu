<?php
/**
* 购买会员
*
* @package custom
*/
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$this->need('header.php');
if(!$this->user->hasLogin()){
	header("Location: /tepass/signin"); 
}
?>

<div class="container">
    <!--主体-->
    <div class="main radius radius-both">
        <div class="home-header radius_top radius-both">
            <div style="padding: 5px; color: #808080;">
                <span>
                     <?php $this->user->screenName(); ?> 购买VIP会员
                </span>
            </div>
        </div>

			
		<div style="padding: 15px 8px; text-align: center;">
			<?php echo TePass_Plugin::getBuyVip(); ?>
		</div>

	</div>

    <!--侧边栏-->
	<?php $this->need('sidebar.php'); ?>
	
</div>
<!-- footer -->
<?php $this->need('footer.php'); ?>
<!-- end footer -->
