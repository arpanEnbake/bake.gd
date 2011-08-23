<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php echo $this->load->view('header_new_includes');?>
<body>
	<?php echo $this->load->view('inner_elements/header_new'); ?>
	
	<?php $host = isset($account) && isset($account->domain) ? $account->domain : $_SERVER['HTTP_HOST'];?>
	<?php if(!isset($twitter)) $twitter = null;?>
	<?php if(!isset($fb)) $fb = null;?>

	<!-- BODY START-->
	<div id="mainBody">
		<div id="body">
			<div class="content">
				<div class="subheader">
					<span style="float:left">
						<h1><?php echo 'http://' . $url->domain . '/' . $url->keyword;?></h1>
					</span>
					<?php echo form_open(uri_string(), array('id'=>'TimePeriodFormId', 'class'=>'settings_form')); ?>
						<span style="float:right;">
							<select name="data[Time][period]" id="TimePeriodDDId" class="select_input">
								<option value="1">Past Hour</option>
								<option selected ="selected" value="<?php echo 7 * 24;?>">Past 7 days</option>
								<option value="<?php echo 14 * 24;?>">Past 14 days</option>
								<option value="<?php echo 30 * 24;?>">Past 30 days</option>
							</select>
						</span>
					<?php echo form_close()?>
					<!-- <span style="float:right;">
						<ul>
							<li><a href="#">Copy</a></li>
							<li><a href="#">Share</a></li>
						</ul>
					</span>  -->
				</div>
				<div class="link_detail">
					<h2 id="link_title"><?php echo $url->title; ?></h2>
					<ul class="stats">
						<li class="clearfix">
							<span class="label">Link:</span><?php echo $url->url; ?>
						</li>
						<li class="clearfix">
							<span class="label"  style="line-height:24px;">Social Stats:</span>
							<ul style="line-height:24px;">
								<li style="display:inline;"><span class="count"><?php echo $url->retweets > 0 ? $url->retweets : 0; ?></span>RTs</li>
								<li style="display:inline;"><span class="count"><?php echo $url->likes > 0 ? $url->likes : 0; ?></span>Likes</li>
							</ul>
						</li>
						<li class="clearfix">
						<?php $total_count = 0;
							if (isset($clicks)) {
						?>
						<span class="label"  style="line-height:24px;">Clicks Summary:</span>
						<ul style="line-height:24px;">
							<?php 
								foreach($clicks as $key => $count) {
							?>
							<li style="display:inline;"><span class="count"><?php echo $count->Count; ?></span>via <?php echo $count->referrer; ?></li>
							<?php $total_count += $count->Count;
							} ?>
							<li style="display:inline;"><span class="count"><?php echo $total_count; ?></span> Total Clicks</li>
						</ul>
						<?php } ?>
						</li>
					</ul>
				</div>
				<?php echo  $this->load->view('analytics/highcharts', array('url_id'=>$url->id)); ?>
			</div> <!-- body -->
		</div> <!-- main body -->
	</div>
	<?php echo $this->load->view('inner_elements/footer'); ?>
</body>
</html>
