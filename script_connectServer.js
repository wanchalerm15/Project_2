set_data = 0;
time = 0;
var data = "กำลังโหลด";
$(function() {
    $(".warning-unline").css("display", "none");
    $(".warning-inline").css("display", "none");
    $(".warning-inline").click(function() {
        warning_inlineClose();
    });
    /*------------------------------set checkbox---------------------------*/
    $("#checkAll_data").click(function() {
        var delete_check = document.getElementsByClassName('delete_check');
        if ($("#checkAll_data").html() == 'เลือกทั้งหมด') {
            for (i = 0; i < delete_check.length; i++) {
                delete_check[i].checked = true;
            }
            $("#checkAll_data").html('ยกเลิกการเลือก');
        } else {
            for (i = 0; i < delete_check.length; i++) {
                delete_check[i].checked = false;
            }
            $("#checkAll_data").html('เลือกทั้งหมด');
        }
    });

    /*------------------------------set img---------------------------*/
    $("h3.topic img.add").attr('src', 'images/topic_icon.png');
    $("p.title img.add").attr('src', 'images/title_icon.jpg');

    /*----------------------------set sidebar-------------------------------*/
    $("#artical.slidebar_aftershop").height($("#containur.after_shop").height() - 3);

    /*----------------------------set dialog-------------------------------*/
    $("#dialog,#dialog2").click(dialog_eixt);
    $("*").keyup(function(e) {
        if (e.keyCode == 27) {
            $("#dialog,#dialog2").hide();
        }
    });

});
function loding() {
    if (time <= 3) {
        data += ". ";
        time++;
    } else {
        data = "กำลังโหลด";
        time = 0;
    }
    $(".loading p.show").html(data);
    setTimeout(loding, 1000);
}
function warning_inlineClose() {
    $(".warning-unline").hide();
    $(".warning-inline").hide();
}
function dialog_eixt(e) {
    $("#dialog,#dialog2").fadeOut();
    e.stopPropagation();
}
function set_d(data) {
    set_data = data;
}
function get_d() {
    return set_data;
}
function change_row_Aftershop(id, url) {
    location = "?manage=" + url + "&row=" + $(id).val() + "#top";
}
function check_add_reg(id, table, where, data, text, select) {
    $.post("web_server_script/employee.php", {table: table, where: where, data: data, text: text, select: select, check_add_reg: 1}, function(data) {
        if (data) {
            $(id).removeAttr("class").addClass("warning-error").html(data);
        } else {
            $(id).removeAttr("class").addClass("warning-ok").html(text + " นี้สามารถใช้ได้");
        }
    });
}
function check_code(id, table, where, data, text, select) {
    $.post("web_server_script/employee.php", {table: table, where: where, data: data, text: text, select: select, check_code: 1}, function(data) {
        if (data) {
            $(id).removeAttr("class").addClass("warning-error").html(data);
        } else {
            $(id).removeAttr("class").addClass("warning-ok").html(text + " นี้สามารถใช้ได้");
        }
    });
}

/*------------------------------------------------------------------------------ category */
function show_table_category(category_id, start_row, end_row) {
    $.post("web_server_script/category.php", {
        start_row: start_row,
        end_row: end_row,
        show_table_category: 1
    },
    function(data) {
        if (data) {
            $("#show_table_category").html(data);
            if (category_id != 0) {
                $("tr.category_id_" + category_id).addClass("focus");
            }
        } else {
            $("#show_table_category").html("");
            $("top").removeAttr("class").addClass("warning-error").html("ไม่สามารถโหลดข้อมูลได้!");
        }
    });
}
/*------------------------------------------------------------------------------ add category */
function add_category() {
    var data = $("#add_category").serialize() + "&add_category=1";
    $.ajax({
        url: "web_server_script/category.php",
        data: data,
        type: 'POST',
        beforeSend: function(xhr) {

        },
        success: function(data, textStatus, jqXHR) {
            if (data) {
                $('#add_category_error').removeAttr('class').addClass('warning-error').html(data);
            } else {
                location.reload();
            }
        }
    });
}

