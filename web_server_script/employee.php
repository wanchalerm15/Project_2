<?php
session_start();
include './connect_DB.php';
if ($_REQUEST['delete_employee_arrlay'] == 1) {
    $delete_array = $_REQUEST['delete_array'];
    if (!count($delete_array)) {
        exit("กรุณาเลือกรายการที่จะลบ!");
    }
    $error = "";
    foreach ($delete_array as $array) {
        $query = "DELETE FROM employee WHERE employee_id=$array";
        if (!mysql_query($query)) {
            $error .= "รหัส $array ไม่สามารถลบได้เนื่องจาก : " . mysql_error() . "<br />";
        }
    }
    if (trim($error) != "") {
        echo "$error";
    }
}
if ($_REQUEST['check_add_reg'] == 1) {
    $pattern = "[a-z0-9_]{6,15}";
    if ($_REQUEST['select'] == 1) {
        $url = "SELECT * FROM " . $_REQUEST['table'] . " WHERE " . $_REQUEST['where'] . "=" . $_REQUEST['data'];
    } else {
        $url = "SELECT * FROM " . $_REQUEST['table'] . " WHERE " . $_REQUEST['where'] . "='" . $_REQUEST['data'] . "'";
    }
    if (!eregi($pattern, $_REQUEST['data'])) {
        exit("Username ควรเป็น ตัวอักษรอังกฤษ หรือ ตัวเลข และมีตั้งแต่ 6 ตัวขึ้นไปไม่เกิน 15 ตัว");
    }
    $text = $_REQUEST['text'];
    $check = mysql_num_rows(mysql_query($url));
    if ($check > 0) {
        echo "มีคนใช้ $text นี้แล้ว<br />";
    }
}
if ($_REQUEST['check_code'] == 1) {
    if ($_REQUEST['select'] == 1) {
        $url = "SELECT * FROM " . $_REQUEST['table'] . " WHERE " . $_REQUEST['where'] . "=" . $_REQUEST['data'];
    } else {
        $url = "SELECT * FROM " . $_REQUEST['table'] . " WHERE " . $_REQUEST['where'] . "='" . $_REQUEST['data'] . "'";
    }
    $text = $_REQUEST['text'];
    $check = mysql_num_rows(mysql_query($url));
    if ($check > 0) {
        echo "มีรายการ $text นี้แล้ว กรุณาเปลี่ยนใหม่<br />";
    }
}
if ($_REQUEST['add_employee'] == 1) {
    $input_name_emp = $_REQUEST['input_name_emp'];
    $input_user_emp = $_REQUEST['input_user_emp'];
    $input_pass_emp = $_REQUEST['input_pass_emp'];
    $input_Iden_emp = $_REQUEST['input_Iden_emp'];
    $input_edu_emp = $_REQUEST['input_edu_emp'];
    $input_salary_emp = $_REQUEST['input_salary_emp'];
    $input_address_emp = $_REQUEST['input_address_emp'];
    $input_tel_emp = $_REQUEST['input_tel_emp'];
    $input_email_emp = $_REQUEST['input_email_emp'];
    if (!$input_salary_emp) {
        $input_salary_emp = 0;
    }
    if (!$input_edu_emp) {
        $input_edu_emp = "ยังไม่มีข้อมูลส่วนนี้";
    }
    $query = "INSERT INTO employee VALUES("
            . "0,'$input_user_emp','$input_pass_emp','$input_name_emp',"
            . "'$input_Iden_emp','$input_address_emp',$input_salary_emp,"
            . "'$input_edu_emp','$input_tel_emp','$input_email_emp',"
            . "NOW())";
    mysql_query($query) or die("ไม่สามารถเพิ่มพนักงานได้ เนื่องจาก : " . mysql_error());
}

