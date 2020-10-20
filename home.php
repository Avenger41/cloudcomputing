<?php
session_start();
include("config.php");

if(!isset($_REQUEST['page'])){$page=1;$page_next=2;$page_prev=null;$page_max=3;}else{$page=$_REQUEST['page'];$page_next=$_REQUEST['page']+1;$page_prev=$_REQUEST['page']-1;}
if($page>=3){$page_min=$page-1;}else{$page_min=1;}
$page_max=$page+1;
$rs=mysqli_query($cn,"select * from items");
$max_item=3;
$sum_item=mysqli_num_rows($rs);
$sum_page=ceil($sum_item/$max_item);
if(($page+1)>=$sum_page){
	$page_max=$sum_page;$page_next=null;
}
else{
	$page_max=$page_min+2;
}
$limit=($page-1)*$max_item;
$limit=$limit.",".$max_item;
$rs=mysqli_query($cn,"select * from items limit $limit ");

echo "<a href='add.php'>Add Item</a>";
echo "<table border=1>
		<tr>
			<th>iditem</th>
			<th>iduser_owner</th>
			<th>name</th>
			<th>date_posting</th>
			<th>price_initial</th>
			<th>status</th>
			<th>image_extention</th>
			<th>Action</th>
		</tr>";
while($row=mysqli_fetch_Array($rs)){
	echo "<tr><td>$row[iditem]</td><td>$row[iduser_owner]</td><td>$row[name]</td><td>$row[date_posting]</td><td>$row[price_initial]</td><td>$row[status]</td><td><img src='data:image/jpg;base64,".base64_encode($row['image']). "' width=100></td><td>";
	if($_SESSION['iduser']==$row['iduser_owner']){
		echo "<a href='detail.php?iditem=$row[iditem]'><button>DETAIL</button></a>";
		if($row['status']=='OPEN'){
			echo "<br><a href='?set=cancel&iditem=$row[iditem]'><button>CANCEL</button></a>";}
		else{
			echo "<br><a href='?set=open&iditem=$row[iditem]'><button>OPEN</button></a>";}
	}
	else{
		if(mysqli_num_rows(mysqli_query($cn,"select * from biddings WHERE iduser='$_SESSION[iduser]' AND iditem='$row[iditem]'"))==0){
		echo "<br><form action='home.php?iditem=$row[iditem]' method=post><input type=text name='price_offer'><input type=submit value='bid'></form></a>";}
		else{
			$rb=mysqli_query($cn,"select * from biddings WHERE iduser='$_SESSION[iduser]' AND iditem='$row[iditem]'");
			while($r=mysqli_fetch_array($rb)){echo "$r[price_offer]";}
		}
	}
	echo "</td></tr>";
}
echo "</table>";
echo "
	<div style='display:inline-block;text-decoration: none;'><ul>
						<li style='display:inline-block;text-decoration: none;'";if($page_prev==null){echo " class='disabled'";}echo ">";if($page_prev==null){echo "<a href='#'><button>Prev</button></a>";}else{echo "<a href='home.php?page=$page_prev'><button>Prev</button></a>";}echo "</li>";
						for($i=$page_min;$i<=$page_max;$i++){		
							echo "<li style='display:inline-block;text-decoration: none;'";if($page==$i){echo " class='active'";}echo "><a href='home.php?page=$i'><button>$i</button></a></li>";
						}
					echo "<li style='display:inline-block;text-decoration: none;'";if($page_next==null){echo " class='disabled'";}echo ">";if($page_next==null){echo "<a href=''><button>Next</button></a>";}else{echo "<a href='home.php?page=$page_next'>Next</a>";}echo "</li>
					</ul></div><br>
	";

echo "<a href='?logout=1'>Logout</a>";
if(isset($_REQUEST['logout'])){
	session_destroy();
	echo "<script>alert('Anda Logout');self.location='index.php'</script>";
}
if(isset($_REQUEST['set'])){
	mysqli_query($cn,"UPDATE items SET status='$_REQUEST[set]' WHERE iditem='$_REQUEST[iditem]'");
	echo "<script>alert('Status Berubah');self.location='home.php'</script>";
}
if(isset($_REQUEST['price_offer'])){
	mysqli_query($cn,"INSERT INTO biddings VALUES('$_SESSION[iduser]','$_REQUEST[iditem]','$_REQUEST[price_offer]',0)");
	echo "<script>alert('Bid Telah Aktif');self.location='home.php'</script>";
}
?>