<?php
	$code = $_POST['cargo'];
	include('account_new.php');
	$sql = "SELECT * FROM Order_Details WHERE Order_Number='".$code."'";
	
	$STH = $DBH->query("$sql");
	$STH->setFetchMode(PDO::FETCH_ASSOC);
while($row = $STH->fetch()){
	$group['Item']=$row['Item_Code'];
	$group['Quantity']=$row['Item_Quantity'];
	$total[]=$group;
}

	echo json_encode($total);
?>