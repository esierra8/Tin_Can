<?php
	$path = $_SERVER['DOCUMENT_ROOT'].'/php/'; // The path to the included php files
	$title = "Donation Complete"; // The page/navigation bar title
	$index1 = "active"; // Set the first index in the navigation to 'active'
	
	// Include the database access variables
	include $path.'__db.php';
	
	// Connect to the database
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) 
			die("Connection failed: " . $conn->connect_error);

	// Add the specified amount to the amount already in the persons "account"?
	$sql = "UPDATE recipient 
				  SET current_amount = current_amount+".$_GET["amount"]." WHERE id = '".$_GET["id"]."'";
	if ($conn->query($sql) != TRUE)
			echo "Error updating record: " . $conn->error;
	
	// Keep track of the donation
	$sql = "INSERT INTO donations
					VALUES (NULL, '{$_GET["id"]}', '{$_GET["amount"]}');";
	$result = $conn->query($sql);
	if ($conn->query($sql) != TRUE)
			echo "Error updating record: " . $conn->error;

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
		
		<!-- Open the dialog letting the user know the transaction completed -->
		<script type="text/javascript">
			$(document).ready(function(){
				$('#modal1').openModal();
			});
		</script>
		
		<main>
			<div id="modal1" class="modal" style="margin:20px; color:#9fdeb1; background-color:#3ed782">
				<div style="margin:20px; color:#9fdeb1; background-color:#3ed782">
					<p class="flow-text white-text">Your donation of $<?php echo $_GET["amount"]; ?> is complete!</p>
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