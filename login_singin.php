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
        <meta class="refrest">
        <title>เข้าสู่ระบบ - สมัครสมาชิก</title>
        <link rel="stylesheet" type="text/css" href="web_design_script/Website_selling_musical_intrusment_CSS.css">
        <link rel="stylesheet" type="text/css" href="web_design_script/SmartPhone_Design_Musical_intrusment.css">
        <script type="text/javascript" src="web_design_script/jquery.min.js"></script>
        <script>
            $(document).ready(function () {
                // alert($(window).width());
            });
        </script>
    </head>
    <body>
        <?php $signin = "active"; ?>
        <?php require './header.php'; ?>
        <div id="containur">
            <!-----------------------------------/ login ------------------------------------->
            <div id="artical" class=" container login" style="margin-top: 5px;">
                <?php if (empty($member_id_session) && empty($employee_id_session) && empty($admin_id_session)) { ?>
                    <div class="inner_border">
                        <h3 class="topic bg_img">
                            เข้าสู่ระบบ <?= $WEB_THAI_NAME ?>
                        </h3>
                        <div class="inner">
                            <div class="inner-w border-inner">
                                <?php if ($member_id_session || $employee_id_session || $admin_id_session) { ?>
                                    <!-------------------------------login Disable-------------------------------------->
                                    <div class="warning">
                                        ถ้าคุณต้องการ เข้าสู่ระบบบัญชีใหม่ กรุณาออกจากระบบบัญชีเดิมก่อน
                                    </div>
                                    <form id="check_login" method="POST">
                                        <p>ชื่อผู้ใช้งาน</p>
                                        <input type="text" maxlength="15" name="username_login" id="username_login" placeholder=" Cannot Enter Username" required="" disabled="" class="text">
                                        <p>รหัสผ่าน</p>
                                        <input type="password" maxlength="15" name="password_login" id="password_login" placeholder=" Cannot Enter Password" required="" disabled="" class="text">
                                        <div class="bt_login">
                                            <input type="submit" value="ออกจากระบบ" class="bt_black" onclick="location = '?Logout=yes';
                                                            return false;">
                                        </div>
                                    </form>
                                    <!-------------------------------/login Disable-------------------------------------->
                                <?php } else { ?>
                                    <!-------------------------------login Enable-------------------------------------->
                                    <div class="warning">
                                        กรุณาเข้าสู่ระบบก่อนจึงจะสามารถซื้อสินค้าได้
                                    </div>
                                    <div class="error_login"></div>
                                    <form id="check_login" method="POST" action="web_server_script/check_login.php">
                                        <p>ชื่อผู้ใช้งาน</p>
                                        <input type="text" maxlength="15" name="username_login" id="username_login" placeholder=" Please Enter Username" required="" class="text">
                                        <p>รหัสผ่าน</p>
                                        <input type="password" maxlength="15" name="password_login" id="password_login" placeholder=" Please Enter Password" required="" class="text">
                                        <div class="bt_login">
                                            <input type="submit" value="เข้าสู่ระบบ" class="bt_black" id="bt_login">
                                        </div>
                                    </form>
                                    <!-------------------------------/login Enable-------------------------------------->
                                <?php } ?>
                                <script>
                                    $(document).ready(function () {
                                        $("#bt_login").click(function () {
                                            if ($("#username_login").val() == "" || $("#password_login").val() == "") {
                                                $(".error_login").addClass("warning-error").html("กรุณากรอก Username และ Password");
                                                return false;
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <!-------------------------------- Mamber Edit ---------------------------------------------->
                    <?php if (!empty($_SESSION['member_id_session'])) { ?>
                        <div class="inner_border" style="margin:0 0 10px 0;">
                            <h3 class="topic bg_img">
                                แก้ไขข้อมูลส่วนตัว
                            </h3>
                            <div class="inner">
                                <?php
                                $query = mysql_query("select * from member where member_id=" . $_SESSION['member_id_session']);
                                $member = mysql_fetch_array($query);
                                ?>
                                <form id="check_signin" method="POST" class="edit member">
                                    <div class="inner-w border-inner">
                                        <div class="warning" id="member_myselfError">
                                            แก้ไขข้อมูลส่วนตัวของ คุณ <?= $member['member_name'] ?> สถานะ : [ ลูกค้าสมาชิก ]
                                            <p class="disable">วันที่แก้ไขล่าสุด : <?= $member['input_date'] ?></p>
                                        </div>
                                        <input type="hidden" name="input_id" value="<?= $member['member_id'] ?>" class="tx_signin" id="input_id">
                                        <p>ชื่อ-สกุล :</p>
                                        <input type="text" name="input_name"  value="<?= $member['member_name'] ?>" class="tx_signin" placeholder="ชื่อ-สกุล">
                                        <p>ชื่อผู้ใช้ :</p>
                                        <input type="text" value="<?= $member['member_user'] ?>" maxlength="15"  class="tx_signin" placeholder="ชื่อผู้ใช้" disabled="">
                                        <p>รหัสผ่าน :</p>
                                        <input type="password" name="input_pass"  value="<?= $member['member_pass'] ?>" maxlength="15" class="tx_signin" placeholder="รหัสผ่าน">
                                        <p>รหัสประจำตัวประชาชน :</p>
                                        <input type="text" value="<?= $member['member_identification'] ?>" maxlength="13"  class="tx_signin" disabled="">
                                        <p>ที่อยู่ :</p>
                                        <textarea name="input_address" class="tx_signin" placeholder="ที่อยู่"><?= $member['member_address'] ?></textarea>
                                        <p>เบอร์โทร :</p>
                                        <input type="text" name="input_tel" value="<?= $member['member_tel'] ?>" maxlength="10" class="tx_signin" placeholder="เบอร์โทร">
                                        <p>อีเมล์ :</p>
                                        <input type="text" name="input_email" value="<?= $member['member_email'] ?>" class="tx_signin" placeholder="อีเมล์">
                                        <br /><br />
                                    </div>
                                    <div class="bt_login inner-w border-inner" style="margin-top: 10px;padding: 10px 5px;">
                                        <input type="submit" value="แก้ไขข้อมูล" class="bt_black" id="bt_edit_signin">
                                        <input type="button" value="ออกจากระบบ" class="bt_black" onclick="location = '?Logout=yes';
                                                        return false;">
                                    </div>
                                    <div style="clear: both;"></div>
                                </form>
                                <script>
                                    // signin manager code
                                    $(document).ready(function () {
                                        $("#bt_edit_signin").click(function () {
                                            var error = "";
                                            $("#check_signin.edit.member .tx_signin").each(function () {
                                                if ($.trim($(this).val()) == "") {
                                                    error += "กรุณากรอก : " + $(this).attr('placeholder') + "<br />"
                                                    $(this).addClass("focus-warning");
                                                } else {
                                                    if ($(this).attr('name') == "input_tel") {
                                                        error = ($.isNumeric($(this).val())) ? error += "" : error += "กรุณากรอก เบอร์โทรเป็นตัวเลข <br />";
                                                    }
                                                }
                                            });
                                            if (error == "") {
                                                edit_member_mySelf("#check_signin.member");
                                            } else {
                                                $("#member_myselfError").removeAttr('class').addClass("warning-problem").html(error);
                                            }
                                            return false;
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <!-------------------------------- Mamber Edit ---------------------------------------------->
                    <?php } elseif (!empty($_SESSION['admin_id_session'])) { ?>
                        <!-------------------------------- Admin Edit ---------------------------------------------->
                        <div class="inner_border" style="margin:0 0 10px 0;">
                            <h3 class="topic bg_img">
                                แก้ไขข้อมูลส่วนตัว
                            </h3>
                            <div class="inner">
                                <?php
                                $query = mysql_query("select * from admin where admin_id=" . $_SESSION['admin_id_session']);
                                $admin = mysql_fetch_array($query);
                                ?>
                                <form id="check_signin" method="POST" class="edit Admin">
                                    <div class="inner-w border-inner">
                                        <div class="warning" id="member_myselfError">
                                            แก้ไขข้อมูลส่วนตัวของ คุณ <?= $admin['admin_name'] ?> สถานะ : [ เจ้าของร้าน ]
                                             <p class="disable">วันที่แก้ไขล่าสุด : <?= $admin['date_input'] ?></p>
                                        </div>
                                        <input type="hidden" name="input_id" value="<?= $admin['admin_id'] ?>" class="tx_signin" id="input_id">
                                        <p>ชื่อ-สกุล :</p>
                                        <input type="text" name="input_name"  value="<?= $admin['admin_name'] ?>" class="tx_signin" placeholder="ชื่อ-สกุล">
                                        <p>ชื่อผู้ใช้ :</p>
                                        <input type="text" name="input_user"  value="<?= $admin['admin_user'] ?>" maxlength="15"  class="tx_signin" placeholder="ชื่อผู้ใช้">
                                        <p>รหัสผ่าน :</p>
                                        <input type="password" name="input_pass"  value="<?= $admin['admin_pass'] ?>" maxlength="15" class="tx_signin" placeholder="รหัสผ่าน">
                                        <p>รหัสประจำตัวประชาชน :</p>
                                        <input type="text" name="input_code" value="<?= $admin['admin_identification'] ?>" maxlength="13"  class="tx_signin">
                                        <p>ที่อยู่ :</p>
                                        <textarea name="input_address" class="tx_signin" placeholder="ที่อยู่"><?= $admin['admin_address'] ?></textarea>
                                        <p>เบอร์โทร :</p>
                                        <input type="text" name="input_tel" value="<?= $admin['admin_tel'] ?>" maxlength="10" class="tx_signin" placeholder="เบอร์โทร">
                                        <p>อีเมล์ :</p>
                                        <input type="text" name="input_email" value="<?= $admin['admin_email'] ?>" class="tx_signin" placeholder="อีเมล์">
                                        <br /><br />
                                    </div>
                                    <div class="bt_login inner-w border-inner" style="margin-top: 10px;padding: 10px 5px;">
                                        <input type="submit" value="แก้ไขข้อมูล" class="bt_black" id="bt_edit_signin">
                                        <input type="button" value="ออกจากระบบ" class="bt_black" onclick="location = '?Logout=yes';
                                                        return false;">
                                    </div>
                                    <div style="clear: both;"></div>
                                </form>
                                <script>
                                    // signin Admin code
                                    $(document).ready(function () {
                                        $("#bt_edit_signin").click(function () {
                                            var error = "";
                                            $("#check_signin.edit.Admin .tx_signin").each(function () {
                                                if ($.trim($(this).val()) == "") {
                                                    error += "กรุณากรอก : " + $(this).attr('placeholder') + "<br />"
                                                    $(this).addClass("focus-warning");
                                                } else {
                                                    if ($(this).attr('name') == "input_tel") {
                                                        error = ($.isNumeric($(this).val())) ? error += "" : error += "กรุณากรอก เบอร์โทรเป็นตัวเลข <br />";
                                                    }
                                                }
                                            });
                                            if (error == "") {
                                                edit_admin_mySelf(".Admin");
                                            } else {
                                                $("#member_myselfError").removeAttr('class').addClass("warning-problem").html(error);
                                            }
                                            return false;
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <!-------------------------------- /Employee Edit ---------------------------------------------->
                    <?php } elseif (!empty($_SESSION['employee_id_session'])) { ?>
                        <!-------------------------------- Employee Edit ---------------------------------------------->
                        <div class="inner_border" style="margin:0 0 10px 0;">
                            <h3 class="topic bg_img">
                                แก้ไขข้อมูลส่วนตัว
                            </h3>
                            <div class="inner">
                                <?php
                                $query = mysql_query("select * from employee where employee_id=" . $_SESSION['employee_id_session']);
                                $employee = mysql_fetch_array($query);
                                ?>
                                <form id="check_signin" method="POST" class="edit employee">
                                    <div class="inner-w border-inner">
                                        <div class="warning" id="member_myselfError">
                                            แก้ไขข้อมูลส่วนตัวของ คุณ <?= $employee['employee_name'] ?> สถานะ : [ พนักงาน ]
                                            <p class="disable">วันที่แก้ไขล่าสุด : <?= $employee['input_date'] ?></p>
                                        </div>
                                        <input type="hidden" name="input_id" value="<?= $employee['employee_id'] ?>" class="tx_signin" id="input_id">
                                        <p>ชื่อ-สกุล :</p>
                                        <input type="text" name="input_name"  value="<?= $employee['employee_name'] ?>" class="tx_signin" placeholder="ชื่อ-สกุล">
                                        <p>ชื่อผู้ใช้ :</p>
                                        <input type="text"  value="<?= $employee['employee_user'] ?>" maxlength="15"  class="tx_signin" placeholder="ชื่อผู้ใช้" disabled="">
                                        <p>รหัสผ่าน :</p>
                                        <input type="password" name="input_pass"  value="<?= $employee['employee_pass'] ?>" maxlength="15" class="tx_signin" placeholder="รหัสผ่าน">
                                        <p>รหัสประจำตัวประชาชน :</p>
                                        <input type="text" value="<?= $employee['employee_identification'] ?>" maxlength="13"  class="tx_signin" disabled="">
                                        <p>ที่อยู่ :</p>
                                        <textarea name="input_address" class="tx_signin" placeholder="ที่อยู่"><?= $employee['employee_address'] ?></textarea>
                                        <p>การศึกษา :</p>
                                        <textarea name="input_education" class="tx_signin" placeholder="การศึกษา"><?= $employee['employee_education'] ?></textarea>
                                        <p>เบอร์โทร :</p>
                                        <input type="text" name="input_tel" value="<?= $employee['employee_tel'] ?>" maxlength="10" class="tx_signin" placeholder="เบอร์โทร">
                                        <p>อีเมล์ :</p>
                                        <input type="text" name="input_email" value="<?= $employee['employee_email'] ?>" class="tx_signin" placeholder="อีเมล์">
                                        <p>เงินเดือน :</p>
                                        <input type="text" value="<?= $employee['employee_salary'] ?>" class="tx_signin" placeholder="เงินเดือน" disabled="">
                                        <br /><br />
                                    </div>
                                    <div class="bt_login inner-w border-inner" style="margin-top: 10px;padding: 10px 5px;">
                                        <input type="submit" value="แก้ไขข้อมูล" class="bt_black" id="bt_edit_signin">
                                        <input type="button" value="ออกจากระบบ" class="bt_black" onclick="location = '?Logout=yes';
                                                        return false;">
                                    </div>
                                    <div style="clear: both;"></div>
                                </form>
                                <script>
                                    // signin Admin code
                                    $(document).ready(function () {
                                        $("#bt_edit_signin").click(function () {
                                            var error = "";
                                            $("#check_signin.edit.employee .tx_signin").each(function () {
                                                if ($.trim($(this).val()) == "") {
                                                    error += "กรุณากรอก : " + $(this).attr('placeholder') + "<br />"
                                                    $(this).addClass("focus-warning");
                                                } else {
                                                    if ($(this).attr('name') == "input_tel") {
                                                        error = ($.isNumeric($(this).val())) ? error += "" : error += "กรุณากรอก เบอร์โทรเป็นตัวเลข <br />";
                                                    }
                                                }
                                            });
                                            if (error == "") {
                                                edit_employee_mySelf(".employee");
                                            } else {
                                                $("#member_myselfError").removeAttr('class').addClass("warning-problem").html(error);
                                            }
                                            return false;
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <!-------------------------------- /Employee Edit ---------------------------------------------->
                    <?php } ?>
                <?php } ?>
            </div>
            <!-----------------------------------/ login ------------------------------------->

            <!----------------------------------- signin ------------------------------->
            <div id="artical" class="container signin" style="margin-top: 5px;margin-bottom: 10px;">
                <div class="inner_border">
                    <h3 class="topic bg_img">
                        สมัครสมาชิก <?= $WEB_THAI_NAME ?>
                    </h3>
                    <div class="inner">
                        <div class="inner-w border-inner">
                            <div class="warning" id="error_signin">
                                สมัครเป็นลูกค้าสมาชิก เพื่อซื้อสินค้าของเรา ได้ที่นี่
                            </div>
                            <form id="check_signin" method="POST" class="signin">
                                <p>ชื่อ-สกุล :</p>
                                <input type="text" name="input_name" placeholder=" Name - Lastname" required="" class="tx_signin">
                                <p>ชื่อผู้ใช้ :</p>
                                <input type="text" name="input_user" placeholder=" Username" maxlength="15" required="" class="tx_signin">
                                <p>รหัสผ่าน :</p>
                                <input type="password" name="input_pass" id="input_pass" placeholder=" Password" maxlength="15" required="" class="tx_signin">
                                <p>ยืนยันรหัสผ่าน :</p>
                                <input type="password" name="input_passConfirm" placeholder=" Confirm Password" maxlength="15" required="" class="tx_signin">
                                <p>รหัสประจำตัวประชาชน :</p>
                                <input type="text" name="input_code" placeholder=" Identification Number" maxlength="13" required="" class="tx_signin">
                                <p>ที่อยู่ :</p>
                                <textarea name="input_address" placeholder=" Address" required="" class="tx_signin"></textarea>
                                <p>เบอร์โทร :</p>
                                <input type="text" name="input_tel" placeholder=" Phone Number" maxlength="10" required="" class="tx_signin">
                                <p>อีเมล์ :</p>
                                <input type="text" name="input_email" placeholder=" E-mail" required="" class="tx_signin">
                                <div class="bt_login">
                                    <input type="submit" value="สมัครสมาชิก" class="bt_black" id="bt_signin">
                                    <input type="reset" value="ล้างข้อมูล" class="bt_black reset">
                                </div>
                                <div style="clear: both;"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <script>
                    // signin manager code
                    $(document).ready(function () {
                        $("#bt_signin").click(function () {
                            var error = "";
                            $("#check_signin.signin .tx_signin").each(function () {
                                if ($(this).val() != "") {
                                    if ($(this).attr('name') == "input_user") {
                                        error = ($(this).val().length >= 6) ? error += "" : error += "กรุณากรอก Username เป็น 0-9 หรือ a-z 6-15 ตัว<br />";
                                    }
                                    if ($(this).attr('name') == "input_passConfirm") {
                                        error = ($(this).val() == $("#input_pass").val()) ? error += "" : error += "กรุณากรอก Password และ Confirm Password ให้ตรงกัน <br />";
                                    }
                                    if ($(this).attr('name') == "input_code") {
                                        if ($.isNumeric($(this).val())) {
                                            error = ($(this).val().length == 13) ? error += "" : error += "กรุณากรอก รหัสประจำตัวประชาชนเป็นตัวเลข 13 หลัก <br />";
                                        } else {
                                            error += "กรุณากรอก รหัสประจำตัวประชาชนเป็นตัวเลข <br />";
                                        }
                                    }
                                    if ($(this).attr('name') == "input_tel") {
                                        error = ($.isNumeric($(this).val())) ? error += "" : error += "กรุณากรอก เบอร์โทรเป็นตัวเลข <br />";
                                    }
                                    $(this).removeClass('focus-warning');
                                } else {
                                    error += "กรุณากรอก ช่อง : " + $(this).attr('placeholder') + " ให้เรียบร้อย !<br />";
                                    $(this).addClass('focus-warning');
                                }
                            });
                            if ($.trim(error) == "") {
                                signin_member("#check_signin.signin");
                            } else {
                                $("#error_signin").removeAttr('class').addClass('warning-problem').html(error);
                            }
                            return false;
                        });
                        $("#check_signin .reset").click(function () {
                            $("#check_signin.signin *").removeClass("focus-warning");
                            $("#error_signin").removeAttr('class').addClass("warning").html("สมัครเป็นลูกค้าสมาชิก เพื่อซื้อสินค้าของเรา ได้ที่นี่");
                        });
                        /*----------------------- delete Search -----------------------------*/
                        $("div.search").css("display", "none");
                        $(".nav-header_top").css("float", "right");
                        $(".dialog_user").css("right", "800%");
                        /*----------------------- /delete Search -----------------------------*/
                    });
                </script>
            </div>
            <!-----------------------------------/ signin ------------------------------------->
        </div>
        <?php require './footer.php'; ?>
        <script src="script_before_shop.js"></script>
        <script src="script_connectServer.js"></script>
    </body>
</html>
