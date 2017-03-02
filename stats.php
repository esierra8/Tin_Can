<?php
	$path = $_SERVER['DOCUMENT_ROOT'].'/php/'; // The path to the included php files
	$title = "The TinCan Statistics"; // The page/navigation bar title
	$index4 = "active"; // Set the first index in the navigation to 'active'
	
	// Include the database access variables
	include $path.'__db.php';
	
	// Connect to the database
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error)
			die("Connection failed: " . $conn->connect_error);

	// Find the sum of all of the donations given
	$sql = "SELECT SUM(amount) AS total FROM donations";
	$result = $conn->query($sql);
	if ($result != TRUE) 
			echo "Error getting sum: " . $conn->error;
	$row = $result->fetch_assoc();
	$sum = number_format(intval($row["total"])); // Add commas...commas make it look cooler
	
	// Findthe number of people who have completed their goal and retained their houses
	$sql = "SELECT COUNT(recipient.id) as helped 
	        FROM recipient 
					INNER JOIN ( 
						SELECT needs.id, SUM(needs.cost) as tally 
						FROM needs 
						GROUP BY needs.id 
					) AS b ON recipient.id=b.id 
					WHERE recipient.current_amount=b.tally";
	$result = $conn->query($sql);
	if ($result != TRUE)
			echo "Error getting sum: " . $conn->error;
	$row = $result->fetch_assoc();
	$helped = number_format(intval($row["helped"])); // More commas
	
	$conn->close();
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
			<div class="row">
				<div class="col s12 m8 offset-m2 l6 offset-l3">
					<div class="card-panel">
						<div class="row">
							<div class="col s6 center-align">
								<h1>$<?php echo $sum; ?></h1>
								<p>In donations has been used to help prevent homelessness</p>
							</div>
							<div class="col s6 center-align">
								<h1 id="helped"><?php echo $helped; ?></h1>
								<p>People have escaped homelessness because of your donations</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
	
		<footer>
		</footer>
		
	</body>
</html>