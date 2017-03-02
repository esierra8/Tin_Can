<?php
	$path = $_SERVER['DOCUMENT_ROOT'].'/php/'; // The path to the included php files
	$title = "Make a Donation"; // The page/navigation bar title
	$index1 = "active"; // Set the first index in the navigation to 'active'
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
					<div class="card hoverable">
						<div class="card-image center-align">
							<img src="/pics/<?php echo $_GET["id"]; ?>.jpg">
							<h2>$<?php echo $_GET["amount"]; ?></h2>
            </div>
						<div class="card-content">
							<div class="row">
								<div class="col s6 center-align ">
									<a href="cc.php?amount=<?php echo $_GET["amount"]."&id=".$_GET["id"]; ?>"> 
										<div class="card-panel hoverable valign-wrapper" style="height: 100px">
											<i class="material-icons left blue-text valign">payment</i>Credit Card<br/>
										</div>
									</a>
								</div>
								<div class="col s6 right-align">
									<!-- The paypal does not work ... so dont try to actually donate money -->
									<div class="card-panel hoverable" style="height: 100px">
										<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
										<input type="hidden" name="cmd" value="_s-xclick" />
										<input type="hidden" name="hosted_button_id" value="4YM3QBA92PC9E" />
										<input type="image" src="https://www.paypal.com/en_GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate" />
									</div>
								</div>
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