<?php
session_start();
include './connect_DB.php';
if ($_REQUEST['delete_member_arrlay'] == 1) {
    $delete_array = $_REQUEST['delete_array'];
    if (!count($delete_array)) {
        exit("กรุณาเลือกรายการที่จะลบ!");
    }
    $error = "";
    foreach ($delete_array as $array) {
        $query = "DELETE FROM member WHERE member_id=$array";
        if (!mysql_query($query)) {
            $error .= "รหัส $array ไม่สามารถลบได้เนื่องจาก : " . mysql_error() . "<br />";
        }
    }
    if (trim($error) != "") {
        echo "$error";
    }
}

if ($_REQUEST['add_member'] == 1) {
    $member_name = $_REQUEST['member_name'];
    $member_user = $_REQUEST['member_user'];
    $member_pass = $_REQUEST['member_pass'];
    $member_identification = $_REQUEST['member_identification'];
    $member_address = $_REQUEST['member_address'];
    $member_tel = $_REQUEST['member_tel'];
    $member_email = $_REQUEST['member_email'];
    $query = "INSERT INTO member VALUES(0,'$member_user','$member_pass','$member_name','$member_identification','$member_address','$member_tel','$member_email',NOW())";
    mysql_query($query) or die("ไม่สามารถเพิ่มลูกค้าสมาชิกได้เนื่องจาก : " . mysql_error());
}

if ($_REQUEST['show_member_employee'] == 1) {
    $member_id = $_REQUEST['member_id'];
    $query = "SELECT * FROM member WHERE member_id=$member_id";
    $result = mysql_query($query);
    $member = mysql_fetch_array($result);
    ?>
    <h3 class="topic" style="text-align: left;">
        <img src="images/topic_icon.png">
        <span>รหัสสมาชิก M<?= $member['member_id'] ?></span>/<span style="font-size: 14px;"><?= $member['member_name'] ?></span>
    </h3>
    <div class="in_main">
        <div id="artical">
            <div class="warning" id="dialog_emp_error">
                แก้ไขข้อมูลลูกค้าสมาชิก ของคุณ <?= $member['member_name'] ?> รหัสลูกค้าสมาชิก M<?= $employee['member_id'] ?>
            </div>
            <form class="update_dialog_employee" method="POST" id="update_dialog_employee">
                <p> 
                    <span>รหัสลูกค้าสมาชิก</span>
                    <?php if ($admin_id_session) { ?>
                        <span>: <input type="text" class="text" value="<?= $member['member_id'] ?>" name="id_sub" id="id_sub"></span>
                    <?php } else { ?>
                        <span>: <input type="text" class="text" value="<?= $member['member_id'] ?>" disabled="" name="id_sub" id="id_sub"></span>
                    <?php } ?>
                    <input type="hidden" value="<?= $_REQUEST['start_row'] ?>" id="start_row">
                    <input type="hidden" value="<?= $_REQUEST['end_row'] ?>" id="end_row">
                    <input type="hidden" value="<?= $member['member_id'] ?>" id="member_id_hidden">
                </p>
                <p>
                    <span>ชื่อ - สกุล</span>
                    <span>: <input type="text" value="<?= $member['member_name'] ?>" class="text" name="member_name"></span>
                </p>
                <p>
                    <span>Username </span>
                    <span>: <input type="text" value="<?= $member['member_user'] ?>" class="text" name="member_user" maxlength="15"></span>
                </p>
                <p>
                    <span>Password </span>
                    <span>: <input type="text" value="<?= $member['member_pass'] ?>" class="text" name="member_pass" maxlength="15"></span>
                </p>
                <p>
                    <span>รหัสประจำตัวประชาชน </span>
                    <span>: <input type="text" value="<?= $member['member_identification'] ?>" class="text" name="member_identification" maxlength="13"></span>
                </p>
                <p>
                    <span>ที่อยู่ </span
                    <span>: <input type="text" value="<?= $member['member_address'] ?>" class="text" name="member_address"></span>
                </p>
                <p>
                    <span>เบอร์โทร </span>
                    <span>: <input type="text" value="<?= $member['member_tel'] ?>" class="text" name="member_tel"></span>
                </p>
                <p>
                    <span>อีเมล์ </span>
                    <span>: <input type="text" value="<?= $member['member_email'] ?>" class="text" name="member_email"></span>
                </p>
                <p style="text-align: center;color: #afafaf;font-size: 14px;">
                    วันที่แก้ไขล่าสุด : <?= $member['input_date'] ?>
                </p> 
                <p style="text-align: center;" class="dialog_update_bt">
                    <button class="button" id="bt_update_emp" type="submit">
                        <img src="images/update_icon.png"> <span>แก้ไข</span>
                    </button>
                    <button class="button" id="bt_delete_emp" type="button">
                        <img src="images/delete_icon_w.png"> <span>ลบ</span>
                    </button>
                    <button class="button" id="close_dialog" type="button">
                        <img src="images/close.png"> <span>ปิดหน้านี้</span>
                    </button>
                </p>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#dialog .in_main,#dialog h3.topic").click(function (e) {
                $("#dialog").fadeIn();
                e.stopPropagation();
            });
            $("#close_dialog").click(dialog_eixt);
            $("#bt_delete_emp").click(function () {
                delete_member();
            });
            $("#bt_update_emp").click(function () {
                update_member();
                return false;
            });
        });</script>
    <?php
}

