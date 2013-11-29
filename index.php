<?php require_once('includes/core/init.php'); ?>
<!DOCTYPE HTML>
<html lang="en-US">
	<?php include('includes/page-layout/head.php'); ?>
	<body>
	<div id="doug-neiner-three" class="clearfix">
	  <?php include('includes/page-layout/header.php'); ?>
	  <?php include('includes/page-layout/top-main-navigation.php'); ?>
		<div class="col1">
			<?php include('includes/page-layout/left-side.php');?>
		</div><!-- close left -->
	  	<div class="col2">
			<?php
			    echo messages();
				$page = $_GET['page']; //name of the page without the .php extension
				$category = $_GET['category']; //the name of the folder that the file is in
				$pages = array('register','forgotten','password_reset'); // the name of the names go here
				$folders = array( ); //the name of the folders will go in here

				if(!empty($page) && !empty($category)) {
					if(in_array($category,$folders) && in_array($page,$pages)) {
							$url = $category . '/'. $page . '.php';
							include($url);
					} else {
						echo 'Page not found. Return to
						<a href="index.php">index</a>';
					}
				} else if(!empty($page)) {
					if(in_array($page,$pages)) {
						$page .= '.php';
						include($page);
					} else {
						echo 'Page not found. Return to
						<a href="index.php">index</a>';
					}
				} else {
					include('includes/page-layout/middle.php');

				}
			?>
		</div><!-- close middle -->
		<div class="col3">
			<?php include('includes/page-layout/right-side.php');?>
		</div><!-- close right -->
	</div><!-- close wrapper -->
	<div class="clearfix"> <!--Clearfix for the footer-->
		<?php include('includes/page-layout/footer.php'); ?>
	</div>
	</body><!-- close body -->
</html><!-- close html -->