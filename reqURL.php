<?php

include './web_server_script/connect_DB.php';
// การส่งคืนค่าของ การชำระเงินของ Paysbuy
$result = $_POST['result'];
$result = substr($result, 0, 2);
$amount = $_POST['amt'];
if ($result = 00) {
    $update_orderDetail = "UPDATE order_music SET order_status=5,order_date=NOW() WHERE order_id=" . ORDER_ID;
    mysql_query($update_orderDetail);
    echo "<script>location='http://localhost/Website_selling_musical_intrusment_PROJECT/order_pays.php?step=4'</script>";
} else {
    $update_orderDetail = "UPDATE order_music SET order_status=4,order_date=NOW() WHERE order_id=" . ORDER_ID;
    mysql_query($update_orderDetail);
    echo "<script>location='http://localhost/Website_selling_musical_intrusment_PROJECT/order_pays.php?step=4'</script>";
}
