<?php
	$path = $_SERVER['DOCUMENT_ROOT'].'/php/'; // The path to the included php files
	$title = "Find a shelter"; // The page/navigation bar title
	$index3 = "active"; // Set the first index in the navigation to 'active'
	
	// Include the database access variables
	include $path.'__db.php';


	// Connect to the database
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error)
			die("Connection failed: " . $conn->connect_error);

	// Get all of the CoC information from the database
	$sql = "SELECT lat, lon FROM addresses";
	$result = $conn->query($sql);
?>

<html>
	<head>
		<?php include $path.'__head.php'; ?> <!-- Include the global document header -->
	</head>

	<body>

		<header>
			<?php include $path.'__js.php'; ?> <!-- Load the Javascript Libraries -->

			<!-- Helps keep the map size managable -->
			<style>
				#map {
					min-width: 200px;
					min-height: 100px;
					width: 100%;
					height: 100%;
					border: none;
				}
			</style>
		</header>

		<nav>
			<?php include $path.'__navbar.php'; ?> <!-- Load the navigation bar -->
		</nav>

		<main>
			<div class="row">
				<div class="col s12 m10 l6 offset-m1 offset-l3">
					<div class="card-panel s12 center-align">
						<h1 id="coc"></h1>
						<p class="flow-text">Acording to our data, this CoC is likley to have the most available space</p>
						<a id="link">Directions</a>
					</div>
				</div>	
			</div>
		</main>
		
		<script type='text/javascript'>
			var usr_lats = []; // Latitudes
			var usr_longs = []; // Longitudes
			var coc_lats = []; // Latitudes
			var coc_longs = []; // Longitudes
			var coc_names = []; // Names of the CoCs
			
			<?php 
				while($row = $result->fetch_assoc()) {
					echo 'usr_lats.push(parseFloat("'.$row['lat'].'"));'."\n";
					echo 'usr_longs.push(parseFloat("'.$row['lon'].'"));'."\n";
				}
				
				// Get all of the CoC information from the database
				$sql = "SELECT id, name, latitude, longitude
				FROM locations";
				$result = $conn->query($sql);
				
				// Pull the information from PHP into the JS engine
				if ($result->num_rows > 0)
					while($row = $result->fetch_assoc()) {
						echo 'coc_lats.push(parseFloat("'.$row['latitude'].'"));'."\n";
						echo 'coc_longs.push(parseFloat("'.$row['longitude'].'"));'."\n";
						echo 'coc_names.push("'.$row['name'].'");'."\n";
					}
				$conn->close();
			?>
			
			// http://stackoverflow.com/questions/18883601/function-to-calculate-distance-between-two-coordinates-shows-wrong
			function getDistance(lat1,lon1,lat2,lon2) {
				var R = 6371; // Radius of the earth in km
				var dLat = deg2rad(lat2-lat1);  // deg2rad below
				var dLon = deg2rad(lon2-lon1); 
				var a = 
					Math.sin(dLat/2) * Math.sin(dLat/2) +
					Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
					Math.sin(dLon/2) * Math.sin(dLon/2)
					; 
				var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
				var d = R * c; // Distance in km
				return d;
			}

			function deg2rad(deg) {
				return deg * (Math.PI/180)
			}
			
			function indexOfMax(arr) {
				if (arr.length === 0) {
						return -1;
				}
				var max = arr[0];
				var maxIndex = 0;
				for (var i = 1; i < arr.length; i++) {
						if (arr[i] > max) {
								maxIndex = i;
								max = arr[i];
						}
				}
				return maxIndex;
			}
			
			// We now have all of the coordnates loaded
			var cocs = coc_lats.length;
			var usrs = usr_lats.length;
			
			var coc_dists = []; // Longitudes
			for (c = 0; c < cocs; c++) {
				var dist = 0;
				for (u = 0; u < usrs; u++) {
					dist += getDistance(coc_lats[c],coc_longs[c],usr_lats[u],usr_longs[u]);
				}
				coc_dists.push(dist);
				
			}
			var coc = coc_names[indexOfMax(coc_dists)];
			document.getElementById("coc").innerHTML = coc;
			document.getElementById("link").href = "https://www.google.com/maps/search/"+encodeURI(coc)+"+st+louis";
		</script>

		<footer>
		</footer>

		</body>
</html>