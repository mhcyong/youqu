<?php
/**
* 设置
*
* @package custom
*/
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
require_once("libs/common.php");
if(!$this->user->hasLogin()){
	header("Location: /tepass/signin"); 
}
$this->need('header.php');

//获取支付相关的配置参数
$db = Typecho_Db::get();

//检测并更新用户会员状态，在三个地方都做了检测，refresh,my,buy
$user=Typecho_Widget::widget('Widget_User');
if($user->uid > 0){
	$rsvips=$db->fetchRow($db->select()->from('table.tepass_vips')->where('table.tepass_vips.vip_uid=?',$user->uid)->limit(1));
	$rsconfig=$db->fetchRow($db->select()->from ('table.tepass_configs')->where('cfg_key = ?',"months_for_upgrade_eternal")->limit(1));
	//先检测一下用户是否存在，不存在就在会员中心增加
	if(empty($rsvips)){
		$invcode = $_COOKIE["TePassRefCookie"]==""?1:$_COOKIE["TePassRefCookie"];
		//随机生成邀请码
		static $source_string = 'E5FCDG3HQA4B1NOPIJ2RSTUV67MWX89KLYZ';
		$num = $user->uid;
		$code = '';
		while ( $num > 0) {
			$mod = $num % 35;
			$num = ($num - $mod) / 35;
			$code = $source_string[$mod].$code;
		}
		if(empty($code[3])){
			$code = str_pad($code,4,'0',STR_PAD_LEFT);
		}
		$refcode = chr(rand(65,90)).$code;
		$refrate=$db->fetchRow($db->select()->from('table.tepass_configs')->where('table.tepass_configs.cfg_key=?',"ref_rate")->limit(1));
		if(!empty($refrate['cfg_value'])){
			$ref_rate = $refrate['cfg_value'];
		}else{
			$ref_rate = "0.00";
		}
		$sql = $db->insert('table.tepass_vips')->rows(array('vip_uid' => $user->uid, 'vip_username' => $user->name, 'vip_desc' => $user->screenName, 'vip_email' => $user->mail, 'vip_endtime' => 0, 'vip_status' => 0, 'vip_invcode' => $invcode, 'vip_refcode' => $refcode,  'vip_ref_rate' => $ref_rate, 'vip_intime' => date('Y-m-d H:i:s',time())));
		$db->query($sql);
	}
	
	//检查用户会员是否到期
	if($rsvips["vip_status"] < $rsconfig['cfg_value']){
		if(time() > $rsvips["vip_endtime"]){
			$updateVipstatus = $db->update('table.tepass_vips')->rows(array('vip_status'=>0))->where('vip_uid=?',$user->uid);
			$updateVipstatusRows= $db->query($updateVipstatus);	
		}		
	}

	//2.1更新用户的总支出vip_total_costs，单位为分
	$rstotal_cost=$db->fetchAll($db->select('fee_total_price')->from ('table.tepass_fees')->where('fee_uid=?',$user->uid)->where('fee_status=?',1)->where('fee_type < 3'));//充值或单独购买总支出
	$total_cost = 0;
	foreach($rstotal_cost as $key=>$val){
		$total_cost += $val['fee_total_price']*100;//单位为分
	}					
	$updateTotalCost = $db->update('table.tepass_vips')->rows(array('vip_total_costs'=>$total_cost))->where('vip_uid=?',$user->uid);
	$updateTotalCostRows= $db->query($updateTotalCost);	

	//2.2更新用户的推广总收益 vip_total_ref_income，单位为分
	$rstotal_income=$db->fetchAll($db->select('fee_total_price')->from ('table.tepass_fees')->join('table.tepass_vips', 'table.tepass_vips.vip_uid = table.tepass_fees.fee_uid', Typecho_Db::LEFT_JOIN)->where('vip_invcode=?',$rsvips["vip_refcode"])->where('fee_status=?',1));
	$total_income = 0;
	foreach($rstotal_income as $key=>$val){
		$total_income += $val['fee_total_price']*100;//单位为分
	}
	$total_ref_income = $total_income * $rsvips["vip_ref_rate"];//计算出总推广收益
	$total_money = (int)$rsvips["vip_points"] + (int)$total_ref_income;
	$updateTotalIncome = $db->update('table.tepass_vips')->rows(array('vip_total_income'=>(int)$total_income,'vip_total_ref_income'=>(int)$total_ref_income,'vip_money'=>(int)$total_money))->where('vip_uid=?',$user->uid);
	$updateTotalIncomeRows= $db->query($updateTotalIncome);		
}
?>


