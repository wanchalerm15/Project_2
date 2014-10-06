<div id="artical" class="main_aftershop top_main bottom_main">
    <h3 class="topic">
        <img class="add">
        จัดการสินค้าเครื่องดนตรี
    </h3>
    <div class="in_main">
        <?php
        require './web_server_script/php_function.php';
        $end_row = $WEB_AFTERSHOP_NUMROW;
        $mysql_numrow = mysql_num_rows(mysql_query("SELECT * FROM order_music"));
        $numrow = ceil($mysql_numrow / $end_row);
        if (isset($_GET['row'])) {
            if ($_GET['row'] > $numrow) {
                echo "<script>location='?manage=order&row=$numrow#top';</script>";
            }
            $num_page = $_GET['row'];
            $start_row = ($_GET['row'] - 1) * $end_row;
        } else {
            $r = 1;
            $num_page = 1;
            $start_row = 0;
        }
        if (isset($_POST['search_order'])) {
            $search_order = $_POST['search_order'];
            $query = "SELECT * FROM order_music where order_status=$search_order ORDER BY order_id DESC";
            ?>
            <p class="warning" id="top">
                ผลการค้นหารายการสั่งซื้อสินค้าเครื่องดนตรีจากสถานะ  "<?= order_status($search_order) ?>" 
                พบ <?= mysql_num_rows(mysql_query($query)) ?> รายการ
            </p>
            <?php
        } else {
            $query = "SELECT * FROM order_music ORDER BY order_id DESC LIMIT $start_row,$end_row";
            ?>
            <p class="warning" id="top">
                มีรายการสั่งซื้อสินค้าเครื่องดนตรีภายในระบบทั้งหมด  <?= $mysql_numrow ?> รายการ
                มีหน้าที่แสดงรายการสั่งซื้อสินค้าเครื่องดนตรีทั้งหมด <?= $numrow ?> หน้า
            </p>
            <?php
        }
        $result = mysql_query($query);
        ?>
        <p class="title">
            <img class="add">
            รายการสินค้าเครื่องดนตรี
        </p>
        <div style="display: none;" id="show_edit_product">

        </div>
        <table class="table_aftershop" id="show_table_category">
            <tr>
                <td>#รหัสสั่งซื้อ</td>
                <td>#สถานะ</td>
                <td>#ผู้สั่งซื้อ</td>
                <td class="show_date">#การชำระเงิน</td>
                <td class="show_date">#วันที่สั่งซื้อ</td>
                <td>#ลบ</td>
            </tr>
            <?php if (mysql_num_rows(mysql_query("SELECT * FROM order_music")) <= 0) { ?>
                <tr>
                    <td colspan="7" style="text-align: left;">ไม่มีรายการในระบบ</td>
                </tr>
            <?php } elseif (mysql_num_rows($result) <= 0) { ?>
                <tr>
                    <td colspan="7" style="text-align: left;">ไม่มีรายการในระบบ</td>
                </tr>
                <?php
            } else {
                while ($order = mysql_fetch_array($result)) {
                    ?>
                    <?php $order_id = "ORDER : " . $order['order_id']; ?>
                    <tr class="order_id_<?= $order['order_id'] ?>">
                        <td>
                            <a class="link" href="show_order.php?ORDER=<?= $order['order_id'] ?>" title="ดูข้อมูลการสั่งซื้อ">
                                <?= $order_id ?>
                            </a>
                        </td>
                        <td>
                            <a class="link" title="แก้ไขสถานะ" 
                               onclick="receive_order(<?= $order['order_id'] ?>,<?= $_SESSION['employee_id_session'] ?>,<?= $order['order_status'] ?>)">
                                   <?= order_status($order['order_status']) ?>
                            </a>
                            <?php
                            $sql = "select employee.employee_id,employee_name,receive_date,receive_status from "
                                    . "employee,receive_order where receive_order.employee_id=employee.employee_id and "
                                    . "receive_order.order_id=" . $order['order_id'];
                            $query_receive_order = mysql_query($sql);
                            list($employee_id, $employee_name, $receive_date, $receive_status) = mysql_fetch_row($query_receive_order);
                            ?>
                            <?php if (!empty($employee_name)) { ?>
                                <p class="disable" style="font-size: 12px;">
                                    รับ ORDER : 
                                    <a style="color: #a0a0a0;" onclick="show_employee_receive_order(<?= $employee_id ?>, '<?= $receive_date ?>',<?= $receive_status ?>,<?= $order['order_id'] ?>)">
                                        <?= $employee_name ?>
                                    </a><br />
                                    สถานะ : <?= order_status($receive_status) ?>
                                </p>
                            <?php } ?>
                        </td>
                        <td>
                            <?php
                            $member = mysql_query("select member_name from member where member_id=" . $order['member_id']);
                            list($member_name) = mysql_fetch_array($member);
                            ?>
                            <a class="link" onclick="show_member_receive_order(<?= $order['member_id'] ?>);"><?= $member_name ?></a>
                        </td>
                        <td class="show_date"><?= checkPayment($order['order_pays']) ?></td>
                        <td class="show_date"><?= $order['order_date'] ?></td>
                        <td>
                            <input type="checkbox" class="delete_check" value="<?= $order['order_id'] ?>">
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
        <p class="delete_data">
            <button class="button" id="checkAll_data">เลือกทั้งหมด</button>
            <button class="button" id="delete_data">ลบที่เลือก</button>
        </p> 
        <script>
            $(document).ready(function () {
                $("#delete_data").click(function () {
                    var data = " [ ";
                    $(":checkbox.delete_check:checked").each(function (index) {
                        if (($(":checkbox.delete_check:checked").length - 1) == index) {
                            data += "ORDER : " + $(this).val();
                        } else {
                            data += "ORDER : " + $(this).val() + ", ";
                        }
                    });
                    data += " ] ";

                    if (confirm("คุณต้องการลบรายการที่" + data + "นี้จริงหรือ !")) {
                        delete_order_arrlay();
                    }
                });
            });</script>
        <?php if (!isset($_POST['search_order'])) { ?>
            <div class="part_row">
                <a href="?manage=order&row=<?= $_GET['row'] - ($r + 1) ?>#top" class="past">ก่อนหน้า</a>
                <span>
                    |
                    <select onchange="change_row_Aftershop(this, 'order')" class="select">
                        <?php
                        for ($i = 1; $i <= $numrow; $i++) {
                            if ($i == $_GET['row']) {
                                echo "<option value='$i' selected=''>$i</option>";
                            } else {
                                echo "<option value='$i'>$i</option>";
                            }
                        }
                        ?>
                    </select>
                    |
                </span>
                <a href="?manage=order&row=<?= $_GET['row'] + ($r + 1) ?>#top" class="past">ถัดไป</a>
            </div>
        <?php } ?>
        <?php
        echo "<script>";
        echo "$(document).ready(function() {";
        if (isset($_GET['row'])) {
            if ($_GET['row'] == 1) {
                echo " $('div.part_row a:first-child').removeClass('past').addClass('disable').removeAttr('href');";
            } elseif ($_GET['row'] == $numrow) {
                echo " $('div.part_row a:last-child').removeClass('past').addClass('disable').removeAttr('href');";
            }
        } else {
            echo " $('div.part_row a:first-child').removeClass('past').addClass('disable').removeAttr('href');";
            if ($numrow <= 1) {
                echo " $('div.part_row a:last-child').removeClass('past').addClass('disable').removeAttr('href');";
            }
        }
        echo "});";
        echo "</script>";
        ?>
    </div>
</div>

