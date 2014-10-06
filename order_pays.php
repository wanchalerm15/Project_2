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
        <script type="text/javascript" src="web_design_script/jquery.min.js"></script>
        <script type="text/javascript" src="web_design_script/jqFancyTransitions.1.7.min.js"></script>
        <script>
            $(document).ready(function () {
                //alert($(window).width());
            });
        </script>
        <style>
        </style>
    </head>
    <body>
        <?php require './header.php'; ?>
        <div id="containur">
            <?php
            $query_product = "select * from product";
            $result_product = mysql_query($query_product);
            $query = "select order_id from order_music where member_id=$member_id_session order by order_id desc limit 0,1";
            list($order_id) = mysql_fetch_row(mysql_query($query));

            define(ORDER_ID, $order_id);

            $order_index = 0;
            while ($rowProduct = mysql_fetch_array($result_product)) {
                for ($index1 = 0; $index1 <= $_SESSION['count']; $index1++) {
                    if (!empty($_SESSION['session_unit_product'][$index1])) {
                        if ($_SESSION['session_add_product'][$index1] == $rowProduct['product_id']) {
                            $orderDetail_array[$order_index] = array(
                                'order_id' => $order_id,
                                'order_product_id' => $_SESSION['session_add_product'][$index1],
                                'unit_price' => $_SESSION['session_unit_product'][$index1],
                            );
                            $order_index++;
                        }
                    }
                }
            }
            if (isset($_GET['no_pays'])) {
                mysql_query("delete from order_music where order_id=" . ORDER_ID);
                echo "<script>location='order_manage.php';</script>";
            }
            ?>
            <!------------------------------------------------------------- order_pays 1----------------->
            <div id="artical" class="container">
                <?php
                if ($_GET['step'] == 1) {
                    $sql = "select * from member where member_id=$member_id_session";
                    $select = mysql_query($sql);
                    $member_order = mysql_fetch_array($select);
                    ?>
                    <div class="inner_border" style="margin-top: 5px;">
                        <h3 class="topic bg_img">
                            ซื้อสินค้าเครื่องดนตรี STEP 1
                        </h3>
                        <div class="inner">
                            <form method="post" id="member_order_pays" class="inner-w border-inner" action="order_pays.php?step=2">
                                <div class="black_title">
                                    ตรวจสอบข้อมูลผู้สั่งซื้อสินค้าเพื่อส่งสินค้า
                                </div>
                                <p>
                                    <span>ชื่อ-สกุล : <span>name-lastname</span></span>
                                    <span>
                                        <input type="text" class="text" value="<?= $member_order['member_name'] ?>" name="member_name">
                                    </span>
                                </p>
                                <p>
                                    <span>ที่อยู่ : <span>address</span></span>
                                    <span>
                                        <textarea class="text" name="member_address"><?= $member_order['member_address'] ?></textarea>
                                    </span>
                                </p>
                                <p>
                                    <span>เบอร์โทร : <span>telephone</span></span>
                                    <span>
                                        <input type="text" class="text" value="<?= $member_order['member_tel'] ?>" name="member_tel">
                                    </span>
                                </p>
                                <p>
                                    <span>อีเมล์ : <span>e-mail</span></span>
                                    <span>
                                        <input type="text" class="text" value="<?= $member_order['member_email'] ?>" name="member_email">
                                    </span>
                                </p>
                                <p>
                                    <span>หมายเลขประจำตัวประชาชน : <span>identification number</span></span>
                                    <span>
                                        <input type="text" class="text" value="<?= $member_order['member_identification'] ?>" name="member_identification">
                                    </span>
                                </p>
                                <p class="bt_orderStep1">
                                    <span></span>
                                    <span>
                                        <input type="submit" class="bt-beforeshop" value="ตกลง" 
                                               onclick="return update_member_to_pays(<?= $_SESSION["member_id_session"] ?>, '#member_order_pays')">
                                        <input type="button" class="bt-beforeshop" value="ยกเลิก" onclick="location = '<?= $_SERVER['PHP_SELF'] ?>?no_pays'">
                                    </span>
                                </p>
                                <div class="warning-inline"></div>
                                <div class="black_title" style="margin: 0;">&nbsp;</div>
                            </form>
                        </div>
                    </div>
                    <!------------------------------------------------------------- order_pays 2----------------->
                <?php } elseif ($_GET['step'] == 2) { ?>
                    <?php
                    /* ------------------------Add order Detail------------------------------ */
                    for ($index2 = 0; $index2 < count($orderDetail_array); $index2++) {
                        $order_id = $orderDetail_array[$index2]['order_id'];
                        $order_product_id = $orderDetail_array[$index2]['order_product_id'];
                        $unit_price = $orderDetail_array[$index2]['unit_price'];
                        $sub_priceall = $orderDetail_array[$index2]['sub_priceall'];

                        $seletc_product_unit = mysql_query("select product_unit from product where product_id=$order_product_id");
                        list($product_unit) = mysql_fetch_row($seletc_product_unit);
                        $new_product_unit = $product_unit - $unit_price;
                        $query_orderDetail = "REPLACE INTO order_detail(order_id,product_id,unit_price) "
                                . "VALUES($order_id,$order_product_id,$unit_price)";
                        $query_updateUnitProduct = "UPDATE product SET product_unit=$new_product_unit WHERE product_id=$order_product_id";

                        mysql_query($query_orderDetail) or die("เพิ่มการสั่งซื้อสินค้ารหัส P$order_product_id ไม่ได้ :<br />" . mysql_error());
                        mysql_query($query_updateUnitProduct) or die(mysql_error());
                    }
                    /* ------------------------------------------------------------- */
                    ?>
                    <div class="inner_border" style="margin-top: 5px;">
                        <h3 class="topic bg_img">
                            ซื้อสินค้าเครื่องดนตรี STEP 2
                        </h3>
                        <div class="inner">
                            <form class="inner-w border-inner" action="order_pays.php?" method="GET"
                                  id="order_pays" onsubmit="return order_pays_step2(this,<?= $order_id ?>)">
                                <div class="black_title">
                                    เลือกประเภท การชำระเงิน
                                </div>
                                <div class="inner">
                                    <p>
                                        <input type="hidden" name="step" value="3">
                                        <!--<label><input type="radio" value="1" name="order_pays" checked=""> ชำระผ่าน PAYSBUY</label> -->
                                        <label><input type="radio" value="2" name="order_pays"> โอนเงินเข้าบัญชีธนาคาร</label>     
                                        <label><input type="radio" value="3" name="order_pays"> ส่งพัสดุเก็บเงินปลายทาง</label>  
                                        <label><input type="radio" value="5" name="order_pays"> ชำระเงินและรับสินค้าที่ร้าน</label>  
                                        <label><input type="radio" value="4" name="order_pays"> ชำระผ่าน paypal</label>   
                                    </p>
                                    <p style="margin-top: 5px;">
                                        <span class="bt_orderStep1">
                                            <button type="submit" class="bt-beforeshop bt-step2">ตกลง</button>
                                        </span>
                                    </p>
                                </div>
                                <div class="warning-inline errorstep2"></div>
                                <div class="black_title" style="margin: 0;margin-top: 10px;">
                                    &nbsp;
                                </div>
                            </form>
                        </div>
                    </div>
                    <!------------------------------------------------------------- order_pays 3----------------->
                <?php } elseif (($_GET['step'] == 3 && $_GET['order_pays'] == 2) || ($_GET['step'] == 3 && $_GET['order_pays'] == 3)) { ?>
                    <?php clear_order(); ?>
                    <div class="inner_border" style="margin-top: 5px;">
                        <h3 class="topic bg_img">
                            ซื้อสินค้าเครื่องดนตรี STEP 3
                        </h3>
                        <div class="inner">
                            <div class="inner-w border-inner">
                                <div class="black_title">ชำระเงินผ่านการโอนเงินหรือเก็บเงินปลายทาง</div>
                                <div id="show_order_paper">
                                    <div class="inner-w border-inner">
                                        <?php require './order_pays_tables.php'; ?>
                                    </div>
                                    <?php if ($_GET['order_pays'] == 2) { ?>
                                        <div class="inner-w border-inner" style="margin: 7px 0;text-align: center;">
                                            <p class="title">
                                                <b>คุณสามารถโอนเงินได้ที่บัญชีด้านล่างนี้</b>
                                            </p>
                                            <img src="images/bank_pays.jpg" style="display: block;margin: 7px auto;width: 50%;border: solid 1px #000;"/>
                                        </div>
                                    <?php } ?>
                                    <div class="inner download_order" style="text-align: center;margin-top: 10px;">
                                        <a href="script_create/create_order/order_pdf.php?ORDER=<?= ORDER_ID ?>&MEMBER=<?= $member_id ?>"
                                           class="download_pdf" target="_blank">
                                            ดาวน์โหลดรายการสั่งซื้อนี้ 
                                        </a>
                                        <button class="bt-beforeshop" onclick="location = 'index.php'" style="margin-left: 5px;">
                                            ไปที่หน้าแรก 
                                        </button>
                                    </div>
                                </div>
                                <div class="black_title" style="margin: 0;margin-top: 10px;">
                                    &nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } elseif (($_GET['step'] == 3 && $_GET['order_pays'] == 5)) { ?>
                    <?php clear_order(); ?>
                    <div class="inner_border" style="margin-top: 5px;">
                        <h3 class="topic bg_img">
                            ซื้อสินค้าเครื่องดนตรี STEP 3
                        </h3>
                        <div class="inner">
                            <div class="inner-w border-inner">
                                <div class="black_title">ชำระเงินและรับสินค้าที่ <?= $WEB_THAI_NAME ?></div>
                                <div id="show_order_paper">
                                    <div class="inner-w border-inner">
                                        <?php require './order_pays_tables.php'; ?>
                                    </div>
                                    <div class="inner download_order" style="text-align: center;margin-top: 10px;">
                                        <a href="script_create/create_order/order_pdf.php?ORDER=<?= ORDER_ID ?>&MEMBER=<?= $member_id ?>"
                                           class="download_pdf" target="_blank">
                                            ดาวน์โหลดรายการสั่งซื้อนี้ 
                                        </a>
                                        <button class="bt-beforeshop" onclick="location = 'index.php'" style="margin-left: 5px;">
                                            ไปที่หน้าแรก 
                                        </button>
                                    </div>
                                </div>
                                <div class="black_title" style="margin: 0;margin-top: 10px;">
                                    &nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <!------------------------------------------Paysbuy
                    <?php //} elseif ($_GET['step'] == 3 && $_GET['order_pays'] == 1) { ?>
                    <?php //clear_order(); ?>
                    <div class="inner_border" style="margin-top: 5px;">
                        <h3 class="topic bg_img">
                            ซื้อสินค้าเครื่องดนตรี STEP 3
                        </h3>
                        <div class="inner">
                            <div class="inner-w border-inner">
                                <div class="black_title">ชำระเงินผ่าน Paysbuy</div>
                                <div id="show_order_paper" style="display: none;">
                                    <div class="inner-w border-inner">
                    <?php //require './order_pays_tables.php'; ?>
                                    </div>
                                </div>
                                <div style="text-align: center;">
                                    <div class="warning" style="width: 80%;margin: 10px auto;">
                                        คลิ๊กปุ่มด้านล่างเพื่อชำระเงินผ่าน Paysbuy
                                    </div>
                    <!----------------------------------- PAYSBUY --------------------
                    <Form method="post" action="https://www.paysbuy.com/paynow.aspx?lang=t"> 
                        <input type="Hidden" Name="psb" value="psb"/> 
                        <input Type="Hidden" Name="biz" value="wanchaloem.laokeut@googlemail.com"/>
                        <input Type="Hidden" Name="inv" value="<?= ORDER_ID ?>"/> 
                        <input Type="Hidden" Name="itm" value="<?= $WEB_THAI_NAME ?> [Order-<?= ORDER_ID ?>]"/> 
                        <input Type="Hidden" Name="amt" value="<?= $sumPriceALL_Tax ?>"/>
                        <Input Type="Hidden" Name="reqURL" value="http://localhost/Website_selling_musical_intrusment_PROJECT/reqURL.php">
                        <Input Type="Hidden" Name="postURL" value="http://localhost/Website_selling_musical_intrusment_PROJECT/postURL.php">
                        <input type="image" src="https://www.paysbuy.com/imgs/L_click2buy.gif" border="0" 
                               name="submit" alt="Make it easier,PaySbuy - it's fast,free and secure!"/> 
                    </Form>
                    <!---------------------------------------------------------
                    </div>
                    <div class="black_title" style="margin: 0;margin-top: 10px;">
                        &nbsp;
                    </div>
                </div>
            </div>
        </div>
                    -->
                <?php } elseif ($_GET['step'] == 3 && $_GET['order_pays'] == 4) { ?>
                    <?php clear_order(); ?>
                    <div class="inner_border" style="margin-top: 5px;">
                        <h3 class="topic bg_img">
                            ซื้อสินค้าเครื่องดนตรี STEP 3
                        </h3>
                        <div class="inner">
                            <div class="inner-w border-inner">
                                <div class="black_title">ชำระเงินผ่าน Paypal</div>
                                <div id="show_order_paper" style="display: none;">
                                    <div class="inner-w border-inner">
                                        <?php require './order_pays_tables.php'; ?>
                                    </div>
                                </div>
                                <div style="text-align: center;">
                                    <div class="warning" style="width: 80%;margin: 10px auto;">
                                        คลิ๊กปุ่มด้านล่างเพื่อชำระเงินผ่าน Paypal
                                    </div>
                                    <!----------------------------------- PAYPAL ------------------------------------------->
                                    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                        <input type="hidden" name="cmd" value="_ext-enter"> 
                                        <input type="hidden" name="redirect_cmd" value="_xclick"> 
                                        <input type="hidden" name="business" value="ttvone-facilitator@hotmail.com">
                                        <input type="hidden" name="currency_code" value="THB"> 
                                        <input type="hidden" name="item_name" value="<?= $WEB_ENG_NAME ?> [OrderNumber:<?= ORDER_ID ?>]"> 
                                        <input type="hidden" name="upload" value="<?= $unit_ALL ?>"> 
                                        <input type="hidden" name="amount" value="<?= number_format($sumPriceALL_Tax, 2) ?>"> 
                                        <input type="hidden" name="invoice" value="Order Number - <?= ORDER_ID ?>">
                                        <input type="hidden" name="return" value="http://localhost/Website_selling_musical_intrusment_PROJECT/order_pays.php?status=1"> 
                                        <input type="hidden" name="cancel_return" value="http://localhost/Website_selling_musical_intrusment_PROJECT/order_pays.php?status=2"> 
                                        <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                                        <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
                                    </form>
                                    <!----------------------------------------------------------------------------------->
                                </div>
                                <div class="black_title" style="margin: 0;margin-top: 10px;">
                                    &nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <!------------------------------------------------------------- order_pays 4----------------->
                <?php } elseif ($_GET['step'] == 4) { ?>
                    <div class="inner_border" style="margin-top: 5px;">
                        <h3 class="topic bg_img">
                            ซื้อสินค้าเครื่องดนตรี STEP 4
                        </h3>
                        <div class="inner">
                            <div class="inner-w border-inner">
                                <div class="black_title">ชำระเงินผ่านการโอนเงินหรือเก็บเงินปลายทาง</div>
                                <div id="show_order_paper">
                                    <div class="inner-w border-inner">
                                        <?php require './order_pays_tables.php'; ?>
                                    </div>
                                    <div class="inner download_order" style="text-align: center;margin-top: 10px;">
                                        <a href="script_create/create_order/order_pdf.php?ORDER=<?= ORDER_ID ?>&MEMBER=<?= $member_id ?>" 
                                           class="download_pdf" target="_blank">
                                            ดาวน์โหลดรายการสั่งซื้อนี้ 
                                        </a>
                                        <button class="bt-beforeshop" onclick="location = 'index.php'" style="margin-left: 5px;">
                                            ไปที่หน้าแรก 
                                        </button>
                                    </div>
                                </div>
                                <div class="black_title" style="margin: 0;margin-top: 10px;">
                                    &nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php require './footer.php'; ?>
        <script type="text/javascript" src="script_connectServer.js"></script>
        <script type="text/javascript" src="script_before_shop.js"></script>
    </body>
</html>
<?php
if (isset($_GET['status'])) {
    if ($_GET['status'] == 1) {
        $update_orderDetail = "UPDATE order_music SET order_status=3,order_date=NOW() WHERE order_id=" . ORDER_ID;
        mysql_query($update_orderDetail);
    } elseif ($_GET['status'] == 2) {
        $update_orderDetail = "UPDATE order_music SET order_status=4,order_date=NOW() WHERE order_id=" . ORDER_ID;
        mysql_query($update_orderDetail);
    }
    echo "<script>location='http://localhost/Website_selling_musical_intrusment_PROJECT/order_pays.php?step=4'</script>";
}

function clear_order() {
    unset($_SESSION['count']);
    unset($_SESSION['session_add_product']);
    unset($_SESSION['session_unit_product']);
}
?>