<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/css.css">
    <title>Index</title>
    <style>

    </style>
</head>
<?php
    require_once 'db.php';

    $popular_app = get_popular_top_apps();
    if($popular_app['code']!=0){
        die($popular_app['error']);
    }

    $recommend_app = get_recommend_top_apps();
    if($recommend_app['code']!=0){
        die($recommend_app['error']);
    }

    $lastest_app = get_lastest_top_apps();
    if($lastest_app['code']!=0){
        die($lastest_app['error']);
    }

    $content = get_content();
    if($content['code']!=0){
        die($content['error']);
    }

    $content = $content['data'];

?>
<body onresize="resize()" class="index">
    <?php include 'index-template.php';?>
    <div class="flex-container">
        <div id="sidebar" class="sidebar">
            <ul class="menu">
                <li><a href="#home">Home</a></li>
                <li><a href="#news">News</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="#about">About</a></li>
            </ul>
        </div>
        <div class="content">
            <!-- <div class="application-box">
                <iframe class="iframe-app" src="application.html"></iframe>
            </div> -->
            <div class="apps-menu">
                <div class="info-row">
                    <h2>Popular Apps</h2>
                    <div>
                        <a class='btn btn-success' href="seemore.php?id=1">See more</a>
                    </div>
                </div>
                <div class="apps-row">
                    <?php
                        foreach($popular_app['data'] as $item){
                            ?>
                                <div class="app-card">
                                    <div class="app-img">
                                        <a href="application.php?id=<?= $item['id'] ?>"><img src="<?= $item['image'] ?>" /></a>
                                    </div>
                                    <div class="app-name">
                                        <a href="application.php?id=<?= $item['id'] ?>"><?= $item['name'] ?></a>
                                    </div>
                                    <div class="app-coop">
                                        <a href="#X-Cooporation"><?= $item['developer'] ?></a>
                                    </div>
                                    <div class="rating">
                                    <?= $item['stars'] ?><span class="fa fa-star checked"></span></p>
                                    </div>
                                </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
            <div class="apps-menu">
                <div class="info-row">
                    <h2>Recommend Apps</h2>
                    <div>
                    <a class='btn btn-success' href="seemore.php?id=2">See more</a>
                    </div>
                </div>
                <div class="apps-row">
                    <?php
                        foreach($recommend_app['data'] as $item){
                            ?>
                                <div class="app-card">
                                    <div class="app-img">
                                        <a href="application.php?id=<?= $item['id'] ?>"><img src="<?= $item['image'] ?>" /></a>
                                    </div>
                                    <div class="app-name">
                                        <a href="application.php?id=<?= $item['id'] ?>"><?= $item['name'] ?></a>
                                    </div>
                                    <div class="app-coop">
                                        <a href="#X-Cooporation"><?= $item['developer'] ?></a>
                                    </div>
                                    <div class="rating">
                                    <?= $item['stars'] ?><span class="fa fa-star checked"></span></p>
                                    </div>
                                </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
            <div class="apps-menu">
                <div class="info-row">
                    <h2>Lastest Apps</h2>
                    <div>
                        <a class='btn btn-success' href="seemore.php?id=3">See more</a>
                    </div>
                </div>
                <div class="apps-row">
                <?php
                        foreach($lastest_app['data'] as $item){
                            ?>
                                <div class="app-card">
                                    <div class="app-img">
                                        <a href="application.php?id=<?= $item['id'] ?>"><img src="<?= $item['image'] ?>" /></a>
                                    </div>
                                    <div class="app-name">
                                        <a href="application.php?id=<?= $item['id'] ?>"><?= $item['name'] ?></a>
                                    </div>
                                    <div class="app-coop">
                                        <a href="#X-Cooporation"><?= $item['developer'] ?></a>
                                    </div>
                                    <div class="rating">
                                    <?= $item['stars'] ?><span class="fa fa-star checked"></span></p>
                                    </div>
                                </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
            
            <?php include 'footer.php';?>
        </div>
    </div>
    
    <script>
        document.querySelector('.app-name > a').addEventListener('click', () => {
            listAppmenu = document.getElementsByClassName('apps-menu');
            for (let appmenu of listAppmenu) {
                appmenu.style.display = 'none';
            }
            document.querySelector('.iframe-app').classList.toggle('show');
        });
    </script>
</body>
<script src="javascript/drivers.js"></script>
</html>