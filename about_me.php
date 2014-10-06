<?php session_start(); ?>
<!DOCTYPE html>
<!--
INDEX
เว็บไซด์ขายเครื่องดนตรีออนไลน์
นาย วันเฉลิม เหลาเกตุ รหัสนิสิต 54011213110 สาขา ICT ระบบ ปกติ คณะวิทยาการสารสนเทศ
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>หน้าแรก - เว็บไซด์ขายเครื่องดนตรีออนไลน์</title>
        <link rel="stylesheet" type="text/css" href="web_design_script/Website_selling_musical_intrusment_CSS.css">
        <link rel="stylesheet" type="text/css" href="web_design_script/SmartPhone_Design_Musical_intrusment.css">
        <link rel="stylesheet" type="text/css" href="scripts_camera/camera.css">
        <script type='text/javascript' src='web_design_script/jquery.min.js'></script>
        <script type='text/javascript' src='scripts_camera/jquery.min.js'></script>
        <script type='text/javascript' src='scripts_camera/jquery.mobile.customized.min.js'></script>
        <script type='text/javascript' src='scripts_camera/jquery.easing.1.3.js'></script> 
        <script type='text/javascript' src='scripts_camera/camera.min.js'></script> 
        <script>
            jQuery(function () {
                jQuery('#camera_wrap_1').camera({
                    height: '400px',
                    loader: 'bar',
                    pagination: true
                });
            });
        </script>
        <style>
        </style>
    </head>
    <body>
        <?php
        $about_me = "active";
        $search_top = "search_top_product";
        require './web_server_script/php_function.php';
        ?>
        <?php require './header.php'; ?>
        <div id="containur" class="bottom_main">
            <div class="inner_border" style="margin-top: 5px;">
                <h3 class="topic bg_img" style="text-align: left;">
                    <img class="add" />
                    วิธีการสั่งซื้อ
                </h3>
                <div class="inner" id="show_every_web">
                    <div class="inner-w border-inner">
                        <div style="overflow-x: auto;">
                            <?= $WEB_ABOUT_ME ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require './footer.php'; ?>
        <script type="text/javascript" src="script_connectServer.js"></script>
        <script type="text/javascript" src="script_before_shop.js"></script>
    </body>
</html>
