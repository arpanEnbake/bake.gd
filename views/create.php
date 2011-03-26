<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>URL Shortner</title>

<base href="<?php echo base_url(); ?>" />
<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" />
<link type="text/css" rel="stylesheet" href="resource/app/css/960gs.css" />
<link type="text/css" rel="stylesheet" href="resource/app/css/style.css" />
</head>
<body>
<?php echo $this->load->view('header'); ?>
<?php echo validation_errors(); ?>

<?php echo form_open('/home/index'); ?>
<h5>Enter the URL to Shorten</h5>
<input type="text" name="url" value="<?php echo set_value('url', $url); ?>" size="50" />

<div><input type="submit" value="Submit" /></div>

</form>

<?php echo $this->load->view('footer'); ?>
</body>
</html>

		
		
		