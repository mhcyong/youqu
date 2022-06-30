
<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 $this->need('header.php');
 ?>
 
 <div class="topic container">
    <div class="info">
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tbody><tr>
                <td class="avatar">
                    <a href="<?php $this->author->permalink(); ?>" style="display:block;">
                        <?php $email=$this->author->mail; $imgUrl = getGravatar($email);echo '<img src="'.$imgUrl.'" srcset="'.$imgUrl.'" height="100" width="100">'; ?>
                    </a>
                </td>
                <td class="text">
                    <a href="<?php $this->author->permalink(); ?>"><?php $this->author(); ?></a> 发表于<?php $this->date(); ?>
                </td>
            </tr>
        </tbody></table>
    </div>

    <div class="article">
        <div class="title">
            <h1>
                <?php $this->title() ?>
            </h1>
        </div>
        
		<div style="margin-top:15px; line-height: 23px; word-wrap: break-word;">
             <?php $this->content(); ?>
             <?php if (array_key_exists('TePass', Typecho_Plugin::export()['activated'])) : 
echo TePass_Plugin::getTePass(); 
endif; ?>
        </div>
        
    </div>

    <?php $this->need('comments.php'); ?>
    
	<?php if($this->user->hasLogin()): ?>	
	<div id="comments" class="commpost">
		<?php $this->comments()->to($comments); ?>
		<?php if($this->allow('comment')): ?>
		<div id="<?php $this->respondId(); ?>" class="reply_box">
			<div class="cancel-comment-reply">
			<?php $comments->cancelReply(); ?>
			</div>   
			
			<form id="new_comment_form" method="post" action="<?php $this->commentUrl() ?>" _lpchecked="1">
			
			<div id="showfacenamereplace"></div>
			<div class="new_comment">
			<textarea name="text" rows="3" class="m1" placeholder="请尽量让你的回复有点意思~"></textarea></div>
			
			<div class="comment_triggered" style="display: block;">
				<div class="input_body">
					<input type="submit" value="提交评论" class="reg_bottom" style="float: left;"> 
					<div class="hasLogin" style="float: left;">
					<?php $email=$this->user->mail; $imgUrl = getGravatar($email);echo '<img src="'.$imgUrl.'" width="32px" height="32px" class="avatar hasLogin-author" >'; ?><?php $this->user->screenName(); ?>. <a href="<?php $this->options->logoutUrl(); ?>" title="Logout">退出 &raquo;</a>
					</div>
				</div>           
			</div>
			</form>  
		</div>
		<?php else: ?>
		<h3><?php _e('评论已关闭'); ?></h3>
		<?php endif; ?>		
	</div>
	<?php else : ?>
	<div id="comments" class="commpost">
		<div id="<?php $this->respondId(); ?>" class="reply_box">				
			<div class="new_comment">
			<textarea name="text" rows="3" class="m1" placeholder="请尽量让你的回复有点意思~"></textarea>
			</div>
			
			<div class="comment_triggered" style="display: block;">
				<div class="input_body">
				<input type="submit" value="请先登录" class="reg_bottom" style="float: left;"> 
				</div>           
			</div> 
		</div>				
	</div>
	<?php endif; ?>  
	
    
</div>


<!-- footer -->
<?php $this->need('footer.php'); ?>
<!-- end footer -->