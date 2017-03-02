<?php
	$path = $_SERVER['DOCUMENT_ROOT'].'/php/'; // The path to the included php files
	$title = "Signed Up"; // The page/navigation bar title
	$index2 = "active"; // Set the first index in the navigation to 'active'
	
	// Include the database access variables
	include $path.'__db.php';
	
	// Provide *minimal* error checking for the uploaded image
	$target_dir = $_SERVER["DOCUMENT_ROOT"]."/pics/";
	$imageFileType = pathinfo($target_dir.basename($_FILES["pic"]["name"]),PATHINFO_EXTENSION);
	if(getimagesize($_FILES["pic"]["tmp_name"]) === false)
			die("Your image does not seem to be valid");
	
	// Connect to the database
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) 
			die("Connection failed: " . $conn->connect_error);

	/* Add the person into the user table
		 Note: This only adds the name and username feild into the databse
					 This helps keep the demo simple because those extra feilds would 
					 add quite a bit of stuff to handle while providing no benefit to the 
					 demonstration.
	*/
	$sql = "INSERT INTO user (name, username)
	        VALUES ('{$_POST["name"]}', '{$_POST["uname"]}')";
	if ($conn->query($sql) != TRUE) 
			echo "Error: " . $sql . "<br>" . $conn->error;
	
	// Get the person's ID so that the uploaded image's filename can match
	$sql = "SELECT * FROM user 
	        WHERE name = '{$_POST["name"]}' AND username = '{$_POST["uname"]}' ";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$target_file = $target_dir.$row["user_id"].'.'.$imageFileType;
	$id = $row["user_id"];
	move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file);
	
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
				<div class="col s12 m10 l8 offset-m1 offset-l2">
					<div class="card hoverable" style="padding:20px">
						<p class="flow-text">You have been registered. You are now eligible to receive support from your 
							community.</p>
						<p class="flow-text">Keep in mind that any support you may receive comes from the generosity of strangers, <b>do not disrespect
							their gifts by abusing this system</b>. It is made to help people who are on the brink of homelessness, use it as such.
						</p>
						<a href="add_recipient.php?id=<?php echo $id; ?>" class="waves-effect waves-light btn-large">
							<i class="material-icons left">supervisor_account</i>Start getting support
						</a>
					</div>
				</div>
			</div>
		</main>
		
		<footer>
		</footer>
		
	</body>
</html>