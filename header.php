<?php
if ($_GET["Logout"] == "yes") {
    session_destroy();
    echo "<script>location='" . $_SERVER["PHP_SELF"] . "'</script>";
}
?>
<?php include './web_server_script/edit_website.php'; ?>
<script>
    $(document).ready(function () {
    });
</script>
<div id="nev_header">
    <div id="containur">
        <div class="logo">
            <img src="<?= $WEB_LOGO; ?>">
        </div>
        <div class="search-box">
            <form method="POST" id="search_top" <?= $no_search ?>>
                <span class="search-tx">
                    <?php if ($search_top == 'search_order') { ?>
                        <select style="width: 90%;border:solid 1px #FFF;padding: .7% 1%;" name="<?= $search_top ?>" onchange="$('#search_top').submit()">
                            <?php
                            $ORDER_STATUS = array(
                                "รายการสั่งซื้อใหม่",
                                "กำลังตรวจสอบรายการสั่งซื้อ",
                                "จัดส่งสินค้าไปแล้ว",
                                "รายการสั่งซื้อใหม่ ชำระเงินแล้ว",
                                "เกิดข้อขัดข้อง ลูกค้ายกเลิกการจ่ายเงิน",
                                "รายการเสร็จสิ้น",
                                "เกิดข้อขัดข้องอื่นๆ"
                            );
                            if (isset($_POST['search_order'])) {
                                for ($index = 0; $index < count($ORDER_STATUS); $index++) {
                                    if ($index == 0 || $index == 3 || $index == 4) {
                                        if ($_POST['search_order'] == $index) {
                                            echo "<option value='$index' selected=''>$ORDER_STATUS[$index]</option>";
                                        } else {
                                            echo "<option value='$index'>$ORDER_STATUS[$index]</option>";
                                        }
                                    }
                                }
                            } else {
                                echo '<option value="false" selected="">ค้นหารายการสั่งซื้อ</option>';
                                for ($index = 0; $index < count($ORDER_STATUS); $index++) {
                                    if ($index == 0 || $index == 3 || $index == 4) {
                                        echo "<option value='$index'>$ORDER_STATUS[$index]</option>";
                                    }
                                }
                            }
                            ?>
                        </select>
                    <?php } else { ?>
                        <?php if (!empty($no_search)) { ?>
                            <input type="search" placeholder="<?= $search_detail ?>" name="<?= $search_top ?>" class="search-tx" disabled="">
                        <?php } else { ?>
                            <input type="search" placeholder="<?= $search_detail ?>" name="<?= $search_top ?>" class="search-tx">
                        <?php } ?>
                        <button>
                            <img src="images/search.png">
                        </button>
                    <?php } ?>
                </span>
            </form>
        </div>
        <div class="nav_menu">
            <ul>
                <?php if ($admin_id_session || $employee_id_session || $member_id_session) { ?>
                    <li class="submenu">
                        <a class="<?= $signin ?>" style="cursor: default;">
                            <img src="images/setting_icon.png"> <span>ตั้งค่าระบบ</span></a>
                        <ul class="secon-navmenu">
                            <li><a href="login_singin.php" class="<?= $signin ?>"><img src="images/editUser_icon.png"> <span>แก้ไขข้อมูลส่วนตัว</span></a></li>
                            <?php if ($member_id_session) { ?>
                                <li><a href="order_cast.php" class="<?= $cast ?>"><img src="images/shopping_cast_icon.png"> <span>ตระกร้าสินค้า</span></a></li>
                            <?php } else { ?>
                                <li><a href="after_music_shop.php" class="<?= $after_shop ?>"><img src="images/after_icon.png"> <span>ระบบหลังร้าน</span></a></li>
                            <?php } ?>
                            <li><a href="?Logout=yes"><img src="images/logOut_icon.png"> <span>ออกจากระบบ</span></a></li>
                        </ul>
                    </li>
                <?php } else { ?>
                    <li><a href="login_singin.php" class="<?= $signin ?>"><img src="images/editUser_icon.png"> <span>สมัครสมาชิก</span></a></li>
                <?php } ?>
                <li><a href="contact_us.php" class="<?= $contact_us ?>"><img src="images/contact_icon.png"> <span>ติดต่อเรา</span></a></li>
                <li><a href="about_me.php" class="<?= $about_me ?>"><img src="images/about_icon.png"> <span>เกี่ยวกับเรา</span></a></li>
                <li><a href="how_to_pays.php" class="<?= $how_to_pays ?>"><img src="images/pay_icon.png"> <span>วิธีการสั่งซื้อ</span></a></li>
                <li><a href="index.php" class="<?= $home ?>"><img src="images/home_icon.png"> <span>หน้าแรก</span></a></li>
            </ul>
        </div>
        <div style="clear: both;"></div>
    </div>
</div>