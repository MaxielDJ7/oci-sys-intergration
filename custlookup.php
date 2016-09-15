<?php

	//echo 'admin orders<br>';
	include('account_new.php');

	$query = "SELECT * FROM Orders INNER JOIN Invoice on Orders.Order_Number_ID=Invoice.Order_Number";


	if($_GET['request']=='Find'){
		$orderNum = $_GET['name'];
		$query .= " WHERE Order_Number_ID='".$orderNum."'";

    $STH = $DBH->prepare($query);
  	$STH->execute();

    $querytwo= "SELECT * FROM Order_Details WHERE Order_Number= '".$orderNum."'";
    $STHtwo = $DBH->prepare($querytwo);
    $STHtwo->execute();


  	echo "<h6> Orders found: " .$STH->rowCount() ."</h6>";





  	while($row = $STH->fetch(PDO::FETCH_ASSOC)){

  		$order = $row["Order_Number_ID"];
  		$cust = $row["Customer_ID"];
  		$date = $row["Order_Date"];
  		$total = $row["Total_Amount"];
  		$status = $row["Order_Status"];
  		$inv_num = $row["Invoice_Number"];
  		$inv_stat = $row["Invoice_Status"];

      echo "<div class= 'col-md-6'> ";

      echo "<h3> Order Summary: </h3>";

			echo "<table class= \"table table-nonfluid ordersum\" >";
			echo "<thead>
				 <tr>
					 <th> Order Number </th>
					 <th> Customer ID </th>
					 <th>  Order Total </th>
					 <th>  Order Date </th>
					 <th> Order Status </th>

				 </tr>
			 </thead>

			 <tbody>";

			 /*
			 echo "<h6> Order Number: ".$order. "</h6>";
       echo '<h6> Customer ID: '.$cust. "</h6>";
       echo '<h6> Order  Total: '.$total. "</h6>";
       echo '<h6> Order Date: '.$date."</h6>";
       echo '<h6> Order Status: '.$status."</h6>";
			 */

			//order summary row

      echo "<tr> <td>".$order. "</td>";
      echo "<td>".$cust. "</td>";
      echo "<td>".$total. "</td>";
      echo "<td>".$date."</td>";
      echo "<td>".$status."</td></tr>";

			//order details row

			echo "<tr> <th colspan=\"5\"> <h3>Order Details <h3> </th></tr>";
			echo "<tr> <th align= \"right\" colspan=\"2\"> Item Code </th>
								<th> </th>
								<th align= \"right\" colspan=\"2\"> Item Quantity </th></tr>";
		//	echo "<div class= 'col-md-4'> ";

			//echo "<h3> Order Details: </h3>";

			while($row= $STHtwo->fetch(PDO::FETCH_ASSOC)){

				$code= $row["Item_Code"];
				$quant= $row["Item_Quantity"];


				echo "<tr><td colspan=\"2\">".$code. "</td>";
				echo "<td> </td>";
				echo "<td colspan=\"2\">".$quant. "</td></tr>";


		}
		echo "</tbody></table>";

		echo "<button class='btn btn-primary' onclick='status(".$order.")'> Check Order Status </button>";

		echo "</div>";

		echo "<div class='col-md-6 col-centered append'> </div>";


	}

}


?>
