<?php 
$app->get('/session', function() {
    $db = new DbHandler();
    $session = $db->getSession();
    $response["uid"] = $session['uid'];
    $response["email"] = $session['email'];
    $response["name"] = $session['name'];
    echoResponse(200, $session);
});

$app->post('/login', function() use ($app) {
    require_once 'passwordHash.php';
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('email', 'password'),$r->customer);
    $response = array();
    $db = new DbHandler();
    $password = $r->customer->password;
    $email = $r->customer->email;
    $user = $db->getOneRecord("select id,first_name,last_name,password,mail_id from dp_portal_users where mail_id='$email' AND password='$password'  ");
    //$files = $db->getAllRecord("select * from db_portal_files where user_id='".$user['id']."'");
        
    if ($user != NULL) {
        $response['status'] = "success";
        $response['message'] = 'Logged in successfully.';
        $response['name'] = $user['first_name'].$user['last_name'];
        $response['uid'] = $user['id'];
        $response['email'] = $user['mail_id'];       
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['uid'] = $user['id'];
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $user['first_name'].' '.$user['last_name'];
    }else {
            $response['status'] = "error";
            $response['message'] = 'No such user is registered';
        }
    echoResponse(200, $response);
});

$app->get('/getrecords', function(){    
    $response = array();    
    $db = new DbHandler();
    $session    = $db->getSession();
    $user_id    = $session['uid'];  
    $files      = $db->getAllRecord("select * from db_portal_files WHERE user_id = '".$user_id."' ");
    //$user_name  = $db->getOneRecord("SELECT first_name,last_name FROM dp_portal_users WHERE id = '".$user_id."' ");
    foreach ($files as $all_files)    {
        $record_id      = ($all_files["id"] != '') ? $all_files["id"] : '';
        $file_name      = ($all_files["file_name"] != '') ? $all_files["file_name"] : '';
        $comp_id        = ($all_files["comp_id"] != '') ? $all_files["comp_id"] : '';
        $user_id        = ($all_files["user_id"] != '') ? $all_files["user_id"] : '';        
        $uploaded_by    = ($all_files["status"] == '1') ? 'Admin' : 'My self';
        $uploaded_by_f  = ($uploaded_by != '') ? $uploaded_by : ''; 
        $uploaded       = ($all_files["uploaded"] != '') ? $all_files["uploaded"] : ''; 
    $response [] = array(
        "status"     => "success", 
        "rec_id"     => $record_id, 
        "file_name"  => $file_name, 
        "comp_id"    => $comp_id, 
        "user_id"    => $user_id,
        "uploaded_sts"    => $uploaded_by_f,
        "uploaded"   => $uploaded);
    }  
    echoResponse(200, $response);
});


$app->post('/signUp', function() use ($app) {
    $response = array();
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('email', 'name', 'password'),$r->customer);
    require_once 'passwordHash.php';
    $db = new DbHandler();
    $phone = $r->customer->phone;
    $name = $r->customer->name;
    $email = $r->customer->email;
    $address = $r->customer->address;
    $password = $r->customer->password;
    $isUserExists = $db->getOneRecord("select 1 from customers_auth where phone='$phone' or email='$email'");
    if(!$isUserExists){
        $r->customer->password = passwordHash::hash($password);
        $tabble_name = "customers_auth";
        $column_names = array('phone', 'name', 'email', 'password', 'city', 'address');
        $result = $db->insertIntoTable($r->customer, $column_names, $tabble_name);
        if ($result != NULL) {
            $response["status"] = "success";
            $response["message"] = "User account created successfully";
            $response["uid"] = $result;
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['uid'] = $response["uid"];
            $_SESSION['phone'] = $phone;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            echoResponse(200, $response);
        } else {
            $response["status"] = "error";
            $response["message"] = "Failed to create customer. Please try again";
            echoResponse(201, $response);
        }            
    }else{
        $response["status"] = "error";
        $response["message"] = "An user with the provided phone or email exists!";
        echoResponse(201, $response);
    }
});
$app->get('/logout', function() {
    $db = new DbHandler();
    $session = $db->destroySession();
    $response["status"] = "info";
    $response["message"] = "Logged out successfully";
    echoResponse(200, $response);
});
?>