<?php

include './admin/config.php';

function User_Login($user_id,$password) {
    $select_category = "select * from dp_portal_users WHERE mail_id ='".$user_id."' AND password = '".$password."'";
    $category = mysql_query($select_category);
    while ($object = mysql_fetch_assoc($category)):
        $value[] = $object;
    endwhile;
    return $value;
}

if ($_POST['user_name_enter'] == '1') {
    
    $user_id    = $_POST['user_name'];
    $password   = $_POST['password'];
    
    $check_user = User_Login($user_id, $password);
    
    if(count($check_user) > 0){
        $_SESSION['user_name'] = $user_id;
        echo 'OK';
    }
    
}


if ($_POST['user_name_enter'] == '0') {
    
    unset($_SESSION['user_name']);
    echo 'OK';
    
}
?>