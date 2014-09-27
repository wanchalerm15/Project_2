<?php

$div_errorOpen = "<div style='"
        . "border: solid 1px #eeee00;background-color: #ffffdd;display:inline-block;"
        . "text-align: left;color: #808080;padding: 2%;font-size: 14px;margin: 1%;font-family:sans-serif;"
        . "background-image: url(../images/warning.png);background-repeat: no-repeat;background-position: 100% 0%;"
        . "'> ไฟล์ edit_website.php Error :<br />";
$div_errorClose = "</div>";
@mysql_connect("localhost", "root", "4096") or die("$div_errorOpen การเชื่อมต่อ MY SQL ผิดพลาด ! เนื่องมาจาก :<br />" . mysql_error() . $div_errorClose);
mysql_select_db("website_selling_musical_intrusment_db") or die("$div_errorOpen การเชื่อมต่อ DATABASE ผิดพลาด ! เนื่องมาจาก :<br />" . mysql_error() . $div_errorClose);
mysql_query("SET NAMES UTF8")or die("$div_errorOpen การเข้ารหัส ENCODER ผิดพลาด ! เนื่องมาจาก :<br />" . mysql_error() . $div_errorClose);
$query = "SELECT * FROM website where web_id=1";
$result = mysql_query($query);
$website = mysql_fetch_array($result);

$WEB_THAI_NAME = $website["web_thai_name"];
$WEB_ENG_NAME = $website["web_eng_name"];
$WEB_LOGO = $website["web_logo"];
$WEB_AFTERSHOP_NUMROW = $website["aftershop_numrow"];
$WEB_TAX = $website['tax'];
$WEB_DATE = $website['date_input'];
$WEB_HOW_TO_PAYS = $website['how_to_pays'];
$WEB_ABOUT_ME = $website['about_me'];
$WEB_CONTACT_US = $website['contact_us'];
