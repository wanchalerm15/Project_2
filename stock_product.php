<div id="artical" class="main_aftershop top_main">
    <h3 class="topic"><img class="add"> <span>สต็อกสินค้าเครื่องดนตรี</span></h3>
    <div class="in_main">
        <div class="warning">
            หน้านี้เป็นหน้าตรวจสอบการคงเหลือของสินค้าเครื่องดนตรี ในระบบ
        </div>
        <p class="title">
            <img class="add" />
            สินค้าเครื่องดนตรีในระบบ
        </p>
        <!-------------------------------ALL--------------------------------------->
        <div class="stock_product_ALL">
            <?php
            $query = "select * from category";
            $result_stock_ALL = mysql_query($query);
            while ($category = mysql_fetch_array($result_stock_ALL)) {
                $result_numrow = mysql_query("select * from product where category_id=" . $category['category_id']);
                ?>
                <div>
                    <p>
                        <b>ประเภทสินค้า<?= $category['category_name'] ?></b> 
                        <span style="font-size: 14px;" class="link" onclick="$('#show_ALL-<?= $category['category_id'] ?>').slideToggle()">
                            <u><?= mysql_num_rows($result_numrow) ?> รายการ</u>
                        </span>
                    </p>
                    <div style="font-size: 14px;padding-left: 2%;margin: 5px 0 10px 0;display: none;" id="show_ALL-<?= $category['category_id'] ?>">
                        <ol style="padding: 0 2%;">
                            <?php
                            while ($row = mysql_fetch_array($result_numrow)) {
                                ?>
                                <li>
                                    รหัสสินค้า P<?= $row['product_id'] ?> :
                                    <span style="font-size: 12px;">
                                        <?= $row['product_name'] ?>
                                        [ เหลือ : <?= $row['product_unit'] ?> ชิ้น ]
                                    </span>
                                </li>
                                <?php
                            }
                            ?>
                        </ol>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <p class="title">
            <img class="add" />
            สินค้าเครื่องดนตรีที่มีลูกค้าซื้อ
            <span onclick="$('#result_product_sell').slideToggle()" class="link" title="ดูหรือซ่อน">รายระเอียด</span>
        </p>
        <div id="result_product_sell" style="display: none;">
            <?php
            $array_put_product_sell = array();
            $array_monthTH = array(
                "มกราคม", "กุมภาพันธ์", "มีนาคม",
                "เมษายน", "พฤษภาคม", "มิถุนายน",
                "กรกฎาคม", "สิงหาคม", "กันยายน",
                "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
            );
            ?>
            <?php
            $sql = "SELECT * from category";
            $result = mysql_query($sql);
            while ($category = mysql_fetch_array($result)) {
                ?>
                <div class="stock_product">
                    <h4>ประเภทสินค้า <?= $category['category_name'] ?></h4>
                    <?php
                    $query_pro_order = "SELECT "
                            . "product.product_id,product.category_id,product_name,product_price,product_unit,product_image,product_cost,date_input,"
                            . "order_id,unit_price,cost "
                            . "FROM product,order_detail "
                            . "WHERE product.product_id=order_detail.product_id AND category_id=" . $category['category_id'] . " ORDER BY unit_price DESC";
                    $result_product_sell = mysql_query($query_pro_order);
                    ?>
                    <div class="stock_product_product">
                        <?php
                        while ($product = mysql_fetch_array($result_product_sell)) {
                            array_push($array_put_product_sell, $product['product_id']);
                            $product_image = explode(",", $product['product_image']);
                            $img_product = ($product_image[0]) ? "<img src = 'image_product/thumbnail/thumbnails_$product_image[0]' />" : "<img src='images/no_image.jpg' />";
                            $date_time = explode(" ", $product['date_input']);
                            $date = explode("-", $date_time[0]);
                            $time = $date_time[1];
                            ?>
                            <div style="margin: 5px 5px 5px 10px;padding:0 0 7px 0;border-bottom: solid 1px #e8e8e8;">
                                <?= $product['product_name'] ?> 
                                <span class="date_stock">[ <?= $date[2] ?> <?= $array_monthTH[$date[1] - 1] ?> <?= ($date[0] + 543) ?> ]</span>
                                <span class="link" onclick="$('#show_stock_product_sell-<?= $product['product_id'] ?>').toggle()" title="ดูหรือซ่อน">ข้อมูล</span>
                                <p id="show_stock_product_sell-<?= $product['product_id'] ?>" class="show_stock">
                                    <?php
                                    $order_select = "SELECT SUM(unit_price) as unit_price FROM order_detail WHERE product_id=" . $product['product_id'];
                                    $result_order_select = mysql_query($order_select);
                                    list($unit) = mysql_fetch_row($result_order_select);
                                    $unit_price = (empty($unit)) ? 0 : $unit;
                                    ?>
                                    <?= $img_product ?>
                                    วันที่นำเข้า : <?= $date[2] ?> เดือน <?= $array_monthTH[$date[1] - 1] ?> พ.ศ.<?= ($date[0] + 543) ?><br />
                                    เวลานำเข้า : <?= $time ?> น.<br />
                                    ราคาสินค้า : ฿<?= number_format($product['product_price'], 2) ?><br />
                                    ค่าขนส่ง : ฿<?= number_format($product['product_cost'], 2) ?><br />
                                    ขายไปแล้ว : <?= ($unit_price) ? "<span style='color:#0000FF;'>$unit_price</span>" : "<span style='color:#FF0000;'>$unit_price</span>" ?> ชิ้น<br />
                                    คงเหลือ : <span style="color: #0000FF;"><?= $product['product_unit'] ?></span> ชิ้น<br />
                                    <?php ?>
                                    <span style="clear: both;"></span>
                                </p>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

        <!------------------------No Sell---------------------------------------------->
        <p class="title">
            <img class="add" />
            สินค้าเครื่องดนตรีที่ยังไม่มีลูกค้าซื้อ
            <span onclick="$('#result_product_no_sell').slideToggle()" class="link" title="ดูหรือซ่อน">รายระเอียด</span>
        </p>
        <div id="result_product_no_sell" style="display: none;">
            <?php
            $sql2 = "SELECT * from category";
            $result2 = mysql_query($sql2);
            while ($category = mysql_fetch_array($result2)) {
                ?>
                <div class="stock_product">
                    <h4>ประเภทสินค้า <?= $category['category_name'] ?></h4>
                    <?php
                    $query = "select * "
                            . "from product where category_id=" . $category['category_id'];
                    $result_product_no_sell = mysql_query($query);
                    ?>
                    <div class="stock_product_product">
                        <?php
                        while ($product = mysql_fetch_array($result_product_no_sell)) {
                            if (!in_array($product['product_id'], $array_put_product_sell)) {
                                $product_image = explode(",", $product['product_image']);
                                $img_product = ($product_image[0]) ? "<img src = 'image_product/thumbnail/thumbnails_$product_image[0]' />" : "<img src='images/no_image.jpg' />";
                                $date_time = explode(" ", $product['date_input']);
                                $date = explode("-", $date_time[0]);
                                $time = $date_time[1];
                                ?>
                                <div style="margin: 5px 5px 5px 10px;padding:0 0 7px 0;border-bottom: solid 1px #e8e8e8;">
                                    <?= $product['product_name'] ?> 
                                    <span class="date_stock">[ <?= $date[2] ?> <?= $array_monthTH[$date[1] - 1] ?> <?= ($date[0] + 543) ?> ]</span>
                                    <span class="link" onclick="$('#show_product_no_sell-<?= $product['product_id'] ?>').toggle()" title="ดูหรือซ่อน">ข้อมูล</span>
                                    <p id="show_product_no_sell-<?= $product['product_id'] ?>" class="show_stock">
                                        <?php
                                        $order_select = "SELECT SUM(unit_price) as unit_price FROM order_detail WHERE product_id=" . $product['product_id'];
                                        $result_order_select = mysql_query($order_select);
                                        list($unit) = mysql_fetch_row($result_order_select);
                                        $unit_price = (empty($unit)) ? 0 : $unit;
                                        ?>
                                        <?= $img_product ?>
                                        วันที่นำเข้า : <?= $date[2] ?> เดือน <?= $array_monthTH[$date[1] - 1] ?> พ.ศ.<?= ($date[0] + 543) ?><br />
                                        เวลานำเข้า : <?= $time ?> น.<br />
                                        ราคาสินค้า : ฿<?= number_format($product['product_price'], 2) ?><br />
                                        ค่าขนส่ง : ฿<?= number_format($product['product_cost'], 2) ?><br />
                                        ขายไปแล้ว : <?= ($unit_price) ? "<span style='color:#0000FF;'>$unit_price</span>" : "<span style='color:#FF0000;'>$unit_price</span>" ?> ชิ้น<br />
                                        คงเหลือ : <span style="color: #0000FF;"><?= $product['product_unit'] ?></span> ชิ้น<br />
                                        <?php ?>
                                        <span style="clear: both;"></span>
                                    </p>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<br />
<br />