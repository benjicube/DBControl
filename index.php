<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<title>DBControl example site</title>
</head>
<body>

<style>
	tr:first-child {
		font-weight: bold;
		text-transform: uppercase;
		text-align: center;
		font-size: 1.2em;
		background-color: #DDF4D7 !important;
	}
	td:nth-child(4),
	td:nth-child(5) {
		text-align: right;
	}
</style>

<div class="container-fluid">

	<div class="well"><h2>DBControl example site</h2></div>

	<article class="col-xs-12">
		
		<a href="" type="button" class="btn btn-success btn-block">Reload</a>

		<h2>Example: Query()</h2>

		<table class="table table-striped table-bordered table-condensed">
			<tr>
				<td>ID</td>
				<td>VendorID</td>
				<td>Navn</td>
				<td>Pris i $</td>
				<td>Pris i DKK</td>
			</tr>

			<?php
				// Query database
				require_once "DBControl.php";
				$DBControl = new DBControl();
				$link = $DBControl->Connect("bror");
				$query = "SELECT prod_id, prod_name, vend_id, prod_price, ROUND(prod_price*6.8, 0) AS 'pris i kr' FROM products LIMIT 10";
				$result = $DBControl->Query($query, $link);
				while( $row = $result->fetch_assoc() ):
			?>

			<tr>
				<td><?=$row["prod_id"]?></td>
				<td><?=$row["vend_id"]?></td>
				<td><?=$row["prod_name"]?></td>
				<td><?=$row["prod_price"]?></td>
				<td><?=$row["pris i kr"]?></td>
			</tr>

			<?php
				endwhile;
				$result->free();
				$DBControl->Close($link);
			?>

		</table>





		<h2>Example: ConnectAndQuery()</h2>

		<table class="table table-striped table-bordered table-condensed">
			<tr>
				<td><strong>Value1</strong></td>
				<td><strong>Value2</strong></td>
			</tr>

			<?php
				// Database query
				require_once "DBControl.php";
				$DBControl = new DBControl();
				$query = "SELECT * FROM wp_posts ORDER BY post_title DESC limit 5";
				$result = $DBControl->ConnectAndQuery($query, "test");

				while($row = $result->fetch_assoc()) :
			?>

			<tr>
				<td><?=$row["post_title"]?></td>
				<td><?=$row["post_type"]?></td>
			</tr>

			<?php 
				endwhile;
				$result->free();
			?>
		</table>

		<a href="#" type="button" class="btn btn-warning btn-block btn-xs">Top</a>

	</article>
</div>

</body>
</html>