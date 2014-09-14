<div id="artical" class="main_aftershop top_main">
    <h3 class="topic">
        <img class="add">
        จัดการสินค้าเครื่องดนตรี
    </h3>
    <div class="in_main">
        <?php
        $end_row = $WEB_AFTERSHOP_NUMROW;
        $mysql_numrow = mysql_num_rows(mysql_query("SELECT * FROM product"));
        $numrow = ceil($mysql_numrow / $end_row);
        if (isset($_GET['row'])) {
            if ($_GET['row'] > $numrow) {
                echo "<script>location='?manage=product&row=$numrow#top';</script>";
            }
            $num_page = $_GET['row'];
            $start_row = ($_GET['row'] - 1) * $end_row;
        } else {
            $r = 1;
            $num_page = 1;
            $start_row = 0;
        }
        $query = "SELECT * FROM product ORDER BY product_id LIMIT $start_row,$end_row";
        $result = mysql_query($query);
        ?>
        <p class="warning" id="top">
            มีรายการสินค้าเครื่องดนตรีภายในระบบทั้งหมด  <?= $mysql_numrow ?> รายการ
            มีหน้าที่แสดงรายการสินค้าเครื่องดนตรีทั้งหมด <?= $numrow ?> หน้า
        </p>
        <p class="title">
            <img class="add">
            รายการสินค้าเครื่องดนตรี
        </p>
        <div style="display: none;" id="show_edit_product">

        </div>
        <table class="table_aftershop" id="show_table_category">
            <tr>
                <td>#รหัสสินค้า</td>
                <td>#ชื่อสินค้า</td>
                <td class="show_date">#ราคาสินค้า</td>
                <td>#จำนวนสินค้า</td>
                <td class="show_date">#ประเภทสินค้า</td>
                <td class="show_date">#วันที่แก้ไข</td>
                <td>#ลบ</td>
            </tr>
            <?php if (mysql_num_rows(mysql_query("SELECT * FROM product")) <= 0) { ?>
                <tr>
                    <td colspan="7" style="text-align: left;">ไม่มีรายการในระบบ</td>
                </tr>
                <?php
            } else {
                while ($product = mysql_fetch_array($result)) {
                    ?>
                    <?php $product_id = "P" . $product['product_id']; ?>
                    <tr class="product_id_<?= $product['product_id'] ?>">
                        <td><?= $product_id ?></td>
                        <td>
                            <a title="ต้องการแก้ไข คลิ๊ก!" onclick="show_edit_product('<?= $product['product_name'] ?>',<?= $product['product_id'] ?>);">
                                <?= $product['product_name'] ?>
                            </a>
                        </td>
                        <td class="show_date"><?= $product['product_price'] ?></td>
                        <td><?= $product['product_unit'] ?></td>
                        <td class="show_date">
                            <?php
                            $category_result = mysql_query("SELECT * FROM category WHERE category_id=" . $product['category_id']);
                            $category = mysql_fetch_array($category_result);
                            echo $category['category_name'];
                            ?>
                        </td>
                        <td class="show_date"><?= $product['date_input'] ?></td>
                        <td>
                            <input type="checkbox" class="delete_check" value="<?= $product['product_id'] ?>">
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
            $(document).ready(function() {
                $("#delete_data").click(function() {
                    var data = " [ ";
                    $(":checkbox.delete_check:checked").each(function(index) {
                        if (($(":checkbox.delete_check:checked").length - 1) == index) {
                            data += "P" + $(this).val();
                        } else {
                            data += "P" + $(this).val() + ", ";
                        }
                    });
                    data += " ] ";

                    if (confirm("คุณต้องการลบรายการที่" + data + "นี้จริงหรือ !")) {
                        delete_product_array();
                    }
                });
            });
        </script>
        <div class="part_row">
            <a href="?manage=product&row=<?= $_GET['row'] - ($r + 1) ?>#top" class="past">ก่อนหน้า</a>
            <span>
                |
                <select onchange="change_row_Aftershop(this, 'product')" class="select">
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
            <a href="?manage=product&row=<?= $_GET['row'] + ($r + 1) ?>#top" class="past">ถัดไป</a>
        </div>
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
<div id="artical" class="main_aftershop">
    <div class="in_main">
        <p class="title">
            <img class="add">
            เพิ่มสินค้าเครื่องดนตรี
        </p>
        <p class="warning" id="add_product_error">
            จะเพิ่มสินค้าเครื่องดนตรีเข้าสู่ระบบได้ จะต้องกรอกข้อมูลในส่วนที่มี ตราสัญลักษณ์ <span style="color: #F00;"> * </span> ด้านหลัง
        </p>
        <div class="iframe_crop">
            <h3 class="topic">
                <img class="add">
                หน้าต่างอัพโหลด
            </h3>
            <button class="btsub" onclick="location.reload();">ปิดหน้าต่าง</button>
            <iframe name="updoad_file" class="updoad_file_ifm" frameborder="0">
            บาวเซอร์ไม่รองรับ iframe
            </iframe>
        </div>
        <form id="add_product" enctype="multipart/form-data" action="web_server_script/product.php?add_product=1" method="POST" target="updoad_file">
            <p>
                <span>
                    ประเภทสินค้าเครื่องดนตรี :
                </span>
                <span>
                    <select class="select" name="category_id" id="category_id">
                        <option value="0">กรุณาเลือกประเภทสินค้า</option>
                        <?php
                        $query = "SELECT * FROM category";
                        $result = mysql_query($query);
                        ?>
                        <?php while ($category = mysql_fetch_array($result)) { ?>
                            <option value="<?= $category['category_id'] ?>"><?= $category['category_name'] ?></option>
                        <?php } ?>
                    </select>
                    <span id="important_Symbols"></span>
                </span>
            </p>
            <p>
                <span>
                    ชื่อสินค้าเครื่องดนตรี :
                </span>
                <span>
                    <input type="text" placeholder="Enter Name Product" class="text" name="product_name" id="product_name">
                    <span id="important_Symbols"></span>
                </span>
            </p>
            <p>
                <span>
                    ราคาสินค้าเครื่องดนตรี :
                </span>
                <span>
                    <input type="text" placeholder="Enter Price Product" class="text" name="product_price" id="product_price">
                    <span id="important_Symbols"></span>
                </span>
            </p>
            <p>
                <span>
                    จำนวนสินค้าเครื่องดนตรี :
                </span>
                <span>
                    <input type="text" placeholder="Enter Unit Product" class="text" name="product_unit" id="product_unit">
                    <span id="important_Symbols"></span>
                </span>
            </p>
            <p>
                <span>
                    ภาพสินค้าเครื่องดนตรี :
                </span>
                <span>
                    <input type="file" name="product_image[]" multiple="" accept="image/*" id="product_image">
                </span>
            </p>
            <p>
                <span>
                    เสียงสินค้าเครื่องดนตรี :
                </span>
                <span>
                    <input type="file" name="product_sound" accept="audio/*" id="product_sound">
                </span>
            </p>
            <p style="text-align: center;">
                <button class="btsub" type="submit" id="add_product-bt">เพิ่มสินค้าเครื่องดนตรี</button>
                <button class="btsub" type="reset" id="add_product-rs">ล้างข้อมูล</button>
            </p>
        </form>
        <script>
            function showUpload_error(error, product_id) {
                if (error == 1) {
                    show_img_product(product_id);
                }
                if (error == 2) {
                    showProduct_sound(product_id);
                }
            }
            $(document).ready(function() {
                $("#product_name").keyup(function() {
                    check_code("#add_product_error", "product", "product_name", $(this).val(), "ชื่อสินค้าเครื่องดนตรี", 0);
                });
                $("#add_product-rs").click(function() {
                    var warning = "จะเพิ่มสินค้าเครื่องดนตรีเข้าสู่ระบบได้ จะต้องกรอกข้อมูลในส่วนที่มี ตราสัญลักษณ์ <span style='color: #F00;'> * </span> ด้านหลัง";
                    $("#add_product_error").removeAttr("class").addClass("warning").html(warning);
                });
                $("#add_product-bt").click(function() {
                    var category_id = $.trim($("#category_id").val());
                    var product_name = $.trim($("#product_name").val());
                    var product_price = $.trim($("#product_price").val());
                    var product_unit = $.trim($("#product_unit").val());
                    if (category_id != "" && product_name != "" && product_price != "" && product_unit != "") {
                        if (category_id != 0) {
                            if ($.isNumeric(product_price)) {
                                if ($.isNumeric(product_unit)) {
                                    var upload_image = $("#product_image").val();
                                    var upload_sound = $("#product_sound").val();
                                    if (upload_image != "" || upload_sound != "") {
                                        $(".iframe_crop").fadeIn();
                                        $("#add_product_error").hide();
                                        $("#add_product").hide();
                                        return true;
                                    } else {
                                        var data = $("#add_product").serialize();
                                        add_product(data);
                                    }
                                } else {
                                    var warning = "จำนวนสินค้าเครื่องดนตรี ต้องเป็นตัวเลข";
                                    $("#add_product_error").removeAttr("class").addClass("warning-problem").html(warning);
                                }
                            } else {
                                var warning = "ราคาสินค้าเครื่องดนตรี ต้องเป็นตัวเลขหรือ ทศนิยม";
                                $("#add_product_error").removeAttr("class").addClass("warning-problem").html(warning);
                            }
                        } else {
                            var warning = "กรุณาเลือกประเภทสินค้า";
                            $("#add_product_error").removeAttr("class").addClass("warning-problem").html(warning);
                        }
                    } else {
                        var warning = "ข้อมูลว่าง ! กรุณากรอกข้อมูลที่มีเครื่องหมาย <span style='color: #F00;'> * </span> ให้ครบ";
                        $("#add_product_error").removeAttr("class").addClass("warning-problem").html(warning);
                    }
                    return false;
                });
            });
        </script>
    </div>
</div>

