<?php
session_start();
include './connect_DB.php';
require './php_function.php';
if ($_REQUEST["add_product"] == 1) {
    $category_id = $_REQUEST['category_id'];
    $product_name = $_REQUEST['product_name'];
    $product_price = $_REQUEST['product_price'];
    $product_unit = $_REQUEST['product_unit'];
    $product_cost = $_REQUEST['product_cost'];
    if ($_FILES) {
        $image_product = $_FILES["product_image"]['name'];
        $sound_product = $_FILES["product_sound"]['name'];
        /* ------------------------------------------------------------ Image ----------------------------------------------------------------------- */
        if (!empty($image_product[0])) {
            $img = _upload_Image("../image_product/", "product_image", 1024, 400, 150);
            for ($i = 0; $i < count($img['data']); $i++) {
                if ($img['data'][$i] != "") {
                    if ($i != count($img['data']) - 1) {
                        $image_DB .= $img['data'][$i] . ",";
                    } else {
                        $image_DB .= $img['data'][$i];
                    }
                }
            }
            echo "การอัพโหลดไฟล์ภาพ <u>$product_name</u> : <br />";
            if ($img['sucess'] != "") {
                echo "<div style='width:95%;margin:5px auto;background-color: #d8ffcd;border: solid 1px #36ff00;padding:10px;'>";
                echo $img['sucess'];
                echo "</div>";
            }
            if ($img['error'] != "") {
                echo "<div style='width:95%;margin:5px auto;background-color: #ffe9e9;border: solid 1px #ffaaaa;padding:10px;'>";
                echo $img['error'];
                echo "</div>";
            }
        } else {
            echo "<div style='width:95%;margin:5px auto;background-color: #ffffdd;border: solid 1px #faf500;padding:10px;'>";
            echo "การโหลดภาพ <u>$product_name</u>  ไม่มีการอัพโหลด";
            echo "</div>";
        }
        /* ------------------------------------------------------------ Sound ----------------------------------------------------------------------- */
        if (!empty($sound_product[0])) {
            $sound = _upload_sound("../sound_product/", "product_sound", 5120);
            for ($i = 0; $i < count($sound['data']); $i++) {
                if ($sound['data'][$i] != "") {
                    if ($i != count($sound['data']) - 1) {
                        $sound_DB .= $sound['data'][$i] . ",";
                    } else {
                        $sound_DB .= $sound['data'][$i];
                    }
                }
            }
            echo "การอัพโหลดไฟล์เสียง <u>$product_name</u> : <br />";
            if ($sound['sucess'] != "") {
                echo "<div style='width:95%;margin:5px auto;background-color: #d8ffcd;border: solid 1px #36ff00;padding:10px;'>";
                echo $sound['sucess'];
                echo "</div>";
            }
            if ($sound['error'] != "") {
                echo "<div style='width:95%;margin:5px auto;background-color: #ffe9e9;border: solid 1px #ffaaaa;padding:10px;'>";
                echo $sound['error'];
                echo "</div>";
            }
        } else {
            echo "<div style='width:95%;margin:5px auto;background-color: #ffffdd;border: solid 1px #faf500;padding:10px;'>";
            echo "การโหลดเสียง <u>$product_name</u> ไม่มีการอัพโหลด";
            echo "</div>";
        }
    }
    $query = "INSERT INTO product(category_id,product_name,product_price,product_unit,product_image,product_sound,product_cost,date_input) ";
    $query .= "VALUES($category_id,'$product_name',$product_price,$product_unit,'$image_DB','$sound_DB',$product_cost,NOW())";
    mysql_query($query) or die("ไม่สามารถเพิ่มรายการ $product_name ได้ เนื่องจาก : " . mysql_error());
}