/*------------------------------------------------------------------------------ delete category */
function delete_category_arrlay() {
    var delete_check_data = Array();
    $(":checkbox.delete_check:checked").each(function(index) {
        delete_check_data[index] = $(this).val();
    });
    $.ajax({
        url: "web_server_script/category.php",
        data: {delete_array: delete_check_data, delete_category_arrlay: 1},
        type: 'POST',
        beforeSend: function(xhr) {

        },
        success: function(data, textStatus, jqXHR) {
            if (!data) {
                location.reload();
            } else {
                $("#top").removeAttr("class").addClass("warning-error").html(data);
            }
        }
    });
}
function delete_category(category_id) {
    if (confirm("คุณต้องการลบประเภทสินค้าเครื่องดนตรีนี้ จริงหรือ!")) {
        $.ajax({
            url: "web_server_script/category.php",
            data: {category_id: category_id, delete_category: 1},
            type: 'GET',
            beforeSend: function(xhr) {

            },
            success: function(data, textStatus, jqXHR) {
                if (data) {
                    $('#top').removeAttr('class').addClass('warning-error').html(data);
                } else {
                    location.reload();
                }
            }
        });
    }
}

/*------------------------------------------------------------------------------ update category */
function update_category(category_id, width, position, start_row, end_row) {
    $("#dialog").fadeIn();
    if (width != 0) {
        $("#dialog .in-dialog").css({width: width + "%"});
    }
    if (position != 0) {
        $("#dialog .in-dialog").css({top: position + "%"});
    }
    $.ajax({
        url: "web_server_script/category.php",
        data: {
            category_id: category_id,
            start_row: start_row,
            end_row: end_row,
            show_update_category: 1
        },
        type: 'POST',
        beforeSend: function(xhr) {

        },
        success: function(data, textStatus, jqXHR) {
            $("#dialog .in-dialog").html(data);
        }
    });
}
/*------------------------------------------------------------------------------ /category */

/*---------------------------------------------------------------------------------------------- employee */

/*------------------------------------------------- delete array employee */
function delete_employee() {
    if (confirm("คุณต้องการลบรายการนี้จริงหรือ!")) {
        $.ajax({
            url: "web_server_script/employee.php",
            data: {employee_id_hidden: $("#employee_id_hidden").val(), delete_employee: 1},
            type: 'GET',
            beforeSend: function(xhr) {

            },
            success: function(data, textStatus, jqXHR) {
                if (data) {
                    $("#dialog_emp_error").removeAttr("class").addClass("warning-error").html(data);
                } else {
                    location.reload();
                }
            }
        });
    }
}

function delete_employee_arrlay() {
    var delete_check_data = Array();
    $(":checkbox.delete_check:checked").each(function(index) {
        delete_check_data[index] = $(this).val();
    });
    $.ajax({
        url: "web_server_script/employee.php",
        data: {delete_array: delete_check_data, delete_employee_arrlay: 1},
        type: 'POST',
        beforeSend: function(xhr) {

        },
        success: function(data, textStatus, jqXHR) {
            if (!data) {
                location.reload();
            } else {
                $("#top").removeAttr("class").addClass("warning-error").html(data);
            }
        }
    });
}
/*------------------------------------------------------------------------------ add_employee */
function add_employee() {
    $.ajax({
        url: "web_server_script/employee.php",
        data: $("#add_emplooyee").serialize() + "&add_employee=1",
        type: 'POST',
        beforeSend: function(xhr) {

        },
        success: function(data, textStatus, jqXHR) {
            if (data) {
                $("#add_employee_error").removeAttr("class").addClass("warning-error").html(data);
            } else
                location.reload();
        }
    });
}
/*------------------------------------------------------------------------------ show update_employee */
function show_update_employee(employee_id, width, position, start_row, end_row) {
    $("#dialog").fadeIn();
    if (width != 0) {
        $(".in-dialog").css("width", width + "%");
    }
    if (position != 0) {
        $(".in-dialog").css("top", position + "%");
    } else {
        $("#dialog").css({position: "absolute", height: $(document).height() + "px"});
        $(".in-dialog").css("top", ($(document).scrollTop() + 50) + "px");
    }
    $.ajax({
        url: "web_server_script/employee.php",
        data: {employee_id: employee_id, start_row: start_row, end_row: end_row, show_update_employee: 1},
        type: 'POST',
        beforeSend: function(xhr) {

        },
        success: function(data, textStatus, jqXHR) {
            $(".in-dialog").html(data);
        }
    });
}
/*------------------------------------------------------------------------------ update_employee */
function update_employee() {
    var start_row = $("#start_row").val();
    var end_row = $("#end_row").val();
    var id_main = $("#employee_id_hidden").val();
    var id_sub = $("#id_sub").val();
    $.ajax({
        url: "web_server_script/employee.php",
        data: $("#update_dialog_employee").serialize() + "&update_employee=1&id_main=" + id_main,
        type: 'POST',
        beforeSend: function(xhr) {

        },
        success: function(data, textStatus, jqXHR) {
            if (data) {
                $("#dialog_emp_error").removeAttr("class").addClass("warning-error").html(data);
            } else {
                show_table_employee(id_sub, start_row, end_row);
                $("#dialog").fadeOut();
            }
        }
    });
}

