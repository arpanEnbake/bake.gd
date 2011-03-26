<html>
<head>
</head>
<body>
sssssssssss<?php echo validation_errors(); ?>

<?php echo form_open('home/index'); ?>

<h5>Enter the URL to Shorten</h5>
<input type="text" name="url" value="<?php echo set_value('url'); ?>" size="50" />

<div><input type="submit" value="Submit" /></div>

</form>

</body>
</html>