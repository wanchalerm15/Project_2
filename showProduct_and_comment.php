<?php session_start(); ?>
<?php
include './web_server_script/connect_DB.php';
define(PRODUCT_ID, $_GET['product_id']);
$resultProduct = mysql_query("select * from product where product_id=" . PRODUCT_ID);
$product = @mysql_fetch_array($resultProduct);
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
        <meta class="refrest">
        <title>แสดงสินค้า : <?= $product['product_name'] ?></title>
        <link rel="stylesheet" type="text/css" href="web_design_script/Website_selling_musical_intrusment_CSS.css">
        <link rel="stylesheet" type="text/css" href="web_design_script/SmartPhone_Design_Musical_intrusment.css">
        <link rel="stylesheet" type="text/css" href="web_design_script/cloud-zoom.css">
        <script type="text/javascript" src="web_design_script/jquery.min.js"></script>
        <script src="wysiwyg.js"></script>
        <script>
            $(document).ready(function () {
                //alert($(window).width());
            });</script>
    </head>
    <body>
        <?php require './header.php'; ?>
        <div id="containur">
            <div id="artical" class="container" style="margin-top: 5px;">
                <div class="inner_border">
                    <h3 class="topic bg_img" style="text-align:left;">
                        ชื่อสินค้า : <?= $product['product_name'] ?>
                        <button class="bt_back" onclick="history.back();">ย้อนกลับ</button>
                    </h3>
                    <div class="inner">
                        <div class="show_imgProduct">
                            <div class="border-inner" style="text-align: center;">
                                <?php $productIMG = explode(",", $product['product_image']); ?>
                                <div id="showIMG">
                                    <span>
                                        <a href="image_product/<?= $productIMG[0] ?>" target="_blank" id="">
                                            <img src="image_product/<?= $productIMG[0] ?>" title="ดูรูปเต็ม คลิ๊ก!" onload="load_img_forShow(this);" />
                                        </a>
                                    </span>
                                    <p class="top"><?= $product['product_name'] ?></p>
                                </div>
                            </div>
                            <div class="inner-w border-inner" style="margin-top: 7px;">
                                <div id="showTHUM">
                                    <?php foreach ($productIMG as $img) { ?>
                                        <span>
                                            <img src="image_product/thumbnail/thumbnails_<?= $img ?>" title="<?= $img ?>"/>
                                        </span>
                                    <?php } ?>
                                </div>
                            </div>
                            <script>
                                $(document).ready(function () {
                                    if ($("#showIMG img").height() > $("#showIMG img").width()) {
                                        if ($("#showIMG img").height() >= 400) {
                                            $("#showIMG img").css({height: "400px", width: 'auto'});
                                        }
                                    }
                                    $("#showTHUM img").each(function (index) {
                                        $(this).click(function () {
                                            var src = "image_product/" + $(this).attr('title');
                                            var html_data = "<a href ='" + src + "' target='_blank'>";
                                            html_data += "<img src='" + src + "' title='ดูรูปเต็ม คลิ๊ก!' onload = 'load_img_forShow(this)' />";
                                            html_data += "</a>";
                                            $('#showIMG span').hide().fadeIn(1000);
                                            $('#showIMG span').html(html_data);
                                        });
                                    });
                                });</script>
                            <h3 class="topic" style="margin: 10px 0 5px 0;">
                                เสียงสินค้าเครื่องดนตรี
                            </h3>
                            <div class="inner-w border-inner" id="product_music">
                                <?php if (!empty($product['product_sound'])) { ?>
                                    <p>
                                        <a href="sound_product/<?= $product['product_sound'] ?>" class="link" target="_blank">
                                            <?= $product['product_sound'] ?>
                                        </a>
                                    </p>
                                    <audio src="sound_product/<?= $product['product_sound'] ?>" controls="">
                                        เว็บ Bowser ไม่สนับสนุน Tag นี้
                                    </audio>
                                <?php } else { ?>
                                    -
                                <?php } ?>
                            </div>
                        </div>
                        <div class="show_detail_rocuct">
                            <h3 class="topic">
                                รายละเอียดสินค้าเครื่องดนตรี
                            </h3>
                            <div class="inner-w border-inner" id="product_detail">
                                <p>
                                    <b>ชื่อสินค้าเครื่องดนตรี :</b> <?= $product['product_name'] ?>
                                </p>
                                <p>
                                    <b>ราคาสินค้าเครื่องดนตรี :</b> <?= number_format($product['product_price'], 2) ?> บาท
                                </p>
                                <p>
                                    <b>จำนวนที่เหลือในระบบ :</b> <?= $product['product_unit'] ?> ชื้น
                                </p>
                                <p>
                                    <?php
                                    $quer = mysql_query("select category_name from category where category_id=" . $product['category_id']);
                                    list($category_name) = @mysql_fetch_row($quer)
                                    ?>
                                    <b>ประเภทสินค้า :</b> <?= $category_name ?>
                                </p>
                                <p>
                                    <b>นำเข้าสินค้าเมื่อ :</b> <?= $product['date_input'] ?>
                                </p>
                            </div>   
                            <div class="inner-w border-inner add_cast" style="text-align: center;margin-top: 5px;">
                                <?php if ($product['product_unit'] > 0) { ?>
                                    <?php if ($member_id_session) { ?>
                                        <a onclick="session_add_product(<?= $product['product_id'] ?>)">
                                            ใส่ตระกร้า <img src="images/shopping_cast_icon.png">
                                        </a>
                                    <?php } else { ?>
                                        <a onclick="alert('กรุณาเข้าสู่ระบบของลูกค้าสมาชิก')">
                                            ใส่ตระกร้า <img src="images/shopping_cast_icon.png">
                                        </a>
                                    <?php } ?>
                                <?php } else { ?>
                                    <span style="color: #f00;">สินค้าหมด !</span>
                                <?php } ?>
                            </div>
                            <!---------------------------------------------- comment -------------------------------------------->
                            <h3 class="topic" style="margin: 10px 0 5px 0;">
                                แสดงความเห็น
                            </h3>
                            <div class="inner-w border-inner">
                                <form method="POST" id="comment">
                                    <p>หัวข้อความเห็น</p>
                                    <input type="text" class="text" placeholder=" ชื่อหัวข้อความเห็น" name="comment_topic">
                                    <p>ชื่อผู้แสดงความเห็น</p>
                                    <?php
                                    $comment_peple = "";
                                    $no_name = "ไม่มีชื่อ-ID:" . substr(session_id(), 0, 10);
                                    if (!empty($member_id_session)) {
                                        $query = mysql_query("select * from member where member_id=$member_id_session");
                                        $member = mysql_fetch_array($query);
                                        $comment_peple = $member['member_name'];
                                    } elseif (!empty($employee_id_session)) {
                                        $query = mysql_query("select * from employee where employee_id=$employee_id_session");
                                        $employee = mysql_fetch_array($query);
                                        $comment_peple = $employee['employee_name'];
                                    } elseif (!empty($admin_id_session)) {
                                        $query = mysql_query("select * from admin where admin_id=$admin_id_session");
                                        $admin = mysql_fetch_array($query);
                                        $comment_peple = $admin['admin_name'];
                                    } else {
                                        $comment_peple = $no_name;
                                    }
                                    ?>
                                    <input type="text" class="text" placeholder=" ชื่อผู้แสดงความเห็น" name="comment_peple" id="comment_peple">
                                    <p>รายละเอียดความเห็น</p>
                                    <textarea id="comment_detail" class="text" placeholder=" รายละเอียดแสดงความเห็นต่อสินค้าเครื่องดนตรี" name="comment_detail"></textarea>
                                    <input type="hidden" name="product_id" value="<?= PRODUCT_ID ?>">
                                    <p>
                                        <button type="submit" class="bt_black">แสดงความเห็น</button>
                                    </p>
                                    <span class="warning-inline" id="comment_error"></span>
                                </form>
                                <script>
                                    $(function () {
                                        $("#comment").submit(function () {
                                            $("#comment_peple").click(function () {
                                                $(this).val('<?= $comment_peple ?>');
                                            });
                                            if ($.trim($("#comment_peple").val()) == "") {
                                                $("#comment_peple").val('<?= $comment_peple ?>');
                                            }
                                            var error = "";
                                            $("#comment .text").each(function () {
                                                if ($(this).val() == "") {
                                                    error += "กรุณากรอกช่อง : " + $(this).attr('placeholder') + "<br />";
                                                }
                                            });
                                            if (error == "") {
                                                add_comment(this,<?= PRODUCT_ID ?>);
                                            } else {
                                                $("#comment_error").show().html(error).removeClass("warning-ok");
                                            }
                                            return false;
                                        });
                                    });</script>
                                <script>
                                    generate_wysiwyg('comment_detail');</script>
                            </div>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                </div>
            </div>
            <div id="artical" class="container bottom_main" style="margin-top: 15px;">
                <div class="inner_border">
                    <h3 class="topic" style="margin-bottom: -15px;text-align: left;">
                        ความเห็นต่อสินค้าเครื่องดนตรีชิ้นนี้
                    </h3>
                    <div class="inner" id="comment_show">
                        <?php
                        $query = "select * from comment where product_id=" . PRODUCT_ID;
                        $resultComment = mysql_query($query);
                        ?>
                        <?php while ($comment = @mysql_fetch_array($resultComment)) { ?>
                            <div id="comment-<?= $comment['comment_id'] ?>">
                                <h3 class="topic" style="margin: 20px 0 3px 0;">
                                    <?= $comment['comment_topic'] ?>
                                </h3>
                                <div class="inner-w border-inner">
                                    <pre><?= trim($comment['comment_detail']); ?></pre>
                                </div>
                                <div id="date_peple_delete_com">
                                    <div class="inner-w border-inner">
                                        โดย : <?= trim($comment['comment_peple']); ?>
                                    </div>
                                    <div class="inner-w border-inner">
                                        วันที่โพส : <?= trim($comment['comment_date']); ?>
                                    </div>
                                    <div class="inner-w border-inner">
                                        <a onclick="delete_comment(<?= $comment['comment_id'] ?>)">แจ้งลบ</a> : 
                                        <span class="delete_comment" id="comment_del-<?= $comment['comment_id'] ?>">
                                            <?= trim($comment['comment_delete']); ?>
                                        </span>
                                    </div>
                                    <?php if (!empty($admin_id_session) || !empty($employee_id_session)) { ?>
                                        <div class="inner-w border-inner">
                                            <a onclick="delete_commect_cascade(<?= $comment['comment_id'] ?>)">ลบความเห็นนี้</a>
                                        </div>
                                    <?php } ?>
                                    <script>
                                        $(document).ready(function () {
                                            if ($("#comment_del-<?= $comment['comment_id'] ?>").text() != 0) {
                                                $("#comment_del-<?= $comment['comment_id'] ?>").addClass("red");
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php require './footer.php'; ?>
        <script src="script_connectServer.js"></script>
        <script src="script_before_shop.js"></script>
        <script src="web_design_script/cloud-zoom.js"></script>
    </body>
</html>
