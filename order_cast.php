<?php session_start(); ?>
<?php
if (empty($member_id_session)) {
    exit('Pleare Login !');
}
require './web_server_script/php_function.php';
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
        <title>ตระกร้าสินค้า - เว็บไซด์ขายเครื่องดนตรีออนไลน์</title>
        <link rel="stylesheet" type="text/css" href="web_design_script/Website_selling_musical_intrusment_CSS.css">
        <link rel="stylesheet" type="text/css" href="web_design_script/SmartPhone_Design_Musical_intrusment.css">
        <script type="text/javascript" src="web_design_script/jquery.min.js"></script>
        <script>
            $(document).ready(function () {
                //alert($(window).width());
            });
        </script>
    </head>
    <body>
        <?php require './header.php'; ?>
        <div id="containur">
            <!------------------------------------------------------------- order_pays-------------------------------------------------------------/-->
            <div id="artical" class="container order_main">
                <?php if ($_GET['orderMenu'] == "history") { ?>
                    <div class="inner_border" style="margin-top: 4px;">
                        <h3 class="topic bg_img">
                            <img src="images/shopping_cast_icon.png">
                            ประวัติการสั่งซื้อสินค้าเครื่องดนตรี
                        </h3>
                        <?php
                        $query_ORDER = "select * from order_music where member_id=" . $_SESSION['member_id_session'] . " order by order_id desc";
                        $result_ORDER = mysql_query($query_ORDER);
                        ?>
                        <div class="inner">
                            <div class="inner-w border-inner">
                                <div class="warning">
                                    คุณมีประวัติการสั่งซื้อสินค้าเครื่องดนตรีทั้งหมด <?= mysql_num_rows($result_ORDER) ?>: รายการ
                                </div>
                                <table class="tabale_order" style="margin: 10px 0;">
                                    <tr>
                                        <td>รายการสั่งซื้อ</td>
                                        <td class="show_date">ราคาสุทธิ</td>
                                        <td>สถานะ</td>
                                        <td class="show_date">วันที่ซื้อ</td>
                                    </tr>
                                    <?php while ($order = mysql_fetch_array($result_ORDER)) { ?>
                                        <?php $sumPriceALL_Tax = $order['order_priceall'] + $order['order_tax'] + $order['order_cost'] ?>
                                        <tr>
                                            <td>
                                                <a href="show_order.php?ORDER=<?= $order['order_id'] ?>" class="link">
                                                    ORDER : <?= $order['order_id'] ?>
                                                </a>
                                            </td>
                                            <td class="show_date"><?= number_format($sumPriceALL_Tax, 2) ?> บาท</td>
                                            <td>
                                                <?php
                                                $result_ORDER2 = mysql_query("select * from receive_order where order_id=" . $order['order_id']);
                                                $receive_order = mysql_fetch_array($result_ORDER2);
                                                ?>

                                                <?php if (!empty($receive_order['employee_id'])) { ?>
                                                    <?php if ($receive_order["receive_status"] == 6) { ?>
                                                        <div style="background-color: rgba(140,100,0,.5);padding: 5px;border-radius: 5px;color: #FFF;">
                                                            <?= order_status($order['order_status']) ?> <br />
                                                            เกิดข้อขัดข้องอื่นๆ
                                                            <p>
                                                                <a class="FFF_link" style="font-size: 12px;"
                                                                   onclick="show_employee_receive_order(
                                                                   <?= $receive_order['employee_id'] ?>,
                                                                                                   '<?= $receive_order['receive_date'] ?>',
                                                                   <?= $receive_order['receive_status'] ?>,
                                                                   <?= $order['order_id'] ?>
                                                                                           )">
                                                                    พนักงานรับ ORDER เเล้ว
                                                                </a>
                                                            </p>
                                                        </div>
                                                    <?php } elseif ($receive_order["receive_status"] == 4) { ?>
                                                        <div style="background-color: rgba(180,0,0,.5);padding: 5px;border-radius: 5px;color: #FFF;">
                                                            <?= order_status($order['order_status']) ?> <br />
                                                            <p>
                                                                <a class="FFF_link" style="font-size: 12px;"
                                                                   onclick="show_employee_receive_order(
                                                                   <?= $receive_order['employee_id'] ?>,
                                                                                                   '<?= $receive_order['receive_date'] ?>',
                                                                   <?= $receive_order['receive_status'] ?>,
                                                                   <?= $order['order_id'] ?>
                                                                                           )">
                                                                    พนักงานรับ ORDER เเล้ว
                                                                </a>
                                                            </p>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div style="background-color: rgba(0,150,0,.5);padding: 5px;border-radius: 5px;color: #FFF;">
                                                            <?= order_status($order['order_status']) ?>
                                                            <p>
                                                                <a class="FFF_link" style="font-size: 12px;"
                                                                   onclick="show_employee_receive_order(
                                                                   <?= $receive_order['employee_id'] ?>,
                                                                                                   '<?= $receive_order['receive_date'] ?>',
                                                                   <?= $receive_order['receive_status'] ?>,
                                                                   <?= $order['order_id'] ?>
                                                                                           )">
                                                                    พนักงานรับ ORDER เเล้ว
                                                                </a>
                                                            </p>
                                                        </div>                                                       
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <?php if ($order['order_status'] == 4 || $receive_order["receive_status"] == 4) { ?>
                                                        <div style="background-color: rgba(180,0,0,.5);padding: 5px;border-radius: 5px;color: #FFF;">
                                                            <?= order_status($order['order_status']) ?>
                                                            <p>
                                                                <a style="font-size: 12px;color: #FFF;">                                                 
                                                                    ยังไม่มีพนักงานรับ Order
                                                                </a>
                                                            </p>
                                                        </div>  
                                                    <?php } else { ?>
                                                        <div style="background-color: rgba(0,120,150,.5);padding: 5px;border-radius: 5px;color: #FFF;">
                                                            <?= order_status($order['order_status']) ?>
                                                            <p>
                                                                <a style="font-size: 12px;color: #FFF;">                                                 
                                                                    ยังไม่มีพนักงานรับ Order
                                                                </a>
                                                            </p>
                                                        </div>  
                                                    <?php } ?>
                                                <?php } ?>
                                            </td>
                                            <td class="show_date"><?= $order['order_date'] ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td class="show_date"></td>
                                        <td></td>
                                        <td class="show_date"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="inner"></div>
                    </div>
                <?php } else { ?>
                    <div class="inner_border" style="margin-top: 4px;">
                        <h3 class="topic bg_img">
                            <img src="images/shopping_cast_icon.png">
                            สินค้าเครื่องดนตรีในตระกร้าสินค้า
                        </h3>
                        <div class="inner">
                            <div class="inner-w border-inner">
                                <table class="tabale_order">
                                    <tr>
                                        <td>สินค้าเครื่องดนตรี</td>
                                        <td class="show_date">ราคา</td>
                                        <td>จำนวน</td>
                                        <td>ค่าขนส่ง</td>
                                        <td></td>
                                    </tr>
                                    <?php
                                    if ($session_add_product != 0) {
                                        $sumPrice = 0;
                                        $sumUnit = 0;
                                        $sumPriceALL = 0;
                                        $query = "select * from product";
                                        $result = mysql_query($query);
                                        while ($row_product = mysql_fetch_array($result)) {
                                            for ($index = 0; $index <= $_SESSION['count']; $index++) {
                                                $img_pro = explode(',', $row_product['product_image']);
                                                if ($_SESSION['session_add_product'][$index] == $row_product['product_id']) {
                                                    if ($_SESSION["session_unit_product"][$index] >= 0) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <div class="show_imgproduct">
                                                                    <div class="order_text">
                                                                        <b><?= $row_product['product_name'] ?></b>
                                                                    </div>
                                                                    <div class="order_product">
                                                                        <?php
                                                                        $img_order_cast = (empty($img_pro[0])) ? "images/no_image.jpg" : "image_product/thumbnail/thumbnails_$img_pro[0]";
                                                                        ?>
                                                                        <div class="order_images"
                                                                             style="background-image: url(<?= $img_order_cast ?>);">
                                                                        </div>
                                                                    </div>
                                                                    <div class="order_text">
                                                                        <?php
                                                                        if ($_SESSION['session_unit_product'][$index] >= $row_product['product_unit']) {
                                                                            $_SESSION['session_unit_product'][$index] = $row_product['product_unit'];
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        $unit_ALL = $row_product['product_unit'] - $_SESSION['session_unit_product'][$index];
                                                                        if ($unit_ALL >= 0) {
                                                                            if (empty($row_product['product_unit'])) {
                                                                                echo "<span>สินค้าหมดแล้ว</span>";
                                                                            } else {
                                                                                echo "เหลือสินค้าอยู่ <span>$unit_ALL</span> ชิ้น";
                                                                            }
                                                                            ?>
                                                                        <?php } else { ?>
                                                                            <span>สินค้าหมดแล้ว</span>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="show_date">฿<?= number_format($row_product['product_price'], 2) ?> </td>
                                                            <?php
                                                            $sumUnit = $sumUnit + $_SESSION['session_unit_product'][$index];
                                                            $sumPriceALL = $sumPriceALL + ($row_product['product_price'] * $_SESSION['session_unit_product'][$index]);
                                                            ?>
                                                            <td>
                                                                <div class="edit_unitprice">
                                                                    <span id="UniitOrder-<?= $index ?>">
                                                                        <?= $_SESSION['session_unit_product'][$index] ?>
                                                                    </span>
                                                                    <input type="text" class="text" 
                                                                           value="<?= $_SESSION['session_unit_product'][$index] ?>" 
                                                                           id="text_UpdateOrder-<?= $index ?>">
                                                                </div>
                                                                <script>
                                                                    $(document).ready(function () {
                                                                        $("#text_UpdateOrder-<?= $index ?>").keyup(function (e) {
                                                                            if ($.isNumeric($(this).val())) {
                                                                                if (e.keyCode == 13) {
                                                                                    update_orderUnit(this, $('#text_UpdateOrder-<?= $index ?>').val(),<?= $index ?>,<?= $row_product['product_id'] ?>);
                                                                                }
                                                                            }
                                                                        });
                                                                    });
                                                                </script>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $cost = $_SESSION['order_cost'][$index] * $_SESSION['session_unit_product'][$index];
                                                                $product_cost = $product_cost + $cost;
                                                                ?>
                                                                ฿<?= $cost ?>
                                                            </td>
                                                            <td class="bt_updateOrder">
                                                                <input type="button" class="bt-beforeshop edit" value="แก้ไขจำนวน"
                                                                       onclick="update_orderUnit(this, $('#text_UpdateOrder-<?= $index ?>').val(),<?= $index ?>,<?= $row_product['product_id'] ?>)">
                                                                <input type="button" class="bt-beforeshop remov" value="นำสินค้าออก"
                                                                       onclick="remove_Order(<?= $index ?>)">
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' style='color:#FF0000'>ยังไม่มีสินค้าในตระกร้า</td></tr>";
                                    }
                                    ?>
                                    <tr>
                                        <?php
                                        $tax = ($sumPriceALL * $WEB_TAX) / 100;
                                        $PriceAll_Tax = $sumPriceALL + $tax;
                                        ?>
                                        <td>รวม</td>
                                        <td class="show_date"><?= number_format($sumPriceALL, 2) ?> บาท</td>
                                        <td><?= $sumUnit ?> ชิ้น</td>
                                        <td class="show_date"><?= number_format($product_cost, 2) ?> บาท</td>
                                        <td class="sum_priceAll">
                                            ฿<?= number_format($PriceAll_Tax, 3) ?><sup> +ภาษี <?= $WEB_TAX ?>%</sup>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="inner_arrtical margin_top" id="confirm_order">
                        <div class="inner-w border-inner">
                            <div style="float: left;" class="textconfirm">
                                <div class="confirm_order">
                                    <?php $PriceAll_Tax_cost = ($PriceAll_Tax + $product_cost) ?>
                                    ราคาที่ต้องชำระ รวมทั้งสิ้น <?= number_format($PriceAll_Tax_cost, 3) ?> บาท
                                    <p style="font-size: 14px;">
                                        [ ค่าขนส่งสินค้า <?= $product_cost ?> บาท ]
                                    </p>
                                    <p>
                                        [ ภาษีหัก ณ. ที่จ่าย <?= $WEB_TAX ?>% = <?= $tax ?> บาท ]
                                    </p>
                                </div>
                            </div>
                            <div style="float: right;" class="btconfirm">
                                <form method="post" action="order_pays.php?step=1" id="form_add_order">
                                    <input type="hidden" id="member_id_session" value="<?= $member_id_session ?>">
                                    <input type="hidden" id="sumPriceALL" value="<?= $sumPriceALL ?>">
                                    <input type="hidden" id="tax" value="<?= $tax ?>">
                                    <input type="hidden" id="order_cost" value="<?= $product_cost ?>" >
                                    <button class="bt_black Orback" type="button" onclick="location = 'index.php'"> กลับไปซื้อต่อ </button>
                                    <button class="bt_black OrClear" type="button"> ลบการสั่งซื้อทั้งหมด </button>
                                    <button class="bt_black" type="submit"> ยืนยันการสั่งซื้อ </button>
                                </form>
                                <div class="warning-inline"></div>
                            </div>
                            <script>
                                $("button.OrClear").click(function () {
                                    if (confirm('คุณต้องการลบสิ้นค้าที่ซื้อทั้งหมดทิ้งจริงหรือ !')) {
                                        clear_session();
                                    }
                                });
                                $('#form_add_order').submit(function () {
                                    if (confirm('คุณต้องการซื้อสินค้าในตระกร้านี้จริงหรือ !')) {
                                        add_order($('#member_id_session').val(), $('#sumPriceALL').val(), $('#tax').val(), $('#order_cost').val());
                                    }
                                    return false;
                                });
                            </script>
                            <div style="clear: both;"></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!-------------------------------------------------------------/order_pays-------------------------------------------------------------/-->
            <div id="artical" class="container order_sidebar">
                <div class="inner_arrtical bg_img">
                    <div class="inner_border inner">
                        <h3 class="topic" style="text-align: center;">
                            จัดการตระกร้าสินค้า
                        </h3>
                        <ul class="nav_order inner-w border-inner">
                            <li><a href="order_cast.php">สินค้าในตระกร้า</a></li>
                            <li><a href="<?= $_SERVER["PHP_SELF"] ?>?orderMenu=history">ประวัติการซื้อสินค้า</a></li>
                            <li><a href="javascript:location.reload()">รีโหลดหน้าเว็บใหม่</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-top: 30px;"></div>
        <script>
            $(document).ready(function () {
                if ($("#artical.container.order_main").height() < $(window).height()) {
                    $("#artical.container.order_sidebar").height($(window).height() - 140);
                }
            });
        </script>
        <?php require './footer.php'; ?>
        <script type="text/javascript" src="script_connectServer.js"></script>
        <script type="text/javascript" src="script_before_shop.js"></script>
    </body>
</html>

