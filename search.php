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
//->setBasicAuthentication('Sheng12345', 'Sheng12345')
$client = Elastic\Elasticsearch\ClientBuilder::create()
    ->setHosts(['localhost:9200'])
    ->build();

$search=$_POST['search'] ?? null;
if ($search != null){
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
                    ],
                    'highlight'=>[
                        'pre_tags'=>["<strong class='text-danger'>"],
                        'post_tags'=>["</strong>"],
                        'fields'=>[
                            'title'=> new stdClass(),
                            'content'=> new stdClass()
                        ]
                    ]
        ]
    ];
    $rs = $client->search($params);
    //var_dump($rs->getBody());
    $rs=json_decode($rs->getBody(),true);
    //var_dump($rs);

    $items=null;
    $total=$rs["hits"]["total"]["value"];
    if($total>0){
        $items=$rs['hits']['hits'];
    }
    //var_dump($total,$items);
    $search=null;
}

?>
<div class="card m-4">
    <div class="card-header text-danger display-4">Search </div>
    <div class="card-body">
        <form action='#' method="post">

        <div class="form-group">
                <label>Search content</label>
                <input class="form-control" type="text" name="search" value="<?=$search?>">
            </div>

        <div class="form-group">
                <input class="btn-btn-danger" type="submit" name="Search">
            </div>

            <? if($items!=null):?>
                <?foreach ($items as $item):?>
                    <?
                        $title=$item['_source']['title'];
                        $content=$item['_source']['content'];
                        
                        if(isset($item['highlight']['title']))
                            $title=implode(" ",$item['highlight']['title']);
                        if(isset($item['highlight']['content']))
                            $content=implode(" ",$item['highlight']['content']);
                    
                    ?>    
                    <p><strong><?= $title?></strong><br>
                        <?=$content?>
                    </p>
                    <hr>
                <?endforeach?>
            <?endif?>
    </div >
</div>