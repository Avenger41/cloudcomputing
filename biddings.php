<?php
session_start();
include("config.php");
$rs=mysqli_query($cn,"select * from items");
echo $_SESSION['iduser'];
echo "<table border=1>
		<tr>
			<th>iditem</th>
			<th>iduser_owner</th>
			<th>name</th>
			<th>date_posting</th>
			<th>price_initial</th>
			<th>status</th>
			<th>image_extention</th>
		</tr>";
while($row=mysqli_fetch_Array($rs)){
	echo "<tr>
			<td>$row[iditem]</td>
			<td>$row[iduser_owner]</td>
			<td>$row[name]</td>
			<td>$row[date_posting]</td>
			<td>$row[price_initial]</td>
			<td>$row[status]";
	if($_SESSION['iduser']==$row['iduser_owner']){
		if($row['status']=='OPEN'){
			echo "<button><a href='?set=cancel'>CANCEL</a></button>";}
		else{
			echo "<button><a href='?set=open'>OPEN</a></button>";}
	}
	echo "</td><td>$row[image_extention]</td>
		</tr>";
}
echo "</table>";
if(isset($_REQUEST['set'])){
	mysqli_query($cn,"UPDATE items SET status='$_REQUEST[set]'");
	echo "<script>alert('Status Berubah');self.location='home.php'</script>";
}
?>