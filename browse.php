
<?php

session_start();

include 'account_new.php';

//retrieve session id that will be used to set a customer id # for the CART , CUSTOMER, ORDERS,

$count = $_GET['count'];
$category = $_GET['category'];
$arrange = $_GET['arrange'];
//query
$query='SELECT * FROM Inventory';
if($arrange=='namedwn' || $arrange=='nameup'){
	$query=$query . ' ORDER BY Item_Name';
}else{
	$query=$query . ' ORDER BY Price';
}
if($arrange=='nameup' || $arrange=='priceup'){
	$query=$query . ' DESC';
}else{
	$query=$query . ' ASC';
}


if($count!='all'){
	$query=$query . " LIMIT $count";
}
$STH = $DBH->query($query);

// setting the fetch mode
$STH->setFetchMode(PDO::FETCH_ASSOC);
if($count == 'all'){
		echo 'All Products';
	}else{
		echo '1-' . $count;
	}
echo '<br>';
echo "<table><tr><th></th><th></th><tr/>";

while($row = $STH->fetch()){
	echo '<tr>';
		$name = $row['Item_Name'];
		$price = '$' . $row['Price'];
		$code = $row['Item_Code'];
		echo "<td><img src=\"products/$code.png\" id=\"pic1\" ><a href=\"product.php?code=$code\">$name</a></td>";
		echo "<td>$price<br>";

    //removed form action 3/16

  	echo "<form action=\"cart.php\">
		<input type=\"hidden\" name=\"item\" value=\"$code\">
		<input type=\"number\" name=\"quantity\" value=\"1\" style=\"width: 30px;\">
	    <input type=\"submit\" name=\"request\" id= \"Buy\" value=\"Buy\">
		</form>";
		echo "</td>";
  	echo '</tr>';


}
echo '</table>';



//echo '<br>test';
?>
