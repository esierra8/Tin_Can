<?php
	$path = $_SERVER['DOCUMENT_ROOT'].'/php/';
	$title = "The TinCan";
	$index1 = "active"
?>

<html>
	<head>
		<!-- Include the global document header -->
		<?php include $path.'__head.php'; ?>
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
		</main>
		
		<footer>
		</footer>
		
	</body>
</html>