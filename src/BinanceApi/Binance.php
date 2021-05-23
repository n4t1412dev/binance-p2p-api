<?php
/**
*  Copyright (C) 1412dev, Inc - All Rights Reserved
*  @author      1412dev <me@1412.io>
*  @site        https://1412.dev
*  @date        5/22/21, 5:17 AM
*  Please don't edit, respect me, if you want to be appreciated.
*/

// Define the page namespace
namespace API\BinanceApi;


// Define the namespaces to use
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Binance
{
    protected $url          = "https://www.binance.cc";
    protected $endPoint     = "/bapi/c2c/v2/friendly/c2c/adv/search";
    protected $headers      =  [
                                'clienttype' => 'android',
                                'lang' => 'vi',
                                'versioncode' => 14004,
                                'versionname' => '1.40.4',
                                'BNC-App-Mode' => 'pro',
                                'BNC-Time-Zone' => 'Asia/Ho_Chi_Minh',
                                'BNC-App-Channel' => 'play',
                                'BNC-UUID' => '067042cf79631252f1409a9baf052e1a',
                                'referer' => 'https://www.binance.com/',
                                'Cache-Control' => 'no-cache, no-store',
                                'Content-Type' => 'application/json',
                                'Accept-Encoding' => 'gzip, deflate',
                                'User-Agent' => 'okhttp/4.9.0'
                            ];
    protected $client;
    protected $logger;


    public function __construct() {
        $this->client = new Client(['verify' => false, 'headers' => $this->headers]);

        //create log
        $this->logger = new Logger('[Binanace_P2P]');
        $this->logger->pushHandler(new StreamHandler(__DIR__ . '/logs.log', Logger::INFO));
    }
    
    public function exchange($asset, $fiat, $tradeType)
    {
        try {
            $options = [
                'json' => [
                    'asset' => $asset,
                    'tradeType' => $tradeType,
                    'fiat' => $fiat,
                    'transAmount' => 0,
                    'order' => '',
                    'page' => 1,
                    'rows' => 10,
                    'filterType' => 'all'
                ]
            ];
            $response =  $this->client->request('POST', $this->url.$this->endPoint, $options);
            $data = json_decode($response->getBody());
            $result = [];
            foreach ($data->data as $value) {
                $details = array(
                    'price' => $value->adv->price, // price
                    'minSingleTransAmount' => $value->adv->minSingleTransAmount, // min trans amount limit
                    'dynamicMaxSingleTransAmount' => $value->adv->dynamicMaxSingleTransAmount, // max trans amount limit
                    'nickName' => $value->advertiser->nickName,
                );
                array_push($result, $details);
            }
            return $result;

        } catch (RequestException $e) {
            $response = json_decode($e->getResponse()->getBody());
            $this->logger->error($e->getResponse()->getBody());
            return (object)  array(
                'status' => 'error',
                'message' => $response->error->message
            );
        }
    }

}