if ($_REQUEST['delete_product_array'] == 1) {
    $delete_array = $_REQUEST['delete_array'];
    if (!count($delete_array)) {
        exit("กรุณาเลือกรายการที่จะลบ!");
    }
    $error = "";
    foreach ($delete_array as $array) {
        $query_select = mysql_query("select * from product where product_id=$array");
        $product = mysql_fetch_array($query_select);
        $img_delete = explode(",", $product['product_image']);
        for ($index1 = 0; $index1 < count($img_delete); $index1++) {
            $img_De = "../image_product/" . $img_delete[$index1];
            $img_De_thum = "../image_product/thumbnail/thumbnails_" . $img_delete[$index1];
            if ($img_delete[$index1] != "") {
                if (file_exists($img_De)) {
                    @unlink($img_De) or die("$img_De ลบไม่ได้ ");
                    if (file_exists($img_De_thum)) {
                        @unlink($img_De_thum) or die("$img_De_thum ลบไม่ได้  ");
                    }
                }
            }
        }
        if ($product['product_sound'] != "") {
            $product_sound = $product['product_sound'];
            $sound_De = "../sound_product/" . $product_sound;
            if (file_exists($sound_De)) {
                @unlink($sound_De) or die("$sound_De ลบไม่ได้ ");
            }
        }
        $query = "DELETE FROM product WHERE product_id=$array";
        if (!mysql_query($query)) {
            $error .= "รหัส $array ไม่สามารถลบได้เนื่องจาก : " . mysql_error() . "<br />";
        }
    }
    if (trim($error) != "") {
        echo "$error";
    }
}
if ($_REQUEST['show_edit_product'] == 1) {
    $product_id = $_REQUEST['product_id'];
    $query = "SELECT * FROM product WHERE product_id=$product_id";
    $result = mysql_query($query);
    $product = mysql_fetch_array($result);
    $productId = $product['product_id'];
    pr
    ?>
    <form id="edit_product">
        <p>
            <span>รหัสสินค้าเครื่องดนตรี : </span>
            <input type="hidden" value="<?= $product_id ?>" name="product_id_main">
            <?php if ($admin_id_session) { ?>
                <span><input type="text" value="<?= $product['product_id'] ?>" class="text" name="product_id"></span>
            <?php } else { ?>
                <span><input type="text" value="<?= $product['product_id'] ?>" class="text" disabled="" name="product_id"></span>
            <?php } ?>
        </p>
        <p>
            <span>
                ประเภทสินค้าเครื่องดนตรี :
            </span>
            <span>
                <select class="select" name="category_id">
                    <?php
                    $query = "SELECT * FROM category";
                    $result = mysql_query($query);
                    ?>
                    <?php
                    while ($category = mysql_fetch_array($result)) {
                        if ($category['category_id'] == $product['category_id']) {
                            ?>
                            <option value="<?= $category['category_id'] ?>" selected=""><?= $category['category_name'] ?></option>
                            <?php
                        } else {
                            ?>
                            <option value="<?= $category['category_id'] ?>"><?= $category['category_name'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </span>
        </p>
        <p>
            <span>ชื่อสินค้าเครื่องดนตรี : </span>
            <span><input type="text" value="<?= $product['product_name'] ?>" class="text" name="product_name"></span>
        </p>
        <p>
            <span>ราคาสินค้าเครื่องดนตรี : </span>
            <span><input type="text" value="<?= $product['product_price'] ?>" class="text" name="product_price"></span>
        </p>
        <p>
            <span>จำนวนสินค้าเครื่องดนตรี : </span>
            <span><input type="text" value="<?= $product['product_unit'] ?>" class="text" name="product_unit"></span>
        </p>
        <p>
            <span>ค่าขนส่งสินค้าเครื่องดนตรี : </span>
            <span><input type="text" value="<?= $product['product_cost'] ?>" class="text" name="product_cost"></span>
        </p>
        <p>
            <span>ภาพสินค้าเครื่องดนตรี : </span>
            <span style="color: red;font-size: 13px;">ดูภาพ[ คลิ๊กที่รูป ]</span>
        </p>
        <div>
            <span></span>
            <span class="show_img_product">
                <?php
                $img = explode(",", $product['product_image']);
                for ($index = 0; $index < count($img); $index++) {
                    if (trim($img[$index] == "")) {
                        ?>
                        <img src='images/no_data.jpg' class='img_product'>
                        <?php
                    } else {
                        ?>
                        <div style="position: relative;display: inline-block;" id="proPic-<?= $index ?>">
                            <img src='image_product/thumbnail/thumbnails_<?= $img[$index] ?>' class='img_edis_product' title='<?= $img[$index] ?>'>
                            <span id="deletePorpic" title='ลบภาพนี้' onclick="deleteProduct_img('<?= $img[$index] ?>',<?= $productId ?>,<?= $index ?>)">
                                &times;
                            </span>
                        </div>
                        <?php
                    }
                }
                ?>
            </span>
        </div>
        <p>
            <span></span>
            <span>
                <button type="button" class="button-3" onclick="upload_img('<?= $productId ?>');">เพิ่มรูปภาพ</button>
            </span>
        </p>
        <div class="show_sound_product">
            <p>
                <span>เสียงสินค้าเครื่องดนตรี : </span>
                <span>
                    <?php if (trim($product['product_sound']) != "") { ?>
                        [ <a href="sound_product/<?= $product['product_sound']; ?>" class="sound_to_load" target="_blank">
                            <?= $product['product_sound']; ?></a> ]
                    <?php } ?>
                </span>
            </p>
            <?php if (trim($product['product_sound']) != "") { ?>
                <p>
                    <span></span>
                    <span class="sound_product">
                        <audio src="sound_product/<?= $product['product_sound']; ?>" controls=""></audio>
                    </span>
                </p>
            <?php } else { ?>
                <p>
                    <span></span>
                    <span>
                        <img src='images/no_data.jpg' class="img_product">
                    </span>
                </p>
            <?php } ?>
            <p>
                <span></span>
                <span>
                    <?php if (trim($product['product_sound']) != "") { ?>
                        <button type="button" class="button-3" onclick="upload_sound(<?= $productId ?>)">เปลี่ยนเสียง</button>
                        <button type="button" class="button-3" 
                                onclick="deleteProduct_sound('<?= $product['product_sound'] ?>',<?= $productId ?>);">
                            ลบเสียง
                        </button>
                    <?php } else { ?>
                        <button type="button" class="button-3" onclick="upload_sound(<?= $productId ?>)">เพิ่มเสียง</button>
                    <?php } ?>
                    <span class="warning-unline" onclick="warning_inlineClose();" id="sound_error">
                        xxxx
                    </span>
                </span>
            </p>
        </div>
        <p class="edit_product-bt">
            <button class="button subbt">
                <img src="images/update_icon.png"> แก้ไขสินค้า
            </button>
            <button class="button del">
                <img src="images/delete_icon_w.png"> ลบ
            </button>
            <button class="button rst" type="reset">
                <img src="images/close.png"> ยกเลิก
            </button>
        </p>
    </form>
    <script>
        $(function () {
            $(".warning-unline").css("display", "none");
            $("#edit_product .button.subbt").click(function () {
                edit_product_main($("#edit_product").serialize());
                return false;
            });
            $("#edit_product .button.del").click(function () {
                delete_product($("#edit_product").serialize());
                return false;
            });
            $("#edit_product .button.rst").click(function () {
                location.reload();
            });
            $("img.img_edis_product").each(function () {
                $(this).click(function () {
                    showProduct_img(this);
                });
            });
        });
    </script>
    <?php
}

if ($_REQUEST['deleteProduct_img'] == 1) {
    $product_id = $_REQUEST['product_id'];
    $image_delete = $_REQUEST['image_delete'];
    $img_array = array();
    $result = mysql_query("select * from product where product_id=$product_id");
    $product = mysql_fetch_array($result);
    $img_de = explode(",", $product['product_image']);
    for ($index = 0; $index < count($img_de); $index++) {
        if ($image_delete != $img_de[$index]) {
            array_push($img_array, $img_de[$index]);
        } else {
            $dir = "../image_product/";
            if (file_exists($dir . $image_delete)) {
                unlink($dir . $image_delete) or die("ลบภาพ " . $dir . $image_delete . "ไม่ได้");

                $dir = "../image_product/thumbnail/thumbnails_";
                if (file_exists($dir . $image_delete)) {
                    unlink($dir . $image_delete) or die("ลบภาพ " . $dir . $image_delete . "ไม่ได้");
                }
            }
        }
    }
    for ($index = 0; $index < count($img_array); $index++) {
        if ($index != count($img_array) - 1) {
            $update_img_DB .= $img_array[$index] . ",";
        } else {
            $update_img_DB .= $img_array[$index];
        }
    }
    $query = "UPDATE product set product_image='$update_img_DB' WHERE product_id=$product_id";
    mysql_query($query) or die("ลบภาพนี้ไม่ได้เนื่องจาก : " . mysql_error());
}
if ($_REQUEST['upload_img'] == 1) {
    sleep(2);
    $product_image = trim($_REQUEST['img_fromDB']);
    $product_id = $_REQUEST['product_id'];
    if ($_FILES) {
        $image_product = $_FILES["update_imgProduct"]['name'];
        if (!empty($image_product[0])) {
            $img = _upload_Image("../image_product/", "update_imgProduct", 1024, 400, 150);
            for ($i = 0; $i < count($img['data']); $i++) {
                if ($img['data'][$i] != "") {
                    if ($i != count($img['data']) - 1) {
                        $image_DB .= $img['data'][$i] . ",";
                    } else {
                        $image_DB .= $img['data'][$i];
                    }
                }
            }
        }
        if ($img['sucess'] != "") {
            echo "<div style='width:90%;margin:5px auto;background-color: #d8ffcd;border: solid 1px #36ff00;padding:10px;'>";
            echo $img['sucess'];
            echo "</div>";
        }
        if ($img['error'] != "") {
            echo "<div style='width:90%;margin:5px auto;background-color: #ffe9e9;border: solid 1px #ffaaaa;padding:10px;'>";
            echo $img['error'];
            echo "</div>";
        }
    }
    if ($image_DB != "" && $product_image != "") {
        $new_updateImag = $product_image . "," . trim($image_DB);
    } elseif ($product_image != "") {
        $new_updateImag = $product_image;
    } elseif ($image_DB != "") {
        $new_updateImag = trim($image_DB);
    } else {
        exit("อัพโหลดไฟล์ไม่ได้ทั้งหมด");
    }
    $query = "update product set product_image='$new_updateImag' where product_id=$product_id";
    if (mysql_query($query)) {
        echo "<script>window.top.showUpload_error('1','$product_id');</script>";
    } else {
        $data .= "<div style='width:90%;margin:5px auto;background-color: #ffe9e9;border: solid 1px #ffaaaa;padding:10px;'>";
        $data .= "ไม่สามารถเพิ่มข้อมูล $new_updateImag ลงในดาต้าเบสได้ เนื่องจาก : " . mysql_error();
        $data .= "</div>";
        exit($data);
    }
}
if ($_REQUEST['show_img_product'] == 1) {
    $product_id = $_REQUEST['product_id'];
    $query = "SELECT * FROM product WHERE product_id=$product_id";
    $result = mysql_query($query);
    $product = mysql_fetch_array($result);
    $productId = $product['product_id'];

    $img = explode(",", $product['product_image']);
    for ($index = 0; $index < count($img); $index++) {
        if (trim($img[$index] == "")) {
            echo "<img src='images/no_data.jpg' class='img_product'> ";
        } else {
            ?>
            <div style="position: relative;display: inline-block;" id="proPic-<?= $index ?>">
                <img src='image_product/thumbnail/thumbnails_<?= $img[$index] ?>' class='img_edis_product' title='<?= $img[$index] ?>'>
                <span id="deletePorpic" title='ลบภาพนี้' onclick="deleteProduct_img('<?= $img[$index] ?>',<?= $productId ?>,<?= $index ?>)">
                    &times;
                </span>
            </div>
            <?php
        }
    }
    ?>
    <script>
        $(function () {
            $("img.img_edis_product").each(function () {
                $(this).click(function () {
                    showProduct_img(this);
                });
            });
        });
    </script>
    <?php
}
if ($_REQUEST['deleteProduct_sound'] == 1) {
    $product_id = $_REQUEST['product_id'];
    $proSound_name = $_REQUEST['proSound_name'];
    $dir = "../sound_product/" . $proSound_name;
    $query = "UPDATE product SET product_sound='' WHERE product_id=$product_id";
    if (file_exists($dir)) {
        unlink($dir) or die($dir . "นี้ไม่สามารถลบได้ !");
        mysql_query($query) or die("ไม่สามารถลบ $proSound_name ออกจากดาต้าเบสได้");
    } else {
        echo "หาที่อยู่ไฟล์ $dir ไม่เจอ";
    }
}
if ($_REQUEST['showProduct_sound'] == 1) {
    $product_id = $_REQUEST['product_id'];
    $query = "SELECT * FROM product WHERE product_id=$product_id";
    $result = mysql_query($query);
    $product = mysql_fetch_array($result);
    $productId = $product['product_id'];
    ?>
    <p>
        <span>เสียงสินค้าเครื่องดนตรี : </span>
        <span style="color: red;font-size: 13px;">ฟังเสียง[ คลิ๊กซ้าย ] | ลบเสียง[ คลิ๊กขวา ] 
            <?php if (trim($product['product_sound']) != "") { ?>
                [ <a href="sound_product/<?= $product['product_sound']; ?>" class="sound_to_load" target="_blank">
                    <?= $product['product_sound']; ?></a> ]
            <?php } ?>
        </span>
    </p>
    <?php if (trim($product['product_sound']) != "") { ?>
        <p>
            <span></span>
            <span class="sound_product">
                <audio src="sound_product/<?= $product['product_sound']; ?>" controls=""></audio>
            </span>
        </p>
    <?php } else { ?>
        <p>
            <span></span>
            <span>
                <img src='images/no_data.jpg' class="img_product">
            </span>
        </p>
    <?php } ?>
    <p>
        <span></span>
        <span>
            <?php if (trim($product['product_sound']) != "") { ?>
                <button type="button" class="button-3" onclick="upload_sound(<?= $productId ?>)">เปลี่ยนเสียง</button>
                <button type="button" class="button-3" 
                        onclick="deleteProduct_sound('<?= $product['product_sound'] ?>',<?= $productId ?>);">
                    ลบเสียง
                </button>
            <?php } else { ?>
                <button type="button" class="button-3" onclick="upload_sound(<?= $productId ?>)">เพิ่มเสียง</button>
            <?php } ?>
            <span class="warning-unline" onclick="warning_inlineClose();" id="sound_error">
                xxxx
            </span>
        </span>
    </p>
    <?php
}

if ($_REQUEST['upload_sound'] == 1) {
    sleep(2);
    $product_id = $_REQUEST['product_id'];
    $product_soundFromDB = $_REQUEST['product_soundFromDB'];
    $dir = "../sound_product/";
    if (trim($product_soundFromDB) != "") {
        $delete = $dir . $product_soundFromDB;
        if (file_exists($delete)) {
            @unlink($delete);
        }
    }
    if ($_FILES) {
        $update_soundProduct = $_FILES["update_soundProduct"]['name'];
        if (!empty($update_soundProduct[0])) {
            $sound = _upload_sound($dir, "update_soundProduct", 5120);
            for ($i = 0; $i < count($sound['data']); $i++) {
                if ($sound['data'][$i] != "") {
                    if ($i != count($sound['data']) - 1) {
                        $sound_DB .= $sound['data'][$i] . ",";
                    } else {
                        $sound_DB .= $sound['data'][$i];
                    }
                }
            }
        }
        if ($sound['sucess'] != "") {
            echo "<div style='width:90%;margin:5px auto;background-color: #d8ffcd;border: solid 1px #36ff00;padding:10px;'>";
            echo $sound['sucess'];
            echo "</div>";
        }
        if ($sound['error'] != "") {
            echo "<div style='width:90%;margin:5px auto;background-color: #ffe9e9;border: solid 1px #ffaaaa;padding:10px;'>";
            echo $sound['error'];
            echo "</div>";
        }
    }
    $new_updateSound = trim($sound_DB);
    $query = "update product set product_sound='$new_updateSound' where product_id=$product_id";
    if (mysql_query($query)) {
        echo "<script>window.top.showUpload_error('2',$product_id);</script>";
    } else {
        $data .= "<div style='width:90%;margin:5px auto;background-color: #ffe9e9;border: solid 1px #ffaaaa;padding:10px;'>";
        $data .= "ไม่สามารถเพิ่มข้อมูล $new_updateSound ลงในดาต้าเบสได้ เนื่องจาก : " . mysql_error();
        $data .= "</div>";
        exit($data);
    }
}

if ($_REQUEST['edit_product_main'] == 1) {
    $product_id_main = $_REQUEST['product_id_main'];
    $product_id = $_REQUEST['product_id'];
    $category_id = $_REQUEST['category_id'];
    $product_name = trim($_REQUEST['product_name']);
    $product_price = $_REQUEST['product_price'];
    $product_unit = $_REQUEST['product_unit'];
    $product_cost = $_REQUEST['product_cost'];
    if (empty($category_id) || empty($product_name) || empty($product_price) || empty($product_unit) || empty($product_cost)) {
        exit('ข้อมูลว่าง กรุณากรอกข้อมูลให้ครบ !');
    }
    if (empty($product_id)) {
        $product_id = $product_id_main;
    }
    $query = "update product set product_id=$product_id,"
            . "category_id=$category_id,product_name='$product_name',"
            . "product_price=$product_price,product_unit=$product_unit,"
            . "product_cost=$product_cost,"
            . "date_input=NOW() where product_id=$product_id_main";
    mysql_query($query) or die("ไม่สามารถแก้ไขรายการนี้ได้ เนื่องจาก : " . mysql_error());
}

if ($_REQUEST['delete_product'] == 1) {
    $product_id = $_REQUEST['product_id_main'];
    $query_select = mysql_query("select * from product where product_id=$product_id");
    $product = mysql_fetch_array($query_select);
    $img_delete = explode(",", $product['product_image']);
    for ($index1 = 0; $index1 < count($img_delete); $index1++) {
        $img_De = "../image_product/" . $img_delete[$index1];
        $img_De_thum = "../image_product/thumbnail/thumbnails_" . $img_delete[$index1];
        if ($img_delete[$index1] != "") {
            if (file_exists($img_De)) {
                @unlink($img_De) or die("$img_De ลบไม่ได้ ");
                if (file_exists($img_De_thum)) {
                    @unlink($img_De_thum) or die("$img_De_thum ลบไม่ได้  ");
                }
            }
        }
    }
    if ($product['product_sound'] != "") {
        $product_sound = $product['product_sound'];
        $sound_De = "../sound_product/" . $product_sound;
        if (file_exists($sound_De)) {
            @unlink($sound_De) or die("$sound_De ลบไม่ได้ ");
        }
    }
    $query = "DELETE FROM product WHERE product_id=$product_id";
    if (!mysql_query($query)) {
        $error .= "รหัส $array ไม่สามารถลบได้เนื่องจาก : " . mysql_error() . "<br />";
    }
}