<?php
	$path = $_SERVER['DOCUMENT_ROOT'].'/php/'; // The path to the included php files
	$title = "Donate via Credit Card"; // The page/navigation bar title
	$index1 = "active"; // Set the first index in the navigation to 'active'
	
	/*
		None of the fields in this page have validation checking.
		
		This is because having to enter valid inforamtion inside the text 
		feilds would take more time and detract from the actuall project being displayed
		
		A child with Google can validate a form...that is not why we are here
	*/
?>

<html>
	<head>
		<?php include $path.'__head.php'; ?> <!-- Include the global document header -->
	</head>
	
	<body>
	
		<header>
			<!-- Load the Javascript Libraries -->
			<?php include $path.'__js.php'; ?>
		</header>
		
		<nav>
			<!-- Load the navigation bar -->
			<?php include $path.'__navbar.php'; ?>
		</nav>
		
		<main>
			<div class="row">
				<div class="col s12 m8 offset-m2">
					<div class="card hoverable">
						<div class="card-image center-align">
							<h2><br />$<?php echo $_GET["amount"]; ?><br /></h2>
							<br />
            </div>
					</div>
					
					<!-- The CC card -->
					<div class="card-panel">
						<div class="row">
							<div class="input-field col s7 l6">
								<i class="material-icons prefix">payment</i>
								<input data-stripe="number" size="20" id='number' type='text'>
								<label class="active" for="number">Credit-card number?</label>
							</div>
							<div class="hide-on-med-and-down input-field col s1 center-align">
								<i class="material-icons prefix">event</i>
							</div>
							<div class="hide-on-large-only input-field col s1 left-align">
								<i class="material-icons prefix">event</i>
							</div>
							<div class="input-field col s2 l1">
								<p>Expiration</p>
							</div>
							<div class="input-field col s1 l2">
								<input id='mm' type="text" size="2" data-stripe="exp_month">
								<label class="active" for="mm">MM</label>
							</div>
							<div class="input-field col s1 l2">
								<input id='yy' type="text" size="2" data-stripe="exp_year">
								<label class="active" for="yy">YY</label>
							</div>
						</div>
						
						<div class="row">
							<div class="input-field col s6 m6">
								<i class="material-icons prefix">fingerprint</i>
								<input data-stripe="cvc" size="4" id='cvc' type='text'>
								<label class="active" for="cvc">CVC?</label>
							</div>
							<div class="input-field col s6">
								<i class="material-icons prefix">room</i>
								<input data-stripe="address_zip" size="6" id='zip' type='text'>
								<label class="active" for="zip">Billing Zip Code</label>
							</div>
						</div>
					</div>
					<div class="row">
						<form method="GET" action="/cc_donate.php"> 
							<input name="amount" type="hidden" value="<?php echo $_GET["amount"]; ?>" />
							<input name="id" type="hidden" value="<?php echo $_GET["id"]; ?>" />
							<button type="submit" class="col s4 offset-s8 btn-large waves-effect waves-light">Donate!
								<i class="material-icons right">send</i>
							</button>
						</form>
					</div>
				</div>
			</div>
		</main>
		
		<footer>
		</footer>
		
	</body>
</html>