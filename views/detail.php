<?php echo $this->load->view('inner_elements/header'); ?>
<script src="resource/app/js/ZeroClipboard.js" type="text/javascript"></script>

<?php $host = isset($account) && isset($account->domain) ? $account->domain : $_SERVER['HTTP_HOST'];?>
<?php if(!isset($twitter)) $twitter = null;?>
<?php if(!isset($fb)) $fb = null;?>


<!-- BODY START-->
<div id="mainBody">
<div id="body">
<div class="content">
<div class="left">
			
</div>  <!-- end left -->
</div>

			<h1>Shortened URL: <?php echo 'http://' . $url->domain . '/' . $url->keyword;?></h1>
			Created on <?php echo $url->timestamp?> by <?php echo $user->username?>
			<h2>Keyword: <?php echo $url->keyword?></h2>
			<h2>URL: <?php echo $url->url?></h2>
			<h3>Clicks:</h3>
			<?php $total_count = 0;
				if (isset($clicks)) {
				foreach($clicks as $key => $count) {
					echo "Clicks via  $count->referrer : $count->Count <br />";
					$total_count += $count->Count;
				}
			}
			echo "Total Clicks: $total_count";
			?>
			
<?php echo "<h2>Retweets made : $url->retweets </h2><br />" ;?>
<?php echo "<h2>FB Likes : $url->likes </h2><br />" ;?>



<?php echo  $this->load->view('analytics/graphs'); ?>
</div> <!-- body -->
</div> <!-- main body -->
<?php echo $this->load->view('inner_elements/footer'); ?>
