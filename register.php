<?php include('config.php');?>
<html>
<head>
	<title>Register</title>
</head>
<body>
	<h1>Register</h1>
	<form action='?' method=post>
		Username:<br>
		<input type=text name='iduser'><br>
		Name:<br>
		<input type=text name='name'><br>
		Password:<br>
		<input type=password name='password'><br>
		<input type=hidden name='salt' value='<?php echo (rand(1,8).date('Ymdhis')); ?>'><br>
		<input type=submit value=OK>
	</form>
</body>
</html>
<?php
 if(isset($_REQUEST['iduser'])){
	 mysqli_query($cn,"INSERT into users VALUES('$_REQUEST[iduser]','$_REQUEST[name]','".crypt($_REQUEST['password'],$_REQUEST['salt'])."','$_REQUEST[salt]')");
	 echo "<script>alert('Pendaftaran Berhasil');self.location='index.php'</script>";
 }
?>
