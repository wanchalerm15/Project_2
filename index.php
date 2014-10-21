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
        $search_detail = " ค้นหาสินค้าเครื่องดนตรี ด่วน !";
        $home = "active";
        $search_top = "search_top_product";
        $method = "GET";
        require './web_server_script/php_function.php';
        ?>
        <?php require './header.php'; ?>
        <div id="containur">
            <div class="bar_design">
                <div class="inner cast_shoping" style="margin-top: 4px;">
                    <a href="order_cast.php">
                        <?php if ($session_add_product != 0) { ?>
                            ตระกร้าสินค้า :<img src="images/shopping_cast_icon.png"><sup>@</sup> [ <?= count($session_add_product) ?> ]
                        <?php } else { ?>
                            ตระกร้าสินค้า :<img src="images/shopping_cast_icon.png"><sup>@</sup> [ <?= count($session_add_product) ?> ]
                        <?php } ?>    
                    </a>
                </div>
                <h3 class="title_category">
                    <img src="images/up-arrow-icon.png" class="before_showShowcat" onclick="$('.sidebarMenu').slideToggle()">
                    <span>
                        ประเภทสินค้า
                    </span>
                </h3>
            </div>
            <div id="artical" class="container before_shop-sidebar">
                <div class="inner_border sidebarMenu bg_img">
                    <!---------------- category --------------------------------------------------------------------->
                    <div>
                        <div class="inner" style="color: #fff;">
                            <ul class="category_nav">
                                <?php
                                $resultcat = mysql_query("select * from category");
                                $i = 0;
                                while ($category = mysql_fetch_array($resultcat)) {
                                    if ($i >= 5) {
                                        $i = 1;
                                    } else {
                                        $i++;
                                    }
                                    ?>
                                    <li>
                                        <a href="?product_category=<?= $category['category_id'] ?>">
                                            <img src="images/Music-icon-<?= $i ?>.png" style="vertical-align: middle;" class="icon_cate"/>
                                            <?= $category['category_name'] ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!---------------- login --------------------------------------------------------------------->
                <?php if (empty($member_id_session) && empty($employee_id_session) && empty($admin_id_session)) { ?>
                    <div class="inner_border" style="margin-top: 10px;" id="login_BrforeShop">
                        <h3 class="topic bg_img">
                            <img src="images/login_icon.png" style="height: 20px;"> เข้าสู่ระบบ
                        </h3>
                        <div class="inner">
                            <div class="inner-w border-inner">
                                <p class="warning">เข้าสู่ระบบ เพื่อสั่งซื้อสินค้าเครื่องดนตรี</p>
                                <form id="login" method="POST" action="web_server_script/check_login.php">    
                                    <p>
                                        Username
                                    </p>
                                    <input type="text" class="text" placeholder=" ชื่อผู้ใช้งาน" name="username_login">     
                                    <p>
                                        Password
                                    </p>
                                    <input type="text" class="text" placeholder=" รหัสเข้าใช้งาน" name="password_login">                                
                                    <button type="submit" class="bt_black">เข้าสู่ระบบ</button>                                      
                                    <button type="button" class="bt_black">สมัครสมาชิก</button>                                 
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="inner_border" style="margin-top: 10px;" id="login_BrforeShop">
                        <h3 class="topic bg_img">
                            <img src="images/login_icon.png" style="height: 20px;"> สถานะสมาชิก
                        </h3>
                        <div class="inner">
                            <div class="inner-w border-inner" id="admin_login">
                                <?php if ($admin_id_session) { ?>
                                    <?php
                                    $query = mysql_query("select * from admin where admin_id=" . $admin_id_session);
                                    $admin = mysql_fetch_array($query);
                                    ?>
                                    <img src="images/admin.png" style="float: left;"/>
                                    <b>ชื่อผู้ใช้ :</b> <?= $admin['admin_user'] ?><br/>
                                    <b>ชื่อ :</b> <?= $admin['admin_name'] ?><br/>
                                    <b>ติดต่อ :</b> <?= $admin['admin_tel'] ?><br/>
                                    <b>สถานะ : เจ้าของร้าน </b><br />
                                    <a href="login_singin.php" class="link" style="font-size: 13px;">
                                        แก้ไขข้อมูลส่วนตัว
                                    </a>
                                <?php } elseif ($employee_id_session) { ?>
                                    <?php
                                    $query = mysql_query("select * from employee where employee_id=" . $employee_id_session);
                                    $employee = mysql_fetch_array($query);
                                    ?>
                                    <img src="images/employee.png" style="float: left;"/>
                                    <b>ชื่อผู้ใช้ :</b> <?= $employee['employee_user'] ?><br/>
                                    <b>ชื่อ :</b> <?= $employee['employee_name'] ?><br/>
                                    <b>ติดต่อ :</b> <?= $employee['employee_tel'] ?><br/>
                                    <b>สถานะ : พนักงาน </b><br />
                                    <a href="login_singin.php" class="link" style="font-size: 13px;">
                                        แก้ไขข้อมูลส่วนตัว
                                    </a>
                                <?php } else { ?>
                                    <?php
                                    $query = mysql_query("select * from member where member_id=" . $member_id_session);
                                    $member = mysql_fetch_array($query);
                                    ?>
                                    <img src="images/use.png" style="float: left;"/>
                                    <b>ชื่อผู้ใช้ :</b> <?= $member['member_user'] ?><br/>
                                    <b>ชื่อ :</b> <?= $member['member_name'] ?><br/>
                                    <b>ติดต่อ :</b> <?= $member['member_tel'] ?><br/>
                                    <b>สถานะ : ลูกค้าสมาชิก </b><br />
                                    <a href="login_singin.php" class="link" style="font-size: 13px;">
                                        แก้ไขข้อมูลส่วนตัว
                                    </a>
                                <?php } ?>
                                <div style="clear: left;"></div>
                                <p style="margin: 3px 0;">
                                    <a href="?Logout=yes" class="bt_black">ออกจากระบบ</a>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!---------------- search --------------------------------------------------------------------->
                <div class="inner_border" style="margin-top: 10px;margin-bottom: 10px;" id="search_BeforeShop">
                    <h3 class="topic bg_img">
                        <img src="images/search-file.png">
                        ค้นหาสินค้าเครื่องดนตรี
                    </h3>
                    <div class="inner">
                        <div class="inner-w border-inner">
                            <p class="warning">
                                ค้นหาสินค้าเครื่องดนตรีโดยละเอียด
                            </p>
                            <form id="main_search" method="GET">
                                <input type="hidden" name="search_hard" value="1">
                                <?php $resultcatSeach = mysql_query("select * from category"); ?>
                                <p>
                                    ชื่อสินค้าเครื่องดนตรี
                                </p>
                                <input type="search" placeholder="ชื่อสินค้า" class="text" name="search_name_pro">
                                <p>
                                    ราคาสินค้าเครื่องดนตรี
                                </p>
                                <select name="search_price_pro">
                                    <option value="0">เลือกราคาสินค้า</option>
                                    <option value="1">น้อยกว่า 500 บาท</option>
                                    <option value="2">ระหว่าง 500-5,000 บาท</option>
                                    <option value="3">ระหว่าง 5,000-10,000 บาท</option>
                                    <option value="4">ระหว่าง 10,000-25,000 บาท</option>
                                    <option value="5">มากกว่า 25,000 บาท</option>
                                </select>
                                <p>
                                    ประเภทสินค้าเครื่องดนตรี
                                </p>
                                <select name="search_cat_pro">
                                    <option value="0">เลือกประเภทสินค้า</option>
                                    <?php while ($category = mysql_fetch_array($resultcatSeach)) { ?>
                                        <option value="<?= $category['category_id'] ?>"><?= $category['category_name'] ?></option>
                                    <?php } ?>
                                </select>
                                <button class="bt_black margin_top">ค้นหาสินค้าเครื่องดนตรี</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="artical" class="container before_shop-mainContainer" style="margin-top:5px;">
                <?php if (!isset($_GET['product_category']) && !isset($_GET['search_top_product']) && empty($_GET["search_hard"])) { ?>
                    <!----------------------------------------------- IMG Slide show ------------------------------------->
                    <div class="frame_img">
                        <div class="img_slide">
                            <div class="camera_wrap pattern_4 camera_beige_skin" id="camera_wrap_1">
                                <?php
                                $query = "select product_image,product_name,product_id from product order by product_id desc limit 0,10";
                                $result = mysql_query($query);
                                while (list($product_image, $product_name, $id) = mysql_fetch_row($result)) {
                                    if ($product_image != "") {
                                        $product_image = explode(",", $product_image);
                                        if ($product_image[0] != "") {
                                            ?>
                                            <div data-thumb="image_product/thumbnail/thumbnails_<?= $product_image[0] ?>" data-src = "image_product/<?= $product_image[0] ?>">
                                                <div class = "camera_caption fadeFromBottom">
                                                    สินค้าเครื่องดนตรีมาใหม่ 
                                                    <em>
                                                        <a href="showProduct_and_comment.php?product_id=<?= $id ?>" class="new_product">
                                                            <u><?= $product_name ?></u>
                                                        </a>
                                                    </em>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!----------------------------------------------- /IMG Slide show ------------------------------------->
                    <div class="bar_design bottom_design">
                        <div style="padding: 0 20px;color: #FFF;opacity: .7;">
                            <marquee>
                                <?= $WEB_THAI_NAME ?> - <?= $WEB_ENG_NAME ?> ขายเครื่องดนตรีสากลทุกชนิด จ่ายเงินแบบหลายทางเลือก
                            </marquee>
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                    <div class="inner_border bottom_main" style="margin-top: 10px;" id="show_product_sell">
                        <h3 class="topic bg_img" style="text-align: left;">
                            สินค้าเครื่องดนตรี <span class="hideTosmartPhoe"><?= $WEB_ENG_NAME ?></span>
                            <div class="inner cast_shoping">
                                <a href="order_cast.php">
                                    <?php if ($session_add_product != 0) { ?>
                                        ตระกร้าสินค้า :<img src="images/shopping_cast_icon.png"><sup>@</sup> [ <?= count($session_add_product) ?> ]
                                    <?php } else { ?>
                                        ตระกร้าสินค้า :<img src="images/shopping_cast_icon.png"><sup>@</sup> [ <?= count($session_add_product) ?> ]
                                    <?php } ?>   
                                </a>
                            </div>
                        </h3>
                        <?php
                        $resultProduct = mysql_query("select * from product");
                        ?>
                        <?php while ($product = mysql_fetch_array($resultProduct)) { ?>
                            <?php $img_product = explode(",", $product['product_image']); ?>
                            <?php if ($img_product[0] != "") { ?>
                                <div class="product_price">
                                    <div class="inner-w">
                                        <div id="img_product">
                                            <img src="image_product/thumbnail/thumbnails_<?= $img_product[0] ?>" onload="setsizeIMG(this);">
                                        </div>
                                        <p> <a href="showProduct_and_comment.php?product_id=<?= $product['product_id'] ?>"><?= $product['product_name'] ?></a> </p>
                                        <p>ราคา :  ฿<span><?= number_format($product['product_price'], 2) ?></span></p>
                                        <div class="add_cast">
                                            <?php if ($WEB_CLOSE_SELL) { ?>
                                                <?php if ($product['product_unit'] > 0) { ?>
                                                    <?php if ($member_id_session) { ?>
                                                        <a onclick="session_add_product(<?= $product['product_id'] ?>,<?= $product['product_cost'] ?>)">
                                                            ใส่ตระกร้า <img src="images/shopping_cast_icon.png">
                                                        </a>
                                                    <?php } else { ?>
                                                        <a onclick="alert('กรุณาเข้าสู่ระบบขอลลูกค้าสมาชิก')">
                                                            ใส่ตระกร้า <img src="images/shopping_cast_icon.png">
                                                        </a>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <span>สินค้าหมด !</span>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <a onclick="alert('ร้านค้ายังไม่พร้อมขายสินค้า !')" >
                                                    แสดงสินค้าเท่านั้น
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div id="show_product_search">
                        <!----------------------------------------------- Product show ------------------------------------->
                        <?php if (isset($_GET['product_category']) && !empty($_GET["product_category"])) { ?>
                            <?php
                            $resultProduct = mysql_query("select * from product where category_id=" . $_GET["product_category"]);
                            $cat_name = mysql_query("select * from category where category_id=" . $_GET["product_category"]);
                            $category_product = mysql_fetch_array($cat_name);
                            ?>
                            <div class="inner_border bottom_main" style="margin-top: 10px;" id="show_product_sell">
                                <h3 class="topic" style="text-align: left;margin-bottom: 10px;">
                                    <u>ประเภท <?= $category_product['category_name'] ?></u>
                                </h3>
                                <?php while ($product = mysql_fetch_array($resultProduct)) { ?>
                                    <?php $img_product = explode(",", $product['product_image']); ?>
                                    <?php if ($img_product[0] != "") { ?>
                                        <div class="product_price">
                                            <div class="inner-w">
                                                <div id="img_product">
                                                    <img src="image_product/thumbnail/thumbnails_<?= $img_product[0] ?>" onload="setsizeIMG(this);">
                                                </div>
                                                <p> <a href="showProduct_and_comment.php?product_id=<?= $product['product_id'] ?>"><?= $product['product_name'] ?></a> </p>
                                                <p>ราคา :  ฿<span><?= number_format($product['product_price'], 2) ?></span></p>
                                                <div class="add_cast">
                                                    <?php if ($WEB_CLOSE_SELL) { ?>
                                                        <?php if ($product['product_unit'] > 0) { ?>
                                                            <?php if ($member_id_session) { ?>
                                                                <a onclick="session_add_product(<?= $product['product_id'] ?>,<?= $product['product_cost'] ?>)">
                                                                    ใส่ตระกร้า <img src="images/shopping_cast_icon.png">
                                                                </a>
                                                            <?php } else { ?>
                                                                <a onclick="alert('กรุณาเข้าสู่ระบบขอลลูกค้าสมาชิก')">
                                                                    ใส่ตระกร้า <img src="images/shopping_cast_icon.png">
                                                                </a>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <span>สินค้าหมด !</span>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <a onclick="alert('ร้านค้ายังไม่พร้อมขายสินค้า !')" >
                                                            แสดงสินค้าเท่านั้น
                                                        </a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="product_price">
                                            <div class="inner-w">
                                                <div id="img_product">
                                                    <img src="images/no_image.jpg" onload="setsizeIMG(this);">
                                                </div>
                                                <p> <a href="showProduct_and_comment.php?product_id=<?= $product['product_id'] ?>"><?= $product['product_name'] ?></a> </p>
                                                <p>ราคา :  ฿<span><?= number_format($product['product_price'], 2) ?></span></p>
                                                <div class="add_cast">
                                                    <?php if ($WEB_CLOSE_SELL) { ?>
                                                        <?php if ($product['product_unit'] > 0) { ?>
                                                            <?php if ($member_id_session) { ?>
                                                                <a onclick="session_add_product(<?= $product['product_id'] ?>,<?= $product['product_cost'] ?>)">
                                                                    ใส่ตระกร้า <img src="images/shopping_cast_icon.png">
                                                                </a>
                                                            <?php } else { ?>
                                                                <a onclick="alert('กรุณาเข้าสู่ระบบขอลลูกค้าสมาชิก')">
                                                                    ใส่ตระกร้า <img src="images/shopping_cast_icon.png">
                                                                </a>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <span>สินค้าหมด !</span>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <a onclick="alert('ร้านค้ายังไม่พร้อมขายสินค้า !')" >
                                                            แสดงสินค้าเท่านั้น
                                                        </a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        <?php } elseif (isset($_GET['search_top_product']) && !empty($_GET["search_top_product"])) { ?>
                            <div class="inner_border bottom_main" style="margin-top: 10px;" id="show_product_sell">
                                <h3 class="topic" style="text-align: left;margin-bottom: 10px;">
                                    <u>ผลการค้นหาสินค้า <?= $_GET['search_top_product'] ?></u>
                                </h3>
                                <?php
                                $resultProduct = mysql_query("select * from product where product_name like('%" . $_GET["search_top_product"] . "%')");
                                if (mysql_num_rows($resultProduct) == 0) {
                                    echo "<div class=\"inner\">ไม่มีสินค้าเครื่องดนตรีนี้</div>";
                                } else {
                                    ?>
                                    <?php while ($product = mysql_fetch_array($resultProduct)) { ?>
                                        <?php $img_product = explode(",", $product['product_image']); ?>
                                        <?php if ($img_product[0] != "") { ?>
                                            <div class="product_price">
                                                <div class="inner-w">
                                                    <div id="img_product">
                                                        <img src="image_product/thumbnail/thumbnails_<?= $img_product[0] ?>" onload="setsizeIMG(this);">
                                                    </div>
                                                    <p> <a href="showProduct_and_comment.php?product_id=<?= $product['product_id'] ?>"><?= $product['product_name'] ?></a> </p>
                                                    <p>ราคา :  ฿<span><?= number_format($product['product_price'], 2) ?></span></p>
                                                    <div class="add_cast">
                                                        <?php if ($WEB_CLOSE_SELL) { ?>
                                                            <?php if ($product['product_unit'] > 0) { ?>
                                                                <?php if ($member_id_session) { ?>
                                                                    <a onclick="session_add_product(<?= $product['product_id'] ?>,<?= $product['product_cost'] ?>)">
                                                                        ใส่ตระกร้า <img src="images/shopping_cast_icon.png">
                                                                    </a>
                                                                <?php } else { ?>
                                                                    <a onclick="alert('กรุณาเข้าสู่ระบบขอลลูกค้าสมาชิก')">
                                                                        ใส่ตระกร้า <img src="images/shopping_cast_icon.png">
                                                                    </a>
                                                                <?php } ?>
                                                            <?php } else { ?>
                                                                <span>สินค้าหมด !</span>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <a onclick="alert('ร้านค้ายังไม่พร้อมขายสินค้า !')" >
                                                                แสดงสินค้าเท่านั้น
                                                            </a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="product_price">
                                                <div class="inner-w">
                                                    <div id="img_product">
                                                        <img src="images/no_image.jpg" onload="setsizeIMG(this);">
                                                    </div>
                                                    <p> <a href="showProduct_and_comment.php?product_id=<?= $product['product_id'] ?>"><?= $product['product_name'] ?></a> </p>
                                                    <p>ราคา :  ฿<span><?= number_format($product['product_price'], 2) ?></span></p>
                                                    <div class="add_cast">
                                                        <?php if ($WEB_CLOSE_SELL) { ?>
                                                            <?php if ($product['product_unit'] > 0) { ?>
                                                                <?php if ($member_id_session) { ?>
                                                                    <a onclick="session_add_product(<?= $product['product_id'] ?>,<?= $product['product_cost'] ?>)">
                                                                        ใส่ตระกร้า <img src="images/shopping_cast_icon.png">
                                                                    </a>
                                                                <?php } else { ?>
                                                                    <a onclick="alert('กรุณาเข้าสู่ระบบขอลลูกค้าสมาชิก')">
                                                                        ใส่ตระกร้า <img src="images/shopping_cast_icon.png">
                                                                    </a>
                                                                <?php } ?>
                                                            <?php } else { ?>
                                                                <span>สินค้าหมด !</span>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <a onclick="alert('ร้านค้ายังไม่พร้อมขายสินค้า !')" >
                                                                แสดงสินค้าเท่านั้น
                                                            </a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        <?php } elseif ($_GET["search_hard"] == 1) { ?>
                            <div class="inner_border bottom_main" style="margin-top: 10px;" id="show_product_sell">
                                <h3 class="topic" style="text-align: left;margin-bottom: 10px;">
                                    <u>ผลการค้นหาสินค้าโดยละเอียด</u>
                                </h3>
                                <?php
                                if (!empty($_GET["search_name_pro"]) && !empty($_GET["search_price_pro"]) && !empty($_GET["search_cat_pro"])) {
                                    $search_name = $_GET["search_name_pro"];
                                    $search_cat = $_GET["search_cat_pro"];
                                    switch ($_GET["search_price_pro"]) {
                                        case 1:
                                            $sql_search = "select * from product where product_name like('%$search_name%') and category_id=$search_cat and product_price < 500";
                                            break;
                                        case 2:
                                            $sql_search = "select * from product where product_name like('%$search_name%') and category_id=$search_cat and product_price between 500 and 5000";
                                            break;
                                        case 3:
                                            $sql_search = "select * from product where product_name like('%$search_name%') and category_id=$search_cat and product_price between 5000 and 10000";
                                            break;
                                        case 4:
                                            $sql_search = "select * from product where product_name like('%$search_name%') and category_id=$search_cat and product_price between 10000 and 25000";
                                            break;
                                        case 5:
                                            $sql_search = "select * from product where product_name like('%$search_name%') and category_id=$search_cat and product_price > 25000";
                                            break;
                                    }
                                    $resultProduct = mysql_query($sql_search);
                                } elseif (!empty($_GET["search_name_pro"]) && !empty($_GET["search_price_pro"]) && empty($_GET["search_cat_pro"])) {
                                    $search_name = $_GET["search_name_pro"];
                                    switch ($_GET["search_price_pro"]) {
                                        case 1:
                                            $sql_search = "select * from product where product_name like('%$search_name%') and product_price < 500";
                                            break;
                                        case 2:
                                            $sql_search = "select * from product where product_name like('%$search_name%') and product_price between 500 and 5000";
                                            break;
                                        case 3:
                                            $sql_search = "select * from product where product_name like('%$search_name%') and product_price between 5000 and 10000";
                                            break;
                                        case 4:
                                            $sql_search = "select * from product where product_name like('%$search_name%') and product_price between 10000 and 25000";
                                            break;
                                        case 5:
                                            $sql_search = "select * from product where product_name like('%$search_name%') and product_price > 25000";
                                            break;
                                    }
                                    $resultProduct = mysql_query($sql_search);
                                } elseif (!empty($_GET["search_name_pro"]) && empty($_GET["search_price_pro"]) && !empty($_GET["search_cat_pro"])) {
                                    $search_name = $_GET["search_name_pro"];
                                    $search_cat = $_GET["search_cat_pro"];
                                    $sql_search = "select * from product where product_name like('%$search_name%') and category_id=$search_cat";
                                    $resultProduct = mysql_query($sql_search);
                                } elseif (empty($_GET["search_name_pro"]) && !empty($_GET["search_price_pro"]) && !empty($_GET["search_cat_pro"])) {
                                    $search_cat = $_GET["search_cat_pro"];
                                    switch ($_GET["search_price_pro"]) {
                                        case 1:
                                            $sql_search = "select * from product where category_id=$search_cat and product_price < 500";
                                            break;
                                        case 2:
                                            $sql_search = "select * from product where category_id=$search_cat and product_price between 500 and 5000";
                                            break;
                                        case 3:
                                            $sql_search = "select * from product where category_id=$search_cat and product_price between 5000 and 10000";
                                            break;
                                        case 4:
                                            $sql_search = "select * from product where category_id=$search_cat and product_price between 10000 and 25000";
                                            break;
                                        case 5:
                                            $sql_search = "select * from product where category_id=$search_cat and product_price > 25000";
                                            break;
                                    }
                                    $resultProduct = mysql_query($sql_search);
                                } elseif (!empty($_GET["search_name_pro"])) {
                                    $resultProduct = mysql_query("select * from product where product_name like('%" . $_GET["search_name_pro"] . "%')");
                                } elseif (!empty($_GET["search_price_pro"])) {
                                    $resultProduct = mysql_query(search_price_product($_GET["search_price_pro"]));
                                } elseif (!empty($_GET["search_cat_pro"])) {
                                    $resultProduct = mysql_query("select * from product where category_id=" . $_GET["search_cat_pro"]);
                                } else {
                                    $resultProduct = mysql_query("select * from product where product_id=0");
                                }
                                if (mysql_num_rows($resultProduct) == 0) {
                                    echo "<div class=\"inner\">ไม่มีสินค้าเครื่องดนตรีนี้</div>";
                                } else {
                                    ?>
                                    <?php while ($product = mysql_fetch_array($resultProduct)) { ?>
                                        <?php $img_product = explode(",", $product['product_image']); ?>
                                        <?php if ($img_product[0] != "") { ?>
                                            <div class="product_price">
                                                <div class="inner-w">
                                                    <div id="img_product">
                                                        <img src="image_product/thumbnail/thumbnails_<?= $img_product[0] ?>" onload="setsizeIMG(this);">
                                                    </div>
                                                    <p> <a href="showProduct_and_comment.php?product_id=<?= $product['product_id'] ?>"><?= $product['product_name'] ?></a> </p>
                                                    <p>ราคา :  ฿<span><?= number_format($product['product_price'], 2) ?></span></p>
                                                    <div class="add_cast">
                                                        <?php if ($WEB_CLOSE_SELL) { ?>
                                                            <?php if ($product['product_unit'] > 0) { ?>
                                                                <?php if ($member_id_session) { ?>
                                                                    <a onclick="session_add_product(<?= $product['product_id'] ?>,<?= $product['product_cost'] ?>)">
                                                                        ใส่ตระกร้า <img src="images/shopping_cast_icon.png">
                                                                    </a>
                                                                <?php } else { ?>
                                                                    <a onclick="alert('กรุณาเข้าสู่ระบบขอลลูกค้าสมาชิก')">
                                                                        ใส่ตระกร้า <img src="images/shopping_cast_icon.png">
                                                                    </a>
                                                                <?php } ?>
                                                            <?php } else { ?>
                                                                <span>สินค้าหมด !</span>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <a onclick="alert('ร้านค้ายังไม่พร้อมขายสินค้า !')" >
                                                                แสดงสินค้าเท่านั้น
                                                            </a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="product_price">
                                                <div class="inner-w">
                                                    <div id="img_product">
                                                        <img src="images/no_image.jpg" onload="setsizeIMG(this);">
                                                    </div>
                                                    <p> <a href="showProduct_and_comment.php?product_id=<?= $product['product_id'] ?>"><?= $product['product_name'] ?></a> </p>
                                                    <p>ราคา :  ฿<span><?= number_format($product['product_price'], 2) ?></span></p>
                                                    <div class="add_cast">
                                                        <?php if ($WEB_CLOSE_SELL) { ?>
                                                            <?php if ($product['product_unit'] > 0) { ?>
                                                                <?php if ($member_id_session) { ?>
                                                                    <a onclick="session_add_product(<?= $product['product_id'] ?>,<?= $product['product_cost'] ?>)">
                                                                        ใส่ตระกร้า <img src="images/shopping_cast_icon.png">
                                                                    </a>
                                                                <?php } else { ?>
                                                                    <a onclick="alert('กรุณาเข้าสู่ระบบขอลลูกค้าสมาชิก')">
                                                                        ใส่ตระกร้า <img src="images/shopping_cast_icon.png">
                                                                    </a>
                                                                <?php } ?>
                                                            <?php } else { ?>
                                                                <span>สินค้าหมด !</span>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <a onclick="alert('ร้านค้ายังไม่พร้อมขายสินค้า !')" >
                                                                แสดงสินค้าเท่านั้น
                                                            </a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                    <!----------------------------------------------- Product show ------------------------------------->
                </div>
            </div>
        </div>
        <?php require './footer.php'; ?>
        <script type="text/javascript" src="script_connectServer.js"></script>
        <script type="text/javascript" src="script_before_shop.js"></script>
    </body>
</html>
