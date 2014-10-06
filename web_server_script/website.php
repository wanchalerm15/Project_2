<?php

include './connect_DB.php';
if ($_REQUEST['update_web_name'] == 1) {
    $web_thai_name = trim($_REQUEST['web_thai_name']);
    $web_eng_name = trim($_REQUEST['web_eng_name']);
    $query = "UPDATE website SET web_thai_name='$web_thai_name',web_eng_name='$web_eng_name',date_input=NOW() "
            . "WHERE web_id=1";
    mysql_query($query) or die("แก้ไขชื่อร้านไม่ได้ : " . mysql_error());
}
if ($_REQUEST['update_numrow_tax'] == 1) {
    $aftershop_numrow = trim($_REQUEST['aftershop_numrow']);
    $tax = trim($_REQUEST['tax']);
    $query = "UPDATE website SET aftershop_numrow='$aftershop_numrow',tax='$tax',date_input=NOW() "
            . "WHERE web_id=1";
    mysql_query($query) or die("แก้ไขจำนวนแถวและภาษีไม่ได้ : " . mysql_error());
}
if ($_GET['how_to_pays'] == 1) {
    $how_to_pays = $_POST['how_to_pays'];
    $query = "UPDATE website SET how_to_pays='$how_to_pays',date_input=NOW() "
            . "WHERE web_id=1";
    if (mysql_query($query)) {
        echo "<script>window.top.update_how_to_pays(1);</script>";
    } else {
        echo "<script>window.top.update_how_to_pays(0);</script>";
    }
}
if ($_GET['about_me'] == 1) {
    $about_me = $_POST['about_me'];
    $query = "UPDATE website SET about_me='$about_me',date_input=NOW() "
            . "WHERE web_id=1";
    if (mysql_query($query)) {
        echo "<script>window.top.update_about_me(1);</script>";
    } else {
        echo "<script>window.top.update_about_me(0);</script>";
    }
}
if ($_GET['contact_us'] == 1) {
    $contact_us = $_POST['contact_us'];
    $query = "UPDATE website SET contact_us='$contact_us',date_input=NOW() "
            . "WHERE web_id=1";
    if (mysql_query($query)) {
        echo "<script>window.top.update_about_me(1);</script>";
    } else {
        echo "<script>window.top.update_about_me(0);</script>";
    }
}
if ($_GET['logo_web'] == 1) {
    $img_logo_size = ($_FILES["file_logo"]['size'] / 1024);
    $img_logo_type = ($_FILES["file_logo"]['type'] == "image/png" || $_FILES["file_logo"]['type'] == "image/gif") ? 0 : 1;
    /* ---------------------------------------------------------------------------- */
    if ($img_logo_type) {
        exit("<script>window.top.upload_img_logo(0,'ภาพ logo ต้องมีนามสกุลเป็น .GIF หรือ .PNG')</script>");
    }
    if ($img_logo_size > 1024) {
        exit("<script>window.top.upload_img_logo(0,'ภาพโลโก้มีขนาดมากกว่า 1MB')</script>");
    }
    if (eregi("(.png)$", $_FILES["file_logo"]['name'])) {
        $img_logo_name = "logo.png";
    } elseif (eregi("(.gif)$", $_FILES["file_logo"]['name'])) {
        $img_logo_name = "logo.gif";
    }
    $path_dir = "images/" . $img_logo_name;
    if (file_exists($path_dir)) {
        unlink($path_dir);
    }
    $query = "UPDATE website SET web_logo='$path_dir' WHERE web_id=1";
    if (mysql_query($query) && copy($_FILES["file_logo"]['tmp_name'], "../" . $path_dir)) {
        exit("<script>window.top.upload_img_logo(1,'แก้ไขภาพสำเร็จ')</script>");
    } else {
        exit("<script>window.top.upload_img_logo(0,'แก้ไขภาพไม่สำเร็จ')</script>");
    }
}
if ($_GET['img_bank_pays'] == 1) {
    $img_logo_size = ($_FILES["file_img_bank_pays"]['size'] / 1024);
    $img_logo_type = ($_FILES["file_img_bank_pays"]['type'] == "image/jpeg") ? 0 : 1;
    /* ---------------------------------------------------------------------------- */
    if ($img_logo_type) {
        exit("<script>window.top.upload_img_logo(0,'ภาพ ต้องมีนามสกุลเป็น .jpg เท่านั้น')</script>");
    }
    if ($img_logo_size > 1024) {
        exit("<script>window.top.upload_img_logo(0,'ภาพต้องมีขนาดไม่เกิน 1MB')</script>");
    }
    $img_logo_name = "bank_pays.jpg";
    $path_dir = "images/" . $img_logo_name;
    if (file_exists($path_dir)) {
        unlink($path_dir);
    }
    if (copy($_FILES["file_img_bank_pays"]['tmp_name'], "../" . $path_dir)) {
        exit("<script>window.top.upload_img_logo(1,'แก้ไขภาพสำเร็จ')</script>");
    } else {
        exit("<script>window.top.upload_img_logo(0,'แก้ไขภาพไม่สำเร็จ $path_dir')</script>");
    }
}