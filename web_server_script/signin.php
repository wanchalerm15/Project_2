<?php

header("Content-Type:text/html;charset=utf-8");
include './connect_DB.php';
if ($_REQUEST["login_signin"] == 1) {
    if (isset($_POST["input_name"], $_POST["input_user"], $_POST["input_pass"], $_POST["input_passConfirm"], $_POST["input_code"], $_POST["input_address"], $_POST["input_tel"], $_POST["input_email"])) {
        $input_name = $_POST["input_name"];
        $input_user = $_POST["input_user"];
        $input_pass = $_POST["input_pass"];
        $input_passConfirm = $_POST["input_passConfirm"];
        $input_code = $_POST["input_code"];
        $input_address = $_POST["input_address"];
        $input_tel = $_POST["input_tel"];
        $input_email = $_POST["input_email"];

        $query_emp = mysql_query("select * from employee where employee_user='$input_user'");
        $query_mem = mysql_query("select * from admin where admin_user='$input_user'");
        if (mysql_num_rows($query_emp) != 0 || mysql_num_rows($query_mem) != 0) {
            exit("Error! : ชื่อผู้ใช้ <u>$input_user</u> นี้มีในระบบแล้ว");
        }
        if ($input_pass == $input_passConfirm) {
            $query = "INSERT INTO member VALUES(0,'$input_user','$input_pass','$input_name','$input_code','$input_address','$input_tel','$input_email',NOW())";
            if (!mysql_query($query)) {
                echo "Error! : " . mysql_error();
            }
        } else {
            echo "กรุณากรอก Password และ Confirm Password ให้ตรงกัน";
        }
    }
}
if ($_REQUEST['edit_member_mySelf'] == 1) {
    if (isset($_POST["input_name"], $_POST["input_pass"], $_POST["input_id"], $_POST["input_address"], $_POST["input_tel"], $_POST["input_email"])) {
        $input_name = $_POST["input_name"];
        $input_pass = $_POST["input_pass"];
        $input_id = $_POST["input_id"];
        $input_address = $_POST["input_address"];
        $input_tel = $_POST["input_tel"];
        $input_email = $_POST["input_email"];
        $query = "UPDATE member SET member_pass='$input_pass',member_name='$input_name',member_address='$input_address'"
                . ",member_tel='$input_tel',member_email='$input_email',input_date=NOW() "
                . "WHERE member_id=$input_id";
        mysql_query($query) or die("ERROR ! : " . mysql_error());
    }
}

if ($_REQUEST['edit_admin_mySelf'] == 1) {
    if (isset($_POST["input_name"], $_POST["input_pass"], $_POST["input_id"], $_POST["input_address"], $_POST["input_tel"], $_POST["input_email"], $_POST["input_user"], $_POST["input_code"])) {
        $input_name = $_POST["input_name"];
        $input_user = trim($_POST["input_user"]);
        $input_code = trim($_POST["input_code"]);
        $input_pass = trim($_POST["input_pass"]);
        $input_id = $_POST["input_id"];
        $input_address = $_POST["input_address"];
        $input_tel = $_POST["input_tel"];
        $input_email = $_POST["input_email"];
        $query = "UPDATE admin SET admin_pass='$input_pass',admin_name='$input_name',admin_address='$input_address'"
                . ",admin_tel='$input_tel',admin_email='$input_email',date_input=NOW(),admin_user='$input_user',admin_identification='$input_code' "
                . "WHERE admin_id=$input_id";
        mysql_query($query) or die("Admin Insert ERROR ! : " . mysql_error());
    } else {
        echo "กรุณากรอกข้อมูลให้ครบ !";
    }
}

if ($_REQUEST['edit_employee_mySelf'] == 1) {
    if (isset($_POST["input_name"], $_POST["input_pass"], $_POST["input_id"], $_POST["input_address"], $_POST["input_tel"], $_POST["input_email"], $_POST["input_education"])) {
        $input_name = $_POST["input_name"];
        $input_education = trim($_POST["input_education"]);
        $input_pass = trim($_POST["input_pass"]);
        $input_id = $_POST["input_id"];
        $input_address = $_POST["input_address"];
        $input_tel = $_POST["input_tel"];
        $input_email = $_POST["input_email"];
        $query = "UPDATE employee SET employee_pass='$input_pass',employee_name='$input_name',employee_address='$input_address'"
                . ",employee_tel='$input_tel',employee_email='$input_email',input_date=NOW(),employee_education='$input_education' "
                . "WHERE employee_id=$input_id";
        mysql_query($query) or die("Admin Insert ERROR ! : " . mysql_error());
    } else {
        echo "กรุณากรอกข้อมูลให้ครบ !";
    }
}