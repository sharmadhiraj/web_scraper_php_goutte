<?php

require 'vendor/autoload.php';

use Goutte\Client;

header('Content-Type: application/json');

$url = "http://automationpractice.com/index.php";
$client = new Client();
$crawler = $client->request('GET', $url);

$products = array();
$crawler->filter('ul[id="homefeatured"] > li')
    ->each(function ($node) {
        global $products;
        $item = $node->filter('li > div')->first();
        $link = $item->filter('div[class="left-block"] > div > a')->attr("href");
        $img = $item->filter('div[class="left-block"] > div > a > img')->first()->attr("src");
        $title = $item->filter('div[class="right-block"] > h5')->first()->text();
        $price = $item->filter('div[class="right-block"] > div >span')->first()->text();
        $products[] = array(
            "link" => $link,
            "image" => $img,
            "title" => trim(preg_replace('/\t/', '', $title)),
            "price" => trim(preg_replace('/\t/', '', $price))
        );
    });
print_r(json_encode($products));