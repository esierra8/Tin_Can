<?php
	$path = $_SERVER['DOCUMENT_ROOT'].'/php/'; // The path to the included php files
	$index1 = "active"; // Set the first index in the navigation to 'active'
	
	// Include the database access variables
	include $path.'__db.php';
	
	// Individual user information
	$name = ""; // The name of the person
	$current_amount = ""; // The current amount donated to the person
	$short_bio = ""; // A short description of the person's situation
	$total = 0; // The number of times the person has used the service

	// Database reading stuff
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error)
			die("Connection failed: " . $conn->connect_error);
	
	// Read the person's information from the database
	$sql = "SELECT * FROM recipient WHERE id = '".$_GET["id"]."'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$name = $row["name"];
			$current_amount = $row["current_amount"];
			$short_bio = $row["short_bio"];
	} else die("Must specify a valid ID");

	// Find the total amount needed by the person
	$sql = "SELECT SUM(needs.cost) as cost FROM needs WHERE id = '{$_GET["id"]}'";
	$result = $conn->query($sql);
	if ($result->num_rows != 0)
		$total = floatval($result->fetch_assoc()["cost"]);
	else die("Something bad happend while reading the sum of needs");

	
	// Determine if the heart and text should be blue (goals have been met) or red (still needs help)
	$color = "";
	if($current_amount >= $total) $color = "#55aef6";
	else $color = "#f65555";

	$title = $name; // The page/navigation bar title to be that of the person viewed
?>

