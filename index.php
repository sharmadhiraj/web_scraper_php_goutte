<?php

use Symfony\Component\BrowserKit\HttpBrowser;

require 'vendor/autoload.php';

header('Content-Type: application/json');

$url = "https://www.automationexercise.com/";
$client = new HttpBrowser();
$crawler = $client->request('GET', $url);

$products = $crawler->filter("div.features_items>div.col-sm-4")
    ->each(function ($node) {
        return array(
            "id" => (int)$node->filter("div.productinfo>a")->attr("data-product-id"),
            "name" => $node->filter("div.productinfo>p")->text(),
            "image" => "https://www.automationexercise.com{$node->filter("div.productinfo>img")->attr("src")}",
            "price" => (int)str_replace("Rs. ", "", $node->filter("div.productinfo>h2")->text()),
            "link" => "https://www.automationexercise.com{$node->filter('li > a')->attr('href')}",
        );
    });
print_r(json_encode($products));