function show_table_employee(id, start_row, end_row) {
    $.ajax({
        url: "web_server_script/employee.php",
        data: {show_table_employee: 1, start_row: start_row, end_row: end_row},
        type: 'POST',
        beforeSend: function(xhr) {

        },
        success: function(data, textStatus, jqXHR) {
            $("#show_table_category").html(data);
            $("tr.employee_id_" + id).addClass("focus");
        }
    });
}
/*------------------------------------------------------------------------------ /employee */

/*------------------------------------------------------------------------------ member */
function signin_member(from_check_signin) {
    var data = $(from_check_signin).serialize();
    $.ajax({
        url: "./web_server_script/signin.php?login_signin=1",
        data: data,
        type: 'POST',
        success: function(error) {
            if (error) {
                $("#error_signin").removeAttr('class').addClass('warning-error').html(error);
                alert(error);
            } else {
                $("#error_signin").removeAttr('class').addClass("warning-ok").html("สมัครสมาชิกสำเร็จ");
                alert("สมัครสมาชิกสำเร็จ");
                $("#check_signin.signin .tx_signin").val("");
            }
        }
    });
}
function edit_member_mySelf(from_seririze) {
    var data = $(from_seririze).serialize();
    $.ajax({
        url: "./web_server_script/signin.php?edit_member_mySelf=1",
        data: data,
        type: 'POST',
        success: function(error) {
            if (error) {
                $("#member_myselfError").removeAttr('class').addClass('warning-error').html(error);
                alert(error);
            } else {
                $("#member_myselfError").removeAttr('class').addClass("warning-ok").html("แก้ไขข้อมูลสำเร็จ");
                alert("สำเร็จ");
                $("meta.refrest").html("<meta http-equiv=\"refresh\" content=\"1\">");
            }
        }
    });
}
function delete_member_arrlay() {
    var delete_check_data = Array();
    $(":checkbox.delete_check:checked").each(function(index) {
        delete_check_data[index] = $(this).val();
    });
    $.ajax({
        url: "web_server_script/member.php",
        data: {delete_array: delete_check_data, delete_member_arrlay: 1},
        type: 'POST',
        beforeSend: function(xhr) {

        },
        success: function(data, textStatus, jqXHR) {
            if (!data) {
                location.reload();
            } else {
                $("#top").removeAttr("class").addClass("warning-error").html(data);
            }
        }
    });
}

function add_member() {
    var data = $("#add_member").serialize() + "&add_member=1";
    $.ajax({
        url: "web_server_script/member.php",
        data: data,
        type: 'POST',
        beforeSend: function(xhr) {

        }, success: function(data, textStatus, jqXHR) {
            if (data) {
                $("#add_member_error").removeAttr("class").addClass("warning-error").html(data);
            } else {
                location.reload();
            }
        }
    });
}

