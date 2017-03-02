<?php
	$path = $_SERVER['DOCUMENT_ROOT'].'/php/'; // The path to the included php files
	$title = "The TinCan"; // The page/navigation bar title
	$index1 = "active"; // Set the first index in the navigation to 'active'
	
	// Include the database access variables
	include $path.'__db.php';

	// Connect to the database
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error)
			die("Connection failed: " . $conn->connect_error);
	
	// Read all of the recipients from the database
	$sql = "SELECT id, name, current_amount, short_bio FROM recipient";
	$result = $conn->query($sql);
	$conn->close(); 
	
	// Kill the page if nobody is found, it should not happen in our demos
	if ($result->num_rows == 0)
		die("Zero Results");
?>

<html>
	<head>
		<?php include $path.'__head.php'; ?> <!-- Include the global document header -->
		<link rel=" stylesheet" type="text/css" href="/css/joyride-2.1.css"> <!-- The tutorial uses this -->

		<script type="text/javascript">
			var new_view = false; // Used to tell if the tutorial should be shown
			<?php
				// Save a cookie, to expire at end of session, to prevent the tutorial from reappearing
				if((!isset($_COOKIE["new"])) && (setcookie("new","new",0)))
					echo "new_view = true;"; // Tell the JS engine that a cookie does not exist
			?>
		</script>
		
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
					<?php while($row = $result->fetch_assoc()) { ?><!-- Go through each item read from the database -->
						<div class='col s12 l6 offset-l3'>
							<div class="card horizontal person">
								<div class="card-image">
									<?php echo "<img src='/pics/{$row['id']}.jpg' alt=''>"; ?> <!-- Load the person's profile picture -->
								</div>

								<!-- Each individual person -->
								<div class="card-stacked">
									<div class="card-content">
										<div class='col s12 left-align'>
											<span style = 'color:#000' class='card-title'>
												<?php echo $row['name']; ?> <!-- Wrtie the person's name -->
											</span>
										</div>
										<div class="col s12 right-align">
											<div class="row">
												<div class="col s8 left-align">
													<p>
														<?php echo $row['short_bio']; ?> <!-- Wrtie the person's mini-biography -->
													</p>
												</div>
												<!-- The dontate button -->
												<a href="/view_recipient.php?id=<?php echo $row['id'] ?>" class='btn-floating btn-large waves-effect waves-light blue'>
													<i class='material-icons'>favorite</i>
												</a>
												<br />
											</div>
										</div>		 	
									</div>
								</div>
								
							</div>	
						</div>
					<?php } ?>
				</div>
			</main>

			<footer>
			</footer>

			<!-- Holds the content for the tutorial -->
			<ol class="hide" id="chooseID">
				<!-- Send the tutorial to the first instance of a 'person' class -->
				<li data-class="person" data-button="Next"> 
					<h2><br />This is a person who needs help</h2>
					<p>All of the people listed on this site have asked for help. They are on the brink of homelessness and need
						a small amount of financial support to keep from going under.</p>
				</li>
				
				<!-- Send the tutorial to the first donate button -->
				<li data-class="btn-floating" data-button="Next">
					<h2><br />This is how you can help</h2>
					<p>Pressing this Blue Heart button will allow you to donate a small amount of money to help the selected person succede</p>
				</li>
			</ol>

			<script type="text/javascript">
				// Start the tutorial once the window loads (needs to be last)
				$(window).load(function() { 
					if(new_view == true) { // If this is the first time the user loaded the page
						$('#chooseID').joyride({
							autoStart : true,
							postStepCallback : function (index, tip) {
								if (index == 2) {
									$(this).joyride('set_li', false, 1);
								}
							},
							modal:true,
							expose: true
						});
					}
				});
			</script>
		</body>
</html>