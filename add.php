<html>
<head>
	<title>Items</title>
</head>
<body>
	<h1>Add Items</h1>
	<form action='?' method=post enctype='multipart/form-data'>
		name:<br>
		<input type=text name='name'><br>
		price initial:<br>
		<input type=text name='price_initial'><br>
		image:<br>
		<input type=file name='image'><br>
		<input type=submit value=OK>
	</form>
</body>
</html>
<?php
	session_start();
	include("config.php");
 if(isset($_REQUEST['name'])){
	move_uploaded_file($_FILES['image']['tmp_name'],"t.jpg");
	$img = imagecreatefromjpeg("t.jpg");
	$img = imagescale($img, 200, 200);
	$img=file_get_contents("t.jpg");
	$img = mysqli_real_escape_string($cn,$img);
	unlink("t.jpg");
	mysqli_query($cn,"INSERT into items(iduser_owner,name,date_posting,price_initial,status,image) VALUES('$_SESSION[iduser]','$_REQUEST[name]','".date('Y-m-d')."','$_REQUEST[price_initial]','OPEN','$img')");
	echo "<script>alert('Item Berhasil Ditambahkan');self.location='home.php'</script>";
 }
?>
