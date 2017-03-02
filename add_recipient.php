<?php
	$path = $_SERVER['DOCUMENT_ROOT'].'/php/'; // The path to the included php files
	$title = "Start getting support"; // The page/navigation bar title
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
		
		<main>
			<div class="row">
			<form action="final_add.php?id=<?php echo $_GET["id"]; ?>" onsubmit="get_geo()" method="post" enctype="multipart/form-data"> 
				<input id="lat" type="hidden" name="lat" />
				<input id="lon" type="hidden" name="lon" />
				<div class="col s12 m8 offset-m2 l6 offset-l3">
					<div class="card-panel">
						<div class="row">
							<div class="input-field col s12">
								<textarea name="short_bio" id="textarea1" class="materialize-textarea"></textarea>
								<label for="textarea1">Short decription of your situation</label>
							</div>
						</div>
					</div>
					
					<div class="card-panel">
							<center><p class="flow-text">Current Necessities (max $1,000)</p><hr></center>
							<div class="row">
								<div class="input-field col s6">
									<input placeholder="Rent" name="item1" id="item1" type="text" class="validate">
									<label for="item1">Needed item</label>
								</div>
								<div class="col s6">
									<label for="cost1">Expected cost ($)</label>
									<p class="range-field">
										<input type="range" id="cost1" name="cost1" min="0" max="1000" value="0" />
									</p>
								</div>
							</div>
							
							<span id="list"></span>
							<center><a class="btn-floating btn-large waves-effect waves-light" onclick="add_item()"><i class="material-icons">add</i></a></center>
						</div>
					<div class="row">
							<button id="done" class="col s4 offset-s8 btn-large waves-effect waves-light" type="submit">Submit!
							<i class="material-icons right">send</i>
					</button>
					</div>
				</form>
			</div>
		</main>
		
		<footer>
		</footer>
		
		<script type="text/javascript">
			var items = 1;
			var remanining = 1000;
			function add_item() {
				remanining -= parseInt(document.getElementById("cost"+items).value);
				items++;
				
				$("#list").append('\
							<div class="row">\
								<div class="input-field col s6">\
									<input placeholder="" id="item'+items+'" name="item'+items+'" type="text" class="validate">\
									<label for="item'+items+'">Needed item</label>\
								</div>\
								<div class="col s6">\
									<label for="cost'+items+'">Expected cost ($)</label>\
									<p class="range-field">\
										<input type="range" id="cost'+items+'" name="cost'+items+'" min="0" max="'+remanining+'" value="1" />\
									</p>\
								</div>\
							</div>\
				');
			}
			
			$(document).ready(function(){
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(function(position) {
						$('#lat').val(position.coords.latitude);
						$('#lon').val(position.coords.longitude);
					});
				}
			});
		</script>
		</script>
		
	</body>
</html>