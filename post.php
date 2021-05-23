<?php
/**
*  Copyright (C) 1412dev, Inc - All Rights Reserved
*  @author      1412dev <me@1412.io>
*  @site        https://1412.dev
*  @date        5/22/21, 5:120 AM
*  Please don't edit, respect me, if you want to be appreciated.
*/

header("Content-Type: application/json");
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once('vendor/autoload.php');
use API\BinanceApi\Binance;

$binance = new Binance();

$asset = $_GET['asset'];
$fiat = $_GET['fiat'];
$tradeType = $_GET['tradeType'];

echo json_encode($binance->exchange($asset, $fiat, $tradeType));

