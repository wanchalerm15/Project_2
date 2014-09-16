<div id="artical" class="main_aftershop top_main bottom_main">
    <h3 class="topic">
        <img class="add">
        จัดการสินค้าเครื่องดนตรี
    </h3>
    <div class="in_main">
        <?php
        require './web_server_script/php_function.php';
        $end_row = $WEB_AFTERSHOP_NUMROW;
        $mysql_numrow = mysql_num_rows(mysql_query("SELECT * FROM comment"));
        $numrow = ceil($mysql_numrow / $end_row);
        if (isset($_GET['row'])) {
            if ($_GET['row'] > $numrow) {
                echo "<script>location='?manage=comment&row=$numrow#top';</script>";
            }
            $num_page = $_GET['row'];
            $start_row = ($_GET['row'] - 1) * $end_row;
        } else {
            $r = 1;
            $num_page = 1;
            $start_row = 0;
        }
        $query = "SELECT * FROM comment ORDER BY comment_id AND comment_delete DESC LIMIT $start_row,$end_row";
        $result = mysql_query($query);
        ?>
        <p class="warning" id="top">
            มีการแสดงความเห็นต่อ สินค้าเครื่องดนตรีภายในระบบทั้งหมด  <?= $mysql_numrow ?> รายการ
            มีหน้าที่แสดงรายการแสดงความเห็นต่อ สินค้าเครื่องดนตรีทั้งหมด <?= $numrow ?> หน้า
        </p>
        <p class="title">
            <img class="add">
            รายการสินค้าเครื่องดนตรี
        </p>
        <div style="display: none;" id="show_edit_product">

        </div>
        <table class="table_aftershop" id="show_table_category">
            <tr>
                <td>#หัวข้อความเห็น</td>
                <td>#แจ้งลบ</td>
                <td class="show_date">#วันที่</td>
                <td>#ลบ</td>
            </tr>
            <?php if (mysql_num_rows(mysql_query("SELECT * FROM comment")) <= 0) { ?>
                <tr>
                    <td colspan="4" style="text-align: left;">ไม่มีรายการในระบบ</td>
                </tr>
                <?php
            } else {
                while ($comment = mysql_fetch_array($result)) {
                    ?>
                    <?php $comment_id = "comment : " . $comment['comment_id']; ?>
                    <tr class="order_id_<?= $comment['comment_id'] ?>">
                        <td>
                            <a class="link" title="ไปที่ความเห็นนี้" href="showProduct_and_comment.php?product_id=<?= $comment['product_id'] ?>#comment-<?= $comment['comment_id'] ?>">
                                Comment:<?= $comment['comment_id'] ?>
                            </a>
                            <br />
                            <?php
                            $comment_data = "";
                            if (strlen($comment['comment_topic']) > 70) {
                                $comment_topic = $comment['comment_topic'];
                                $comment_data = substr($comment_topic, 0, 70);
                            } else {
                                $comment_data = $comment['comment_topic'];
                            }
                            ?>
                            <span class="disable" style="font-size: 13px;"><?= $comment_data ?></span>
                        </td>
                        <td>                           
                            <?php
                            if ($comment['comment_delete'] > 0) {
                                echo "<span class='red'>" . $comment['comment_delete'] . "</span>";
                            } else {
                                echo "ยังไม่มี";
                            }
                            ?>
                        </td>
                        <td class="show_date"><?= $comment['comment_date'] ?></td>
                        <td>
                            <input type="checkbox" class="delete_check" value="<?= $comment['comment_id'] ?>">
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
                            data += "Comment : " + $(this).val();
                        } else {
                            data += "Comment : " + $(this).val() + ", ";
                        }
                    });
                    data += " ] ";

                    if (confirm("คุณต้องการลบรายการที่" + data + "นี้จริงหรือ !")) {
                      delete_comment_arrlay();
                    }
                });
            });</script>
        <div class="part_row">
            <a href="?manage=comment&row=<?= $_GET['row'] - ($r + 1) ?>#top" class="past">ก่อนหน้า</a>
            <span>
                |
                <select onchange="change_row_Aftershop(this, 'comment')" class="select">
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
            <a href="?manage=comment&row=<?= $_GET['row'] + ($r + 1) ?>#top" class="past">ถัดไป</a>
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

