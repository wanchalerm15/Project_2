<?php include './connect_DB.php'; ?>
<meta charset="utf-8">
<script src="../web_design_script/jquery.min.js"></script>
<style>
    .warning-error,.warning-ok{
        background-image: url(../images/warning.png);
        width:90%;margin:5px auto;
        padding:10px;font-size: 13px;
        background-repeat: no-repeat;
        background-position: 100% 0%;
    }
    .warning-error{
        border: solid 1px #ffaaaa;
        background-color: #ffe9e9;
    }
    .warning-ok{
        border: solid 1px #36ff00;
        background-color: #d8ffcd;
    }
    .button{
        cursor: pointer;
        padding: 5px 15px;
    }
    .loading{
        display: none;
        text-align: center;
    }
    .loading img{
        height: 30px;
        vertical-align: middle;
    }
    .loading p{
        position: relative;
        top: 4px;
        margin: 0;padding: 0;
        font-size: 17px;
        font-weight: bolder;
        color: #aa0000;
    }
</style>
<?php
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $result = mysql_query("select product_image from product where product_id=$product_id");
    list($product_image) = mysql_fetch_array($result);
    ?>
    <h3>
        อัพโหลดภาพสินค้า รหัส : P<?= $product_id ?>
    </h3>
    <div class="loading">
        <img src="../images/loading.gif">
        <p>กำลังโหลด...</p>
    </div>
    <div class="warning-error" id="upload_error">
        กรุณาเลือกรูปสินค้าที่จะอัพโหลด
    </div>
    <div style="width: 100%;text-align: center;">
        <form method="post" enctype="multipart/form-data" action="product.php?upload_img=1&product_id=<?= $product_id ?>" id="add_img_product">
            <input type="hidden" name="img_fromDB" value="<?= $product_image ?>">
            <p><input type="file" name="update_imgProduct[]" id="update_imgProduct" multiple="" accept="image/*"></p>
            <p><button class="button" type="submit">อัพโหลดไฟล์</button></p>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $("#add_img_product button.button").click(function() {
                if ($.trim($("#update_imgProduct").val()) == "") {
                    $("#upload_error").html("ยังไม่มีการเลือกภาพที่จะอัพโหลด");
                } else {
                    $("#update_imgProduct").hide();
                    $("#upload_error").hide();
                    $(".loading").fadeIn();
                    return true;
                }
                return false;
            });
        });
    </script>
    <?php
}
if (isset($_REQUEST['upload_sound_id'])) {
    $product_id = $_REQUEST['upload_sound_id'];
    $result = mysql_query("select product_sound from product where product_id=$product_id");
    list($product_sound) = mysql_fetch_array($result);
    if (trim($product_sound) != "") {
        $product_sound_name = " /" . trim($product_sound);
    }
    ?>
    <h3>
        อัพโหลดเสียงสินค้า รหัส : P<?= $product_id ?><?= $product_sound_name ?>
    </h3>
    <div class="loading">
        <img src="../images/loading.gif">
        <p>กำลังโหลด...</p>
    </div>
    <div class="warning-error" id="upload_error">
        กรุณาเลือกเสียงสินค้าที่จะอัพโหลด
    </div>
    <div style="width: 100%;text-align: center;">
        <form method="post" enctype="multipart/form-data" action="product.php?upload_sound=1&product_id=<?= $product_id ?>" id="add_img_sound">
            <input type="hidden" value="<?= $product_sound ?>" name="product_soundFromDB">
            <p><input type="file" name="update_soundProduct[]" id="update_soundProduct" accept="audio/*"></p>
            <p><button class="button" type="submit">อัพโหลดไฟล์</button></p>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $("#add_img_sound button.button").click(function() {
                if ($.trim($("#update_soundProduct").val()) == "") {
                    $("#upload_error").html("ยังไม่มีการเลือกเสียงที่จะอัพโหลด");
                } else {
                    $("#update_soundProduct").hide();
                    $("#upload_error").hide();
                    $(".loading").fadeIn();
                    return true;
                }
                return false;
            });
        });
    </script>
    <?php
}
if (!isset($_GET['product_id']) && !isset($_REQUEST['upload_sound_id'])) {
    exit("ไม่มีรหัสสินค้าเครื่องดนตรี กรุณาเข้าใช้ระบบ ให้ถูกวิธี");
}