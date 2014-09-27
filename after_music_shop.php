<?php session_start(); ?>
<?php include './web_server_script/connect_DB.php'; ?>
<?php
if (!$admin_id_session && !$employee_id_session) {
    header("Location:login_singin.php");
}
?>
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
        <title>ระบบหลังร้าน - เว็บไซด์ขายเครื่องดนตรีออนไลน์</title>
        <link rel="stylesheet" type="text/css" href="web_design_script/Website_selling_musical_intrusment_CSS.css">
        <link rel="stylesheet" type="text/css" href="web_design_script/SmartPhone_Design_Musical_intrusment.css">
        <script type="text/javascript" src="web_design_script/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                //alert($(window).width()+" - "+$(document).height());
            });
        </script>
    </head>
    <body>
        <?php $after_shop = "active"; ?>
        <?php require './header.php'; ?>
        <div id="containur" class="after_shop">
            <div id="artical" class="slidebar_aftershop">
                <h3 class="topic">
                    <img src="images/nav_manage_icon.png">
                    <span>จัดการหลังร้าน</span>
                    <img src="images/up-arrow-icon.png" onclick="$('ul.nev_menuAftershop').slideToggle();" class="smart_phone_hide_icon">
                </h3>
                <ul class="nev_menuAftershop">
                    <li><a href="?manage=category">จัดการประเภทเครื่องดนตรี</a></li>
                    <li><a href="?manage=product">จัดการสินค้าเครื่องดนตรี</a></li>
                    <li><a href="?manage=employee">จัดการระบบพนักงาน</a></li>
                    <li><a href="?manage=member">จัดการระบบลูกค้าสมาชิก</a></li>
                    <li><a href="?manage=order">จัดการระบบสั่งซื้อสินค้า</a></li>
                    <li><a href="?manage=comment">จัดการระบบแสดงความเห็น</a></li>
                    <li><a href="">แก้ไขเว็บไซด์</a></li>
                </ul>
            </div>
            <?php if ($_GET["manage"] == "category") { ?>
                <!------------------------------ category -------------------------------------------->
                <?php include './category_manage.php'; ?>
            <?php } elseif ($_GET["manage"] == "employee") { ?>
                <!------------------------------ employee -------------------------------------------->
                <?php include './employee_manage.php'; ?>
            <?php } elseif ($_GET["manage"] == "member") { ?>
                <!------------------------------ member -------------------------------------------->
                <?php include './member_manage.php'; ?>
            <?php } elseif ($_GET["manage"] == "product") { ?>
                <!------------------------------ member -------------------------------------------->
                <?php include './product_manage.php'; ?>
            <?php } elseif ($_GET["manage"] == "order") { ?>
                <!------------------------------ order -------------------------------------------->
                <?php include './order_manage.php'; ?>
            <?php } elseif ($_GET["manage"] == "comment") { ?>
                <!------------------------------ order -------------------------------------------->
                <?php include './comment_manage.php'; ?>
            <?php } else { ?>
                <!------------------------------ category -------------------------------------------->
                <?php include './category_manage.php'; ?>
            <?php } ?>
            <div style="clear: both;"></div>
        </div>
        <?php require './footer.php'; ?>
        <script type="text/javascript" src="script_connectServer.js"></script>
    </body>
</html>
