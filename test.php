<?php 
require "vendor/autoload.php";
use Elastic\Elasticsearch\ClientBuilder;

$hosts = [
    [
        'host' => 'localhost',          //yourdomain.com
        'port' => '9200',
        'scheme' => 'http',             //https
//        'path' => '/elastic',
    //    'user' => 'Sheng12345',         //nếu ES cần user/pass
    //    'pass' => 'Sheng12345'
    ],

];

$client = Elastic\Elasticsearch\ClientBuilder::create()
    ->setHosts(['localhost:9200'])
    ->build();

    $search="age";
    $params=[
        'index'=>'article',
        'type'=>'article_type',
        'body'=>[
            "query" => [
                "bool"=>[
                    "should" =>[
                        ['match'=>['title'=>$search]],
                        ['match'=>['content'=>$search]],
                        ['match'=>['keywords'=>$search]]
                    ]
                ]
            ]
        ]
    ];
    $rs = $client->search($params);
    $rs=json_decode($rs->getBody());
    var_dump($rs);