if ($_REQUEST['show_update_employee'] == 1) {
    $employee_id = $_REQUEST['employee_id'];
    $query = "SELECT * FROM employee WHERE employee_id=$employee_id";
    $result = mysql_query($query);
    $employee = mysql_fetch_array($result);
    ?>
    <h3 class="topic" style="text-align: left;">
        <img src="images/topic_icon.png">
        <span>รหัสพนักงาน E<?= $employee['employee_id'] ?></span>/<span style="font-size: 14px;"><?= $employee['employee_name'] ?></span>
    </h3>
    <div class="in_main">
        <div id="artical">
            <div class="warning" id="dialog_emp_error">
                แก้ไขข้อมูลพนักงาน ของคุณ <?= $employee['employee_name'] ?> รหัสพนักงาน E<?= $employee['employee_id'] ?>
            </div>
            <form class="update_dialog_employee" method="POST" id="update_dialog_employee">
                <p> 
                    <span>รหัสพนักงาน</span>
                    <?php if ($admin_id_session) { ?>
                        <span>: <input type="text" class="text" value="<?= $employee['employee_id'] ?>" name="id_sub" id="id_sub"></span>
                    <?php } else { ?>
                        <span>: <input type="text" class="text" value="<?= $employee['employee_id'] ?>" disabled="" name="id_sub" id="id_sub"></span>
                    <?php } ?>
                    <input type="hidden" value="<?= $_REQUEST['start_row'] ?>" id="start_row">
                    <input type="hidden" value="<?= $_REQUEST['end_row'] ?>" id="end_row">
                    <input type="hidden" value="<?= $employee['employee_id'] ?>" id="employee_id_hidden">
                </p>
                <p>
                    <span>ชื่อ - สกุล</span>
                    <span>: <input type="text" value="<?= $employee['employee_name'] ?>" class="text" name="employee_name"></span>
                </p>
                <p>
                    <span>Username </span>
                    <span>: <input type="text" value="<?= $employee['employee_user'] ?>" class="text" name="employee_user"></span>
                </p>
                <p>
                    <span>Password </span>
                    <span>: <input type="text" value="<?= $employee['employee_pass'] ?>" class="text" name="employee_pass"></span>
                </p>
                <p>
                    <span>รหัสประจำตัวประชาชน </span>
                    <span>: <input type="text" value="<?= $employee['employee_identification'] ?>" class="text" name="employee_iden"></span>
                </p>
                <p>
                    <span>ที่อยู่ </span
                    <span>: <input type="text" value="<?= $employee['employee_address'] ?>" class="text" name="employee_address"></span>
                </p>
                <p>
                    <span>เบอร์โทร </span>
                    <span>: <input type="text" value="<?= $employee['employee_tel'] ?>" class="text" name="employee_tel"></span>
                </p>
                <p>
                    <span>อีเมล์ </span>
                    <span>: <input type="text" value="<?= $employee['employee_email'] ?>" class="text" name="employee_email"></span>
                </p>
                <p>
                    <span>เงินเดือน </span>
                    <span>: <input type="text" value="<?= $employee['employee_salary'] ?>" class="text" name="employee_salary"></span>
                </p>
                <p>
                    <span>การศึกษา </span>
                    <span>: <input type="text" value="<?= $employee['employee_education'] ?>" class="text" name="employee_edu"></span>
                </p>
                <p style="text-align: center;color: #afafaf;font-size: 14px;">
                    วันที่แก้ไขล่าสุด : <?= $employee['input_date'] ?>
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
        $(document).ready(function() {
            $("#dialog .in_main,#dialog h3.topic").click(function(e) {
                $("#dialog").fadeIn();
                e.stopPropagation();
            });
            $("#close_dialog").click(dialog_eixt);
            $("#bt_delete_emp").click(function() {
                delete_employee();
            });
            $("#bt_update_emp").click(function() {
                update_employee();
                return false;
            });
        });</script>
    <?php
}

if ($_REQUEST['delete_employee'] == 1) {
    $employee_id_hidden = $_REQUEST['employee_id_hidden'];
    $query = "DELETE FROM employee WHERE employee_id=$employee_id_hidden";
    mysql_query($query)or die("ไม่สามารถลบได้เนื่องจาก : " . mysql_error());
}
if ($_REQUEST['update_employee'] == 1) {
    $id_main = $_REQUEST['id_main'];
    if ($_REQUEST['id_sub']) {
        $id_sub = $_REQUEST['id_sub'];
    } else {
        $id_sub = $_REQUEST['id_main'];
    }
    $employee_name = $_REQUEST['employee_name'];
    $employee_user = $_REQUEST['employee_user'];
    $employee_pass = $_REQUEST['employee_pass'];
    $employee_iden = $_REQUEST['employee_iden'];
    $employee_address = $_REQUEST['employee_address'];
    $employee_tel = $_REQUEST['employee_tel'];
    $employee_email = $_REQUEST['employee_email'];
    $employee_salary = $_REQUEST['employee_salary'];
    $employee_edu = $_REQUEST['employee_edu'];
    $query = "UPDATE employee SET ";
    $query .= "employee_id=$id_sub,employee_user='$employee_user',employee_pass='$employee_pass',";
    $query .= "employee_name='$employee_name',employee_identification='$employee_iden',employee_address='$employee_address',";
    $query .= "employee_salary=$employee_salary,employee_education='$employee_edu',employee_tel='$employee_tel',";
    $query .= "employee_email='$employee_email',input_date=NOW() WHERE employee_id=$id_main";
    mysql_query($query) or die("ไม่สามารถแก้ไข : " . $employee_name . " ได้ เนื่องจาก : " . mysql_error());
}
if ($_REQUEST['show_table_employee'] == 1) {
    $start_row = $_REQUEST['start_row'];
    $end_row = $_REQUEST['end_row'];
    $query = "SELECT * FROM employee ORDER BY employee_id LIMIT $start_row,$end_row";
    $result = mysql_query($query);
    ?>
    <tr>
        <td>#รหัสพนักงาน</td>
        <td>#ชื่อพนักงาน</td>
        <td>#Username</td>
        <td class="show_date">#วันที่แก้ไข</td>
        <td>#ลบ</td>
    </tr>
    <?php if (mysql_num_rows(mysql_query("SELECT * FROM employee")) <= 0) { ?>
        <tr>
            <td colspan="5" style="text-align: left;">ไม่มีรายการในระบบ</td>
        </tr>
        <?php
    } else {
        while ($employee = mysql_fetch_array($result)) {
            ?>
            <?php $employee_id = "E" . $employee['employee_id']; ?>
            <tr class="employee_id_<?= $employee['employee_id'] ?>">
                <td><?= $employee_id ?></td>
                <td>
                    <a title="ต้องการแก้ไข คลิ๊ก!" onclick="show_update_employee(<?= $employee['employee_id'] ?>, 70, 0,<?= $start_row ?>,<?= $end_row ?>);">
                        <?= $employee['employee_name'] ?>
                    </a>
                </td>
                <td><?= $employee['employee_user'] ?></td>
                <td class="show_date"><?= $employee['input_date'] ?></td>
                <td>
                    <input type="checkbox" class="delete_check" value="<?= $employee['employee_id'] ?>">
                </td>
            </tr>

            <?php
        }
    }
}