<?php
session_start();
include("config.php");
$rs=mysqli_query($cn,"SELECT * from items where iditem='$_REQUEST[iditem]'");
echo "<h1>Detail Item</h1>";
echo "<h2>Item</h2>";
echo "<table border=1>";
while($row=mysqli_fetch_Array($rs)){
	echo "
	<tr><td>iditem</td><td>$row[iditem]</td></tr>
	<tr><td>iduser</td><td>$row[iduser_owner]</td></tr>
	<tr><td>name</td><td>$row[name]</td></tr>
	<tr><td>Date Posting</td><td>$row[date_posting]</td></tr>
	<tr><td>price_initial</td><td>$row[price_initial]</td></tr>
	<tr><td>Status</td><td>$row[status]</td></tr>
	<tr><td>Gambar</td><td><img src='data:image/jpg;base64,".base64_encode($row['image']). "' width=100></td></tr>";
}
echo "</table>";
echo "<h2>Bidding</h2>";
$rs=mysqli_query($cn,"SELECT * from biddings where iditem='$_REQUEST[iditem]' order by price_offer desc");
echo "<table border=1>";
echo "<tr><td>iduser</td><td>price_offer</td><td>is_winner</td></tr>";
$f=true;
while($row=mysqli_fetch_Array($rs)){
	echo "
	<tr><td>$row[iduser]</td><td>$row[price_offer]</td><td>";
	if($f=true){
		if($row['is_winner']==0){
			echo "<a href='detail.php?iditem=$_REQUEST[iditem]&iduser=$row[iduser]'><button>is_winner</button></a>";$f=false;
		}
		else{
			echo $row['is_winner'];
		}
	}
	else{
	echo $row['is_winner'];
	}
	echo "</td></tr>";
	
}
if(isset($_REQUEST['iduser'])){
	mysqli_query($cn,"UPDATE biddings SET is_winner=1 WHERE iduser='$_REQUEST[iduser]' AND iditem='$_REQUEST[iditem]'");
	mysqli_query($cn,"UPDATE items SET status='SOLD' WHERE iditem='$_REQUEST[iditem]'");
	echo "<script>alert('Winner is set');self.location='detail.php?iditem=$_REQUEST[iditem]'</script>";
}
?>