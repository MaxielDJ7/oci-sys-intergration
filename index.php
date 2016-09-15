<?php

  //start session

  session_start();

  $_SESSION['cid']= rand();

  $customer= $_SESSION['cid'];

?>

<!DOCTYPE html >

<html>

  <head>

    <link href=' css/bootstrap.css' rel= 'stylesheet'>
    <link href=' css/style.css' rel= 'stylesheet'>

    <script src= "https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

    <script>

      function chk(){
        var name=document.getElementById('count').value;
        var category=document.getElementById('category').value;
        var arrange=document.getElementById('arrange').value;
        var dataString='count=' + name + '&category=' + category + '&arrange=' + arrange;
        console.log(dataString);
        $.ajax({
          type: 'get',
          url: 'browse.php',
          data: dataString,
          cache:false,
          success: function(msg){
            $('#msg').html(msg);
          }
        });
        return false;
    }

    $(document).ready(function(){
      chk();

    });

    </script>


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

      <div id="total" class= "container-fluid">

        <div class= 'row form-group'>

          <div class= 'row row-centered'>

            <div class='col-md-12 col-centered background'>

            </div>

          </div>

          <div class= "col-md-4">
            <label for= "items"> Items per page: </label>


              <select name="count" id="count" onChange="chk()" class= "select form-control">
                <option value="1">1</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="all">ALL</option>
              </select>
            </div>


            <div class= "col-md-4">
              <label for= "category"> Category: </label>

              <select name="category" id="category" onChange="chk()" class= "select form-control">
              	<option value="all">ALL</option>
              </select>
            </div>

            <div class= "col-md-4">
              <label for= "arrange"> Arrange by: </label>

              <select name="arrange" id="arrange" onChange="chk()" class= "select form-control">
              	<option value="namedwn">Name (Descending)</option>
              	<option value="nameup">Name (Ascending)</option>
              	<option value="pricedwn">Price (Lowest)</option>
              	<option value="priceup">Price (Highest)</option>
              </select>
          </div>

          </div>

        <div class='row'>



          <div id="msg" class= 'col-md-12'> </div>




        </div>


      </div>


  <body>

</html>
