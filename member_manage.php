<div id="artical" class="main_aftershop top_main">
    <h3 class="topic"><img class="add"> <span>จัดการระบบลูกค้าสมาชิก</span></h3>
    <div class="in_main">
        <?php
        $end_row = $WEB_AFTERSHOP_NUMROW;
        $mysql_numrow = mysql_num_rows(mysql_query("SELECT * FROM member"));
        $numrow = ceil($mysql_numrow / $end_row);
        if (isset($_GET['row'])) {
            if ($_GET['row'] > $numrow) {
                echo "<script>location='?manage=member&row=$numrow#top';</script>";
            }
            $num_page = $_GET['row'];
            $start_row = ($_GET['row'] - 1) * $end_row;
        } else {
            $r = 1;
            $num_page = 1;
            $start_row = 0;
        }
        if (isset($_POST['search_member'])) {
            $search_member = $_POST['search_member'];
            $query = "SELECT * FROM member WHERE member_name like('%$search_member%') ORDER BY member_id";
            ?>
            <p class="warning" id="top">
                ผลการค้นหาลูกค้าสมาชิก  "<?= $search_member ?>"
                พบ <?= mysql_num_rows(mysql_query($query)) ?> รายการ
            </p>
            <?php
        } else {
            $query = "SELECT * FROM member ORDER BY member_id LIMIT $start_row,$end_row";
            ?>
            <p class="warning" id="top">
                มีลูกค้าสมาชิกภายในระบบทั้งหมด  <?= $mysql_numrow ?> คน
                มีหน้าที่แสดงรายการลูกค้าสมาชิกทั้งหมด <?= $numrow ?> หน้า
            </p>
            <?php
        }
        $result = mysql_query($query);
        ?>
        <p class="title">
            <img class="add">
            <span>รายการข้อมูลลูกค้าสมาชิกในระบบ</span>
        </p>
        <table class="table_aftershop" id="show_table_category">
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
            <?php } elseif (mysql_num_rows(mysql_query($query)) <= 0) { ?>
                <tr>
                    <td colspan="5" style="text-align: left;">ไม่มีรายการในระบบ</td>
                </tr>
                <?php
            } else {
                while ($member = mysql_fetch_array($result)) {
                    ?>
                    <?php $member_id = "M" . $member['member_id']; ?>
                    <tr class="member_id_<?= $member['member_id'] ?>">
                        <td><?= $member_id ?></td>
                        <td>
                            <a title="ต้องการแก้ไข คลิ๊ก!" onclick="show_update_member(<?= $member['member_id'] ?>, 70, 0,<?= $start_row ?>,<?= $end_row ?>);">
                                <?= $member['member_name'] ?>
                            </a>
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
                            data += "M" + $(this).val();
                        } else {
                            data += "M" + $(this).val() + ", ";
                        }
                    });
                    data += " ] ";

                    if (confirm("คุณต้องการลบรายการที่" + data + "นี้จริงหรือ !")) {
                        delete_member_arrlay();
                    }
                });
            });
        </script>
        <?php if (isset($_POST['search_member'])) { ?>
            <div class="part_row">
                <a href="?manage=member&row=<?= $_GET['row'] - ($r + 1) ?>#top" class="past">ก่อนหน้า</a>
                <span>
                    |
                    <select onchange="change_row_Aftershop(this, 'member')" class="select">
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
                <a href="?manage=member&row=<?= $_GET['row'] + ($r + 1) ?>#top" class="past">ถัดไป</a>
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
            เพิ่มข้อมูลลูกค้าสมาชิก
        </p>
        <div class="warning" id="add_member_error">
            จะเพิ่มลูกค้าสมาชิกเข้าสู่ระบบได้ จะต้องกรอกข้อมูลในส่วนที่มี ตราสัญลักษณ์ <span style="color: #F00;"> * </span> ด้านหลัง
        </div>
        <form id="add_member" method="POST">
            <p>
                <span>ชื่อ - สกุล :</span>
                <span>
                    <input type="text" class="text" placeholder=" Please Enter Name-Lastname" required="" name="member_name">
                    <span id="important_Symbols"></span>
                </span>
            </p>
            <p>
                <span>ชื่อผู้ใช้ :</span>
                <span> 
                    <input type="text" class="text" maxlength="15"
                           placeholder=" Please Enter Username" required="" name="member_user" id="member_user">
                    <span id="important_Symbols"></span>
                </span>
            </p>
            <p>
                <span>รหัสผ่าน :</span>
                <span> 
                    <input type="password" class="text" maxlength="15" min="5"
                           placeholder=" Please Enter Password" required="" name="member_pass">
                    <span id="important_Symbols"></span>
                </span>
            </p>
            <p>
                <span>รหัสประจำตัวประชาชน :</span>
                <span> 
                    <input type="text" class="text" maxlength="13"
                           placeholder=" Please Enter Identification Number" required="" name="member_identification" id="member_identification">
                    <span id="important_Symbols"></span>
                </span>
            </p>
            <p>
                <span>ที่อยู่ :</span>
                <span> 
                    <textarea class="text" placeholder=" Please Enter Address" required="" name="member_address"></textarea>
                    <span id="important_Symbols"></span>
                </span>
            </p>
            <p>
                <span>เบอร์โทรศัพท์ :</span>
                <span> 
                    <input type="text" class="text" maxlength="10"
                           placeholder=" Please Enter Telephone" required="" name="member_tel" id="member_tel">
                    <span id="important_Symbols"></span>
                </span>
            </p>
            <p>
                <span>อีเมล์ :</span>
                <span> 
                    <input type="text" class="text" placeholder=" Please Enter E-mail" required="" name="member_email">
                    <span id="important_Symbols"></span>
                </span>
            </p>
            <p style="text-align: center;">
                <input type="submit" class="btsub" value="เพิ่มข้อมูล" id="bt_add_member">
                <input type="reset" class="btsub" value="ล้างข้อมูล" id="clearn_data_member">
            </p>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#member_user").keyup(function () {
            check_add_reg("#add_member_error", "member", "member_user", $(this).val(), "Username", 0);
        });
        $("#member_identification").keyup(function () {
            if ($.isNumeric($(this).val())) {
                if ($(this).val().length == 13) {
                    check_code("#add_member_error", "member", "member_identification", $(this).val(), "Username", 0);
                }
            } else {
                $('#add_member_error').removeAttr('class').addClass('warning-problem').html("กรุณากรอกหมายเลขประจำตัวประชาชนเป็นตัวเลข");
            }
        });
        $('#bt_add_member').click(function () {
            var data = "";
            $("#add_member .text").each(function () {
                if ($.trim($(this).val()) == "") {
                    data += $(this).attr('placeholder') + " ว่าง <br />";
                }
            });
            if (data == "") {
                if ($.isNumeric($("#member_identification").val())) {
                    if ($("#member_identification").val().length == 13) {
                        if ($.isNumeric($("#member_tel").val())) {
                            add_member();
                        } else {
                            $('#add_member_error').removeAttr('class').addClass('warning-problem').html("กรุณากรอกหมายเลขโทรศัพท์เป็นตัวเลข");
                        }
                    } else {
                        $('#add_member_error').removeAttr('class').addClass('warning-problem').html("กรุณากรอกหมายเลขประจำตัวประชาชนให้ครบ 13 ตัว");
                    }
                } else {
                    $('#add_member_error').removeAttr('class').addClass('warning-problem').html("กรุณากรอกหมายเลขประจำตัวประชาชนเป็นตัวเลข");
                }
            } else {
                $('#add_member_error').removeAttr('class').addClass('warning-problem').html(data);
            }
            return false;
        });
        $('#clearn_data_member').click(function () {
            var data = "จะเพิ่มลูกค้าสมาชิกเข้าสู่ระบบได้ จะต้องกรอกข้อมูลในส่วนที่มี ตราสัญลักษณ์ <span style=\"color: #F00; \"> * </span> ด้านหลัง";
            $('#add_member_error').removeAttr('class').addClass('warning').html(data);
        });
    });
</script>