<?php 
session_start();
include('config.php');
?>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<h1>Login</h1>
	<form action='?' method=post>
		Username:<br>
		<input type=text name=iduser><br>
		Password:<br>
		<input type=password name=password><br>
		<input type=submit value=OK>
	</form>
	<a href='register.php'>Register</a>
	<ul>
		<li>user:ody21, pw:ody</li>
		<li>user:helo1, pw:helo</li>
		<li>user:kowe1, pw:kowe</li>
	</ul>
</body>
</html>
<?php
 if(isset($_REQUEST['iduser'])){
 $rs=mysqli_query($cn,"select * from users where iduser='$_REQUEST[iduser]'");
 while($row=mysqli_fetch_Array($rs)){$salt=$row['salt'];$password=$row['password'];$name=$row['name'];} 
	if (hash_equals($password, crypt($_REQUEST['password'], $salt))) {
		$_SESSION['iduser']=$_REQUEST['iduser'];
		$_SESSION['name']=$name;
		echo "<script>alert('Selamat Datang $_REQUEST[iduser]!');self.location='home.php'</script>";
	}
	else{
		echo "<script>alert('Login Gagal');self.location='index.php'</script>";
	}
 }
?>
