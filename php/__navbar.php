<!-- Initialize the nav bar -->
<script type="text/javascript">
	$( document ).ready(function(){
		$(".button-collapse").sideNav();
	})
</script>

<div class="nav-wrapper">
	<a href="#" class="brand-logo"><?php echo $title; ?></a>
	<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
	<ul class="right hide-on-med-and-down">
		<li class="<?php echo $index1; ?>"><a href="/index.php"><i class="material-icons left">home</i>Home</a></a></li>
		<li class="<?php echo $index2; ?>"><a href="/register.php"><i class="material-icons left">assignment</i>Sign Up</a></li>
		<li class="<?php echo $index3; ?>"><a href="/locations.php"><i class="material-icons left">pin_drop</i>Find a shelter</a></li>
		<li class="<?php echo $index4; ?>"><a href="/stats.php"><i class="material-icons left">local_phone</i>Statistics</a></li>
	</ul>
	<ul class="side-nav" id="mobile-demo">
		<li class="<?php echo $index1; ?>"><a href="/index.php">Home</a></a></li>
		<li class="<?php echo $index2; ?>"><a href="/register.php">Sign Up</a></li>
		<li class="<?php echo $index3; ?>"><a href="/locations.php">Find a shelter</a></li>
		<li class="<?php echo $index4; ?>"><a href="/stats.php">Statistics</a></li>
	</ul>
</div>