function show_update_member(member_id, width, position, start_row, end_row) {
    $("#dialog").fadeIn();
    if (width != 0) {
        $(".in-dialog").css("width", width + "%");
    }
    if (position != 0) {
        $(".in-dialog").css("top", position + "%");
    } else {
        $("#dialog").css({position: "absolute", height: $(document).height() + "px"});
        $(".in-dialog").css("top", ($(document).scrollTop() + 50) + "px");
    }
    $.ajax({
        url: "web_server_script/member.php",
        data: {member_id: member_id, start_row: start_row, end_row: end_row, show_member_employee: 1},
        type: 'POST',
        beforeSend: function(xhr) {

        },
        success: function(data, textStatus, jqXHR) {
            $(".in-dialog").html(data);
        }
    });
}

function delete_member() {
    if (confirm("คุณต้องการลบรายการนี้จริงหรือ!")) {
        $.ajax({
            url: "web_server_script/member.php",
            data: {member_id_hidden: $("#member_id_hidden").val(), delete_member: 1},
            type: 'GET',
            beforeSend: function(xhr) {

            },
            success: function(data, textStatus, jqXHR) {
                if (data) {
                    $("#dialog_emp_error").removeAttr("class").addClass("warning-error").html(data);
                } else {
                    location.reload();
                }
            }
        });
    }
}

function update_member() {
    var start_row = $("#start_row").val();
    var end_row = $("#end_row").val();
    var id_main = $("#member_id_hidden").val();
    var id_sub = $("#id_sub").val();
    $.ajax({
        url: "web_server_script/member.php",
        data: $("#update_dialog_employee").serialize() + "&update_member=1&id_main=" + id_main,
        type: 'POST',
        beforeSend: function(xhr) {

        },
        success: function(data, textStatus, jqXHR) {
            if (data) {
                $("#dialog_emp_error").removeAttr("class").addClass("warning-error").html(data);
            } else {
                show_table_member(id_sub, start_row, end_row);
                $("#dialog").fadeOut();
            }
        }
    });
}

function show_table_member(id, start_row, end_row) {
    $.ajax({
        url: "web_server_script/member.php",
        data: {show_table_member: 1, start_row: start_row, end_row: end_row},
        type: 'POST',
        beforeSend: function(xhr) {

        },
        success: function(data, textStatus, jqXHR) {
            $("#show_table_category").html(data);
            $("tr.member_id_" + id).addClass("focus");
        }
    });
}
/*------------------------------------------------------------------------------ /member */

/*------------------------------------------------------------------------------ product */
function add_product(data) {
    $.ajax({
        url: "web_server_script/product.php?add_product=1",
        data: data,
        type: 'POST',
        beforeSend: function(xhr) {

        },
        success: function(data, textStatus, jqXHR) {
            if (data) {
                $("#add_product_error").removeAttr("class").addClass("warning-error").html(data);
            } else {
                location.reload();
            }
        }
    });
}
function delete_product_array() {
    var delete_check_data = Array();
    $(":checkbox.delete_check:checked").each(function(index) {
        delete_check_data[index] = $(this).val();
    });
    $.ajax({
        url: "web_server_script/product.php",
        data: {delete_array: delete_check_data, delete_product_array: 1},
        type: 'POST',
        beforeSend: function(xhr) {

        },
        success: function(data, textStatus, jqXHR) {
            if (!data) {
                location.reload();
            } else {
                $("#top").removeAttr("class").addClass("warning-error").html(data);
            }
        }
    });
}

