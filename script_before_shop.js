/*------------------------------------------------------------------------------ product */
$(document).ready(function () {
    /* $(window).resize(function () {
     if ($(".sidebarMenu").height() <= $('.frame_img').height()) {
     if ($(window).width() > 640) {
     $(".sidebarMenu").css("height", $('.frame_img').height() + 70 + "px");
     }
     }
     });
     if ($(".sidebarMenu").height() <= $('.frame_img').height()) {
     if ($(window).width() > 640) {
     $(".sidebarMenu").css("height", $('.frame_img').height() + 70 + "px");
     }
     }*/
    /*------------------------- warning close -*/
    $(".warning span.close").attr("title", "ปิดการแจ้งแตือนนี้").html("&times;");
});
function setsizeIMG(id) {
    if ($(id).width() > $("#img_product").width()) {
        if ($(id).width() > $(id).height()) {
            $(id).width($("#img_product").width()).css("height", "auto");
        }
    }
}
function session_add_product(pro_id, cost) {
    $.get("web_server_script/order.php", {add_product: pro_id, cost: cost}, function (data) {
        if (data.error == 1) {
            alert("! สินค้านี้มีในตระกร้าแล้ว");
        }
        if (data.data) {
            if (confirm("เพิ่มสำเร็จ คุณต้องการซื้อต่อหรือไม่")) {
                var update = "ตระกร้าสินค้า :<img src='images/shopping_cast_icon.png'><sup>@</sup> [ " + data.data + " ]";
                $('.cast_shoping a').html(update);
            } else {
                location = 'order_cast.php';
            }
        }
    }, 'json');
}
function update_orderUnit(id, data_orderUpdate, data_indexUpdate, product_id) {
    if ($.trim($(id).val()) == "แก้ไขจำนวน") {
        $("#UniitOrder-" + data_indexUpdate).hide();
        $("#text_UpdateOrder-" + data_indexUpdate).fadeIn().focus();
        $(id).val("เสร็จสิ้น");
    } else {
        $.get("web_server_script/order.php", {
            data_orderUpdate: data_orderUpdate,
            data_indexUpdate: data_indexUpdate,
            product_id: product_id,
            update_orderUnit: 1
        }, function (data) {
            if (data) {
                alert(data);
            } else {
                location.reload();
            }
        });
    }
}
function remove_Order(index_unit) {
    if (confirm('ต้องการสินค้านี้ออกจริงหรือ !')) {
        $.get("web_server_script/order.php", {index_unit: index_unit, remove_Order: 1}, function (data) {
            if (data) {
                alert(data);
            } else {
                location.reload();
            }
        });
    }
}
function clear_session() {
    $.get("web_server_script/order.php?clear_session=1", function () {
        location.reload();
    });
}
function add_order(member_id, price_all, tax, order_cost) {
    $.post("web_server_script/order.php", {
        member_id: member_id,
        price_all: price_all,
        tax: tax,
        order_cost: order_cost,
        add_order: 1
    },
    function (data) {
        if (data) {
            $(".warning-inline").show().text(data);
        } else {
            document.getElementById('form_add_order').submit();
        }
    });
}
function update_member_to_pays(member_id, form_id) {
    var data = $(form_id).serialize() + "&member_id=" + member_id;
    $.ajax({
        url: "web_server_script/order.php?update_member_to_pays=1",
        type: 'POST',
        data: data,
        success: function (data, textStatus, jqXHR) {
            if (data) {
                $(".warning-inline").show().text(data);
            } else {
                $(form_id).submit();
            }
        }
    });
    return false;
}
function order_pays_step2(id, order_id) {
    var data = $(id).serialize() + "&order_id=" + order_id;
    $.ajax({
        url: "web_server_script/order.php?order_pays_step2=1",
        type: 'POST',
        data: data,
        success: function (data, textStatus, jqXHR) {
            if (data) {
                $(".warning-inline.errorstep2").show().text(data);
            } else {
                document.getElementById('order_pays').submit();
                //order_pays.php?step=3
            }
        }
    });
    return false;
}

function load_img_forShow(id) {
    if ($(id).height() > $(id).width()) {
        if ($(id).height() >= 400) {
            $(id).css({height: "400px"});
        }
    }
}

function add_comment(form_id, product_id) {
    var data = $(form_id).serialize();
    $.ajax({
        url: "web_server_script/comment.php?add_comment=1",
        type: 'POST',
        data: data,
        success: function (data, textStatus, jqXHR) {
            if (data) {
                $("#comment_error").show().html(data);
            } else {
                $("#comment .text").each(function () {
                    $(this).val("");
                });
                var doc = document.getElementById("wysiwygcomment_detail").contentWindow.document;
                doc.open();
                doc.write("");
                doc.close();
                load_comment(product_id);
                $("#comment_error").hide().fadeIn().html("เพิ่มความเห็นสำเร็จ").addClass("warning-ok");
            }
        }
    });
}

function load_comment(product_id) {
    $("#comment_show").load("web_server_script/comment.php?load_comment=1&product_id=" + product_id);
}
function delete_comment(comment_id) {
    if (confirm("คุณต้องการแจ้งลบความเห็นนี้จริงหรือ !")) {
        $.get("web_server_script/comment.php?delete_comment=1", {comment_id: comment_id}, function (data) {
            if (data) {
                $("#comment_del-" + comment_id).html(data).addClass("red");
            }
        });
    }
}
function delete_commect_cascade(comment_id) {
    if (confirm("คุณต้องการลบความเห็นนี้จริงหรือ !")) {
        $.get("web_server_script/comment.php?delete_commect_cascade=1", {comment_id: comment_id}, function (data) {
            if (data) {
                alert(data);
            } else {
                $("#comment-" + comment_id).fadeOut();
            }
        });
    }
}