<?php include './web_server_script/edit_website.php'; ?>
<?php
if ($_GET["Logout"] == "yes") {
    session_destroy();
    echo "<script>location='" . $_SERVER["PHP_SELF"] . "'</script>";
}
?>
<script>
    $(document).ready(function() {
    });
</script>
<div id="nev_header">
    <div id="containur">
        <div class="logo">
            <img src="<?= $WEB_LOGO; ?>">
        </div>
        <div class="search-box">
            <form>
                <!--
                <select id="search_select" name="">
                    <option> ค้นหาจากชื่อสินค้า </option>
                    <option> ค้นหาจากประเภทสินค้า </option>
                    <option> ค้นหาจากราคาสินค้า </option>
                </select>
                -->
                <span class="search-tx">
                    <input type="search" placeholder=" ค้นหาสินค้าเครื่องดนตรี ด่วน !" name="search_tx" class="search-tx"><button>
                        <img src="images/search.png">
                    </button>
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
                <li><a href=""><img src="images/contact_icon.png"> <span>ติดต่อเรา</span></a></li>
                <li><a href=""><img src="images/about_icon.png"> <span>เกี่ยวกับเรา</span></a></li>
                <li><a href=""><img src="images/pay_icon.png"> <span>วิธีการสั่งซื้อ</span></a></li>
                <li><a href="index.php" class="<?= $home ?>"><img src="images/home_icon.png"> <span>หน้าแรก</span></a></li>
            </ul>
        </div>
        <div style="clear: both;"></div>
    </div>
</div>