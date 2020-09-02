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
		<form>
			<div class="form-group">
				<h2 style="text-align:center; margin-top:30px; color:white;">What do you want to tell someone?</h2>
				<input name="message" class="form-control" type="text">
			</div>		

		<!--	FOR NOW MESSAGES WILL BE SEEN FOREVER
			<div class="form-group">
				<h2 style="text-align:center; margin-top:20px; color:white;">How long do you want the message to be accessible?(1-12 hours)</h2>
				<input name="vistime" default="12" class="form-control" type="number" min="1" max ="12" method="POST" style="max-width:150px; margin: 0 auto;">
			</div>-->
			<div class="form-group">
				<button class="btn btn-primary btn-block" type="submit" style="max-width:250px; margin:0 auto;">Generate unique link</button>
			</div>
			<?php

			$message = '';
			$vistime = 1;

			//Get values from form
			$message = validateInput($_GET['message']);
			$vistime = $_GET['vistime'];

			if(empty($vistime)){
				$vistime = 12;
			}

			//Create database-connection
			//FILL THESE WITH THE CREDENTIALS OF YOUR OWN DDATABASE
			if($message != ''){
			$host = 'DATABASE_HOST';
			$dbuser = 'DATABASE_USERNAME';
			$dbpass = 'DATABASE_PASSWORD';
			$dbname = 'DATABASE_NAME';

			$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

			if ($conn->connect_errno){
				echo "There was an error connecting to the database, please try again later.";
			}
			else{
				//Allow nordic characters and insert data to DB
				$conn->set_charset("utf8");
				$sql = "INSERT INTO messages(message, visibletime) VALUES ('$message', $vistime);";
				$conn->query($sql);	
			}

			//Get id of message and generate link based on the id
			$responseSQL = "SELECT id FROM messages ORDER BY id DESC LIMIT 1;";
			$result = $conn->query($responseSQL);
			while($row = mysqli_fetch_assoc($result)){
				$ident = $row['id'];
			}
			
			//Echo out the html for the response reveived from the DB			
			$linkTag = '<a style="word-wrap: break-word; font-size: 2.0em;" href="https://webmessage.link/message.php?ident='.$ident.'">Click here!</a><br>';
			$linkTxt = "https://webmessage.link/message.php?ident=$ident";			
			echo '<h3 style="color:white;">Your message will be visible from this link: </h3>';
			echo $linkTag;
			echo '<br><h4 style="color:white;">Copy and paste this link somewhere safe, you cannot access it later from this website!</h3>';
			echo '</a><br><h3 style="word-wrap: break-word;color:white;">'.$linkTxt.'</h3>';
			}

			function validateInput($text){
				$text = trim($text);
				$text = stripslashes($text);
				$text = htmlspecialchars($text);
				return $text;
			
			}


?>
		</form>    
		<a style="word-wrap: break-word; font-size: 2.0em;" href="privacy.html">Privacy policy</a>
		</div>
        </section>
    </main>
</body>
</html>
