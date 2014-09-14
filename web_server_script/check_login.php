<?php

session_start();
include './connect_DB.php';
if (isset($_POST["username_login"], $_POST["password_login"])) {
    $username_login = $_POST["username_login"];
    $password_login = $_POST["password_login"];
    if ($username_login != "" && $password_login != "") {
        /* ------------------------------------------- admin -------------------------------------------------- */
        $query_admin = "SELECT * FROM admin WHERE admin_user='$username_login' AND admin_pass='$password_login'";
        $result_admin = mysql_query($query_admin);
        $admin = mysql_fetch_array($result_admin);
        /* -------------------------------------------// admin -------------------------------------------------- */

        /* ------------------------------------------- member -------------------------------------------------- */
        $query_member = "SELECT * FROM member WHERE member_user='$username_login' AND member_pass='$password_login'";
        $result_member = mysql_query($query_member);
        $member = mysql_fetch_array($result_member);
        /* -------------------------------------------// member -------------------------------------------------- */

        /* ------------------------------------------- employee -------------------------------------------------- */
        $query_emp = "SELECT * FROM employee WHERE employee_user='$username_login' AND employee_pass='$password_login'";
        $result_emp = mysql_query($query_emp);
        $employee = mysql_fetch_array($result_emp);
        /* -------------------------------------------// employee -------------------------------------------------- */
        if (!empty($admin)) {
            $_SESSION["admin_id_session"] = $admin["admin_id"];
            echo "<script>";
            echo "alert('เข้าสู่ระบบสำเร็จ');";
            echo "history.back();";
            echo "</script>";
        } elseif (!empty($employee)) {
            $_SESSION["employee_id_session"] = $employee["employee_id"];
            echo "<script>";
            echo "alert('เข้าสู่ระบบสำเร็จ');";
            echo "history.back();";
            echo "</script>";
        } elseif (!empty($member)) {
            $_SESSION["member_id_session"] = $member["member_id"];
            echo "<script>";
            echo "alert('เข้าสู่ระบบสำเร็จ');";
            echo "history.back();";
            echo "</script>";
        } else {
            echo "<script>";
            echo "alert('รหัสผ่านไม่ถูกต้อง !');";
            echo "history.back();";
            echo "</script>";
        }
    }
}
