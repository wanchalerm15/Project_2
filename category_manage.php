<div id="artical" class="main_aftershop top_main">
    <h3 class="topic"><img class="add"> <span>จัดการประเภทเครื่องดนตรี</span></h3>
    <div class="in_main">
        <?php
        $end_row = $WEB_AFTERSHOP_NUMROW;
        $mysql_numrow = mysql_num_rows(mysql_query("SELECT * FROM category"));
        $numrow = ceil($mysql_numrow / $end_row);
        if (isset($_GET['row'])) {
            if ($_GET['row'] > $numrow) {
                echo "<script>location='?manage=category&row=$numrow#top';</script>";
            }
            $num_page = $_GET['row'];
            $start_row = ($_GET['row'] - 1) * $end_row;
        } else {
            $r = 1;
            $num_page = 1;
            $start_row = 0;
        }
        if (isset($_POST['search_category'])) {
            $search_category = $_POST['search_category'];
            $query = "SELECT * FROM category WHERE category_name like('%$search_category%') ORDER BY category_id";
            ?>
            <p class="warning" id="top">
                ผลการค้นหา ประเภทสินค้าเครื่องดนตรี "<?= $search_category ?>"  <?= mysql_num_rows(mysql_query($query)) ?> ประเภท
            </p>
            <?php
        } else {
            $query = "SELECT * FROM category ORDER BY category_id LIMIT $start_row,$end_row";
            ?>
            <p class="warning" id="top">
                มีรายการประเภทสินค้าเครื่องดนตรีทั้งหมด  <?= $mysql_numrow ?> ประเภท
                มีหน้าที่แสดงทั้งหมด <?= $numrow ?> หน้า
            </p>
            <?php
        }
        $result = mysql_query($query);
        ?>
        <p class="title">
            <img class="add">
            <span>รายการประเภทสินค้าเครื่องดนตรี</span>
        </p>
        <table class="table_aftershop" id="show_table_category">
            <tr>
                <td>#รหัสประเภท</td>
                <td>#ชื่อประเภท</td>
                <td class="show_date">#วันที่แก้ไข</td>
                <td>#ลบ</td>
            </tr>
            <?php if (mysql_num_rows(mysql_query("SELECT * FROM category")) <= 0) { ?>
                <tr>
                    <td colspan="4" style="text-align: left;">ไม่มีรายการในระบบ</td>
                </tr>
            <?php } elseif (mysql_num_rows(mysql_query($query)) <= 0) { ?>
                <tr>
                    <td colspan="4" style="text-align: left;">ไม่มีรายการในระบบ</td>
                </tr>
            <?php } else { ?>
                <?php while ($category = mysql_fetch_array($result)) {
                    ?>
                    <tr class="category_id_<?= $category['category_id'] ?>">
                        <td>
                            <a title="ต้องการแก้ไข คลิ๊ก!"
                               onclick="update_category(<?= $category['category_id'] ?>, 50, 5,<?= $start_row ?>,<?= $end_row ?>);">
                                C<?= $category['category_id'] ?>
                            </a>
                        </td>
                        <td>
                            <?= $category['category_name'] ?>
                        </td>
                        <td class="show_date"><?= $category['date_input'] ?></td>
                        <td>
                            <input type="checkbox" class="delete_check" value="<?= $category['category_id'] ?>">
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
                            data += "C" + $(this).val();
                        } else {
                            data += "C" + $(this).val() + ", ";
                        }
                    });
                    data += " ] ";

                    if (confirm("คุณต้องการลบรายการที่" + data + "นี้จริงหรือ !")) {
                        delete_category_arrlay();
                    }
                });
            });
        </script>
        <?php if (!isset($_POST['search_category'])) { ?>
            <div class="part_row">
                <a href="?manage=category&row=<?= $_GET['row'] - ($r + 1) ?>#top" class="past">ก่อนหน้า</a>
                <span>
                    |
                    <select class="select" onchange="change_row_Aftershop(this, 'category')">
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
                <a href="?manage=category&row=<?= $_GET['row'] + ($r + 1) ?>#top" class="past">ถัดไป</a>
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
<!------------------------------ add category ---------------------------------------->
<div id="artical" class="main_aftershop bottom_main">
    <div class="in_main">
        <p class="title">
            <img class="add">
            เพิ่มประเภทสินคัาเครื่องดนตรี
        </p>
        <div class="warning" id="add_category_error">
            เพิ่มประเภทสินค้า ได้โดยกรอกข้อมูลลงไปแล้วกด ปุ่ม เพิ่มประเภทสินค้า
        </div>
        <form id="add_category">
            <span>
                <input type="text" class="text" name="input_category" placeholder="กรอกประเภทสินค้าเครื่องดนตรีที่จะเพื่ม" required="">
                <button class="btsub" id="add_category-bt"> <img src="images/add_icon.png" style="height: 14px;vertical-align: top;"> เพิ่มประเภทสินค้า </button>
            </span>
        </form>
    </div>
    <script>
        $(document).ready(function () {
            $('#add_category-bt').click(function () {
                if ($.trim($('#add_category .text').val()) != "") {
                    add_category();
                } else {
                    $('#add_category_error').removeAttr('class').addClass('warning-problem').html('ข้อมูลที่เพิ่มเป็นค่าว่าง !');
                }
                return false;
            });
        });
    </script>
</div>