function show_edit_product(product_name, product_id) {
    $("table.table_aftershop").hide();
    $("p.delete_data").hide();
    $("div.part_row").hide();
    $("p.title").html("<img src='images/title_icon.jpg'> แก้ไขสินค้าเครื่องดนตรี : <u>" + product_name + "</u>");
    $.ajax({
        url: "web_server_script/product.php",
        data: {product_id: product_id, show_edit_product: 1},
        type: 'POST',
        beforeSend: function(xhr) {

        },
        success: function(data, textStatus, jqXHR) {
            $("#show_edit_product").show().html(data);
        }
    });
}
function check_delete_show_productIMG(id) {
    if (confirm("ต้องการลบภาพนี้หรือ !")) {
        deleteProduct_img(id);
    } else {
        showProduct_img(id);
    }
}
function deleteProduct_img(id) {
    if (confirm("ต้องการลบภาพนี้จริงหรือ !")) {
        var product_id = $.trim(parseInt($(id).attr("id")));
        var image_delete = $.trim($(id).attr("title"));
        $.ajax({
            url: "web_server_script/product.php?deleteProduct_img=1",
            data: {product_id: product_id, image_delete: image_delete},
            beforeSend: function(xhr) {

            },
            success: function(data, textStatus, jqXHR) {
                if (data) {
                    $("#top").removeAttr("class").addClass("warning-error").html(data);
                } else {
                    $(id).fadeOut();
                }
            }
        });
    }
}
function showProduct_img(id) {
    var src_img = $(id).attr("title");
    $("#dialog").fadeIn();
    var data = "<div class='in_main'>";
    data += "<img src='image_product/" + src_img + "' clss='img_editShow' onload='loadSize_img(this)' style='box-shadow: 0 0 10px #000;border: solid 5px #fff;'>";
    data += "</div>";
    $("#dialog").html(data);
}
function loadSize_img(id) {
    var img_width = $(id).width();
    var img_height = $(id).height();
    var continur_height = $("#dialog").height();
    var continur_width = $("#dialog").width();
    $(id).css({position: "relative"});
    var top = (continur_height * 90) / 100;
    if (continur_width > continur_height) {
        if (img_width > img_height) {
            if (img_height > continur_height - 50 && img_width > continur_width - 50) {
                $(id).css("width", "90%").height(top);
            }
        } else {
            $(id).height(top);
        }
    } else if (continur_height > continur_width) {
        if (img_width > img_height) {
            $(id).css("width", "90%");
        } else {
            if (img_width > continur_width - 20) {
                $(id).css("width", "80%").height(top);
            } else {
                $(id).height(top);
            }
        }
    } else {
        $(id).css("width", "90%").height(top);
    }
}
function upload_img(id) {
    $("#dialog2").fadeIn();
    var data = "<div class='in_main'>";
    data += "<div id='artical'>";
    data += "<iframe src='web_server_script/iframe_uploadIMG.php?product_id=" + id + "' style='border: none;width:100%;height:260px;'></iframe>";
    data += "</div>";
    data += "</div>";
    $(".in-dialog").html(data).css({
        top: "5%",
        width: "50%"
    });
}
function show_img_product(product_id) {
    $.ajax({
        url: "web_server_script/product.php?show_img_product=1",
        data: {product_id: product_id},
        type: 'POST',
        beforeSend: function(xhr) {

        },
        success: function(data, textStatus, jqXHR) {
            $("span.show_img_product").html(data);
        }
    });
}

