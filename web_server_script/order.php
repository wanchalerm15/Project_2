<?php
session_start();
include './connect_DB.php';
require './php_function.php';
/* ----------------------------------------------------------------- Add Cast Product --------------- */
if ($_REQUEST['add_product'] != 0) {
    if (!$_SESSION['session_add_product']) {
        $_SESSION['count'] = 0;
        $_SESSION['session_add_product'][$_SESSION['count']] = $_REQUEST['add_product'];
        $_SESSION['order_cost'][$_SESSION['count']] = $_REQUEST['cost'];
        $_SESSION['session_unit_product'][$_SESSION['count']] = 1;
        $data['data'] = count($_SESSION['session_add_product']);
    } else {
        if (in_array($_REQUEST['add_product'], $_SESSION['session_add_product'])) {
            $data['error'] = 1;
        } else {
            $_SESSION['count'] = $_SESSION['count'] + 1;
            $_SESSION['session_add_product'][$_SESSION['count']] = $_REQUEST['add_product'];
            $_SESSION['order_cost'][$_SESSION['count']] = $_REQUEST['cost'];
            $_SESSION['session_unit_product'][$_SESSION['count']] = 1;
            $data['data'] = count($_SESSION['session_add_product']);
        }
    }
    echo json_encode($data);
}
if ($_REQUEST['remove_Order'] == 1) {
    $index_unit = $_REQUEST['index_unit'];
    unset($_SESSION['session_unit_product'][$index_unit]);
    unset($_SESSION['session_add_product'][$index_unit]);
    unset($_SESSION['order_cost'][$index_unit]);
}
if (isset($_GET['clear_session'])) {
    unset($_SESSION['count']);
    unset($_SESSION['session_add_product']);
    unset($_SESSION['session_unit_product']);
    unset($_SESSION['order_cost']);
}
if ($_REQUEST['update_orderUnit'] == 1) {
    $data_orderUpdate = $_REQUEST['data_orderUpdate'];
    $data_indexUpdate = $_REQUEST['data_indexUpdate'];
    $product_id = $_REQUEST['product_id'];
    $result = mysql_query("select * from product where product_id=$product_id and product_unit >= $data_orderUpdate");
    $search = mysql_num_rows($result);
    if ($search != 0) {
        if ($data_orderUpdate <= 0) {
            $_SESSION['session_unit_product'][$data_indexUpdate] = 1;
        } else {
            $_SESSION['session_unit_product'][$data_indexUpdate] = $data_orderUpdate;
        }
    } else {
        exit("! สินค้าชิ้นนี้ มีจำนวนไม่ถึงที่คุณระบุ");
    }
}
if ($_REQUEST['add_order'] == 1) {
    $query_product = "select * from product";
    $result_product = mysql_query($query_product);
    $order_array = array(
        'order_member_id' => $_REQUEST['member_id'],
        'order_priceall' => $_REQUEST['price_all'],
        'order_tax' => $_REQUEST['tax'],
        'order_order_cost' => $_REQUEST['order_cost']
    );
    if (empty($order_array['order_priceall'])) {
        exit("ยังไม่มีสินค้าในตระกร้า กรุณาสั่งซื้อสินค้าก่อน");
    }
    $query_order_music = "INSERT INTO order_music(member_id,order_priceall,order_tax,order_cost,order_status,order_date) "
            . "VALUES(" . $order_array['order_member_id'] . "," . $order_array['order_priceall'] . ","
            . $order_array['order_tax'] . "," . $order_array['order_order_cost'] . ",0,NOW())";
    mysql_query($query_order_music) or die("เพิ่มรายการสั่งซื้อล้มเหลว เนื่องจาก :" . mysql_error());
}
if ($_REQUEST['update_member_to_pays'] == 1) {
    $member_id = $_REQUEST['member_id'];
    $member_name = $_REQUEST['member_name'];
    $member_address = trim($_REQUEST['member_address']);
    $member_tel = $_REQUEST['member_tel'];
    $member_email = $_REQUEST['member_email'];
    $member_identification = $_REQUEST['member_identification'];
    $queryUpdateMember = "UPDATE member SET member_name='$member_name',input_date=NOW(),"
            . "member_address='$member_address',member_tel='$member_tel',member_email='$member_email',"
            . "member_identification='$member_identification' WHERE member_id=" . $member_id;
    mysql_query($queryUpdateMember) or die("ข้อมูลผู้ซื้อสินค้าผิดพลาด ! :<br />" . mysql_error());
}
if ($_REQUEST['order_pays_step2'] == 1) {
    $order_pays = $_REQUEST['order_pays'];
    $order_id = $_REQUEST['order_id'];
    $query = "UPDATE order_music SET order_pays=$order_pays,order_date=NOW() "
            . "WHERE order_id=" . $order_id;
    mysql_query($query) or die("เพิ่มข้อมูลการชำระเงินผิดพลาด ! :<br />" . mysql_error());
}
if ($_REQUEST['delete_order_arrlay'] == 1) {
    $delete_array = $_REQUEST['delete_array'];
    if (!count($delete_array)) {
        exit("กรุณาเลือกรายการที่จะลบ!");
    }
    $error = "";
    foreach ($delete_array as $array) {
        $query = "DELETE FROM order_music WHERE order_id=$array";
        if (!mysql_query($query)) {
            $error .= "รหัส C$array ไม่สามารถลบได้เนื่องจาก : " . mysql_error() . "<br />";
        }
    }
    if (trim($error) != "") {
        echo "$error";
    }
}
if ($_REQUEST['receive_order'] == 1) {
    $order_id = $_REQUEST['order_id'];
    $member_id = $_REQUEST['member_id'];
    $order_status = $_REQUEST['order_status'];
    $result_receive_order = mysql_query("select * from receive_order where order_id=$order_id");
    $receive_order = mysql_fetch_array($result_receive_order);
    $receive_status = $receive_order['receive_status'];
    ?>
    <h3 class="topic">
        รับรายการสั่งซื้อสินค้า
    </h3>
    <div class="inner">
        <form id="receive_order_employee">
            <div class="inner-w border-inner">
                <p class="warning" id="receive_order_employee_error">
                    แจ้งสถานะการรับรายการสั่งซื้อของลูกค้าสมาชิกเพื่อให้สามารถติดตามได้
                </p>
                <select style="padding: 5px 0;width: 95%;" name="status_update" id="status_update">
                    <?php for ($index = 0; $index < count($ORDER_status); $index++) { ?>
                        <?php
                        if ($index == 0 || $index == 7) {
                            continue;
                        }
                        ?>
                        <?php if ($receive_status == $index) { ?>
                            <option selected="" value="<?= $index ?>"><?= $ORDER_status[$index] ?></option>
                        <?php } else { ?>
                            <option value="<?= $index ?>"><?= $ORDER_status[$index] ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <p class="sent_product">
                    <span>
                        กรุณากรอกหมายเลขพัสดุที่ส่งไปจากใบเสร็จ 13 หลัก
                    </span>
                    <input type="text" class="text" name="transport_id" placeholder=" กรุณากรอกหมายเลขพัสดุ 13 หลัก" maxlength="13" 
                           value="<?= $receive_order['transport_id'] ?>">
                </p>
                <p class="error_order">
                    <span>
                        ชี้แจงข้อขัดข้อง ของการสั่งซื้อสินค้า
                    </span>
                    <input type="text" class="text" name="warning" placeholder=" กรุณาชี้แจงข้อขัดข้อง" value="<?= $receive_order['warning'] ?>">
                </p>
                <input type="hidden" name="order_id" value="<?= $order_id ?>">
                <input type="hidden" name="employee_id" value="<?= $member_id ?>">
                <br /><br />
            </div>
            <div class="inner-w border-inner" style="margin-top: 5px;">
                <p style="margin-top: 7px;">
                    <?php if (empty($employee_id_session)) { ?>
                        <button class="bt_black" type="submit" disabled="">ยืนยันการรับ Order</button>
                    <?php } else { ?>
                        <button class="bt_black" type="submit">ยืนยันการรับ Order</button>
                    <?php } ?>
                    <button class="bt_black" type="button" onclick="$('#dialog').fadeOut()">ปิดหน้านี้</button>
                </p>
            </div>
        </form>
    </div>
    <script>
        $(function () {
            $("#receive_order_employee").submit(function () {
                receive_order_employee(this);
                return false;
            });
            $("#status_update").change(function () {
                if ($(this).val() == 2) {
                    $(".sent_product").show();
                    $(".error_order").hide();
                } else if ($(this).val() == 6) {
                    $(".error_order").show();
                    $(".sent_product").hide();
                } else {
                    $(".sent_product").hide();
                    $(".error_order").hide();
                }
            });
        });</script>
    <?php
}
if ($_REQUEST['receive_order_employee'] == 1) {
    $order_id = $_REQUEST['order_id'];
    $employee_id = $_REQUEST['employee_id'];
    $status_update = $_REQUEST['status_update'];
    $query_receive_order = "REPLACE INTO receive_order(order_id,employee_id,receive_status,receive_date) VALUES($order_id,$employee_id,$status_update,NOW())";
    $update_roder_status = ($status_update == 4) ? $status_update : 7;
    
    mysql_query("UPDATE order_music SET order_status=$update_roder_status WHERE order_id=$order_id") or die('ERROR order_music ! : ' . mysql_error());
    mysql_query($query_receive_order) or die('ERROR receive_order ! : ' . mysql_error());
    if (!empty($_REQUEST['warning'])) {
        $warning = $_REQUEST['warning'];
        mysql_query("UPDATE receive_order SET warning='$warning' WHERE order_id=$order_id AND employee_id=$employee_id")or die('ERROR warning of receive_order ! : ' . mysql_error());
    }
    if (!empty($_REQUEST['transport_id'])) {
        $transport_id = $_REQUEST['transport_id'];
        mysql_query("UPDATE receive_order SET transport_id='$transport_id' WHERE order_id=$order_id AND employee_id=$employee_id")or die('ERROR transport_id of receive_order ! : ' . mysql_error());
    }
}

if ($_REQUEST['show_employee_receive_order'] == 1) {
    $employee_id = $_REQUEST['employee_id'];
    $order_id = $_REQUEST['order_id'];
    $receive_date = $_REQUEST['receive_date'];
    $status = $_REQUEST['status'];
    $result_employee = mysql_query("select * from employee where employee_id=$employee_id");
    $result_receive_order = mysql_query("select * from receive_order where employee_id=$employee_id and order_id=$order_id");
    $employee = mysql_fetch_array($result_employee);
    $receive_order = mysql_fetch_array($result_receive_order);
    ?>
    <h3 class="topic">
        รายละเอียดข้อมูลรับรายการสั่งซื้อสินค้า
    </h3>
    <div class="inner">
        <div class="inner-w border-inner">
            <div class="black_title" style="margin: 0px 0;">
                สถานะการรับ Order
            </div>
            <p style="color: #A00;" class="inner">
                <?php
                if ($status == 6) {
                    echo order_status($status);
                    echo "<p class='warning-error'><b>ข้อขัดข้อง : </b>" . $receive_order['warning'] . "</p>";
                } elseif ($status == 2) {
                    echo order_status($status);
                    echo "<p class='warning-ok'><b>รหัสส่งสินค้า 13 หลัก : </b><b class='red'>" . $receive_order['transport_id'] . "</b><br />";
                    echo "ท่านสามารถนำรหัสส่งสินค้า 13 หลักไปตรวจสอบว่าสินค้าได้จัดส่งถึงไหนแล้วได้ที่เว็บไซด์ : ";
                    echo "<a href='http://track.thailandpost.co.th/tracking/default.aspx' target='_blank' class='link'>track.thailandpost.co.th</a>";
                    echo "</p>";
                } else {
                    echo order_status($status);
                }
                ?>
            </p>
        </div>
        <div class="inner-w border-inner" style="margin-top: 5px;">
            <div class="black_title" style="margin: 0px 0;">
                ข้อมูลพนักงานผู้รับ Order
            </div>
            <div class="inner " id="show_employee_receive_order">
                <?php if ($_SESSION['employee_id_session'] || $_SESSION['admin_id_session']) { ?>
                    <p>
                        <b>Username </b>: <?= $employee['employee_user'] ?>
                    </p>
                <?php } ?>
                <p>
                    <b>ชื่อผู้รับ Order </b>: <?= $employee['employee_name'] ?>
                </p>
                <p>
                    <b>เบอร์โทรผู้รับ Order </b>: <?= $employee['employee_tel'] ?>
                </p>
                <p>
                    <b>อีเมล์ผู้รับ Order </b>: <?= $employee['employee_email'] ?>
                </p>
            </div>
        </div>
        <div style="margin-top: 5px;text-align: right;">
            <p style="color: #b0b0b0;font-size: 14px;display: inline-block;" class="inner-w border-inner">
                วันที่รับ Order : <?= $receive_date ?>
            </p>
        </div>
        <div style="margin-top: 5px;">
            <p style="text-align: right;">
                <button class="bt_black" onclick="$('#dialog').fadeOut()">ปิดหน้านี้</button>
            </p>
        </div>
    </div>
    <?php
}
if ($_REQUEST['show_member_receive_order'] == 1) {
    $member_id = $_REQUEST['member_id'];
    $result = mysql_query("select * from member where member_id=$member_id");
    $member = mysql_fetch_array($result);
    ?>
    <h3 class="topic">
        รายละเอียดผู้ซื้อสินค้า
    </h3>
    <div class="inner">
        <div class="inner-w border-inner">
            <div class="inner " id="show_employee_receive_order">
                <p>
                    <b>Username </b>: <?= $member['member_user'] ?>
                </p>
                <p>
                    <b>ชื่อผู้สั่งซื้อสินค้า </b>: <?= $member['member_name'] ?>
                </p>
                <p>
                    <b>รหัสประจำตัวประชาชน </b>: <?= $member['member_identification'] ?>
                </p>
                <p>
                    <b>ที่อยู่ </b>: <?= $member['member_address'] ?>
                </p>
                <p>
                    <b>เบอร์โทร </b>: <?= $member['member_tel'] ?>
                </p>
                <p>
                    <b>อีเมล์ </b>: <?= $member['member_email'] ?>
                </p>
            </div>
        </div>
        <div class="inner-w border-inner" style="margin-top: 5px;">
            <p style="color: #b0b0b0;font-size: 14px;text-align: right;" class="inner">
                แก้ไขข้อมูลล่าสุดเมื่อ : <?= $member['input_date'] ?>
            </p>
        </div>
        <div style="margin-top: 5px;">
            <p style="text-align: right;">
                <button class="bt_black" onclick="$('#dialog').fadeOut()">ปิดหน้านี้</button>
            </p>
        </div>
    </div>
    <?php
}    