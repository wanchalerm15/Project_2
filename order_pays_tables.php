<table border="0" style="border-collapse: collapse;width: 100%;">
    <tr>
        <td style="vertical-align: top;font-size: 14px;" colspan="3">
            <?php
            require './web_server_script/php_function.php';
            $query = "select member.member_id,member_name,member_address,member_tel,member_identification "
                    . "from member,order_music where order_music.member_id=member.member_id "
                    . "and order_id=" . ORDER_ID;
            $resultjoin = mysql_query($query);
            list($member_id, $member_name, $member_address, $member_tel, $member_identification) = mysql_fetch_row($resultjoin);
            $result = mysql_query("select * from order_music where order_id=" . ORDER_ID);
            $order = mysql_fetch_array($result);
            ?>
            <h4 style="text-decoration: underline;padding: 2px;">
                <?= $WEB_THAI_NAME ?> 
                <span style="font-size: 14px;"><?= $WEB_ENG_NAME ?></span>
            </h4>
            <p style="font-size: 16px;">
                <b>ข้อมูลผู้สั่งซื้อ</b>
            </p>
            <p><b>ชื่อ :</b> <?= $member_name ?></p>
            <p><b>ที่อยู่ :</b> <?= $member_address ?></p>
            <p><b>เบอร์โทร :</b> <?= $member_tel ?></p>
            <p><b>หมายเลขประจำตัวประชาชน :</b> <?= $member_identification ?></p>
            <p><b>การชำระเงิน :</b> <?= checkPayment($order['order_pays']) ?></p>
            <p><b>สถานะ :</b> <?= order_status($order['order_status']) ?></p>
        </td>
        <td align='center' style="border: solid 2px;width: 25%;vertical-align: middle;" colspan="2">
            <h3><u>รายการสั่งซื้อ</u></h3>
            <h4>Order</h4>
        </td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td style="text-align: center;font-size: 14px;" colspan="2">
            <p><b>เลขที่ : <?= $order['order_id'] ?></b>/<?= $order['order_date'] ?></p>    
            <br />
        </td>
    </tr>
    <tr class="product_tr_orderTopic head">
        <td width='20px'><p></p></td>
        <td><p style="text-align: left;">รายการสินค้าเครื่องดนตรี</p> </td>
        <td> <p>จำนวน</p> </td>
        <td><p>ราคา/หน่วย</p></td>
        <td><p>รวมเป็นเงิน(บาท)</p></td>
    </tr>
    <?php
    $query_order = "select product_name,unit_price,product_price "
            . "from product,order_detail "
            . "where product.product_id=order_detail.product_id and order_id=" . ORDER_ID;
    $result_order = mysql_query($query_order);
    $num = 1;
    while ($row = mysql_fetch_array($result_order)) {
        ?>
        <tr class="product_tr_order">
            <td><p></p></td>
            <td><p style="text-align: left;"><?= $num++ ?>. <?= $row['product_name'] ?></p></td>
            <td><p><?= $row['unit_price'] ?></p></td>
            <td><p><?= number_format($row['product_price'], 2) ?></p></td>
            <?php
            $PriceAll = $row['unit_price'] * $row['product_price'];
            $unit_ALL = $unit_ALL + $row['unit_price'];
            ?>
            <td>
                <p><?= number_format($PriceAll, 2) ?></p>
            </td>
        </tr>
    <?php } ?>
    <tr class="product_tr_order">
        <td><p></p></td>
        <td><p style="text-align: left;">รวม</p></td>
        <td><p></p></td>
        <td><p></p></td>
        <td><p><?= number_format($order['order_priceall'], 2) ?></p></td>
    </tr>
    <tr class="product_tr_order">
        <td><p></p></td>
        <td><p style="text-align: left;">ภาษี <?= $WEB_TAX ?>%</p></td>
        <td><p></p></td>
        <td><p></p></td>
        <td><p><?= number_format($order['order_tax'], 2) ?></p></td>
    </tr>
    <tr class="product_tr_orderTopic buttom">
        <?php $sumPriceALL_Tax = $order['order_priceall'] + $order['order_tax'] ?>
        <td><p></p></td>
        <td><p style="text-align: left;">ราคารวมสุทธิ</p></td>
        <td><p></p></td>
        <td><p></p></td>
        <td><p><?= number_format($sumPriceALL_Tax, 2) ?></p></td>
    </tr>
    <tr>
        <td colspan="5">
            <h4 style="margin-top: 10px;text-align: center;">
                <?= $WEB_THAI_NAME ?> ขอบคุณที่ใช้บริการ
            </h4>
        </td>
    </tr>
</table>