<html>
<head>
<link href=' css/bootstrap.css' rel= 'stylesheet'>
    <link href=' css/style.css' rel= 'stylesheet'>
<nav class= 'row row-centered'>
        <div class= "col-md-12 col-centered">

          <a href="index.php"> Browse </a>
          <a href="cart.html"> Cart </a>
          <a href="index.php"> <img src="images/logo.png" id="logo"> </a>
          <a href="custlookup.html"> Lookup </a>
          <a href="inventory.html"> Admin </a>
        </div>
</nav>


</head>
<body>



<?php
error_reporting(E_ALL);
include('account_new.php');

$customer= 85235;
$name= $_GET['name'];
$phone= $_GET['phone'];
$email= $_GET['email'];
$pass= $_GET['password'];
$str1= $_GET['street1'];
$str2= $_GET['street2'];
$city= $_GET['city'];
$st= $_GET['state'];
$country= $_GET['country'];
$zip= $_GET['zip'];


echo "<div class=\"row row-centered\"> ";
echo "<div class=\"confirmphp col-md-6 col-md-offset-3\">";

echo '<h2> Purchase Confirmation</h2><br>';



//Customer database
$stmt = $DBH->prepare('INSERT INTO `Customer` (`Customer_ID`, `Customer_Name`, `Phone_Number`, `Email`, `Street1`, `Street2`, `City`, `State`, `Country`, `Zip`)
VALUES ("'.$customer.'","'.$name.'","'.$phone.'","'.$email.'","'.$str1.'","'.$str2.'","'.$city.'","'.$st.'","'.$country.'","'.$zip.'")');
$stmt->execute();

//Account database
$stmt = $DBH->prepare('INSERT INTO `Account`(`Email`, `Password`, `Account_Type`)
VALUES ("'.$email.'","'.$pass.'","1")');
$stmt->execute();

//Get from Cart
$STH = $DBH->query("SELECT Cart.Quantity, Cart.Item_Code,
Inventory.Item_Name, Inventory.Price FROM Cart INNER
JOIN Inventory ON Cart.Item_Code=Inventory.Item_Code WHERE Customer_ID ='85235'");
$STH->setFetchMode(PDO::FETCH_ASSOC);
while($row = $STH->fetch()){
	$quantity= $row['Quantity'];
	$quant[$row['Item_Code']]= $quantity;
	$price= $row['Price'];
	$partial= $price * $quantity;
	$total = $total + $partial;
}

//Orders database
$order_num= rand(0,10000);
$stmt = $DBH->prepare('INSERT INTO `Orders` (`Order_Number_ID`, `Customer_ID`, `Order_Date`, `Total_Amount`, `Order_Status`)
VALUES ("'.$order_num.'","85235",now(),"'.$total.'","1")');
$stmt->execute();

//Invoice database
$inv_num = rand(0,10000);
$stmt = $DBH->prepare('INSERT INTO `Invoice` (`Invoice_Number`, `Order_Number`, `Invoice_Status`)
VALUES ("'.$inv_num.'","'.$order_num.'","1")');
$stmt->execute();

//Order Details database
foreach($quant as $key1 => $value1){
	$stmt = $DBH->prepare('INSERT INTO `Order_Details` (`Order_Number`, `Item_Code`, `Item_Quantity`)
	VALUES ("'.$order_num.'","'.$key1.'","'.$value1.'")');
	$stmt->execute();
	echo 'item code: '.$key1 . '<br>quantity:'.$value1. "</br>";
}

//Update Inventory
foreach($quant as $key1 => $value1){
    // Prepare statement
    $stmt = $DBH->prepare("UPDATE Inventory SET OnHand_Quantity= OnHand_Quantity - ".$value1."  WHERE Item_Code=".$key1);
    // execute the query
    $stmt->execute();
	//echo $stmt->rowCount() . " records UPDATED successfully";
}


echo "<h4> Customer Information </h4>";
echo $name . '<br>' . $phone . '<br>' . $email . '<br>' . $str1 . '<br>' . $str2 . '<br>';
echo $city . '<br>' . $st . '<br>' . $country . '<br>' . $zip;
echo '<br>order number: ' . $order_num;

echo '<br>total: ' . $total;

echo "</div></div>";
?>


</body>
</html>
