<?php

    require_once('dev_func.php');
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: loginform.php");
        exit();
    }
    $id = $_GET['id'];
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


    <title>Create New app</title>
  
        

</head>

<body>
<?php
    $error = '';
    $appname = '';
    $desc = '';
    $price = '';
    $appcategory = '';
    $date = date("dmy");
    $date = (string) $date;
    $date = strtotime($date);
    $status = '';
    
    $developer = get_dev_name($id);
    $email = get_dev_email($id);
    $message ='';
    if (isset($_POST['appname']) && isset($_POST['price']) && isset($_POST['desc']) ){
        $appname = $_POST['appname'];
        $price = $_POST['price'];
        $desc = $_POST['desc'];
        $appcategory = $_POST['appcategory'];

        $size = (int) (($_FILES['apk']['size']/1024)/1024);
       
        $size = $size."M";
        $status = 'Pending';

        $time = time();
        $temp = substr($time,6);
        $temp = "A" .$temp;
        $app_id =$temp ;
        mkdir('image/detail/'.$app_id);
        $detail = 'image/detail/'.$app_id;
        $dir = strval($detail)."/";
        $icon = 'image/app/'.$_FILES['icon']['name'];
        $file = 'apk/'.$app_id.'.zip';
        if (empty($appname)) {
            $error = 'Hãy nhập tên ứng dụng';
        }
        else if (intval($price) < 0) {
            $error = 'Giá của sản phẩm không hợp lệ';
        }
        else if (empty($desc)) {
            $error = 'Hãy nhập mô tả của ứng dụng';
        }else if (empty($appcategory)) {
            $error = 'Hãy chọn thể loại của ứng dụng';
        }
        else if ($_FILES["icon"]["error"] != UPLOAD_ERR_OK) {
            $error = 'Vui lòng upload ảnh của sản phẩm';
        }else if ($_FILES["apk"]["error"] != UPLOAD_ERR_OK) {
            $error = 'Vui lòng upload apk của ứng dụng';
        }
        else {

            $result = upload_app($app_id,$developer,$appname,$price,$date,$size, $icon,$appcategory,$desc,$status, $file,$id,$detail,$email);
            if($result['code'] == 0){
                $message = 'Add application success';
                $name = '';
                $price = '';
                $desc = '';
                $appcategory = '';
                $image_name = $_FILES['icon']['name'];
                $fileTempName = $_FILES['icon']['tmp_name'];
                $fileDestination  = 'image/app/' .$image_name;
                move_uploaded_file($fileTempName,$fileDestination);

                $apk_name = $app_id;
                $apkTempName = $_FILES['apk']['tmp_name'];
                $apkDestination  = 'apk/' .$apk_name.'.zip';
                move_uploaded_file($apkTempName,$apkDestination);

                $image_name = $_FILES['image1']['name'];
                $fileTempName = $_FILES['image1']['tmp_name'];
                $fileDestination  = $dir.$image_name;
                move_uploaded_file($fileTempName,$fileDestination);

                $image_name = $_FILES['image2']['name'];
                $fileTempName = $_FILES['image2']['tmp_name'];
                $fileDestination  = $dir.$image_name;
                move_uploaded_file($fileTempName,$fileDestination);

                $image_name = $_FILES['image3']['name'];
                $fileTempName = $_FILES['image3']['tmp_name'];
                $fileDestination  = $dir.$image_name;
                move_uploaded_file($fileTempName,$fileDestination);

            }
            else{
                $error = 'An error occured. Please try again later';
            }
            
        }
    }
?>
    <div class='dev-console'>
        <div class="dev-console-header">
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
                <img src="./image/googleplayconsole.png" alt="" />Google Play Console
            </div>
            <a class="fa fa-shopping-bag" href="index.php"> Google Play Store</a>
            <a class="fa fa-android" href="developer.php?id=<?= (string)$id ?>"> All applications</a>
            <a class="fa fa-gamepad" href="#"> Game services</a>
            <a class="fa fa-credit-card"> Order management</a>
            <a class="fa fa-download" href="#"> Download reports</a>
            <a class='fa fa-warning' href="#"> Alerts</a>
            <a class="fa fa-gear" href="#"> Settings</a>
        </div>
        
        <div class="dev-content-app">
            <div class="dev-menu">
                <div class="dev-row">
                    <h2 class="app-title">Submit application</h2>
                    <h3>App details</h3>
                    <form method="POST" action="" novalidate enctype="multipart/form-data">
                        <label class="appsubmit-label">
                            App Name <input class="appsub-input" type="text" id="appname" name="appname" />
                          </label>

                        <label class="appsubmit-label">
                            Description <textarea class="appsub-textarea" name="desc"></textarea>
                          </label>

                        <label class="appsubmit-label">
                            Price <input class="appsub-price" type="number" id="price" name="price" placeholder="0">
                          </label>

                        <label class="appsubmit-label">
                            App Icon <input name="icon" type="file" class="appsub-input" id="icon" accept="image/gif, image/jpeg, image/png, image/bmp">

                        </label>
                        <label class="appsubmit-label">
                            App Image 1 <input name="image1" type="file" class="appsub-input" id="image1" accept="image/gif, image/jpeg, image/png, image/bmp">

                        </label>
                        <label class="appsubmit-label">
                            App Image 2 <input name="image2" type="file" class="appsub-input" id="image2" accept="image/gif, image/jpeg, image/png, image/bmp">

                        </label>
                        <label class="appsubmit-label">
                            App Image 3 <input name="image3" type="file" class="appsub-input" id="image3" accept="image/gif, image/jpeg, image/png, image/bmp">

                        </label>
                        <label class="appsubmit-label">
                            Categories
                            <select class="appsub-input" name="appcategory" id="appcategory">
                                <option value="Extreme Violence">Extreme Violence</option>
                                <option value="Fear">Fear</option>
                                <option value="Gambling">Gambling</option>
                                <option value="Horror">Horror</option>
                                <option value="Implied Violence">Implied Violence</option>
                                <option value="Mild Swearing">Mild Swearing</option>
                                <option value="Mild Violence">Mild Violence</option>
                                <option value="Moderate Violence">Moderate Violence</option>
                                <option value="Nudity">Nudity</option>
                                <option value="Sex">Sex</option>
                                <option value="Sexual Innuendo">Sexual Innuendo</option>
                                <option value="Simulated Gambling">Simulated Gambling</option>
                                <option value="Strong Violence">Strong Violence</option>
                                <option value="Varies with device">Varies with device</option>
                                
                            </select>
                        </label>

                        <label class="appsubmit-label">
                            App Apk <input name="apk" type="file" class="appsub-input" id="apk" accept=".zip, .rar" onchange="Filevalidation()">
                        </label>
                        <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger appsub-input'>$error</div>";
                            }
                            if (!empty($message)){
                                echo "<div class='alert alert-success appsub-input'>$message</div>";
                            }
                        ?>
                        <button type="submit" class="devcreatebtn">Submit Application</button>
                    </form>
                </div>


            </div>
        </div>

    </div>


    <script src="main.js"></script>

</body>

</html>