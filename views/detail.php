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


<div class="Container"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="84%">  <p><strong>10 Click(s) on this link </strong></p></td>
    <td width="16%"><select style="width:170px;"><option>one</option><option>one</option><option>one</option></select></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td align="center" valign="middle" bgcolor="#BCDCFA">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="middle" bgcolor="#BCDCFA"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>1</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>2</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
          <tr>
            <td colspan="6" align="left" valign="top" bgcolor="#FFFFFF">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
                  <tr>
                    <td width="17%" bgcolor="#FFFFFF"><p>&nbsp;</p>
                        <p>&nbsp;</p>
                      <p>&nbsp;</p>
                      <p>&nbsp;</p>
                      <p>&nbsp;</p></td>
                    <td width="17%" bgcolor="#FFFFFF">&nbsp;</td>
                    <td width="10%" bgcolor="#6baff0">&nbsp;</td>
                    <td width="29%" bgcolor="#FFFFFF">&nbsp;</td>
                    <td width="10%" bgcolor="#6BAFF0">&nbsp;</td>
                    <td width="17%" bgcolor="#FFFFFF">&nbsp;</td>
                  </tr>
                </table>
                </td>
            </tr>
          <tr>
            <td width="17%">0 May 16, 2011</td>
            <td width="17%">0 May 16, 2011</td>
            <td width="10%" nowrap>0 May 16, 2011</td>
            <td width="29%">0 May 16, 2011</td>
            <td width="10%" nowrap>0 May 16, 2011</td>
            <td width="17%">0 May 16, 2011</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="middle" bgcolor="#BCDCFA">&nbsp;</td>
  </tr>
</table>
</div>

</div> <!-- body -->
</div> <!-- main body -->
<?php echo $this->load->view('inner_elements/footer'); ?>
