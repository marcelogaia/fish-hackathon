<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Fishackathon</title>
	<link rel="stylesheet" href="assets/css/default.css">
	<script src="vendor/components/jquery/jquery.min.js" defer></script>
	<script src="assets/js/default.js" defer></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-offset-2 col-sm-8">
				<h1>Fishackathon</h1>
				<form action="javascript:void(0)" id="risk">
					<p><label for="vessel">Vessel:</label><input type="text" id="vessel" name="vessel"></p>
					<p><label for="country">Country:</label><input type="text" id="country" name="country"></p>
					<p><label for="species">Species:</label><input type="text" id="species" name="species"></p>
					<p><label for="company">Company:</label><input type="text" id="company" name="company"></p>
					<p><button type="submit">Calculate Risk</button></p>
				</form>
			</div>
		</div>
	</div>
</body>
</html>