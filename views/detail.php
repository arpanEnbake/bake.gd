

<?php echo $this->load->view('inner_elements/header'); ?>

<!-- BODY START-->
<div id="mainBody">
<div id="body">
<div class="content">
<div class="left">
<p>



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

			
</div>  <!-- end #container -->
</div>
</div> <!-- body -->
</div> <!-- main body -->
<?php echo $this->load->view('inner_elements/footer'); ?>
