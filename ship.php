<?php
$order = $_GET['order'];
echo $order . '<br><br>';
?>

<html>
  <head>

      <link href=' css/bootstrap.css' rel= 'stylesheet'>
      <link href=' css/style.css' rel= 'stylesheet'>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script>

		var order = <?php echo $order; ?>;
		console.log(order);
        //array that will hold airport details recieved from output of selected airport
        var airdeets= [];

        //airport information constructor with 4 local strings

        function airinfo( arrive, depart, flightnum, tocode, fromcode){
          this.arrive= arrive;
          this.depart= depart;
          this.flightnum= flightnum;
          this.tocode= tocode;
          this.fromcode= fromcode;
        }

        var index= 0;

        //function will populate airdeets information on the browser



        function showAirdeets(){

          //creates divs

		  var flight = airdeets[index].flightnum;


          var $newdiv= $("<div id='newdiv' class='col-md-4'/> "),

            //creates label, label text, and retrieves info from airdeets array to append to browser when airport is selected

            alabel= document.createElement("h3"),
            labelA= document.createTextNode("Arriving Time: "),
            infoA= document.createTextNode(airdeets[index].arrive),

            /*test table

            //cellA= document.createElement("td"),

            <table class=" table flightTable">
              <thead>
                <tr>
                  <th>Arriving Time</th>
                  <th>Departure Time</th>
                  <th>Flight Number</th>
                  <th>Arriving To</th>
                  <th>Departing From</th>
                </tr>
              </thead>
              <tbody>
                <tr id= "Listing">
                  <td >
                  </td>
                </tr>
              </tbody>
            </table>

            test table*/

            dlabel= document.createElement("h3"),
            labelD= document.createTextNode("Departure Time: "),
            infoD= document.createTextNode(airdeets[index].depart),

            flabel= document.createElement("h3"),
            labelF= document.createTextNode("Flight Number: "),
            infoF= document.createTextNode(airdeets[index].flightnum),

            tlabel= document.createElement("h3"),
            labelT= document.createTextNode("Arriving To: "),
            infoT= document.createTextNode(airdeets[index].tocode),

            fclabel= document.createElement("h3"),
            labelFC= document.createTextNode("Departing From: "),
            infoFC= document.createTextNode(airdeets[index].fromcode),

             btn= $("<br></br> <button onclick='submit("+flight+")' class= 'btn btn-primary'> Select </button>");
             //append the label text to the label
            alabel.appendChild(labelA);
            dlabel.appendChild(labelD);
            flabel.appendChild(labelF);
            tlabel.appendChild(labelT);
            fclabel.appendChild(labelFC);

                //cellA.appendChild(infoA);

                //$('#Listing').append(cellA);

            //appends all of the label and information to the div
            $newdiv.append(alabel,infoA, dlabel, infoD, flabel, infoF, tlabel, infoT, fclabel, infoFC, btn);

            //appends the new div to existing div in html
            $('.appendship').append($newdiv);




        }


        function chk(){
              var airport=document.getElementById('airport').value;
              $.ajax({
                type: 'POST',
                url: 'https://web.njit.edu/~vha6/IT490/TestApi/ViewAvailableFlights.php',
                data: JSON.stringify({'airportCode':airport}),
                contentType: "application/json; charset=utf-8",
                dataType:'json',
                cache:false,

                success: function(output){
                  $('#msg').html(msg);

        	         var next = output[0];

                   for(var i=0; i<output.length; i++){
                      var info= output[i];
                      console.log(info);
                    }

                	//example showing inside
              		for (var obj in output.data){
              			//just shows a number index
              			console.log(obj);
              			//shows whats inside
              			console.log(output.data[obj]);
              			//shows specific index of item, double key/val
              			console.log(output.data[obj][0]);

                    //records airport infomation into airdeets array

                    airdeets.push(new airinfo(output.data[obj].arrivalTime,output.data[obj].departureTime, output.data[obj].flightNumber, output.data[obj].fromAirportCode, output.data[obj].toAirportCode));
              		showAirdeets();
					index++;
					}
                  console.log(airdeets);


                  //increment index for airdeets array everytime user selects an airport with available flights



                  console.log(index);

                }
              });
              return false;
          }

        /*
        function debug(){
          var test=document.getElementById('airport').value;
        } */
		function submit(flight){
			console.log('flight number: '+flight);

              $.ajax({
                type: 'POST',
                url: 'https://web.njit.edu/~vha6/IT490/WrongWayAirlines/AssignOrderToFlight.php',
                data: JSON.stringify({'cid':order,'flightNumber':flight}),
                contentType: "application/json; charset=utf-8",
                dataType:'json',
                cache:false,

                success: function(output){
                  $('#msg').html(msg);
					console.log(output);


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

    <div class= 'container-fluid'>

      <div class= 'row form-group '>

        <div class= 'col-md-12'>

          <h3> Select your preferred airport </h3>

          <select id="airport" onchange="chk()" class= "select form-control">
            <option value="SFO">SFO Default for Testing</option>
            <?php include 'airports.php';?>
          </select>


        </div>

        <div class= 'row'>
          	<div id="msg" class= 'col-md-12'> </div>

        </div>

        <div class= 'row appendship'>


        </div>

      </div>

    </div>





  </body>
</html>
