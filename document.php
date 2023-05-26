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

$id=$_POST['id']??null;
$title=$_POST['title']??null;
$content=$_POST['content']??null;
$keywords=$_POST['keywords']??null;

$msg="";
if($id!=null && $title!=null && $content!=null && $keywords!=null){
    $params=[
        'index'=>'article',
        'type'=>'article_type',
        'id'=>$id,
        'body'=>[
            'title'=>$title,
            'content'=>$content,
            'keywords'=>explode(",",$keywords)
        ]
    ];
    $req= $client->index($params);
    
    $msg="Update sccessed id: ".$id;
    $id=$title=$content=$keywords=null;
}
?>
<div class="card m-4">
    <div class="card-header text-danger display-4">Create / Update document </div>
    <div class="card-body">
        <form action='#' method="post">

        <div class="form-group">
                <label>ID document</label>
                <input class="form-control" type="text" name="id" value="<?=$id?>">
            </div>

        <div class="form-group">
                <label>Tittle</label>
                <input class="form-control" type="text" name="title" value="<?=$title?>">
            </div>

            <div class="form-group">
                <label>Content</label>
                <textarea class="form-control" type="text" name="content" value="<?=$content?>"></textarea>
            </div>
            
            <div class="form-group">
                <label>Key</label>
                <textarea class="form-control" type="text" name="keywords" value="<?=$keywords?>"></textarea>
            </div>
                        
            <div class="form-group">
                <input class="btn btn-danger" type="submit" name="update">
            </div>

            <?=$msg?>
    </div >
</div>