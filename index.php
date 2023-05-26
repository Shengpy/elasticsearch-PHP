<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Document</title>
</head>
<?php
$page = $_GET['page'] ?? '' ;
var_dump($page);
$menuitems=[
    'manageindex'=>'Quanly',
    'document' => "Document",
    'search' => "Find"
];
?>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
   <div class="collapse navbar-collapse" id="my-nav-bar">
        <!--HTML các thành phần trình bày trên Navbar-->
    <ul class="navbar-nav">

       <li class="nav-item">
        <a class="nav-link" href="/">Trang chu</a>
       </li>

       
       <? foreach ($menuitems as $url => $label ):?>
        
        <? 
        $class ='';
        if($page==$url)
             $class='active';
        ?>

        <li class="nav-item <?=$class?>">
        <a class="nav-link" href="/?page=<?=$url?>"> <?=$label?> </a>
        </li>
        
        <?endforeach?>
    </ul>
    </div>
</nav>
    <p class="text-danger display-4">Thuc hanh Elasticsearch</p>
    <?if ($page != ''):?>
        <?
             include $page.".php";
        ?>
    <?else:?>
        <p class="text-danger display-4">Thuc hanh </p>
    <?endif?>
</body>
</html>