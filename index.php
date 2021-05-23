<?php
/**
*  Copyright (C) 1412dev, Inc - All Rights Reserved
*  @author      1412dev <me@1412.io>
*  @site        https://1412.dev
*  @date        5/22/21, 5:120 AM
*  Please don't edit, respect me, if you want to be appreciated.
*/
require_once('options.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Document</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body style="padding-top: 50px;">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">Binance P2P BOT</div>
			<div class="panel-body">
				<label for="crypto">* Select Crypto:</label>
				<select id="crypto" class="form-control" >
					<?php foreach ($options['crypto'] as $value) {
						echo '<option value="'.$value.'">'.$value.'</option>';
					}?> 
				</select>
				<br>
				<label for="fiat">* Select Fiat:</label>
				<select id="fiat" class="form-control" >
					<?php foreach ($options['fiat'] as $value) {
							echo '<option value="'.$value.'">'.$value.'</option>';
						}?> 
				</select>
				<br>
				<label for="exchange">* Select exchange:</label>
				<select id="exchange" class="form-control" >
					<?php foreach ($options['exchange'] as $value) {
							echo '<option value="'.$value.'">'.$value.'</option>';
						}?> 
				</select>
				<br>
			</div>
			<div class="panel-footer">
				<div class="text-center">
					<button class="btn btn-primary" id="load" data-loading-text="Loading ...">Load</button>
				</div>
			</div>
		</div>

		<textarea class="form-control" id="logs" rows="10"></textarea><br>
	</div>
	<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			var crypto;
			var fiat;
			var exchange;
			$("#load").click(function() {
				crypto = $("#crypto").val();
				fiat = $("#fiat").val();
				exchange = $("#exchange").val();
				$(this).button('loading');
				$.get('/post.php', {
					asset: crypto,
					fiat: fiat,
					tradeType: exchange
				}).done(e => {
					e.forEach(function (item) {
						$('#logs').append('⚠️ Rate: ' + item.price + ' | Min Price: ' + item.minSingleTransAmount + ' | Max Price: ' + item.dynamicMaxSingleTransAmount + ' | Trader: ' + item.nickName + '\n');
					})
					$("#load").button('reset');
				});
			});
		});
	</script>
</body>
</html>