<?php
session_start();
include './connect_DB.php';
if ($_REQUEST['add_comment'] == 1) {
    $comment_peple = $_REQUEST['comment_peple'];
    $comment_topic = $_REQUEST['comment_topic'];
    $comment_detail = $_REQUEST['comment_detail'];
    $product_id = $_REQUEST['product_id'];
    $query = "INSERT INTO comment(product_id,comment_topic,comment_peple,comment_detail,comment_delete,comment_date) "
            . "VALUES($product_id,'$comment_topic','$comment_peple','$comment_detail',0,NOW())";
    mysql_query($query) or die("ERROR ! : " . mysql_error());
}
if ($_REQUEST['load_comment'] == 1) {
    $product_id = $_REQUEST['product_id'];
    $query = "select * from comment where product_id=" . $product_id;
    $resultComment = mysql_query($query);
    ?>
    <?php while ($comment = mysql_fetch_array($resultComment)) { ?>
        <div id="comment-<?= $comment['comment_id'] ?>">
            <h3 class="topic" style="margin: 20px 0 3px 0;">
                <?= $comment['comment_topic'] ?>
            </h3>
            <div class="inner-w border-inner">
                <pre><?= trim($comment['comment_detail']); ?></pre>
            </div>
            <div id="date_peple_delete_com">
                <div class="inner-w border-inner">
                    โดย : <?= trim($comment['comment_peple']); ?>
                </div>
                <div class="inner-w border-inner">
                    วันที่โพส : <?= trim($comment['comment_date']); ?>
                </div>
                <div class="inner-w border-inner">
                    <a onclick="delete_comment(<?= $comment['comment_id'] ?>)">แจ้งลบ</a> : 
                    <span class="delete_comment" id="comment_del-<?= $comment['comment_id'] ?>">
                        <?= trim($comment['comment_delete']); ?>
                    </span>
                </div>
                <?php if (!empty($admin_id_session) || !empty($employee_id_session)) { ?>
                    <div class="inner-w border-inner">
                        <a onclick="delete_commect_cascade(<?= $comment['comment_id'] ?>)">ลบความเห็นนี้</a>
                    </div>
                <?php } ?>
                <script>
                    $(document).ready(function() {
                        if ($("#comment_del-<?= $comment['comment_id'] ?>").text() != 0) {
                            $("#comment_del-<?= $comment['comment_id'] ?>").addClass("red");
                        }
                    });
                </script>
            </div>
        </div>
        <?php
    }
}
if ($_REQUEST['delete_comment'] == 1) {
    $comment_id = $_REQUEST['comment_id'];
    $query = mysql_query("SELECT comment_delete FROM comment WHERE comment_id=$comment_id");
    list($comment_delete) = mysql_fetch_row($query);
    $comment_delete+=1;
    mysql_query("UPDATE comment SET comment_delete=$comment_delete WHERE comment_id=$comment_id");
    $query = mysql_query("SELECT comment_delete FROM comment WHERE comment_id=$comment_id");
    list($comment_deleteFinish) = mysql_fetch_row($query);
    echo $comment_deleteFinish;
}
if ($_REQUEST['delete_commect_cascade'] == 1) {
    $comment_id = $_REQUEST['comment_id'];
    $query = "delete from comment where comment_id=$comment_id";
    mysql_query($query) or die("delete comment error! : " . mysql_error());
}
if ($_REQUEST['delete_comment_arrlay'] == 1) {
    $delete_array = $_REQUEST['delete_array'];
    if (!count($delete_array)) {
        exit("กรุณาเลือกรายการที่จะลบ!");
    }
    $error = "";
    foreach ($delete_array as $array) {
        $query = "DELETE FROM comment WHERE comment_id=$array";
        if (!mysql_query($query)) {
            $error .= "รหัส $array ไม่สามารถลบได้เนื่องจาก : " . mysql_error() . "<br />";
        }
    }
    if (trim($error) != "") {
        echo "$error";
    }
}