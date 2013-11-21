<footer class="c12">
  &copy; <?php
	$copyYear = 2008; // Set your website start date
	$curYear = date('Y'); // Keeps the second year updated
	echo $copyYear . (($copyYear != $curYear) ? '-' . $curYear : '');
	?> Copyright.
</footer>