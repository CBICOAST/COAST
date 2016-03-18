<html>
<head>
	<title>Upload Supporting Document</title>
</head>
<body>
 
	<?php echo $error;?>
 
	<?php echo form_open_multipart('c_oas099/upload');
echo form_upload('dokumen');
echo form_submit('kirim','upload');
	?>
 
</form>


 
</body>
</html>