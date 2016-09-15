<?php


include('account_new.php');

$customer= 85235;



if($_GET['request']=='Update'){
	$quant = $_GET['quantity'];
	$todelete = $_GET['item'];


	$sql = "UPDATE Cart SET Quantity=$quant WHERE Customer_ID=$customer";

    // Prepare statement
    $stmt = $DBH->prepare($sql);
    // execute the query
    $stmt->execute();
	header( 'Location: cart.html' ) ;
}
if($_GET['request']=='Delete'){
	$todelete = $_GET['item'];
	echo 'delete<br>';
	echo $todelete;
	//header( 'Location: ../html/Cart_HTML.html' ) ;
	$sql = "DELETE FROM Cart WHERE Item_Code=$todelete AND Customer_ID=$customer";

    // Prepare statement
    $stmt = $DBH->prepare($sql);
    // execute the query
    $stmt->execute();
	header( 'Location: cart.html' ) ;
}
if($_GET['request']=='Buy'){
	$quant = $_GET['quantity'];
	$code = $_GET['item'];

	$stmt = $DBH->prepare("SELECT * FROM Cart WHERE Customer_ID=$customer AND Item_Code=$code");
	$stmt->bindParam(1, $_GET['id'], PDO::PARAM_INT);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	if( ! $row){

		$sql = "INSERT INTO Cart (Customer_ID,Quantity,Item_Code) VALUES ($customer,$quant,$code)";
		// Execute statement
		$DBH->exec($sql);
	}
	header( 'Location: cart.html' ) ;
}



$STH = $DBH->query("SELECT Cart.Quantity, Cart.Item_Code, Inventory.Item_Name, Inventory.Item_Description, Inventory.Price FROM Cart INNER JOIN Inventory ON Cart.Item_Code=Inventory.Item_Code WHERE Customer_ID = $customer");

// Browser output starts here
//table headings

echo "<form action=\"cart.php\">";
echo "<table class= \"table table-nonfluid\" >";
echo "<thead>
	 <tr>
		 <th> Product </th>
		 <th> Description </th>
		 <th>  Price </th>
		 <th> Quantity </th>
		 <th>  </th>
	 </tr>
 </thead>

 <tbody>";

$total=0;
# setting the fetch mode
$STH->setFetchMode(PDO::FETCH_ASSOC);
while($row = $STH->fetch()){
	$quant = $row['Quantity'];
	$code = $row['Item_Code'];
	$name = $row['Item_Name'];
	$price = $row['Price'];
	$descrip= $row['Item_Description'];


	//table row
	//product cell
	echo "<tr>

		<td>
			<img src=\"products/$code.png\" id=\"pic1\">
			<br>
			<h5>$name </h5>
			</td>";

	//description cell
	echo "<td>
			<h6>Product code: $code</h6>
			<br>".$descrip."
		</td>";

	//price cell
	echo "<td>";

	echo '$' . $price. "</td>";

	//quantity cell
  echo "<td>
		<input type=\"number\" name=\"quantity\" value=\"$quant\" id=\"quantity\">
	  <input type=\"hidden\" name=\"item\" value=\"$code\">
		</td>";

	//update and delete cell
  echo "<td>
		<input type=\"submit\" name=\"request\" value=\"Update\">";

		echo "<input type=\"hidden\" name=\"item\" value=\"$code\">
		<input type=\"submit\" name=\"request\" value=\"Delete\">
		 <td>
		</form>";

	$partial= $price * $quant;
	$total = $total + $partial;
	//echo '<br> $' . $partial;

	echo '</td>';
	echo '</tr>';
}


echo '</tbody> </table>';

echo "<div class= \"col-md-offset-9 total\"> <h3>Total: $" . $total. "</h3> </div>";
//echo '<br>complete';
?>
