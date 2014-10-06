<div id="artical" class="main_aftershop top_main">
    <h3 class="topic"><img class="add"> <span>จัดการระบบพนักงาน</span></h3>
    <div class="in_main">
        <?php
        $end_row = $WEB_AFTERSHOP_NUMROW;
        $mysql_numrow = mysql_num_rows(mysql_query("SELECT * FROM employee"));
        $numrow = ceil($mysql_numrow / $end_row);
        if (isset($_GET['row'])) {
            if ($_GET['row'] > $numrow) {
                echo "<script>location='?manage=employee&row=$numrow#top';</script>";
            }
            $num_page = $_GET['row'];
            $start_row = ($_GET['row'] - 1) * $end_row;
        } else {
            $r = 1;
            $num_page = 1;
            $start_row = 0;
        }
        if (isset($_POST['search_employee'])) {
            $search_employee = $_POST['search_employee'];
            $query = "SELECT * FROM employee WHERE employee_name like('%$search_employee%') ORDER BY employee_id";
            ?>
            <p class="warning" id="top">
                ผลการค้นหาพนักงาน  "<?= $search_employee ?>" 
                พบ <?= mysql_num_rows(mysql_query($query)) ?> รายการ
            </p>
            <?php
        } else {
            $query = "SELECT * FROM employee ORDER BY employee_id LIMIT $start_row,$end_row";
            ?>
            <p class="warning" id="top">
                มีพนักงานภายในระบบทั้งหมด  <?= $mysql_numrow ?> คน
                มีหน้าที่แสดงรายการทั้งหมด <?= $numrow ?> หน้า
            </p>
            <?php
        }
        $result = mysql_query($query);
        ?>
        <p class="title">
            <img class="add">
            <span>รายการข้อมูลพนักงานในระบบ</span>
        </p>
        <table class="table_aftershop" id="show_table_category">
            <tr>
                <td>#รหัสพนักงาน</td>
                <td>#ชื่อพนักงาน</td>
                <td class="show_date">#Username</td>
                <td class="show_date">#วันที่แก้ไข</td>
                <td>#ลบ</td>
            </tr>
            <?php if (mysql_num_rows(mysql_query("SELECT * FROM employee")) <= 0) { ?>
                <tr>
                    <td colspan="5" style="text-align: left;">ไม่มีรายการในระบบ</td>
                </tr>
            <?php } elseif (mysql_num_rows(mysql_query($query)) <= 0) { ?>
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
                        <td class="show_date"><?= $employee['employee_user'] ?></td>
                        <td class="show_date"><?= $employee['input_date'] ?></td>
                        <td>
                            <input type="checkbox" class="delete_check" value="<?= $employee['employee_id'] ?>">
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
                            data += "E" + $(this).val();
                        } else {
                            data += "E" + $(this).val() + ", ";
                        }
                    });
                    data += " ] ";

                    if (confirm("คุณต้องการลบรายการที่" + data + "นี้จริงหรือ !")) {
                        delete_employee_arrlay();
                    }
                });
            });
        </script>
        <?php if (!isset($_POST['search_employee'])) { ?>
            <div class="part_row">
                <a href="?manage=employee&row=<?= $_GET['row'] - ($r + 1) ?>#top" class="past">ก่อนหน้า</a>
                <span>
                    |
                    <select onchange="change_row_Aftershop(this, 'employee')" class="select">
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
                <a href="?manage=employee&row=<?= $_GET['row'] + ($r + 1) ?>#top" class="past">ถัดไป</a>
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
<div id="artical" class="main_aftershop bottom_main">
    <div class="in_main">
        <p class="title">
            <img class="add">
            เพิ่มข้อมูลพนักงาน
        </p>
        <div class="warning" id="add_employee_error">
            จะเพิ่มพนักงานเข้าสู่ระบบได้ จะต้องกรอกข้อมูลในส่วนที่มี ตราสัญลักษณ์ <span style="color: #F00;"> * </span> ด้านหลัง
        </div>
        <form id="add_emplooyee" method="POST">
            <p>
                <span>ชื่อ - สกุล :</span>
                <span>
                    <input type="text" class="text" placeholder=" Please Enter Name-Lastname" required="" name="input_name_emp">
                    <span id="important_Symbols"></span>
                </span>
            </p>
            <p>
                <span>ชื่อผู้ใช้ :</span>
                <span> 
                    <input type="text" class="text" maxlength="15"
                           placeholder=" Please Enter Username" required="" name="input_user_emp" id="input_user_emp">
                    <span id="important_Symbols"></span>
                </span>
            </p>
            <p>
                <span>รหัสผ่าน :</span>
                <span> 
                    <input type="password" class="text" maxlength="15" min="5"
                           placeholder=" Please Enter Password" required="" name="input_pass_emp">
                    <span id="important_Symbols"></span>
                </span>
            </p>
            <p>
                <span>รหัสประจำตัวประชาชน :</span>
                <span> 
                    <input type="text" class="text" maxlength="13"
                           placeholder=" Please Enter Identification Number" required="" name="input_Iden_emp" id="input_Iden_emp">
                    <span id="important_Symbols"></span>
                </span>
            </p>
            <p>
                <span>การศึกษา :</span>
                <span> 
                    <textarea class="text" placeholder=" Please Enter Education" name="input_edu_emp"></textarea>
                </span>
            </p>
            <p>
                <span>เงินเดือน :</span>
                <span> 
                    <input type="text" class="text" placeholder=" Please Enter Salary" name="input_salary_emp" id="input_salary_emp">
                </span>
            </p>
            <p>
                <span>ที่อยู่ :</span>
                <span> 
                    <textarea class="text" placeholder=" Please Enter Address" required="" name="input_address_emp"></textarea>
                    <span id="important_Symbols"></span>
                </span>
            </p>
            <p>
                <span>เบอร์โทรศัพท์ :</span>
                <span> 
                    <input type="text" class="text" maxlength="10"
                           placeholder=" Please Enter Telephone" required="" name="input_tel_emp" id="input_tel_emp">
                    <span id="important_Symbols"></span>
                </span>
            </p>
            <p>
                <span>อีเมล์ :</span>
                <span> 
                    <input type="text" class="text" placeholder=" Please Enter E-mail" required="" name="input_email_emp">
                    <span id="important_Symbols"></span>
                </span>
            </p>
            <p style="text-align: center;">
                <input type="submit" class="btsub" value="เพิ่มข้อมูล" id="bt_add_emplooyee">
                <input type="reset" class="btsub" value="ล้างข้อมูล" id="clearn_data_emp">
            </p>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#clearn_data_emp").click(function () {
            var data = " จะเพิ่มพนักงานเข้าสู่ระบบได้ จะต้องกรอกข้อมูลในส่วนที่มี ตราสัญลักษณ์ <span style=\"color: #F00; \"> * </span> ด้านหลัง";
            $("#add_employee_error").removeAttr("class").addClass("warning").html(data);
        });
        $("#input_user_emp").keyup(function () {
            check_add_reg("#add_employee_error", "employee", "employee_user", $(this).val(), "username", 0);
        });
        $("#input_Iden_emp").keyup(function () {
            if ($.isNumeric($(this).val())) {
                if ($("#input_Iden_emp").val().length == 13) {
                    check_add_reg("#add_employee_error", "employee", "employee_identification", $(this).val(), "รหัสประจำตัวประชาชน", 0);
                } else {
                    $("#add_employee_error").removeAttr("class").addClass("warning-problem").html("ท่านกรอก เลขประจำตัวประชาชนไม่ครบ 13 หลัก");
                }
            } else {
                $("#add_employee_error").removeAttr("class").addClass("warning-problem").html("กรุณากรอกเลขประจำตัวประชาชน เป็นตัวเลข");
            }
        });
        /*---------------------------------------- bt ---------------------------------------------------*/
        $("#bt_add_emplooyee").click(function () {
            var empy = "";
            $("#add_emplooyee .text").each(function (index) {
                if ($(this).attr("name") == "input_edu_emp" || $(this).attr("name") == "input_salary_emp") {
                } else {
                    if ($.trim($(this).val()) == "") {
                        empy += "ช่องที่มีข้อความ : " + $(this).attr("placeholder") + " ว่าง!<br />";
                    }
                }
            });
            if ($.trim(empy) == "") {
                if ($.isNumeric($("#input_Iden_emp").val())) {
                    if ($("#input_Iden_emp").val().length < 13) {
                        empy += " ท่านกรอก เลขประจำตัวประชาชนไม่ครบ 13 หลัก<br />";
                    }
                } else {
                    empy += " กรุณากรอกเลขประจำตัวประชาชน เป็นตัวเลข<br />";
                }
                if (!$.isNumeric($("#input_tel_emp").val())) {
                    empy += " เบอร์โทรศัพท์ ควรกรอกเป็นตัวเลข<br />";
                }
            }
            if ($.trim(empy) == "") {
                add_employee();
            } else {
                $("#add_employee_error").removeAttr("class").addClass("warning-problem").html(empy);
            }
            return false;
        });
    });
</script>