function deleteProduct_sound(proSound_name, product_id) {
    if (confirm("ต้องการลบเสียง " + proSound_name + " นี้จริงหรือ !")) {
        $.ajax({
            url: "web_server_script/product.php?deleteProduct_sound=1",
            data: {product_id: product_id, proSound_name: proSound_name},
            beforeSend: function(xhr) {

            },
            success: function(data, textStatus, jqXHR) {
                if (data) {
                    $(".warning-unline").fadeIn().html(data);
                } else {
                    showProduct_sound(product_id);
                }
            }
        });
    }
}
function showProduct_sound(product_id) {
    $.ajax({
        url: "web_server_script/product.php?showProduct_sound=1",
        data: {product_id: product_id},
        beforeSend: function(xhr) {

        },
        success: function(data, textStatus, jqXHR) {
            if (data) {
                $(".show_sound_product").html(data).fadeIn();
                $(".warning-unline").css("display", "none");
            }
        }
    });
}
function upload_sound(id) {
    $("#dialog2").fadeIn();
    var data = "<div class='in_main'>";
    data += "<div id='artical'>";
    data += "<iframe src='web_server_script/iframe_uploadIMG.php?upload_sound_id=" + id + "' style='border: none;width:100%;height:260px;'></iframe>";
    data += "</div>";
    data += "</div>";
    $(".in-dialog").html(data).css({
        top: "5%",
        width: "50%"
    });
}
function edit_product_main(data_inform) {
    $.ajax({
        url: "web_server_script/product.php?edit_product_main=1",
        data: data_inform,
        beforeSend: function(xhr) {

        },
        success: function(data, textStatus, jqXHR) {
            if (data) {
                $("#top").removeAttr("class").addClass("warning-error").html(data);
            } else {
                location.reload();
            }
        }
    });
}
function delete_product(data) {
    if (confirm("คุณต้องการลบสินค้าเครื่องดนตรีนี้หรือ !")) {
        $.ajax({
            url: "web_server_script/product.php?delete_product=1",
            data: data,
            beforeSend: function(xhr) {

            },
            success: function(data, textStatus, jqXHR) {
                if (data) {
                    $("#top").removeAttr("class").addClass("warning-error").html(data);
                } else {
                    location.reload();
                }
            }
        });
    }
}
/*------------------------------------------------------------------------------ /product */
/*----------------------------------------------------------------------------- order*/
function delete_order_arrlay() {
    var delete_check_data = Array();
    $(":checkbox.delete_check:checked").each(function(index) {
        delete_check_data[index] = $(this).val();
    });
    $.ajax({
        url: "web_server_script/order.php",
        data: {delete_array: delete_check_data, delete_order_arrlay: 1},
        type: 'POST',
        beforeSend: function(xhr) {

        },
        success: function(data, textStatus, jqXHR) {
            if (!data) {
                location.reload();
            } else {
                $("#top").removeAttr("class").addClass("warning-error").html(data);
            }
        }
    });
}
function receive_order(order_id, member_id, order_status) {
    $("#dialog").fadeIn();
    $(".in-dialog").css({"top": "10%", "width": "50%"});
    $.ajax({
        url: "web_server_script/order.php",
        data: {order_id: order_id, member_id: member_id, order_status: order_status, receive_order: 1},
        type: 'POST',
        beforeSend: function(xhr) {

        },
        success: function(data, textStatus, jqXHR) {
            $(".in-dialog").html(data).click(function(e) {
                $("#dialog").css("display", "block");
                e.stopPropagation();
            });
        }
    });
}
function receive_order_employee(form_id) {
    var data = $(form_id).serialize();
    $.ajax({
        url: "web_server_script/order.php?receive_order_employee=1",
        data: data,
        type: 'POST',
        beforeSend: function(xhr) {

        },
        success: function(data, textStatus, jqXHR) {
            if (!data) {
                location.reload();
            } else {
                $("#receive_order_employee_error").removeAttr('class').addClass('warning-error').html(data);
            }
        }
    });
}
function show_employee_receive_order(emp_id, receive_date, status, order_id) {
    $("#dialog").fadeIn().css({
        position: 'absolute',
        height: $(document).height() + 'px'
    });
    $(".in-dialog").css({
        "top": ($(window).scrollTop() + 30) + "px", "width": "50%"
    });
    $(".in-dialog").load("web_server_script/order.php?show_employee_receive_order=1&employee_id=" + emp_id, {receive_date: receive_date, status: status, order_id: order_id},
    function() {
        $(this).click(function(e) {
            $("#dialog").css("display", "block");
            e.stopPropagation();
        });
    });
}
function show_member_receive_order(member_id) {
    $("#dialog").fadeIn();
    $(".in-dialog").css({"top": "5%", "width": "50%"});
    $(".in-dialog").load("web_server_script/order.php?show_member_receive_order=1&member_id=" + member_id, function() {
        $(this).click(function(e) {
            $("#dialog").css("display", "block");
            e.stopPropagation();
        });
    });
}

/*----------------------------------------------------------------------------- /order*/

/*----------------------------------------------------------------------------- comment*/
function delete_comment_arrlay() {
    var delete_check_data = Array();
    $(":checkbox.delete_check:checked").each(function(index) {
        delete_check_data[index] = $(this).val();
    });
    $.ajax({
        url: "web_server_script/comment.php",
        data: {delete_array: delete_check_data, delete_comment_arrlay: 1},
        type: 'POST',
        beforeSend: function(xhr) {

        },
        success: function(data, textStatus, jqXHR) {
            if (!data) {
                location.reload();
            } else {
                $("#top").removeAttr("class").addClass("warning-error").html(data);
            }
        }
    });
}
/*----------------------------------------------------------------------------- /comment*/