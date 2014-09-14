<?php
session_start();
include './connect_DB.php';

/* ------------------------------------------------------------------------------ show category */
if ($_REQUEST['show_table_category'] == 1) {
    $start_row = trim($_REQUEST['start_row']);
    $end_row = trim($_REQUEST['end_row']);
    $query = "SELECT * FROM category ORDER BY category_id LIMIT $start_row,$end_row";
    $result = mysql_query($query);
    ?>
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
    <?php } else { ?>
        <?php while ($category = mysql_fetch_array($result)) {
            ?>
            <tr class="category_id_<?= $category['category_id'] ?>">
                <td>C<?= $category['category_id'] ?></td>
                <td>
                    <a title="ต้องการแก้ไข คลิ๊ก!"
                       onclick="update_category(<?= $category['category_id'] ?>, 50, 5,<?= $start_row ?>,<?= $end_row ?>);">
                           <?= $category['category_name'] ?>
                    </a>
                </td>
                <td class="show_date"><?= $category['date_input'] ?></td>
                <td>
                    <input type="checkbox" class="delete_check" value="<?= $category['category_id'] ?>">
                </td>
            </tr>
            <?php
        }
    }
}
/* ------------------------------------------------------------------------------ add category */
if ($_REQUEST['add_category'] == 1) {
    $input_category = trim($_REQUEST['input_category']);
    mysql_query("INSERT INTO category VALUES(0,'$input_category',NOW())") or die("ไม่สามารถเพิ่มประเภทสินค้าได้เนื่องจาก : " . mysql_error());
}

/* ------------------------------------------------------------------------------ /delete category */
if ($_REQUEST['delete_category_arrlay'] == 1) {
    $delete_array = $_REQUEST['delete_array'];
    if (!count($delete_array)) {
        exit("กรุณาเลือกรายการที่จะลบ!");
    }
    $error = "";
    foreach ($delete_array as $array) {
        $query = "DELETE FROM category WHERE category_id=$array";
        if (!mysql_query($query)) {
            $error .= "รหัส C$array ไม่สามารถลบได้เนื่องจาก : " . mysql_error() . "<br />";
        }
    }
    if (trim($error) != "") {
        echo "$error";
    }
}
if ($_REQUEST['delete_category'] == 1) {
    $category_id = trim($_REQUEST['category_id']);
    mysql_query("DELETE FROM category WHERE category_id=$category_id") or die("ไม่สามารถลบประเภทสินค้าได้เนื่องจาก : " . mysql_error());
}

