<?php

session_start();
header("Content-Type: text/html; charset=utf-8");
include '../../web_server_script/edit_website.php';
define(FPDF_FONTPATH, "font_create/");
define(ORDER_ID, $_GET['ORDER']);
define(MEMBER_ID, $_GET['MEMBER']);


$result_member = mysql_query("select * from member where member_id=" . MEMBER_ID);
$member = mysql_fetch_array($result_member);
$result_order = mysql_query("select * from order_music where order_id=" . ORDER_ID);
$order = mysql_fetch_array($result_order);
$orderID = $order['order_id'];
$orderDate = $order['order_date'];
require '../../web_server_script/php_function.php';
$order_pays = checkPayment($order['order_pays']);
$orderStatus = order_status($order['order_status']);

$memberName = $member['member_name'];
$memberAddress = $member['member_address'];
$memberTel = $member['member_tel'];
$memberIdentification = $member['member_identification'];

require '../ThaiPDF.class.php';
$PDF = new ThaiPDF();
$PDF->AddThaiFont();
?>
<?php

$PDF->AddFont('angsana', ' ', 'angsa.php');
$PDF->AddFont('angsana', 'B', 'angsab.php');
$PDF->AddFont('angsana', 'I', 'angsai.php');
$PDF->AddFont('angsana', 'BI', 'angsaz.php');

$PDF->AddPage();
$PDF->SetFont("angsana", "I", 15);
$PDF->Image("../../images/pdf-logo.gif", 10, 10, 65, 15);
$PDF->SetXY(100, 20);
$PDF->SetDrawColor(220, 220, 220);
$PDF->MultiCell(100, 6, iconv("utf-8", "cp874", $WEB_ENG_NAME . " / order_id : " . ORDER_ID), 0, "R");
$PDF->Line(10, 28, 200, 28);
$PDF->SetFont("angsana", "B", 17);
$PDF->Write(17, iconv("utf-8", "cp874", "$WEB_THAI_NAME ( $WEB_ENG_NAME )"));
$PDF->SetXY(10, 30);
$PDF->SetFont("angsana", " ", 17);
/* -------------------------------------------------------------------------------- */
$PDF->SetXY(10, 40);
$PDF->SetFont("angsana", " ", 15);
$table = "<u>วันที่สั่งซื้อ : $orderDate</u>
<p />
<b><u>ข้อมูลผู้สั่งซื้อ</u></b>
<p />
       ชื่อ : $memberName  <br /><br />
       ที่อยู่ : $memberAddress <br /><br />
       เบอร์โทร : $memberTel <br /><br />
       หมายเลขประจำตัวประชาชน : $memberIdentification <br />
<br />
<b><u>รายการสั่งซื้อ เลขที่ $orderID</u></b>
<p />
    <table border=1 bordercolor=#000;>
    <tr>
        <td width=300 bgcolor=#e0e0e0><b>รายการสินค้าเครื่องดนตรี</b></td>
        <td width=90 bgcolor=#e0e0e0 align=center><b>จำนวน</b></td>
        <td width=170 bgcolor=#e0e0e0 align=center><b>ราคา/หน่วย</b></td>
        <td width=200 bgcolor=#e0e0e0 align=center><b>ราคารวม (บาท)</b></td>
    </tr>
";
$query = "select product_name,unit_price,product_price from "
        . "product,order_detail "
        . "where product.product_id=order_detail.product_id "
        . "and order_detail.order_id=" . ORDER_ID;
$que_porduct_order = mysql_query($query);
$num = 1;
while ($row = mysql_fetch_array($que_porduct_order)) {
    $table.="<tr>";
    $table.="<td width=300>  " . $num++ . ". " . $row['product_name'] . "</td>";
    $table.="<td width=90 align=center>" . number_format($row['unit_price']) . "</td>";
    $table.="<td width=170 align=center>" . number_format($row['product_price'], 2) . "</td>";
    $sumPriceALL = $row['unit_price'] * $row['product_price'];
    $table.="<td width=200 align=center>" . number_format($sumPriceALL, 2) . "</td>";
    $table.="</tr>";
}
$table.="<tr>";
$table.="<td width=300>&nbsp;</td>";
$table.="<td width=90 align=center>&nbsp;</td>";
$table.="<td width=170 align=center>" . "รวม" . "</td>";
$table.="<td width=200 align=center>" . number_format($order['order_priceall'], 2) . "</td>";
$table.="</tr>";
$table.="<tr>";
$table.="<td width=300>&nbsp;</td>";
$table.="<td width=90 align=center>&nbsp;</td>";
$table.="<td width=170 align=center>" . "ภาษี 5%" . "</td>";
$table.="<td width=200 align=center>" . number_format($order['order_tax'], 2) . "</td>";
$table.="</tr>";
$sumPriceALL_tax = $order['order_tax'] + $order['order_priceall'];
$table.="<tr>";
$table.="<td width=300 bgcolor=#e0e0e0><b>ราคารวมสุทธิ</b></td>";
$table.="<td width=90 align=center bgcolor=#e0e0e0>&nbsp;</td>";
$table.="<td width=170 align=center bgcolor=#e0e0e0>&nbsp;</td>";
$table.="<td width=200 align=center bgcolor=#e0e0e0><b>" . number_format($sumPriceALL_tax, 2) . " บาท </b></td>";
$table.="</tr>";
$table.="</table>";
$table.="<br />";
$table.="<b>การชำระเงิน : </b>$order_pays.<p />";
$table.="<b>สถานะ : </b>$orderStatus.<p />";
$PDF->writeHTML(iconv("utf-8", "cp874", $table));
$taxt.="<tr>";
$taxt.="<td width=760 align=center> $WEB_THAI_NAME ขอบคุณที่ใช้บริการ </td>";
$taxt.="</tr>";
$PDF->SetFont("angsana", " ", 13);
$PDF->writeHTML(iconv("utf-8", "cp874", $taxt));
/* ----------------------------------------------------------------------------------- */
$PDF->Output();
$PDF->Close();
