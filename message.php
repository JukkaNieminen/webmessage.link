<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<title>Webmessage-service</title>
	<script href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
</head>

<body style="background-color: black">
	<main class="page contact-us-page">
	<section class="clean-block clean-form dark">
	<div class="container">
		<h2 style="text-align:center; margin-top:30px; color:white;">Here is your secret message:</h2>
			<?php

			//Get "id" from the URL
			$ident = $_GET['ident'];

			//Connect to database
			$host = 'DATABASE_HOST';
			$dbuser = 'DATABASE_USER';
			$dbpass = 'DATABASE_PASSWORD';
			$dbname = 'DATABASE_NAME';

			$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
			


			if ($conn->connect_errno){
				echo "There was an error connecting to the database, please try again later.";
			}
			else{
				//Select the correct message from DB based on "id"
				$sql = "SELECT id,message,visibletime,posteddate FROM messages WHERE id = '$ident';";	
				$result = $conn->query($sql);
				while($row = mysqli_fetch_assoc($result)){
					$message = utf8_encode($row['message']);			
					$postdate = new DateTime($row['posteddate']);
					$dt = $postdate->format('d/m/y @ H:i');
				}
				$rawCurrentTime = new DateTime("now");
				$currentTime = $rawCurrentTime->format('d/m/y @ H:i');
				//NOTICE: The datetime-stuff is not actually used for calculating anything right now. Features will be added a bit later.
			
			}

			//Echo out the message.
			if($message != ''){
				echo '<br><br>';		
				echo '<h3 style="color:white;">'. $message .'<h3>';
				echo '<br><h3 style="color:white;">This message was posted on '. $dt .' (UTC)<h3>';	
			       	echo '<a style="color:teal; text-align: center; font-size:0.8em;" href="https://webmessage.link">Message created using webmessage.link</a>';			
			}
			else{
				echo '<br><h3 style="color:white;">There was a problem.</h3>';
			}
			?>

            </div>
        </section>
    </main>
</body>
</html>
