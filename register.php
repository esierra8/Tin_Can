<?php
	$path = $_SERVER['DOCUMENT_ROOT'].'/php/'; // The path to the included php files
	$title = "Sign Up"; // The page/navigation bar title
	$index2 = "active"; // Set the first index in the navigation to 'active'
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
		
		<script type="text/javascript">
			// Initialize the date/time picker
			$(document).ready(function(){
				$('.datepicker').pickadate({
					selectMonths: true, 
					selectYears: 15
				});
			})
		</script>
		
		<main>
			<form action="phase2.php" method="post" enctype="multipart/form-data"> 
			<div class="row">
			
				<!-- The genreral information card -->
				<div class="col s12 m6 l4">
					<div class="card-panel">
						<center><p class="flow-text">General Information</p><hr></center>
						<div class="row">
							<div class="input-field col s12">
								<i class="material-icons prefix blue-text">account_circle</i>
								<input name='name' id='name' type='text'>
								<label class="active" for="name">What is your name?</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<i class="material-icons prefix blue-text">location_on</i>
								<input id='address' type='text'>
								<label class="active" for="address">What is your address?</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<i class="material-icons prefix blue-text">event</i>
								<input type="date" id="date" class="datepicker">
								<label class="active" for="date">When were you born?</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field file-field col s12">
									<div class="btn">
										<span>Upload</span>
										<input type="file" name="pic">
									</div>
									<div class="file-path-wrapper">
										<input class="file-path" id="pic" value="Profile Picture" type="text">
									</div>
								</div>
						</div>
					</div>
				</div>
				
				<!-- The banking information card -->
				<div class="col s12 m6 l4">
					<div class="card-panel">
						<p class="flow-text">Banking Information</p><hr>
						<div class="row">
							<div class="input-field col s12">
								<i class="material-icons prefix blue-text">attach_money</i>
								<input id='number' type='text'>
								<label class="active" for="number">Bank acount number?</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<i class="material-icons prefix blue-text">near_me</i>
								<input id='route' type='text'>
								<label class="active" for="route">Routing number?</label>
							</div>
						</div>
					</div>
				</div>
				
				<!-- The account information card -->
				<div class="col s12 m6 l4">
					<div class="card-panel">
						<p class="flow-text">Account Information</p><hr>
						<div class="row">
							<div class="input-field col s12">
								<i class="material-icons prefix blue-text">person</i>
								<input name='uname' id='uname' type='text'>
								<label class="active" for="uname">Username?</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<i class="material-icons prefix blue-text">mail</i>
								<input id='email' type='text'>
								<label class="active" for="email">What is your email address?</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<i class="material-icons prefix blue-text">screen_lock_portrait</i>
								<input id='pass' type='password'>
								<label class="active" for="pass">Password?</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<i class="material-icons prefix blue-text">check</i>
								<input id='confirm' type='password'>
								<label class="active" for="confirm">Confirm Password</label>
							</div>
						</div>
					</div>
					<div class="row">
						<button class="col s4 offset-s8 btn-large waves-effect waves-light" type="submit">Sign Up!
							<i class="material-icons right">send</i>
						</button>
					</div>
				</div>
			</form>
		</main>
		
		<footer>
		</footer>
		
	</body>
</html>