if ($_REQUEST['delete_member'] == 1) {
    $member_id_hidden = $_REQUEST['member_id_hidden'];
    $query = "DELETE FROM member WHERE member_id=$member_id_hidden";
    mysql_query($query)or die("ไม่สามารถลบได้เนื่องจาก : " . mysql_error());
}

if ($_REQUEST['update_member'] == 1) {
    $id_main = $_REQUEST['id_main'];
    if (empty($_REQUEST['id_sub'])) {
        exit("กรุณากรอก รหัสลูกค้าสมาชิก !");
    }
    if ($_REQUEST['id_sub']) {
        $id_sub = $_REQUEST['id_sub'];
    } else {
        $id_sub = $_REQUEST['id_main'];
    }
    $member_name = trim($_REQUEST['member_name']);
    $member_user = trim($_REQUEST['member_user']);
    $member_pass = trim($_REQUEST['member_pass']);
    $member_identification = trim($_REQUEST['member_identification']);
    $member_address = trim($_REQUEST['member_address']);
    $member_tel = trim($_REQUEST['member_tel']);
    $member_email = trim($_REQUEST['member_email']);
    if (trim($_REQUEST['id_sub']) == "" || empty($member_name) || empty($member_user) || empty($member_pass) || empty($member_identification) || empty($member_address) || empty($member_tel) || empty($member_email)) {
        exit("กรุณากรอก ข้อมูลให้ครบ !");
    }
    if (!is_numeric($member_identification)) {
        exit("กรุณากรอกหมายเลขประชาชนเป็นตัวเลข !");
    }
    if (strlen((string) $member_identification) != 13) {
        exit("กรุณากรอกหมายเลขประชาชนให้ครบ 13 หลัก !");
    }
    if (!is_numeric($member_tel)) {
        exit("กรุณากรอกเบอร์โทรเป็นตัวเลข !");
    }
    $query = "UPDATE member SET ";
    $query .= "member_id=$id_sub,member_user='$member_user',member_pass='$member_pass',";
    $query .= "member_name='$member_name',member_identification='$member_identification',member_address='$member_address',";
    $query .= "member_tel='$member_tel',";
    $query .= "member_email='$member_email',input_date=NOW() WHERE member_id=$id_main";
    mysql_query($query) or die("ไม่สามารถแก้ไข : " . $member_name . " ได้ เนื่องจาก : " . mysql_error());
}

if ($_REQUEST['show_table_member'] == 1) {
    $start_row = $_REQUEST['start_row'];
    $end_row = $_REQUEST['end_row'];
    $query = "SELECT * FROM member ORDER BY member_id LIMIT $start_row,$end_row";
    $result = mysql_query($query);
    ?>
    <tr>
        <td>#รหัสลูกค้าสมาชิก</td>
        <td>#ชื่อลูกค้าสมาชิก</td>
        <td class="show_date">#Username</td>
        <td class="show_date">#วันที่แก้ไข</td>
        <td>#ลบ</td>
    </tr>
    <?php if (mysql_num_rows(mysql_query("SELECT * FROM member")) <= 0) { ?>
        <tr>
            <td colspan="5" style="text-align: left;">ไม่มีรายการในระบบ</td>
        </tr>
        <?php
    } else {
        while ($member = mysql_fetch_array($result)) {
            ?>
            <?php $member_id = "M" . $member['member_id']; ?>
            <tr class="member_id_<?= $member['member_id'] ?>">
                <td>
                    <a title="ต้องการแก้ไข คลิ๊ก!" onclick="show_update_member(<?= $member['member_id'] ?>, 70, 0,<?= $start_row ?>,<?= $end_row ?>);">
                        <?= $member_id ?>
                    </a>
                </td>
                <td>
                    <?= $member['member_name'] ?>
                </td>
                <td class="show_date"><?= $member['member_user'] ?></td>
                <td class="show_date"><?= $member['input_date'] ?></td>
                <td>
                    <input type="checkbox" class="delete_check" value="<?= $member['member_id'] ?>">
                </td>
            </tr>

            <?php
        }
    }
}