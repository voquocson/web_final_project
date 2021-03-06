<?php
    define('HOST','localhost');
    define('USER','root');
    define('PASS','');
    define('DB','googleplay');

    function open_database(){
        $conn = new mysqli(HOST, USER, PASS, DB);
        if ($conn->connect_error) die('Connect error: ' . $conn->connect_error);
        return $conn; 
    }
    function upload_app($app_id,$developer,$appname,$price,$date,$size,$icon,$appcategory,$desc,$status,$file,$user_id,$detail,$email){
        $sql = 'insert into pending_application (app_id,developer, name, price, date, size, image, content, description, status, file,user_id,detail,email) value (?,?,?,?,?,?,?,?,?,?,?,?,?,?)';

        $conn = open_database();
        $stm = $conn->prepare($sql);

        $stm->bind_param('sssissssssssss',$app_id,$developer,$appname,$price,$date,$size,$icon,$appcategory,$desc,$status,$file,$user_id,$detail,$email);
        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not execute command');
        }

        return array('code' => 0, 'message' => 'Add successful');
    }
    # lấy ứng dụng dev tải lên
    function get_uploadapp($id){
        $sql = 'select * from pending_application where user_id = ?';

        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$id);
        if(!$stm->execute()){
            return array('code' => 2,'error'=> 'Can not execute command');
        }

        $result = $stm->get_result();
        if ($result->num_rows == 0){
            return array('code'=> 1, 'error'=> 'No app');
        }
        $data = array();
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return array('code' => 0,'message'=> 'success','data'=>$data);
    }
    #lấy chi tiết app từ database mà dev up lên
    function get_pending_apps($id){
        
        $sql = "select * FROM pending_application WHERE app_id = ?";

        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param("s",$id);
        if (!$stm->execute()) return array('code'=>1, 'error' => 'Can not execute command');
        $result = $stm->get_result();
        $row = $result ->fetch_assoc();
    

        return $row;
    }
    #chỉnh sửa các app có trạng thái là pending
    function edit_pend_app($app_id,$appname,$price,$date,$size,$icon,$appcategory,$desc,$file){
        $sql = "update pending_application set name = ?, price = ?, date= ?, size = ?, image = ?,content = ?, description = ?, file = ? where app_id = ?;";

        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('sisssssss',$appname,$price,$date,$size,$icon,$appcategory,$desc,$file,$app_id);
        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not execute command');
        }

        return array('code' => 0, 'message' => 'Add successful');
    }
    #chỉnh sửa các app có trạng thái là published
    function edit_pub_app($app_id,$appname,$price,$date,$size,$icon,$appcategory,$desc){
        $sql = "update application set name = ?, price = ?, updated= ?, size = ?, image = ?,content = ?, description = ? where id = ?";

        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('sissssss',$appname,$price,$date,$size,$icon,$appcategory,$desc,$app_id);
        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not execute command');
        }

        return array('code' => 0, 'message' => 'Add successful');
    }
    #Lấy status của app
    function get_app_status($id){
        $sql = "select status from pending_application where user_id = ?";

        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$id);
        
        $stm->execute();
        $result = $stm->get_result();
        $row = $result->fetch_assoc();
        $status = $row['status'];
        return $status;

    }
    #xóa app có trạng thái là pending
    function delete_pend_app($app_id){
        $sql = "Delete from pending_application where app_id = ?";

        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$app_id);
        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not execute command');
        }

        return array('code' => 0, 'message' => 'delete successful');
    }

    #xóa app có trạng thái là pending
    function unpublish_app($status,$app_id){
        $sql = "update application set status = ? where id = ?";

        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss',$status,$app_id);
        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not execute command');
        }
        $sql = "update pending_application set status = ? where app_id = ?";

        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss',$status,$app_id);
        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not execute command');
        }

        return array('code' => 0, 'message' => 'Add successful');
    }
    function get_dev_name($id){
        $sql = "select * from account where id = ?";

        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$id);
        
        $stm->execute();
        $result = $stm->get_result();
        $row = $result->fetch_assoc();
        $status = $row['dev'];
        return $status;
    }
    function get_dev_email($id){
        $sql = "select * from account where id = ?";

        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$id);
        
        $stm->execute();
        $result = $stm->get_result();
        $row = $result->fetch_assoc();
        $status = $row['email'];
        return $status;
    }
    function delete_pub_app($app_id){
        $sql = "Delete from application where id = ?";

        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$app_id);
        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not execute command');
        }

        return array('code' => 0, 'message' => 'delete successful');
    }
?>