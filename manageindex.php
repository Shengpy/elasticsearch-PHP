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
// $indices=$client->cat()->indices();
// var_dump($indices);

$action = $_GET['action'] ?? '';
$params=[
    'index'=>'article'
];

//exist the index;
$response=$client->cat()->indices();
$contents = (string) $response->getBody();
$exists=str_contains($contents, "article");
//$exists = $client->indices()->exists($params);

if ($action == "create"){
    if(!$exists)
        $client->indices()->create($params);
}
else if ($action=="delete"){
    if($exists)
        $client->indices()->delete($params);
}
$exists = $client->indices()->exists($params);

//exist the index;
$reponse=shell_exec("curl http://localhost:9200/article");
$exists=!str_contains($reponse, "error");

$msg = $exists ? "Index dang ton tai" : "Index khong co";
?>
<div class="card m-4">
    <div class="card-header text-danger display-4">Quan ly index </div>
    <div class="card-body">
        <? if(!$exists): ?>
         <a class="btn btn-success" href="http://localhost:8888/?page=manageindex&action=create">Tao index</a>
        <? else: ?>
         <a class="btn btn-danger"href="http://localhost:8888/?page=manageindex&action=delete">Xoa index</a>
        <? endif ?>

        <div class="alert alert-primary mt-3">
        <?=$msg?>
         </div>
        </div >
</div>