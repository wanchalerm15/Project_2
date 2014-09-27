<div id="artical" class="main_aftershop top_main bottom_main">
    <?php include './web_server_script/edit_website.php'; ?>
    <h3 class="topic">
        <img class="add">
        แก้ไขร้านค้า <?= $WEB_THAI_NAME ?>
    </h3>
    <div class="in_main">
        <div class="warning">
            คุณสามารถแก้ไขเว็บไซด์ เพจ วิธีการสั่งซื้อ 
            เกี่ยวกับเรา ติดต่อเรา ได้ที่หน้านี้ครับ
        </div>
        <div>
            <p class="title">
                <img class="add">
                เลือกเมนูที่จะแก้ไข
            </p>
            <ul class="config_web_menu">
                <li><a href="?manage=config_web&set=web_name">ชื่อร้านค้า</a></li>
                <span>|</span>
                <li><a href="?manage=config_web&set=logo_web">โลโก้ร้านค้า</a></li>
                <span>|</span>
                <li><a href="?manage=config_web&set=row_tax">จำนวนแถว,ภาษี</a></li>
                <span>|</span>
                <li><a href="?manage=config_web&set=how_to_pays">หน้าเพจ วิธีการสั่งซื้อ</a></li>
                <span>|</span>
                <li><a href="?manage=config_web&set=about_me">หน้าเพจ เกี่ยวกับเรา</a></li>
                <span>|</span>
                <li><a href="?manage=config_web&set=contact_us">หน้าเพจ ติดต่อเรา</a></li>
            </ul>
        </div>
        <!---------------------------------------WEB NAME--------------------------------------->
        <?php if ($_GET['set'] == 'web_name') { ?>
            <div class="inner-w border-inner" style="margin-top: 15px;">
                <p class="title">
                    <img class="add">
                    <b><u>แก้ไข ชื่อร้านค้า</u></b>
                </p>
                <br />
                <form class="edit_web_name">
                    <p><b>ชื่อเว็บไซด์ ภาษาไทย</b></p>
                    <input type="text" value="<?= $WEB_THAI_NAME ?>" class="text"/>
                    <p><b>ชื่อเว็บไซด์ อังกฤษ</b></p>
                    <input type="text" value="<?= $WEB_ENG_NAME ?>" class="text"/>
                    <p class="btn">
                        <input type="submit" value="แก้ไข" class="bt_black"/>
                        <input type="reset" value="คืนค่าข้อความ" class="bt_black"/>
                    </p>
                </form>
                <br />
            </div>
            <!---------------------------------------LOGO WEB--------------------------------------->
        <?php } elseif ($_GET['set'] == 'logo_web') { ?>
            <div class="inner-w border-inner" style="margin-top: 15px;">
                <p class="title">
                    <img class="add">
                    <b><u>แก้ไข โลโก้ร้านค้า</u></b>
                </p>
                <br />
                <form class="edit_web_name" style="text-align: center;">
                    <img src="<?= $WEB_LOGO ?>" />
                    <br /><br />
                    <p><u>เปลี่ยนภาพโลโก้ใหม่</u></p>
                    <br />
                    <button type="button" class="bt_black" onclick="$('#file_logo').click()">
                        <img src="images/upload.png" height="14px"/> อัพโหลดใหม่
                    </button>
                    <input type="file" style="display: none;" id="file_logo" name="file_logo" />
                </form>
                <br />
            </div>
            <!---------------------------------------ROW TAX--------------------------------------->
        <?php } elseif ($_GET['set'] == 'row_tax') { ?>
            <div class="inner-w border-inner" style="margin-top: 15px;">
                <p class="title">
                    <img class="add">
                    <b><u>แก้ไข จำนวนแถวและภาษี</u></b>
                </p>
                <br />
                <form class="edit_web_name">
                    <p><b>จำนวนแถวข้อมูลที่แสดง (แถว)</b></p>
                    <input type="text" value="<?= $WEB_AFTERSHOP_NUMROW ?>" class="text"/>
                    <p><b>ภาษีของร้านค้า (%)</b></p>
                    <input type="text" value="<?= $WEB_TAX ?>" class="text"/>
                    <p class="btn">
                        <input type="submit" value="แก้ไข" class="bt_black"/>
                        <input type="reset" value="คืนค่าข้อความ" class="bt_black"/>
                    </p>
                </form>
                <br />
            </div>
            <!---------------------------------------how_to_pays--------------------------------------->
        <?php } elseif ($_GET['set'] == 'how_to_pays') { ?>
            <div class="inner-w border-inner" style="margin-top: 15px;">
                <p class="title">
                    <img class="add">
                    <b><u>แก้ไข หน้าเพจวิธีการสั่งซื้อ</u></b>
                </p>
                <br />
                <form class="edit_web_name" style="width: 100%;">
                    <textarea id="how_to_pays" name="how_to_pays" style="height: 432px;"><?= $WEB_HOW_TO_PAYS ?></textarea>
                    <p class="btn">
                        <input type="submit" value="แก้ไขหน้าเพจวิธีการสั่งซื้อ" class="bt_black"/>
                    </p>
                </form>
                <script>
                    $(document).ready(function () {
                        CKEDITOR.replace('how_to_pays', {uiColor: '#aaccff', height: "300"});
                    });
                </script>
                <br />
            </div>
            <!---------------------------------------about_me--------------------------------------->
        <?php } elseif ($_GET['set'] == 'about_me') { ?>
            <div class="inner-w border-inner" style="margin-top: 15px;">
                <p class="title">
                    <img class="add">
                    <b><u>แก้ไข หน้าเพจเกี่ยวกับเรา</u></b>
                </p>
                <br />
                <form class="edit_web_name" style="width: 100%;">
                    <textarea id="about_me" name="about_me" style="height: 432px;"><?= $WEB_ABOUT_ME ?></textarea>
                    <p class="btn">
                        <input type="submit" value="แก้ไขหน้าเพจเกี่ยวกับเรา" class="bt_black"/>
                    </p>
                </form>
                <script>
                    $(document).ready(function () {
                        CKEDITOR.replace('about_me', {uiColor: '#ffccaa', height: "300"});
                    });
                </script>
                <br />
            </div>
            <!---------------------------------------contact_us--------------------------------------->
        <?php } elseif ($_GET['set'] == 'contact_us') { ?>
            <div class="inner-w border-inner" style="margin-top: 15px;">
                <p class="title">
                    <img class="add">
                    <b><u>แก้ไข หน้าเพจติดต่อเรา</u></b>
                </p>
                <br />
                <form class="edit_web_name" style="width: 100%;">
                    <textarea id="contact_us" name="contact_us" style="height: 432px;"><?= $WEB_CONTACT_US ?></textarea>
                    <p class="btn">
                        <input type="submit" value="แก้ไขหน้าเพจติดต่อเรา" class="bt_black"/>
                    </p>
                </form>
                <script>
                    $(document).ready(function () {
                        CKEDITOR.replace('contact_us', {uiColor: '#ccffaa', height: "300"});
                    });
                </script>
                <br />
            </div>
        <?php } else { ?>
            <div class="inner-w border-inner" style="margin-top: 15px;">
                <p class="title">
                    <img class="add">
                    <b><u>แก้ไข ชื่อร้านค้า</u></b>
                </p>
                <br />
                <form class="edit_web_name">
                    <p><b>ชื่อเว็บไซด์ ภาษาไทย</b></p>
                    <input type="text" value="<?= $WEB_THAI_NAME ?>" class="text"/>
                    <p><b>ชื่อเว็บไซด์ อังกฤษ</b></p>
                    <input type="text" value="<?= $WEB_ENG_NAME ?>" class="text"/>
                    <p class="btn">
                        <input type="submit" value="แก้ไข" class="bt_black"/>
                        <input type="reset" value="คืนค่าข้อความ" class="bt_black"/>
                    </p>
                </form>
                <br />
            </div>
        <?php } ?>
        <p class="title"></p>
        <p class="disable" style="text-align: right;font-size: 14px;padding: 5px;">
            วันที่แก้ไขล่าสุด : <?= $WEB_DATE ?>
        </p>
    </div>
</div>

