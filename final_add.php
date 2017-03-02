<?php
	$path = $_SERVER['DOCUMENT_ROOT'].'/php/'; // The path to the included php files
	$title = "Tell us what is going on"; // The page/navigation bar title
	$index2 = "active"; // Set the first index in the navigation to 'active'
	
	// Include the database access variables
	include $path.'__db.php';
	
	// These hold the dynamic feilds that may have been sent via POST
	$bio = "";
	$items = array();
	$costs = array();
?>

<html>
	<head>
		<?php include $path.'__head.php'; ?> <!-- Include the global document header -->
	</head>
	<body>
	
		<header>
			<?php include $path.'__js.php'; ?> <!-- Load the Javascript Libraries -->
		</header>
		
		<nav>
			<?php include $path.'__navbar.php'; ?> <!-- Load the navigation bar -->
		</nav>
		
		<main>
			<?php 
				$lat = 0; // Latitude of user
				$lon = 0; // Longitude of user
				$sum = 0; // The sum of the expected cost for the person
				
				// Go through eahc item sent via post
				foreach ($_POST as $key => $value)
					if($key == "short_bio") $bio = $value;// If we found the biography, save it
					else if(substr($key, 0, 3) == "ite") array_push($items,$value);// If we found an item save it's name
					else if(substr($key, 0, 3) == "lat") $lat = $value;// If we found an item save it's name
					else if(substr($key, 0, 3) == "lon") $lon = $value;// If we found an item save it's name
					else if(substr($key, 0, 3) == "cos") { // If we found the cost for an item save it and tally the cost
						array_push($costs,$value);
						$sum += intval($value);
					}
				
				// Connect to the database
				$conn = new mysqli($servername, $username, $password, $dbname);
				if ($conn->connect_error)
						die("Connection failed: " . $conn->connect_error);

				/* Get the name of the person from the 'users' data base 
						(I was too lazy to have it sent alongside the ID in GET)
				*/
				$get_id_sql = "SELECT * 
										   FROM user 
											 WHERE user_id = '{$_GET["id"]}'";
				$result = $conn->query($get_id_sql);
				$row = $result->fetch_assoc();
				$name = $row['name']; // Remember the name
				
				// Add the person to the current donation recipients
				$sql = "INSERT INTO recipient
								VALUES ('{$_GET["id"]}', '{$name}', '0', '{$bio}');";
				if ($conn->query($sql) != TRUE)
						echo "Error updating record: " . $conn->error;
					
				// Add the person to the current donation recipients
				$sql = "INSERT INTO addresses
								VALUES ('NULL', '{$lat}', '{$lon}');";
				if ($conn->query($sql) != TRUE)
						echo "Error updating record: " . $conn->error;
		
				// Insert each item/cost pair into the 'needs' table
				for ($x = 0; $x < count($items); $x++) {
					$sql = "INSERT INTO needs
								  VALUES (NULL, '{$_GET["id"]}', '{$items[$x]}', '{$costs[$x]}');\n";
					if ($conn->query($sql) != TRUE)
						echo "Error updating record: " . $conn->error;
				}

				$conn->close();
			?>
		
			<!-- Open the dialog letting them know it went well -->
			<script type="text/javascript">
				$( document ).ready(function(){
					$('#modal1').openModal();
				} );
			</script>
		
			<div id="modal1" class="modal" style="margin:20px; color:#9fdeb1; background-color:#3ed782">
				<div style="margin:20px; color:#9fdeb1; background-color:#3ed782">
					<p class="flow-text white-text">Everything went well, your TinCan is setup.</p>
				</div>
				<div class="modal-footer" style="color:#9fdeb1; background-color:#3ed782">
					<a href="/view_recipient.php?id=<?php echo $_GET["id"]; ?>" class="modal-action modal-close waves-effect waves-green white-text btn-flat">Okay</a>
				</div>
			</div>
		</main>
		
		<footer>
		</footer>
		
	</body>
</html>