<html>
	<head>
		<?php include $path.'__head.php'; ?> <!-- Include the global document header -->
	</head>
	<body>
	
		<header>
			<link rel=" stylesheet" type="text/css" href="/css/joyride-2.1.css"> <!-- Used for the tutorial -->
			
			<!-- Load the Javascript Libraries -->
			<style>
				#container {
					margin: 5px;
					width: 100px;
					height: 100px;
				}
			</style>
			
			<script type="text/javascript">
				var new_view = false; // Used to tell if the tutorial should be shown
				<?php
					// Save a cookie, to expire at end of session, to prevent the tutorial from reappearing
					if((!isset($_COOKIE["new2"])) && (setcookie("new2","new2",0)))
						echo "new_view = true;"; // Tell the JS engine that a cookie does not exist
				?>
			</script>
		</header>
		
		<nav>
			<?php include $path.'__navbar.php'; ?> <!-- Load the navigation bar -->
		</nav>

		<main>
			<div class="row">
			
				<!-- Profile picture card -->
				<div class="col s12 m7 l4">
					<div class="card hoverable">
						<div class="card-image">
              <img src="/pics/<?php echo $_GET["id"]; ?>.jpg"><!-- Use the person's profile pic from their ID number -->
            </div>
						<div class="card-content">
							<div class="row">
								<div class="col s8">
									<span class="card-title"><br />
										<?php echo $name; ?> <!-- Display the person's name -->
									</span>
									<p class="flow-text">
										<?php echo $short_bio; ?> <!-- Display the person's short biography -->
									</p>
								</div>
								<div class="col s4 center-align">
									<!-- The heart -->
									<div id="container">
										<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0px" y="0px" viewBox="0 0 100 100" id="heart">
												<path fill-opacity="0" stroke-width="1" stroke="#AAA" d="M81.495,13.923c-11.368-5.261-26.234-0.311-31.489,11.032C44.74,13.612,29.879,8.657,18.511,13.923  C6.402,19.539,0.613,33.883,10.175,50.804c6.792,12.04,18.826,21.111,39.831,37.379c20.993-16.268,33.033-25.344,39.819-37.379  C99.387,33.883,93.598,19.539,81.495,13.923z"/>
												<path id="heart-path" fill-opacity="0" stroke-width="6" stroke="<?php echo $color; ?>" d="M81.495,13.923c-11.368-5.261-26.234-0.311-31.489,11.032C44.74,13.612,29.879,8.657,18.511,13.923  C6.402,19.539,0.613,33.883,10.175,50.804c6.792,12.04,18.826,21.111,39.831,37.379c20.993-16.268,33.033-25.344,39.819-37.379  C99.387,33.883,93.598,19.539,81.495,13.923z"/>
										</svg>
										<p id="cash" class="flow-text">$<?php echo $current_amount; ?></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<!-- The 'needs' card -->
				<div class="col s12 m5 l4">
					<div class="card hoverable">
						<div class="card-content">
							<div class="row">
								<div class="col s12">
									<table id="table">
										<thead>
											<tr>
												<th data-field="id">Needed Item</th>
												<th data-field="price">Estemated Cost</th>
											</tr>
										</thead>
										<tbody>
											<?php
												// Read the list of needs the person has
												$sql = "SELECT * FROM needs WHERE id = '{$_GET["id"]}'";
												$result = $conn->query($sql);
												if($result->num_rows > 0)
													while($row = $result->fetch_assoc())
														echo "<tr><td>".$row["item"]."</td><td>$".$row["cost"]."</td></tr>";
												$conn->close();
											?>
											<tr>
												<th style='color:<?php echo $color; ?>'>Total</th>
												<th style='color:<?php echo $color; ?>'>$<?php echo $total; ?></th>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<!-- If the person still needs some help show the donate butons -->
				<?php if($current_amount < $total) { ?>
				<div class="col s12 m5 l4">
					<div class="card hoverable">
						<div class="card-content">
							<div class="row">
								<div class=" col s12">
									<span class="card-title"><br />Make a Donation</span>
								</div>
							</div>
							<div class="row hide-on-med-and-up ">
								<div class="col s2"><?php if($current_amount+1 <= $total) { ?>
									<a href="/donate.php?amount=1&id=<?php echo $_GET["id"]; ?>" id="stop3" 
										class="btn-floating btn-large waves-effect waves-light ">$1</a>
								</div><?php } if($current_amount+5 <= $total) { ?>
								<div class="col s2">
									<a href="/donate.php?amount=5&id=<?php echo $_GET["id"]; ?>"  
										class="btn-floating btn-large waves-effect waves-light">$5</a>
								</div><?php } if($current_amount+10 <= $total) { ?>
								<div class="col s2">
									<a href="/donate.php?amount=10&id=<?php echo $_GET["id"]; ?>"  
										class="btn-floating btn-large waves-effect waves-light">$10</a>
								</div><?php } if($current_amount+15 <= $total) { ?>
								<div class="col s2">
									<a href="/donate.php?amount=15&id=<?php echo $_GET["id"]; ?>"  
										class="btn-floating btn-large waves-effect waves-light">$15</a>
								</div><?php } if($current_amount+25 <= $total) { ?>
								<div class="col s2">
									<a href="/donate.php?amount=25&id=<?php echo $_GET["id"]; ?>"  
										class="btn-floating btn-large waves-effect waves-light">$25</a>
								</div><?php } if($current_amount+50 <= $total) { ?>
								<div class="col s2">
									<a href="/donate.php?amount=50&id=<?php echo $_GET["id"]; ?>"  
										class="btn-floating btn-large waves-effect waves-light">$50</a>
								</div> <?php } ?>
							</div>
							<div class="row hide-on-small-only"><?php if($current_amount+1 <= $total) { ?>
								<div class="col s4">
									<a  href="/donate.php?amount=1&id=<?php echo $_GET["id"]; ?>" 
										class="btn-floating btn-large waves-effect waves-light ">$1</a>
							</div><?php } if($current_amount+1 <= $total) { ?>
								<div class="col s4">
									<a  href="/donate.php?amount=5&id=<?php echo $_GET["id"]; ?>" 
										class="btn-floating btn-large waves-effect waves-light">$5</a>
							</div><?php } if($current_amount+5 <= $total) { ?>
								<div class="col s4">
									<a  href="/donate.php?amount=10&id=<?php echo $_GET["id"]; ?>" 
										class="btn-floating btn-large waves-effect waves-light">$10</a>
							</div><?php } if($current_amount+10 <= $total) { ?>
							</div>
							<div class="row hide-on-small-only">
								<div class="col s4">
									<a  href="/donate.php?amount=15&id=<?php echo $_GET["id"]; ?>" 
										class="btn-floating btn-large waves-effect waves-light">$15</a>
							</div><?php  }if($current_amount+25 <= $total) { ?>
								<div class="col s4">
									<a  href="/donate.php?amount=25&id=<?php echo $_GET["id"]; ?>" 
										class="btn-floating btn-large waves-effect waves-light">$25</a>
							</div><?php } if($current_amount+50 <= $total) { ?>
								<div class="col s4">
									<a  href="/donate.php?amount=50&id=<?php echo $_GET["id"]; ?>" 
										class="btn-floating btn-large waves-effect waves-light">$50</a>
								</div> <?php } ?>
							</div>
						</div>
					</div>
				</div>
				
				<!-- If they have met their goal do not allow donations -->
				<?php } else { ?>
					<div class="col s12 m6 l4">
						<div class="card">
							<div class="card-content">
								<div class="row">
									<div class=" col s12">
										<span class="card-title"><br /><?php echo $name; ?> has met their goal!</span>
									</div>
								</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</main>
		
		<!-- Holds the content for the tutorial -->
		<ol class="hide" id="chooseID">
			<!-- Send the tutorial to the heart -->
			<li data-id="heart" data-button="Next">
        <h2><br />This is how close the person is to meeting their needs</h2>
        <p>As more donations are given to the person the thick red line surrounding the heart will become more complete</p>
      </li>
			
			<!-- Send the tutorial to the table of needs -->
			<li data-id="table" data-button="Next">
        <h2><br />This is a breakdown of what the person is needing right now</h2>
        <p>This is an itemized list of ow your donations are planned to be spent</p>
      </li>
			
			<!-- Send the tutorial to the donation -->
			<li data-class="btn-floating" data-button="Next">
        <h2><br />These allow you to donate to the selected person</h2>
        <p>Pressing these buttons will donate a small amount of money from you to the person in need</p>
      </li>
		</ol>
		
		<?php include $path.'__js.php'; ?> <!-- Load the Javascript Libraries -->
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

			// Start the heart animation
			$( document ).ready(function(){
				document.getElementById("cash").style.color = "<?php echo $color; ?>";
				
				var bar = new ProgressBar.Path('#heart-path', {
					easing: 'easeInOut',
					duration: 1000
				});

				bar.set(0);
				bar.animate(<?php echo floatval("$current_amount")/$total; ?>);  // Number from 0.0 to 1.0
			})
		</script>
		
		<footer>
		</footer>
		
	</body>
</html>