/* ------------------------------------------------------------------------------ /show update category */
if ($_REQUEST['show_update_category'] == 1) {
    $category_id = trim($_REQUEST['category_id']);
    $start_row = trim($_REQUEST['start_row']);
    $end_row = trim($_REQUEST['end_row']);

    $query = "SELECT * FROM category WHERE category_id=$category_id";
    $result = mysql_query($query);
    $category = mysql_fetch_array($result);
    $id = str_pad($category['category_id'], 3, '0', STR_PAD_LEFT)
    ?>
    <h3 class="topic" style="text-align: left;">
        <img src="images/topic_icon.png">
        <span>C<?= $id ?>/<?= $category['category_name'] ?></span>
    </h3>
    <div class="in_main">
        <div id="artical">
            <p class="date_dialog">วันที่แก้ไขล่าสุด : <?= $category['date_input'] ?></p>
            <div class="warning" id="update_category_error">
                แก้ไขประเภทสินค้าเครื่องดนตรี ของ <?= $category['category_name'] ?> รหัส C<?= $id ?>
            </div>
            <p class="tx_update_category">
                <input hidden="" value="<?= $category['category_id'] ?>" id="id_confirm">
                <input hidden="" value="<?= $start_row ?>" id="start_row">
                <input hidden="" value="<?= $end_row ?>" id="end_row">
                <?php if ($admin_id_session) { ?>
                    <input type="text" value="<?= $category['category_id'] ?>" class="text" id="input_category_id">
                <?php } else { ?>
                    <input type="text" value="<?= $category['category_id'] ?>" class="text" id="input_category_id" disabled="">
                <?php } ?>
                <input type="text" class="text" value="<?= $category['category_name'] ?>" id="input_category_name">
            </p>
            <p class="bt_update_category">
                <button class="button" id="bt_update_category">
                    <img src="images/update_icon.png"> <span>แก้ไข</span>
                </button>
                <button class="button" id="bt_delete_category">
                    <img src="images/delete_icon_w.png"> <span>ลบ</span>
                </button>
                <button class="button" id="close_dialog">
                    <img src="images/close.png"> <span>ปิดหน้านี้</span>
                </button>
            </p>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#dialog .in_main,#dialog h3.topic").click(function(e) {
                $("#dialog").fadeIn();
                e.stopPropagation();
            });
            $("#close_dialog").click(dialog_eixt);
            $("#bt_update_category").click(function() {
                var id_confirm = $("#id_confirm").val();
                var start_row = $("#start_row").val();
                var end_row = $("#end_row").val();
                var input_category_id = $("#input_category_id").val();
                var input_category_name = $("#input_category_name").val();
                $.ajax({
                    url: "web_server_script/category.php",
                    data: {
                        id_confirm: id_confirm,
                        input_category_id: input_category_id,
                        input_category_name: input_category_name,
                        update_category: 1
                    },
                    type: 'POST',
                    beforeSend: function(xhr) {

                    },
                    success: function(data, textStatus, jqXHR) {
                        if (!data) {
                            $("#dialog.dialog").fadeOut();
                            show_table_category(input_category_id, start_row, end_row);
                        } else {
                            $('#update_category_error').removeAttr("class").addClass("warning-error").html(data);
                        }
                    }
                });
            });
            $("#bt_delete_category").click(function() {
                if (confirm("คุณต้องการลบประเภทสินค้าเครื่องดนตรีนี้ จริงหรือ!")) {
                    $.ajax({
                        url: "web_server_script/category.php",
                        data: {category_id: $("#id_confirm").val(), delete_category: 1},
                        type: 'GET',
                        beforeSend: function(xhr) {
                        },
                        success: function(data, textStatus, jqXHR) {
                            if (data) {
                                $('#update_category_error').removeAttr('class').addClass('warning-error').html(data);
                            } else {
                                location.reload();
                            }
                        }
                    });
                }
            });
            $("#dialog *").keyup(function(e) {
                if (e.keyCode == 13) {
                    var id_confirm = $("#id_confirm").val();
                    var start_row = $("#start_row").val();
                    var end_row = $("#end_row").val();
                    var input_category_id = $("#input_category_id").val();
                    var input_category_name = $("#input_category_name").val();
                    $.ajax({
                        url: "web_server_script/category.php",
                        data: {
                            id_confirm: id_confirm,
                            input_category_id: input_category_id,
                            input_category_name: input_category_name,
                            update_category: 1
                        },
                        type: 'POST',
                        beforeSend: function(xhr) {

                        },
                        success: function(data, textStatus, jqXHR) {
                            if (!data) {
                                $("#dialog.dialog").fadeOut();
                                show_table_category(input_category_id, start_row, end_row);
                            } else {
                                $('#update_category_error').removeAttr("class").addClass("warning-error").html(data);
                            }
                        }
                    });
                }
            });
        });
    </script>
    <?php
}

/* ------------------------------------------------------------------------------ /update category */
if ($_REQUEST['update_category'] == 1) {
    $input_category_id = $_REQUEST['input_category_id'];
    $input_category_name = $_REQUEST['input_category_name'];
    $id_confirm = $_REQUEST['id_confirm'];

    $query = "UPDATE category SET category_id=$input_category_id";
    $query .= ",category_name='$input_category_name'";
    $query .= ",date_input=NOW() WHERE category_id=$id_confirm";
    mysql_query($query) or die("ไม่สามารถแก้ไขประเภทเครื่องดนตรีได้ เนื่องจาก : " . mysql_error());
}    