<div class="main container">
	<div class="topic_header" style=" border-bottom: 1px solid #E2E2E2;">
		<h1 style="font-size: 18px; font-weight: blod">
			<?php echo $this->user->screenName; ?> - 个人设置
		</h1>
	</div>
	 <div style="line-height: 23px; overflow: hidden; word-wrap: break-word;">                
		<!-- form -->
		<?php Typecho_Widget::widget('Widget_Security')->to($security); ?>
		<form action="<?php $security->index('/action/users-profile'); ?>" method="post" class="input-form form" name=forma enctype="application/x-www-form-urlencoded">
		<h2 class="form__title">用户中心</h2>
		<table cellpadding="5" cellspacing="0" border="0" width="100%">
			<tbody>
				<tr>
				<td width="120" align="right">用户ID:</td>
				<td width="auto" align="left"><input name="username"  type="text" class="s1" value="<?php echo $this->user->uid; ?>" readonly  unselectable="on"></td>
				</tr>
				<tr>
				<td width="120" align="right">帐号:</td>
				<td width="auto" align="left"><input name="title"  type="text" class="s1" value="<?php echo $this->user->name; ?>" readonly  unselectable="on"> </td>
				</tr>
				<tr>
				<td width="120" align="right">昵称:</td>
				<td width="auto" align="left"><input name="screenName"  type="text" class="s1" value="<?php echo $this->user->screenName; ?>" <?php if($GLOBALS['lock']==1): ?> readonly  unselectable="on"<?php endif; ?>></td>
				</tr>
				<tr>
				<td width="120" align="right">联系:</td>
				<td width="auto" align="left"><input name="mail" type="text" class="s1" value="<?php echo $this->user->mail; ?>" <?php if($GLOBALS['lock']==1): ?> readonly  unselectable="on"<?php endif; ?>></td>
				</tr>
				<tr>
				<td width="120" align="right"></td>
				<td width="auto" align="left"><input name="do" type="hidden" value="profile">
					<button class="s2" type="submit" name="dosubmit"><span>确定</span></button></td>
				</tr>
			</tbody>
		</table>
		</form>
		<!-- end form --> 
	</div>



	<?php if(!$this->user->pass('contributor', true)){ ?>
	<div>
		<div style="margin-bottom: 5px; "></div>		
			<h2 class="form__title">邮箱验证</h2>
			<div style="padding: 20px 36px">提示：权限不足，无法发帖！<a href="/tepass/sendmail"><button class="s2">邮箱验证</button></a></div>
	</div>
	<?php } ?> 
	
	<div>
		<div style="margin-bottom: 5px; "></div>		
			<h2 class="form__title">一句话介绍自己</h2>
			<div style="padding: 5px 10px">
				<form action="" method="post" data-regestered="introduce">
					<textarea maxlength="50" rows="3" name="vip_desc" class="m1" placeholder="看看花和草"></textarea>
					<input type="submit" name="btn_submit" class="s2" value="保存">
				</form>
				<?php
				if(@$_POST["btn_submit"]){
					$updateVipdesc = $db->update('table.tepass_vips')->rows(array('vip_desc'=>htmlspecialchars($_POST["vip_desc"])))->where('vip_uid=?',$user->uid);
					$updateVipdescRows= $db->query($updateVipdesc);	
				}
				?>	
			</div>
	</div>


	<div>
		<div style="margin-bottom: 5px; "></div>		
			<h2 class="form__title">绑定社交登录</h2>
			<div style="padding: 5px 26px">
			<?php
				$snsSql = $db->select()->from('table.tepass_configs')->where('table.tepass_configs.cfg_type=?',"sns");
				$snsSqlRows = $db->fetchAll($snsSql);

				$key = array_column($snsSqlRows, 'cfg_key');
				$value = array_column($snsSqlRows, 'cfg_value');

				$snsRows = array_combine($key, $value);
				
				if(!empty($snsRows['weibo_login'])){ 				
					$rssina=$db->fetchRow($db->select()->from ('table.tepass_sns')->where ('table.tepass_sns.uid=?  AND table.tepass_sns.platform = ?',$user->uid, 'sina')->limit(1));
					if(!empty($rssina)){
						echo '<a href="/tepass/wb_login" rel="nofollow"><img src="/usr/plugins/TePass/static/sns/icon_weibo.png" class="sns_icon"></a>';
					}else{
						echo '<a href="/tepass/wb_login" rel="nofollow"><img src="/usr/plugins/TePass/static/sns/icon_weibo_no.png" class="sns_icon"></a>';
					}
				}
				if(!empty($snsRows['qq_login'])){
					$rsqq=$db->fetchRow($db->select()->from ('table.tepass_sns')->where ('table.tepass_sns.uid=?  AND table.tepass_sns.platform = ?',$user->uid, 'qq')->limit(1));
					if(!empty($rsqq)){
					  echo '<a href="/tepass/qq_login" rel="nofollow"><img src="/usr/plugins/TePass/static/sns/icon_qq.png" class="sns_icon"></a>';
					}else{
					  echo '<a href="/tepass/qq_login" rel="nofollow"><img src="/usr/plugins/TePass/static/sns/icon_qq_no.png" class="sns_icon"></a>';	
					}
				}
				if(!empty($snsRows['github_login'])){
					$rsgithub=$db->fetchRow($db->select()->from ('table.tepass_sns')->where ('table.tepass_sns.uid=?  AND table.tepass_sns.platform = ?',$user->uid, 'github')->limit(1));
					if(!empty($rsgithub)){
					  echo '<a href="/tepass/gh_login" rel="nofollow"><img src="/usr/plugins/TePass/static/sns/icon_github.png" class="sns_icon"></a>';
					}else{
					  echo '<a href="/tepass/gh_login" rel="nofollow"><img src="/usr/plugins/TePass/static/sns/icon_github_no.png" class="sns_icon"></a>';	
					}
				} 
				if(!empty($snsRows['wechat_login'])){
					$rspayjs=$db->fetchRow($db->select()->from ('table.tepass_sns')->where ('table.tepass_sns.uid=?  AND table.tepass_sns.platform = ?',$user->uid, 'payjs')->limit(1));
					$uniqid = md5(uniqid(microtime(true),true));
					$uid_auth = $user->uid.'-'.$uniqid;
					if(!empty($rspayjs)){
					  echo '<a href="/tepass/wx_login?uid_auth='.$uid_auth.'" rel="nofollow"><img src="/usr/plugins/TePass/static/sns/icon_wechat.png" class="sns_icon"></a>';
					}else{
					  echo '<a href="/tepass/wx_login?uid_auth='.$uid_auth.'" rel="nofollow"><img src="/usr/plugins/TePass/static/sns/icon_wechat_no.png" class="sns_icon"></a>';			
					}
				} 
			?>
			</div>
	</div>
	
	<div>
		<div style="padding: 5px;margin-bottom: 5px; "></div>
			<!-- form -->                          
			<form action="<?php $security->index('/action/users-profile'); ?>" method="post"  class="input-form form" enctype="application/x-www-form-urlencoded" >
			<h2 class="form__title">修改密码</h2>
			<?php if(!$this->user->pass('subscriber', true)){
				echo "提示：权限不足，无法修改个人账户密码！";
			}?>
			<table cellpadding="5" cellspacing="0" border="0" width="100%">
				<tbody>
					<tr>
					<td width="120" align="right">密码：</td>
					<td width="auto" align="left"><input type="text" name="password" class="s1" ></td>
					</tr>
					<tr>
					<td width="120" align="right">重复密码:</td>
					<td width="auto" align="left"><input class="s1" type="text" name="confirm"></td>
					</tr>
					<tr>
					<td width="120" align="right"></td>
					<td width="auto" align="left"><input name="do" type="hidden" value="password">
						<button class="s2" type="submit" name="dosubmit" ><span>确定</span></button></td>
					</tr>
				</tbody>
			</table>				
			</form>
			<!-- end form -->    
	</div>

</div>

<!-- footer -->
<?php $this->need('footer.php'); ?>
<!-- end footer -->