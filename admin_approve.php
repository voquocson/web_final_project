<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: loginform.php");
        exit();
    }
    require_once('admin_func.php');
    
    $id = $_GET['id'];
        
    $dev_apps = check_pending_apps($id);
    
?>
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
    <link rel="stylesheet" href="style.css">
    <style> 
        .admin-console-header {
            background-color: #4285F4;
            display: flex;
            height: 60px;
        }

        .admin_approve_btn {
            margin-left: 10px;
            margin-bottom: 25px;
            display: inline-block;
            background: white;
            color: #444;
            width: 150px;
            height: 25.5px;
            border-radius: 5px;
            border: thin solid #888;
            box-shadow: 1px 1px 1px grey;
            white-space: nowrap;
        }

        .admin_deny_btn {
            margin-left: 10px;
            margin-bottom: 25px;
            display: inline-block;
            background: white;
            color: #444;
            width: 150px;
            height: 25px;
            border-radius: 5px;
            border: thin solid #888;
            box-shadow: 1px 1px 1px grey;
            white-space: nowrap;
        }

        .admin_approve_btn:hover {
            cursor: pointer;
        }

        .admin_deny_btn:hover {
            cursor: pointer;
        }
    </style>

    <title>Admin console</title>


</head>

<body>
<?php
    $id = $_GET['id'];
    $id = (string) $id;
    if(isset($_POST['published'])) {
        $status = 'Published';
        $published = edit_publish_status($id,$status);
        foreach($dev_apps['data'] as $item){
            $app_id = $item['app_id'];
            $name = $item['name'];
            $price = $item['price'];
            $updated = $item['date'];
            $size = $item['size'];
            $developer = $item['developer'];
            $image = $item['image'];
            $content = $item['content'];
            $description = $item['description'];
            $file = $item['file'];
            $detail = $item['detail'];
            $email = $item['email'];
            
        }
        $result = push_app($app_id,$name,$price,$updated,$size,$developer,$image,$content,$description,$file,$status,$detail,$email);
       
        header("location:admin_approve.php?id=$id");
    }
    if(isset($_POST['deny'])) {
        foreach($dev_apps['data'] as $item){
            $status = 'Deny';
            $email = $item['email'];
            $result = edit_app_status($id,$status,$email);
            
        }
       
        header("location:admin_approve.php?id=$id");
    }
?>
    <div class='dev-console'>
        <div class="admin-console-header">
            <div class="header-img">
                <a>
                    <img src="./image/googleplayicon.png" alt="" />
                </a>
            </div>
            

            <div class="header-user">
                <?php
                    if(isset($_SESSION['username']) && isset($_SESSION['fullname'])){
                        $username = $_SESSION['username'];
                        $fullname = $_SESSION['fullname'];
                        ?>
                        <div onclick="ClickUserIcon()" class="user-dropdown">
                            <div class="user-profile">
                                <img class="user-img" src="./image/smuge_the_cat.jpg">
                            </div>
                            <div id="user-dropdown-content" class="user-dropdown-content">
                                <h3><?=$fullname?><br><span><?=$username?></span></h3>
                                <ul>
                                    <li><img src="./image/user.svg"><a href="profile.php">My Profile</a></li>
                                    <li><img src="./image/edit.svg"><a href="profile.php">Edit Infomation</a></li>
                                    <li><img src="./image/settings.svg"><a href="profile.php">Change Password</a></li>
                                    <li><img src="./image/log-out.svg"><a href="logout.php">Logout</a></li>
                                </ul>
                            </div>
                        </div>
                        <?php
                    }
                    else{
                        ?>
                            <div class="login-signup">
                                <a class="btn btn-outline-secondary" href="loginform.php">Login</a>
                            </div>
                        <?php
                    }
                    
                ?>
            </div>
        </div>
        <div class="dev-console-sidebar">
            <div class="dev-console-img">
            <img src="./image/admin_icon.png" alt="" />Google Admin
            </div>
            <a class="fa fa-shopping-bag" href="index.php"> Google Play Store</a>
            <a class="fa fa-android" href="admin_check.php"> All applications</a>
            <a class="fa fa-download" href="#"> Download reports</a>
            <a class='fa fa-warning' href="#"> Alerts</a>
            <a class="fa fa-gear" href="#"> Settings</a>
        </div>

        <div class="dev-content">
            <div class="content flex-container">
                <div class="my-3 container">
                    <?php
                        foreach($dev_apps['data'] as $item){
                            ?>
                                <div class="app-page-header">
                                    <span>
                                        <img src="<?= $item['image'] ?>" />
                                    </span>
                                    <div class="app-page-info">
                                        <p><?= $item['name'] ?></p>
                                        <a href="#">
                                            <?= $item['developer'] ?>
                                        </a>
                                        <a href="#category"><?= $item['content'] ?></a>
                                        <div class="rating">
                                            rating
                                            <span class="fa fa-star checked"></span>
                                            
                                        </div>
                                    </div>
                                    <table class="stattable">
                                        <tr>
                                            <td>install</td>
                                            <td>status</td>
                                        </tr>
                                        <tr>
                                            <td>0</td>
                                            <td><?= $item['status'] ?></td>
                                        </tr>
                                    </table>


                                </div>

                                <div class="app-page-description">
                                    <p>
                                    <?= $item['description'] ?>

                                    </p>
                                </div>

                                
                                    
                                    <form method="post" onsubmit="return confirm('You are about to approve an application please confirm your choice');">
                                        <br><input class="admin_approve_btn " type="submit" name="published" value="Published"  /><br>
                                        
                                    </form>
                                    <form method="post" onsubmit="return confirm('You are about to reject an application please confirm your choice');">
                                        <input class="admin_deny_btn " type="submit" name="deny" value="Denied"/>
                                    </form>
                                    
                                  
                                       
                                    
                                    
                                </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="main.js"></script>
    
</body>

</html>