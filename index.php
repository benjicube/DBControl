<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<title>DBControl test....</title>
</head>
<body>

<div class="container">
	<article class="col-xl-6 col-md-8 col-sm-12">
		
		<a href="" type="button" class="btn btn-warning btn-block">Reload</a>

		<h2>Example: Query()</h2>

		<table class="table table-striped table-bordered table-condensed">
			<tr>
				<td><strong>ID</strong></td>
				<td><strong>VendorID</strong></td>
				<td><strong>Navn</strong></td>
				<td><strong>Pris i $</strong></td>
				<td><strong>Pris i DKK</strong></td>
			</tr>

			<?php
				// Query database
				require "DBControl.php";
				$DBControl = new DBControl();
				$link = $DBControl->Connect("bror");
				$query = "SELECT prod_id, prod_name, vend_id, prod_price, ROUND(prod_price*6.8, 1) AS 'pris i kr' FROM products;";
				$result = $DBControl->Query($query, $link);
				while($row = $result->fetch_assoc()) :
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
				$DBControl = new DBControl();
				$query = "SELECT * FROM wp_posts ORDER BY post_title DESC";
				$query_result = $DBControl->ConnectAndQuery($query, "test");

				while($row = $query_result->fetch_assoc()) :
			?>

			<tr>
				<td><?=$row["post_title"]?></td>
				<td><?=$row["post_type"]?></td>
			</tr>

			<?php 
				endwhile; 
			?>
		</table>

		<a href="#" type="button" class="btn btn-success btn-block btn-lg">Top</a>

	</article>
</div>

</body>
</html>