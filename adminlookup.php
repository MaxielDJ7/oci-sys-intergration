<?php

	//echo 'admin orders<br>';
	include('account_new.php');

	//changes
	if($_GET['request']=='Update'){

	$order = $_GET["order"];
	$cust = $_GET["customer"];
	$date = $_GET["date"];
	$total = $_GET["total"];
	$status = $_GET["status"];
	$invoice = $_GET["invoice"];

	echo $date;
	echo $status;
	echo $order;
	//debug and fix SQL statement here *****
	//echo 'test<br>' . $order . '<br>' . $cust . '<br>' . $date . '<br>' . $total . '<br>' . $status . '<br>';

	$sql = "UPDATE Orders SET Order_Status='".$status."',Order_Date='".$date."' WHERE Order_Number_ID='".$order."'";
	// 4/19 debug status and shipping date update
    // Prepare statement
    $stmt = $DBH->prepare($sql);
    // execute the query
    $stmt->execute();

	//invoice update
	$sql = "UPDATE `Invoice` SET Invoice_Status='".$invoice."' WHERE Order_Number='".$order."'";
	echo '<br>inoice';
	echo $invoice;
	echo $order;
	echo '<br>';
	// Prepare statement
    $stmt = $DBH->prepare($sql);
    // execute the query
    $stmt->execute();
	header( 'Location: adminlookup.html' ) ;
}







	$query = "SELECT * FROM Orders INNER JOIN Invoice on Orders.Order_Number_ID=Invoice.Order_Number";

	if($_GET['request']=='Find'){
		$orderNum = $_GET['name'];
		$query .= " WHERE Order_Number_ID='".$orderNum."'";
		//echo $orderNum;
	}
	$STH = $DBH->prepare($query);

	$STH->execute();
	echo "Orders found: " .$STH->rowCount();
	echo "<br>";
	//echo "<table><tr><th></th><tr/>";
	while($row = $STH->fetch(PDO::FETCH_ASSOC)){
		//echo '<tr><td>';
		$order = $row["Order_Number_ID"];
		$cust = $row["Customer_ID"];
		$date = $row["Order_Date"];
		$total = $row["Total_Amount"];
		$status = $row["Order_Status"];
		$inv_num = $row["Invoice_Number"];
		$inv_stat = $row["Invoice_Status"];

		echo "<form action=\"adminlookup.php\">";

		echo "<div class= ' aorderlookup col-md-4'> ";

		echo "<h6> Order Number: ".$order. "</h6>";
		echo '<h6> Customer ID: '.$cust. "</h6>";
		echo '<h6> Order  Total: '.$total. "</h6>";
		echo '<h6> Invoice Number: '.$inv_num."</h6>";

		echo 'Shipping Date';
		echo "<input type=\"text\" name=\"date\" class=\"form-control input\" value=\"$date\" id=\"quantity\">";
		echo "<input type=\"hidden\" name=\"order\" value=\"$order\">";

		echo 'Order Status';
		echo "<input type=\"text\" name=\"status\" class= \"form-control input\" value=\"$status\" id=\"cat\">";
		echo 'Invoice Status';
		echo "<input type=\"text\" name=\"invoice\" class= \"form-control input\" value=\"$inv_stat\" id=\"cat\">";
		echo "<input type=\"submit\" class= \" btn-xs btn\" name=\"request\" value=\"Update\"> ";

		echo " </form>";


		echo "<form action=\"ship.php\">";
		echo "<input type=\"hidden\" name=\"order\" value=\"$order\">";
		echo "<input type=\"submit\" class= \" btn-xs btn\" name=\"request\" value=\"Modify Shipment\"> ";

		echo "<br></br>";
		echo "</form>";

		echo "</div>";
		//echo '</td></tr>';
	}
	//print_r($DBH->errorInfo());
	//echo '<tr><td></td></tr>';
	//echo '</table>';
	//echo 'complete';
?>
