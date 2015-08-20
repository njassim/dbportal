<!DOCTYPE html>
<?php
include './admin/config.php';
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>DB Portal</title>
        <style>
            *{ margin:0; padding:0;}
            a img{ border:none; outline:none;}
            ul li{ list-style:none; text-decoration:none;}
            h1,h2,h3,h4,h5,h6{ font-weight:bold;}
            body{font-family: 'proximanova-regular'; font-size:14px; }
            a{ text-decoration:none;}
            .clr{ clear:both;}
            .left{float:left;}
            .right{float:right;}

            .wrapper_home{
                width: 100%;
                float: left;
                background: #23C1CD;
            }

            .wrapper_home .logo{
                width: 100%;
                float: left;
                text-align: center;
                margin-top: 15px;
                margin-bottom: 15px;
                color: #B7E8EB;
            }            

            .header_menu{
                width: 100%;
                float: left;
                text-align: center;
            }  

            .none{display: none;}

            .modal-overlay {
                opacity: 0.7;
                filter: alpha(opacity=0);
                position: fixed;
                top: 0;
                left: 0;
                z-index: 900;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.3) !important;
            }

            .login_tab{
                list-style: none;
            }

            .login_tab li{
                margin-top: 10px;
                margin-bottom: 10px;
            }

            .login_tab li label{
                width: 40%;
                float: left;
                font-size: 18px;
            }

            #user_name{
                border-color: #cccccc;
                padding: 4px;
                font-size: 14px;
                border-radius: 6px;
                border-width: 2px;
                border-style: groove;
                text-shadow: 0px 0px 0px rgba(42,42,42,.75);
                width: 175px;
            }

            #password{
                border-color: #cccccc;
                padding: 4px;
                font-size: 14px;
                border-radius: 6px;
                border-width: 2px;
                border-style: groove;
                text-shadow: 0px 0px 0px rgba(42,42,42,.75);
                width: 175px;
            }
        </style>
        <script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
        <script>

            function login_user()
            {
                $("body").append("<div class='modal-overlay js-modal-close'></div>");
                $("#asap_popup").slideDown("slow");
            }

            function close_login_user()
            {
                $(".modal-overlay").fadeOut();
                $("#asap_popup").slideUp("slow");
            }

            function login_user_go()
            {
                
                var user_name   = $("#user_name").val();
                var password    = $("#password").val();
                
                if(user_name == ''){
                    $("#user_name").focus();
                    return false;
                }
                
                if(password == ''){
                    $("#password").focus();
                    return false;
                }
                
                if (password != '') {
                    $.ajax
                            ({
                                type: "POST",
                                url: "user_login.php",
                                data: "user_name_enter=1&user_name=" + encodeURIComponent(user_name) + "&password=" + encodeURIComponent(password),
//                                beforeSend: loadStart,
//                                complete: loadStop,
                                success: function(option)
                                {
                                    if(option == 'OK'){
                                        window.location = "index.php";
                                    }
                                }
                            });
                } 
            }
            
            function logout()
            {
                $.ajax
                            ({
                                type: "POST",
                                url: "user_login.php",
                                data: "user_name_enter=0",
//                                beforeSend: loadStart,
//                                complete: loadStop,
                                success: function(option)
                                {
                                    if(option == 'OK'){
                                        window.location = "index.php";
                                    }
                                }
                            });
            }
        </script>
    </head>
    <body>

        <div id="loading" class="none"  style="position: fixed;top: 35%;left: 48%;padding: 5px;z-index: 9999;">
            <img src="images/login_loader.gif" border="0" />
        </div>

        <div id="asap_popup" style="display: none;font-size: 15px;position: fixed;top: 35%;left: 40%;padding: 5px;z-index: 10;position: absolute;z-index: 1000;width: 30%;background: white;border-bottom: 1px solid #aaa;border-radius: 4px;box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);border: 1px solid rgba(0, 0, 0, 0.1);background-clip: padding-box;">
            <div style="width: 96%;padding: 2%;float: left;font-size: 14px;line-height: 18px;text-align: center;">
                <ul class="login_tab">
                    <li>
                        <label>User Name</label>
                        <input type="text" name="user_name" id="user_name" placeholder="Enter the User Name" />
                    </li>
                    <li>
                        <label>Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter the Password" />
                    </li>
                </ul>                
            </div>
            <div style="float: right;width: 98%;background-color: #23C1CD;padding: 1%;">               
                <span style="float: left;border: 1px solid #B7E8EB;padding: 3px 10px;border-radius: 3px;cursor: pointer;" onclick="return login_user_go();">Login</span>
                <span style="float: right;border: 1px solid #B7E8EB;padding: 3px 10px;border-radius: 3px;cursor: pointer;" onclick="return close_login_user();">Close</span>
            </div>
        </div>

        <div class="wrapper_home">
            <div class="logo">
                <h1>DB Portal</h1>
            </div>
        </div>

        <div class="header_menu">
            <div style="width: 50%;float: left;">&nbsp;</div>
            <div style="width: 50%;float: left;text-align: center;">
                <div style="width: 10%;float: left;cursor: pointer;" onclick="return login_user();">Login</div>
                <div style="width: 10%;float: left;">Help</div>
                <div style="width: 13%;float: left;">Contact Us</div>
                <?php  
                //print_r($_SESSION);
                if($_SESSION['user_name'] != ''){
                ?>
                <div style="width: 65%;float: right;">Logged In <span style="color: #23C1CD;"><?php echo $_SESSION['user_name']; ?></span><span style="cursor: pointer;" onclick="return logout();">&nbsp;Logout</span></div>
                <?php
                }
                ?>
            </div>
        </div>
    </body>
</html>
