<?php
	//echo 'admin inventory<br>';
	include('account_new.php');

	$count= 0;

if($_GET['request']=='Update'){
	$quant = $_GET['quantity'];
	$code = $_GET['code'];
	$name = $_GET['name'];
	$desc = $_GET['description'];
	$price = $_GET['price'];
	$cat = $_GET['category'];
	echo $code;
	$sql = "UPDATE Inventory SET Item_Name='".$name."',OnHand_Quantity='".$quant."',Price='".$price."',Category='".$cat."' WHERE Item_Code='$code'";

    // Prepare statement
    $stmt = $DBH->prepare($sql);
    // execute the query
    $stmt->execute();

    echo $stmt->rowCount() . " records UPDATED successfully";
	header( 'Location: inventory.html' ) ;
}


if($_GET['request']=='Add'){
	echo '<br>adding<br>';

	$quant = $_GET['quantity'];
	$code = $_GET['code'];
	$name = $_GET['name'];
	$desc = $_GET['description'];
	$price = $_GET['price'];
	$cat = $_GET['category'];

	$sql = "INSERT INTO `Inventory`(`Item_Name`, `Item_Code`, `Item_Description`, `OnHand_Quantity`, `Price`, `Image`, `Category`)
	VALUES ('".$name."','".$code."','".$desc."','".$quant."','".$price."',NULL,'".$cat."')";

	// Prepare statement
    $stmt = $DBH->prepare($sql);
    // execute the query
    $stmt->execute();
	header( 'Location: inventory.html' ) ;
}


if($_GET['request']=='Delete'){
	echo '<br>deleting<br>';
	$code = $_GET['code'];

	$sql = "DELETE FROM `Inventory` WHERE Item_Code=".$code;
	// Prepare statement
    $stmt = $DBH->prepare($sql);
    // execute the query
    $stmt->execute();
	header( 'Location: inventory.html' ) ;
}



	$STH = $DBH->query("SELECT * FROM Inventory");


	$STH->setFetchMode(PDO::FETCH_ASSOC);
while($row = $STH->fetch()){

	$count++;

	$quant = $row['OnHand_Quantity'];
	$code = $row['Item_Code'];
	$name = $row['Item_Name'];
	$desc = $row['Item_Description'];
	$price = $row['Price'];
	$cat = $row['Category'];

	echo "<form action=\"inventory.php\">";
	echo "<div class= 'col-md-4'>";

	echo "<h6> Product: ".$count."</h6>";

	echo '<h6> Product Name: </h6>';
	echo "<input type=\"text\" name=\"name\" class=\"form-control input\" value=\"$name\" id=\"name\">";

	echo '<h6>Product Code:</h6>';
	echo "<input type=\"number\" name=\"code\" class=\"form-control input\" value=\"$code\" id=\"code\">";

	echo '<h6>Quantity</h6>';
  echo "<input type=\"number\" name=\"quantity\" class=\"form-control input\" value=\"$quant\" id=\"quantity\">";

	echo "<h6>Price</h6>";
	echo "<input type=\"number\" name=\"price\" class=\"form-control input\" value=\"$price\" id=\"price\">";

	echo '<h6>Category</h6>';
	echo "<input type=\"text\" name=\"category\" class=\"form-control input\" value=\"$cat\" id=\"cat\">";

	echo '<h6>Description: </h6>';
	echo "<input type=\"text\" name=\"description\" class=\"form-control input\" value=\"$desc\" id=\"desc\">";


	echo "<input type=\"submit\" name=\"request\" class=\"btn btn-xs btn-primary\" value=\"Update\">";
	echo "<input type=\"submit\" name=\"request\" class=\"btn btn-xs btn-primary\" value=\"Delete\">";
	echo "<br> </br> <br> </br>";
	echo "</form>";


	echo "</div>";


}

	//echo 'complete';
?>
