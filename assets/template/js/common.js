$.extend({
    redirectPost: function(location, args) {
        var form = $("<form></form>");
        form.attr("method", "post");
        form.attr("action", location);
        $.each(args, function(key, value) {
            var field = $("<input></input>");
            field.attr("type", "hidden");
            field.attr("name", key);
            field.attr("value", value);
            form.append(field);
        });
        $(form).appendTo("body").submit();
    },
});
$.fn.serializeObject = function() {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
// $('#bs_change_status').on('confirmed.bs.confirmation', function () {
//     var url = $('#bs_change_status').attr('url');
//     var current_status = $(this).attr('current_status');
//     var id = $(this).attr('list_id');
//     var sa_popupMessageSuccess = "Status Has been changed";
//     var sa_popupTitleSuccess = 'Success';
//     $.ajax({
//           url:url,
//           method:"post",
//           data:{id:id,current_status:current_status},
//           success:function(data) {
//             var jsondata = $.parseJSON(data);
//             if(jsondata == "success"){
//           swal({
//             title: sa_popupMessageSuccess,
//             type: 'success',
//           },
//           function(isConfirm){
//                 if (isConfirm){
//                   swal(sa_popupMessageSuccess, sa_popupMessageSuccess, "success");
//                   location.reload();
//                 }
//           });
//             } else {
//               alert('Oops!!! Something goes wrong');
//             }
//           }
//         });
//     });
var dataTable = $("#Dtable").DataTable();

function check_date_valid(dateval) {
    var date_status = "";
    // var action = base_url + 'common/check_date';
    // $.ajax({
    //     type: "POST",
    //     url: action,
    //     dataType: "html",
    //     data: {
    //         inp_date: dateval
    //     },
    //     async: false,
    //     success: function(jsons) {
    //         data = jQuery.parseJSON(jsons);
    //         if (data.status == "success") {
    //             date_status = "valid";
    //         } else {
    //             date_status = "invalid";
    //         }
    //     }
    // });
    date_status = "valid";
    return date_status;
}

function check_form_validation(formid = false) {
    if (formid) {
        var dates = $("#" + formid).find(".date");
        var date_status = null;
        var date_result = true;
        var hclass = null;
        var result = dates.each(function(key) {
            date_value = $(this).val();
            hclass = $(this).hasClass('required_field');
            // console.log('hclass'+hclass);
            // return false;
            date_status = check_date_valid(date_value);
            if (date_status != 'valid' && hclass != false) {
                $(this).addClass("form_error");
                date_result = false;
                return false;
            } else {
                $(this).removeClass("form_error");
            }
        });
        if (!date_result) {
            return "fail";
        }
        // var date_value=$("#" + formid).find(".date").val();
        // var date_status= check_date_valid(date_value);
        // // console.log(date_status);
        // if(date_status!='valid'){
        //   $(".date").addClass("form_error");
        //   $(".date").find("div.select2").addClass("form_error");
        //    return "fail";
        // }
        var reqlength = $("#" + formid).find(".required_field").not('.select2-container').length;
        var filderval = $("#" + formid).find(".required_field").not('.select2-container');
    } else {
        var reqlength = $(".required_field").not('.select2-container').length;
        var filderval = $(".required_field").not('.select2-container');
    }
    // console.log(reqlength);
    // console.log(filderval);
    var value = filderval.filter(function() {
        // var errmsg=$(this).data('errmsg');
        // var field_name=$(this).attr('name');
        // if(errmsg==''){
        //   errmsg='This field is required.';
        // }
        // console.log(field_name);
        // console.log(errmsg);
        // $('#err_'+field_name).html(errmsg);
        $(this).off("change keyup");
        $(this).on("change keyup", function() {
            //  errmsg=$(this).data('errmsg');
            //  field_name=$(this).attr('name');
            //  if(errmsg==''){
            // errmsg='This field is required.';
            // }
            if ($(this).val() === null || $(this).val() === undefined || $(this).val().length === 0) {
                // $('#err_'+field_name).html(errmsg);
                $(this).addClass("form_error");
                $(this).find("div.select2").addClass("form_error");
            } else {
                // $('#err_'+field_name).html('');
                $(this).removeClass("form_error");
                $(this).find("div.select2").removeClass("form_error");
            }
        });
        // field_name=$(this).attr('name');
        // errmsg=$(this).data('errmsg');
        // if(errmsg==''){
        //   errmsg='This field is required.';
        // }
        // console.log($(this));
        // console.log($(this).attr('name')," Value:",$(this).val());
        if ($(this).val() === null || $(this).val() === undefined || $(this).val().length === 0) {
            // $('#err_'+field_name).html(errmsg);
            $(this).addClass("form_error");
            $(this).find("div.select2").addClass("form_error");
        } else {
            // $('#err_'+field_name).html('');
            $(this).removeClass("form_error");
            $(this).find("div.select2").removeClass("form_error");
        }
        return this.value != "";
    });
    if (value.length >= 0 && value.length !== reqlength) {
        $(".notification_error").html("Please fill all of the required fields.");
        $(".notification_error").addClass("alert");
        setTimeout(function() {
            $(".notification ").html("");
            $(".notification").removeClass("alert");
            $(".notification_error ").html("");
            $(".notification_error").removeClass("alert");
        }, 3000);
        return "fail";
    } else {
        // console.log('All required fields are filled up.');
        return "success";
    }
}
$("#side-menu li:nth-child(9) .dropdown-submenu .dropdown-menu").on("show.bs.dropdown", function() {
    $("body").append($("#side-menu li:nth-child(9) .dropdown-submenu .dropdown-menu").css({
        position: "absolute",
        left: $("#side-menu li:nth-child(9) .dropdown-submenu .dropdown-menu").offset().left,
        top: $("#side-menu li:nth-child(9) .dropdown-submenu .dropdown-menu").offset().top,
    }).detach());
});
$(document).off("click", ".save");
$(document).on("click", ".save", function(e) {
    var formid = $(this).closest("form").attr("id");
    var isvalid = check_form_validation(formid);
    // console.log(isvalid);
    // return false;
    if (isvalid == "fail") {
        return false;
    }
    var is_printsticker = $("#is_printsticker").is(":checked");
    var formdata = new FormData($("form#" + formid)[0]);
    var againsrch = $(this).data("againsrch");
    // alert(againsrch);
    // printThis();
    // alert(is_printsticker);
    // return false;
    //alert(formid);
    //console.log(formdata);
    if (formid == "") {
        alert("Cann't Find Form Id");
        return false;
    }
    var action = $("#" + formid).attr("action");
    var reloadurl = $("#" + formid).data("reloadurl");
    var operation = $(this).data("operation");
    var hasck = $("#" + formid).data("hasck");
    var isactive = $(this).data("isactive");
    var isdismiss = $(this).data("isdismiss");
    var closediv = $(this).data("closediv");
    var isrefresh = $(this).data("isrefresh");
    var isredirect = $("#" + formid).data("isredirect");
    var print = $(this).data("print");
    if (print) {
        action = action + "/" + print;
    }
    // console.log()
    // alert(action);
    // return false;
    // var ptype=$(this).data('ptype');
    // alert(reloadurl);
    // alert(isactive);
    // return false;
    //  alert(action);
    //if has ckeditor
    if (hasck == "Y") {
        // var ckcount = $('.ckeditor').length;
        // var i;
        // for(i=0;i<=ckcount;i++){
        //   formdata.append('ck_field_'+i, CKEDITOR.instances['ck_field_'+i].getData());
        // }
        formdata.append("fali_description", CKEDITOR.instances["fali_description"].getData());
        formdata.append("fali_descriptionnp", CKEDITOR.instances["fali_descriptionnp"].getData());
    }
    if (operation && isactive == "Y") {
        formdata.append("operation", operation);
    }
    // console.log(formdata);
    // check if the input is valid
    $.ajax({
        type: "POST",
        url: action,
        // data:$('form#'+formid).serialize(),
        dataType: "html",
        contentType: false,
        processData: false,
        data: formdata,
        beforeSend: function() {
            // $(this).prop('disabled',true);
            // $(this).html('Saving..');
            $(".overlay").modal("show");
        },
        success: function(jsons) {
            // console.log(jsons);
            data = jQuery.parseJSON(jsons);
            // alert(data.status);
            if (data.status == "success") {
                var param = "";
                // t.find('#ResponseSuccess').html(data.message);
                // ResponseSuccess
                // $("#" + formid).find(".success").html(data.message);
                // $("#" + formid).find(".success").addClass("alert");
                $(".notification").html(data.message + "&nbsp;<i class='fa fa-times '></i>");
                $(".notification").addClass("alert");
                if (operation == "continue") {
                    param = data.param;
                }
                // $('#ResponseSuccess').html(data.message);
                if (is_printsticker == true) {
                    $(".showBarcode").html(data.barcodeprint);
                    setTimeout(function() {
                        $(".printBox").printThis();
                        // $('#barcodePrint').click();
                    }, 800);
                    if (isdismiss == "Y") {
                        $("#myModal1").modal("hide");
                        $("#myModal2").modal("hide");
                        $("#myView").modal("hide");
                    }
                    if (isrefresh == "Y") {
                        $("#searchByDate").trigger("click"); //this is for instant change status and refresh automatically
                        $("#searchPmdata").trigger("click"); //this is for instant change status and refresh automatically
                        // window.location.reload();
                    }
                    if (operation) {
                        setTimeout(function() {
                            $(".formdiv").load(reloadurl + "/");
                        }, 2000);
                    }
                } else {
                    if (isdismiss == "Y") {
                        if (closediv) {
                            setTimeout(function() {
                                $('#' + closediv).html("");
                            }, 1000);
                            $(".overlay").modal("hide");
                            return false;
                        }
                    }
                    if (operation) {
                        if (operation == "continue" && param) {
                            $(".formdiv").load(reloadurl + "/", {
                                param: param
                            });
                        } else {
                            $(".formdiv").load(reloadurl + "/");
                        }
                    }
                }
                if (print) {
                    $(".showPrintedArea").html(data.print_report);
                    setTimeout(function() {
                        $(".printBox").printThis();
                    }, 800);
                }
                if (isredirect) {
                    setTimeout(function() {
                        window.location.replace(reloadurl);
                    }, 800);
                }
                // if(operation)
                // {
                //    $(".formdiv").load(reloadurl+'/');
                // }
                setTimeout(function() {
                    // console.log($("#" + formid)[0]);
                    $("#" + formid)[0].reset();
                }, 2000);
                $(".btnRefresh").click();
                setTimeout(function() {
                    if (againsrch == "Y") {
                        $(".againSearch").click();
                    }
                }, 2000);
                // if(ptype=='setting')
                // {
                //   setTimeout(function(){
                //     window.location.reload();
                //   },3000);
                // }
            } else {
                // t.find('#ResponseError').html(data.message);
                // $("#" + formid).find(".error").html(data.message);
                // $("#" + formid).find(".error").addClass("alert");
                $(".notification_error ").html(data.message);
                $(".notification_error").addClass("alert");
                // $('#ResponseError').html(data.message);
            }
            $(".overlay").modal("hide");
            setTimeout(function() {
                //remove class and html contents
                $(".showPrintedArea").html("");
                // $("#" + formid).find(".success").html("");
                // $("#" + formid).find(".success").removeClass("alert");
                // $("#" + formid).find(".error").html("");
                // $("#" + formid).find(".error").removeClass("alert");
                $(".notification ").html("");
                $(".notification").removeClass("alert");
                $(".notification_error ").html("");
                $(".notification_error").removeClass("alert");
            }, 3000);
        },
    });
    return false;
});
$(document).off("click", ".overview");
$(document).on("click", ".overview", function() {
    // $('#printrpt').printThis();
    var equipkey = $(this).data("equipkey");
    var redirecturl = base_url + "biomedical/reports/overview_report";
    $.redirectPost(redirecturl, {
        equipkey: equipkey
    });
    return false;
});
$(document).off("click", ".savelist");
$(document).on("click", ".savelist", function() {
    var formid = $(this).closest("form").attr("id");
    var isdismiss = $(this).data("isdismiss");
    var isrefresh = $(this).data("isrefresh");
    var isuserregister = $(this).data("isuserregister");
    //alert(formid);
    if (formid == "") {
        alert("Cann't Find Form Id");
        return false;
    }
    var action = $("#" + formid).attr("action");
    // alert(action);
    // return false;
    $.ajax({
        type: "POST",
        url: action,
        data: $("form#" + formid).serialize(),
        dataType: "html",
        beforeSend: function() {
            $(".overlay").modal("show");
        },
        success: function(jsons) {
            // console.log(jsons);
            $(".overlay").modal("hide");
            data = jQuery.parseJSON(jsons);
            // alert(data.status);
            if (data.status == "success") {
                $(".overlay").modal("hide");
                $("#ResponseSuccess_" + formid).html(data.message);
                // $("#"+formid).find('.success').html(data.message);
                $("#" + formid).find(".success").html(data.message);
                $("#" + formid).find(".success").addClass("alert");
                setTimeout(function() {
                    $("#" + formid)[0].reset();
                }, 1000);
                setTimeout(function() {
                    //remove class and html contents
                    // $("#"+formid).find('.success').html('');
                    $("#" + formid).find(".success").removeClass("alert");
                    // $("#"+formid).find('.error').html('');
                    $("#" + formid).find(".error").removeClass("alert");
                    $("#ResponseSuccess_" + formid).html("");
                    $("#ResponseError_" + formid).html("");
                    if (isdismiss == "Y") {
                        $("#myModal1").modal("hide");
                        $("#myModal2").modal("hide");
                        $("#myView").modal("hide");
                        $("#pmCompletedModal").modal("hide");
                        $("#maintenanceModal").modal("hide");
                        $("#amcCompletedModal").modal("hide");
                    }
                    if (isrefresh == "Y") {
                        $("#searchByDate").trigger("click"); //this is for instant change status and refresh automatically
                        $("#searchPmdata").trigger("click"); //this is for instant change status and refresh automatically
                        // window.location.reload();
                    }
                    if (isuserregister == "Y") {
                        //this is for instant change status and refresh automatically
                        window.location.reload();
                    }
                }, 1000);
            } else {
                $("#ResponseError_" + formid).html(data.message);
                $("#" + formid).find(".error").html(data.message);
                $("#" + formid).find(".error").addClass("alert");
            }
            setTimeout(function() {
                //remove class and html contents
                $("#" + formid).find(".success").html("");
                $("#" + formid).find(".success").removeClass("alert");
                $("#" + formid).find(".error").html("");
                $("#" + formid).find(".error").removeClass("alert");
            }, 2000);
        },
    });
    return false;
});
$(document).off("click", ".btnEdit,.btnView");
$(document).on("click", ".btnEdit,.btnView", function() {
    var editurl = "";
    var iddata = $(this).data("id");
    var id = $("#id").val();
    if (iddata) {
        id = iddata;
    } else {
        id = id;
    }
    var viewurl = $(this).data("viewurl");
    var displaydiv = $(this).data("displaydiv");
    //alert(viewurl);
    //alert(displaydiv);
    //alert(id);
    if (viewurl) {
        editurl = viewurl;
    } else {
        editurl = $("#EditUrl").val();
    }
    // alert(editurl);
    // return false;
    // DeleteUrl
    $.ajax({
        type: "POST",
        url: editurl,
        data: {
            id: id
        },
        dataType: "html",
        beforeSend: function() {
            $(".overlay").modal("show");
        },
        success: function(jsons) {
            data = jQuery.parseJSON(jsons);
            // alert(data.status);
            if (data.status == "success") {
                if (displaydiv) {
                    // alert('test');
                    // $("#FormDiv_" + displaydiv).html("");
                    $("#FormDiv_" + displaydiv).html(data.tempform);
                } else {
                    // alert('test2');
                    $("#FormDiv").html(data.tempform);
                }
            } else {
                alert(data.message);
            }
            $(".overlay").modal("hide");
            $(".nepdatepicker").nepaliDatePicker({
                npdMonth: true,
                npdYear: true,
                //npdYearCount: 10 // Options | Number of years to show
            });
        },
    });
});
$(document).off("click", ".btnDelete");
$(document).on("click", ".btnDelete", function() {
    var conf = confirm("Are You Want to Sure to delete?");
    if (conf) {
        var deleteurl = "";
        var tableid = $(this).data("tableid");
        var id = $(this).data("id");
        if (tableid) {
            id = tableid;
        } else {
            id = id;
        }
        //alert(tableid); alert(id);
        if ($(this).data("deleteurl")) {
            deleteurl = $(this).data("deleteurl");
        } else {
            deleteurl = $("#DeleteUrl").val();
        }
        // alert(deleteurl);
        $.ajax({
            type: "POST",
            url: deleteurl,
            data: {
                id: id
            },
            dataType: "html",
            beforeSend: function() {
                $(".overlay").modal("show");
            },
            success: function(jsons) {
                data = jQuery.parseJSON(jsons);
                // alert(data.status);
                if (data.status == "success") {
                    $("#listid_" + id).fadeOut(1000, function() {
                        $("#listid_" + id).remove();
                    });
                } else {
                    alert(data.message);
                }
                $(".overlay").modal("hide");
            },
        });
    }
});
$(document).off("click", ".btnDeleteServer");
$(document).on("click", ".btnDeleteServer", function() {
    var status = $(this).data("changestatus");
    if (status == "changestatus") {
        var conf = confirm("Are You Sure to Change This Status ?");
    } else {
        var conf = confirm("Are You Want to Sure to delete?");
    }
    if (conf) {
        var deleteurl = "";
        var tableid = $(this).data("tableid");
        var id = $(this).data("id");
        if ($(this).data("deleteurl")) {
            deleteurl = $(this).data("deleteurl");
        } else {
            deleteurl = $("#DeleteUrl").val();
        }
        // alert(deleteurl);
        $.ajax({
            type: "POST",
            url: deleteurl,
            data: {
                id: id
            },
            dataType: "html",
            beforeSend: function() {
                $(".overlay").modal("show");
            },
            success: function(jsons) {
                data = jQuery.parseJSON(jsons);
                // alert(data.status);
                if (data.status == "success") {
                    $("#listid_" + tableid).fadeOut(1000, function() {
                        $("#listid_" + tableid).remove();
                    });
                } else {
                    alert(data.message);
                }
                $(".overlay").modal("hide");
            },
        });
    }
});
$(document).off("change", ".usertype");
$(document).on("change", ".usertype", function() {
    var utype = $(this).val();
    // alert(utype);
    if (utype == "Doctor") {
        $("#doctorDiv").show();
        $("#nurseDiv").hide();
        $("#otherDiv").hide();
    }
    if (utype == "Nurse") {
        $("#doctorDiv").hide();
        $("#nurseDiv").show();
        $("#otherDiv").hide();
    }
    if (utype == "Others") {
        $("#doctorDiv").hide();
        $("#nurseDiv").hide();
        $("#otherDiv").show();
    }
});
// $(document).on('keydown','input,select',function(e){
//              if(e.keyCode==13){
//             if($(':input:eq(' + ($(':input').index(this) + 1) + ')').attr('type')=='submit'){// check for submit button and submit form on enter press
//                  return true;
//                 }
//                 $(':input:eq(' + ($(':input ').index(this) + 1) + ')').focus();
//                return false;
//              }
// });
$(document).on("keydown", "input, select, textarea", function(e) {
    var self = $(this),
        form = self.parents("form:eq(0)"),
        focusable,
        next;
    if (e.keyCode == 13) {
        var classname = this.className;
        // alert(classname);
        if (classname.indexOf("jump_to_add") > -1) {
            $(".btnAdd").focus();
            $(".btnAdd").click();
            return false;
        }
        focusable = form.find("input,a,select,button,textarea").filter(":visible");
        next = focusable.eq(focusable.index(this) + 1);
        if (next.length) {
            next.focus();
        } else {
            form.submit();
        }
        return false;
    }
});
$(document).bind("keydown", function(e) {
    // console.log(e.which);
    if (e.ctrlKey && e.which == 83) {
        // console.log(e.which);
        e.preventDefault();
        $(".save").click();
        return false;
    }
    if (e.which == 113) {
        // console.log(e.which);
        e.preventDefault();
        $(".savePrint").click();
        return false;
    }
    if (e.altKey && e.which == 82) {
        e.preventDefault();
        $(".btnRefresh").click();
        return false;
    }
    if (e.altKey && e.which == 80) {
        //Alt+P For Printing
        e.preventDefault();
        $(".PrintThisNow").click();
        return false;
    }
    if (e.altKey && e.which == 65) {
        //Alt+P For Printing
        e.preventDefault();
        $(".btnAdd").click();
        return false;
    }
});
$(document).off("keypress keydown", ".enterinput");
$(document).on("keypress keydown", ".enterinput", function(e) {
    var id = $(this).data("id");
    // console.log(id);
    // return false;
    var targetbtn = $(this).data("targetbtn");
    var keycode = e.keyCode ? e.keyCode : e.which;
    if (id) {
        if (keycode == "13") {
            $("#" + targetbtn + "_" + id).click();
        }
    } else {
        if (keycode == "13") {
            $("#" + targetbtn).click();
        }
    }
});
$(document).on("keyup paste", ".number", function() {
    this.value = this.value.replace(/[^0-9]/g, "");
});
$("body").on("keydown keyup keypress change blur focus paste", ".float", function() {
    var target = $(this);
    var prev_val = target.val();
    setTimeout(function() {
        var chars = target.val().split("");
        var decimal_exist = false;
        var remove_char = false;
        $.each(chars, function(key, value) {
            switch (value) {
                case "0":
                case "1":
                case "2":
                case "3":
                case "4":
                case "5":
                case "6":
                case "7":
                case "8":
                case "9":
                case ".":
                    if (value === ".") {
                        if (decimal_exist === false) {
                            decimal_exist = true;
                        } else {
                            remove_char = true;
                            chars["" + key + ""] = "";
                        }
                    }
                    break;
                default:
                    remove_char = true;
                    chars["" + key + ""] = "";
                    break;
            }
        });
        if (prev_val != target.val() && remove_char === true) {
            target.val(chars.join(""));
        }
    }, 0);
});

function ValidateDate(dtValue) {
    var dtRegex = new RegExp(/\b\d{4}[\/]\d{1,2}[\/]\d{1,2}\b/);
    return dtRegex.test(dtValue);
}
$(document).on("keyup", ".date", function(e) {
    var dtVal = $(this).val();
    if (ValidateDate(dtVal)) {
        console.log("valid date");
    } else {
        // console.log('invalid valid date');
        $(this).next(".errmsg").html("Invalid Date Format").show().fadeOut("slow");
        $(this).focus();
        e.preventDefault();
    }
});
$(document).off("click", ".btnRefresh");
$(document).on("click", ".btnRefresh", function() {
    var listurl = $("#ListUrl").val(); //alert(listurl);
    $.ajax({
        type: "POST",
        url: listurl,
        dataType: "html",
        beforeSend: function() {
            $(".overlay").modal("show");
        },
        success: function(jsons) {
            data = jQuery.parseJSON(jsons);
            // alert(data.status);
            if (data.status == "success") {
                $("#TableDiv").html(data.template);
                var table = $("#Dtable").DataTable();
            } else {
                alert(data.message);
            }
            $(".overlay").modal("hide");
        },
    });
});
$(document).off("click", ".btnreset");
$(document).on("click", ".btnreset", function() {
    // alert('test');
    var url = $(this).data("reloadform");
    $(".formdiv").load(url);
});
$(document).off("click", ".btnRemoveClosestTr");
$(document).on("click", ".btnRemoveClosestTr", function() {
    // $(this).closest('tr').remove();
    $(this).closest("tr").fadeOut(500, function() {
        $(this).closest("tr").remove();
    });
});
var attrid = "";
var dtype = "";
$(document).on("keydown", ".searchText", function(e) {
    // $('.searchText').keydown(function (e) {
    attrid = $(this).attr("id");
    var srchtext = $(this).val();
    var srchdec = $(this).val();
    var serialno = $(this).val();
    var srchurl = $(this).data("srchurl");
    dtype = $(this).data("type");
    // alert(dtype);
    console.log(e.keyCode);
    switch (parseInt(e.keyCode)) {
        case 40:
            var cur = $("#DisplayBlock_" + attrid + " .flatTable tbody").find("tr.current");
            // console.log(cur.length);
            // console.log($('#DisplayBlock_'+attrid +' .flatTable tbody tr').first().addClass('current'));
            if (cur.length == 0) {
                $("#DisplayBlock_" + attrid + " .flatTable tbody tr").first().addClass("current");
                // console.log('current');
            } else {
                $("#DisplayBlock_" + attrid + " .flatTable  tbody").find("tr.current").removeClass("current").next().addClass("current");
            }
            break;
        case 38:
            var cur = $("#DisplayBlock_" + attrid + " .flatTable tbody").find("tr.current");
            if (cur.length == 0) {
                $("#DisplayBlock_" + attrid + " .flatTable tbody tr").last().addClass("current");
            } else {
                $("#DisplayBlock_" + attrid + " .flatTable tbody").find("tr.current").removeClass("current").prev().addClass("current");
            }
            break;
        case 13:
            var cur = $("#DisplayBlock_" + attrid + " .flatTable tbody").find("tr.current");
            if (cur.length > 0 && cur.is(":visible")) {
                cur.first().trigger("click");
                return false;
            }
            break;
        case 9:
            if ($("#DisplayBlock_" + attrid).is(":visible"))
                // $('#DisplayBlock_'+attrid).hide();
                return true;
            break;
    }
    // SPECIAL KEY TAB FUNCTION ENDS
    if (e.keyCode == "13" || e.keyCode == "18" || e.keyCode == "17" || e.keyCode == "40" || e.keyCode == "38" || e.keyCode == "39" || e.keyCode == "37" || e.keyCode == "9") {
        e.preventDefault();
        // alert('sl');
        if ($("#DisplayBlock_" + attrid).is(":visible")) return false;
    }
    // alert(srchurl);
    $.ajax({
        type: "POST",
        url: srchurl,
        data: {
            srchtext: srchtext,
            srchdec: srchdec,
            serialno: serialno
        },
        dataType: "html",
        beforeSend: function() {
            // $('.overlay').modal('show');
        },
        success: function(jsons) {
            // console.log(jsons);
            var jsondata = jQuery.parseJSON(jsons);
            // return false;
            // console.log(jsondata.data);
            $("#DisplayBlock_" + attrid).html(jsondata.template);
        },
    });
});
//   $(document).off('keypress','.searchText');
//    $(document).on('keypress','.searchText',function(event){
//   var keycode = (event.keyCode ? event.keyCode : event.which);
//   console.log(keycode);
//   if(keycode == '13'){
//     alert('You pressed a "enter" key in textbox');
//   }
// });
$(document).off("change", ".dropdownsrch");
$(document).on("change", ".dropdownsrch", function() {
    var attrid = $(this).attr("id");
    var id = $(this).val();
    var srchurl = $(this).data("srchurl");
    // alert(id);
    $.ajax({
        type: "POST",
        url: srchurl,
        data: {
            id: id
        },
        dataType: "html",
        beforeSend: function() {
            $(".overlay").modal("show");
        },
        success: function(jsons) {
            // console.log(jsons);
            var jsondata = jQuery.parseJSON(jsons);
            // return false;
            // console.log(jsondata.data);
            if (jsondata.status == "success") {
                $("#result_" + attrid).html(jsondata.template);
            } else {
                $("#result_" + attrid).html("");
            }
        },
    });
});
$(document).off("click", "#chang_pass");
$(document).on("click", "#chang_pass", function() {
    $("#password").val("");
    $("#change_password").html('<div class="dis_tab"><input name="password" type="password" autocomplete="false" class="form-control" id="password" size="30" /><span id="ChangeResponse"></span> <div style="margin-bottom: 0px; padding-bottom:0;" class="table-cell"><input class="p_change" type="button" name="Submit" value="Change" id="changed"  /></div></div>');
});
$(document).off("click", "#changed");
$(document).on("click", "#changed", function() {
    var password = $("#password").val();
    var userid = $("#id").val();
    var post_url = base_url + "/settings/users/change_password";
    $.ajax({
        type: "POST",
        url: post_url,
        data: {
            password: password,
            userid: userid
        },
        dataType: "html",
        success: function(datas) {
            data = jQuery.parseJSON(datas);
            // alert(data.status);
            if (data.status == "success") {
                $("#change_password").html('<p class="success">' + data.message + "</p>");
                setTimeout(function() {
                    $("#change_password").html("");
                    $("#change_password").html('********** <a href="javascript:void();" id="chang_pass">Click to Change Password</a>');
                }, 4000);
            } else {
                var focus = "";
                if (data.field == "password") {
                    $("#password").focus();
                }
                $("#ChangeResponse").html('<p class="text-danger">' + data.message + "</p>");
                setTimeout(function() {
                    $("#ChangeResponse").html("");
                }, 3000);
            }
        },
    });
});
$(document).off("click", ".trSelectData");
$(document).on("click", ".trSelectData", function() {
    var id = $(this).data("id");
    var name = $(this).data("name");
    var code = $(this).data("code");
    // console.log(code);
    // console.log(dtype);
    // console.log( $('#'+attrid+'_Code'));
    $("#" + attrid).val(name);
    $("#" + attrid + "id").val(id);
    if (dtype == "Test") {
        $("#" + attrid + "_Code").html(code);
    }
    $("#DisplayBlock_" + attrid).html("");
    // $('#DisplayBlock_'+attrid).hide();
});
$("body").click(function(e) {
    if (!$(e.target).closest(".DisplayBlock_").length) {
        $(".DisplayBlock").html("");
    }
});
$(document).off("click", ".historytab");
$(document).on("click", ".historytab", function(e) {
    var date = $(this).data("date");
    var id = $(this).data("id");
    var url = $(this).data("url");
    $(".formdiv").load(url + "/" + date);
});
$(document).off("click", ".btn_edit");
$(document).on("click", ".btn_edit", function() {
    var form = $(this).closest("form").attr("id");
    // alert(form);
    $("#" + form).find("input,textarea,select").attr("disabled", false);
    $(this).hide();
    $("#" + form).find("button[type=submit]").show();
    // $("#"+form+".save").css('display','block');
    // form.find('button[type=submit]').show();
    // form.find('input,textarea,select').attr('disabled', false);
    return false;
});
$(document).off("click", "#btnAddComplain");
$(document).on("click", "#btnAddComplain", function() {
    var compDate = $("#compDate").val();
    var compComplain = $("#compComplain").val();
    var compComplainid = $("#compComplainid").val();
    var compDuration = $("#compDuration").val();
    var compEntry = $("#compEntry").val();
    var template_complain = "<tr>";
    template_complain += '<td><input type="hidden" name ="compDate[]" value="' + compDate + '"> ' + compDate + '</td><td><input type="hidden" name ="compComplainid[]" value="' + compComplainid + '"><input type="hidden" name ="compComplain[]" value="' + compComplain + '">' + compComplain + '</td><td><input type="hidden" name ="compDuration[]" value="' + compDuration + '">' + compDuration + '</td><td><input type="hidden" name ="compEntry[]" value="' + compEntry + '">' + compEntry + '</td><td><a href="javascript:void(0)" class="btn btn-sm btn-danger btnRemoveClosestTr"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
    template_complain += "</tr>";
    $("#ComplainItem").append(template_complain);
    $("#compComplain").val("");
    $("compComplainid").val("");
    $("#compDuration").val("");
    $("#compEntry").val("");
});
$(document).off("click", "#btnAddhistory");
$(document).on("click", "#btnAddhistory", function() {
    var hisDate = $("#hisDate").val();
    var hisHistory = $("#hisHistory").val();
    var hisHistoryid = $("#hisHistoryid").val();
    var template_history = "<tr>";
    template_history += '<td><input type="hidden" name ="hisDate[]" value="' + hisDate + '"> ' + hisDate + '</td><td><input type="hidden" name ="hisHistoryid[]" value="' + hisHistoryid + '"><input type="hidden" name ="hisHistory[]" value="' + hisHistory + '">' + hisHistory + '</td><td><a href="javascript:void(0)" class="btn btn-sm btn-danger btnRemoveClosestTr"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
    template_history += "</tr>";
    $("#HistoryItem").append(template_history);
    $("#hisHistory").val("");
    $("#hisHistoryid").val("");
});
$(document).off("click", "#btnServices");
$(document).on("click", "#btnServices", function() {
    var patienttype = $("#patienttype").val();
    var testnamecode = $("#TestNameList_Code").html();
    var testname = $("#TestNameList").val();
    var qty = $("#testQty").val();
    var template_history = "<tr>";
    template_history += '<td><input type="hidden" name ="patientType[]" value="' + patienttype + '"> ' + patienttype + '</td><td><input type="hidden" name ="testnamecode[]" value="' + testnamecode + '">' + testnamecode + '</td><td><input type="hidden" name ="testname[]" value="' + testname + '">' + testname + '</td><td><input type="hidden" name ="qty[]" value="' + qty + '">' + qty + '</td><td><a href="javascript:void(0)" class="btn btn-sm btn-danger btnRemoveClosestTr"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
    template_history += "</tr>";
    $("#ServicesItem").append(template_history);
    // $('#patienttype').val('');
    $("#TestNameList_Code").html("");
    $("#TestNameList").val("");
    $("#testQty").val("");
});
$(".select2").select2();
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});
$(document).on("change", "#departmentid", function() {
    var depid = $(this).val();
    var action = base_url + "biomedical/bio_medical_inventory/get_room_from_depid";
    // alert(depid);
    $.ajax({
        type: "POST",
        url: action,
        data: {
            depid: depid
        },
        dataType: "json",
        success: function(datas) {
            // console.log(datas);
            var opt = "";
            opt = '<option value="">---select---</option>';
            $.each(datas, function(i, k) {
                opt += "<option value=" + k.rode_roomdepartmentid + ">" + k.rode_roomname + "</option>";
            });
            $("#bmin_roomid").html(opt);
        },
    });
});
$(document).off("click", ".view");
$(document).on("click", ".view", function() {
    var id = $(this).data("id");
    // alert(id);
    var action = $(this).data("viewurl");
    var heading = $(this).data("heading");
    var postdata = {};
    // alert(action);
    var storeid = $(this).data("storeid");
    var location = $(this).data("locationid");
    var store_id = $(this).data("store_id");
    var fiscal_year = $(this).data("fyear");
    var yrs = $(this).data("yrs");
    var month = $(this).data("month");
    var appstatus = $(this).data("appstatus");
    var invoiceno = $(this).data("invoiceno");
    var fromDate = $(this).data("fromdate");
    var toDate = $(this).data("todate");
    var type = $(this).data("type"); //this is for loading transfer data into popup
    if (storeid) {
        postdata = {
            id: id,
            storeid: storeid,
            type: type
        }; // In case of Store
    } else {
        postdata = {
            type: type,
            fromDate: fromDate,
            toDate: toDate,
            id: id,
            appstatus: appstatus,
            fiscal_year: fiscal_year,
            store_id: store_id,
            location: location,
            month: month,
            yrs: yrs,
            invoiceno: invoiceno,
        };
    }
    $("#myView").modal("show");
    $("#MdlLabel").html(heading);
    $.ajax({
        type: "POST",
        url: action,
        data: postdata,
        dataType: "html",
        beforeSend: function() {
            $(".overlay").modal("show");
        },
        success: function(jsons) {
            data = jQuery.parseJSON(jsons);
            // alert(data.status);
            if (data.status == "success") {
                // console.log(data.tempform);
                $(".displyblock").html(data.tempform);
            } else {
                alert(data.message);
            }
            $(".overlay").modal("hide");
        },
    });
});
$(document).off("click", ".btnpmdata");
$(document).on("click", ".btnpmdata", function() {
    var pmcount = $(this).data("pmcount");
    var month = $(this).data("month");
    var year = $(this).data("year");
    var week = $(this).data("week");
    var date = $(this).data("date");
    var type = $(this).data("type");
    var pmcat = $(this).data("pmcat");
    var title = $(this).data("title");
    var url = $(this).data("url");
    // alert(pmcount);
    // alert(month);
    // alert(year);
    $("#myView").modal("show");
    $("#MdlLabel").html(title);
    $(".modal-dialog").addClass("modal-lg");
    $.ajax({
        type: "POST",
        url: url,
        data: {
            pmcount: pmcount,
            month: month,
            year: year,
            week: week,
            date: date,
            type: type,
            pmcat: pmcat,
        },
        dataType: "html",
        beforeSend: function() {
            $(".overlay").modal("show");
        },
        success: function(jsons) {
            data = jQuery.parseJSON(jsons);
            // alert(data.status);
            if (data.status == "success") {
                console.log(data.tempform);
                $(".displyblock").html(data.tempform);
            } else {
                alert(data.message);
            }
            $(".overlay").modal("hide");
        },
    });
});
/* --------------------------------------------Start Repair Request ------------------------*/
// For Repair Request COnformation
$(document).off("click", ".confirmation");
$(document).on("click", ".confirmation", function() {
    var dtablelist = $("#repairTableInfo").dataTable();
    var confirm = $(this).data("confirm");
    var repairid = $(this).data("repairid");
    // return false;
    // alert(confirm);
    if (confirm == "yes") {
        $.ajax({
            type: "POST",
            url: base_url + "biomedical/repair_request_info/updateRepairStatus",
            data: {
                repairid: repairid
            },
            dataType: "json",
            success: function(datas) {
                // alert(datas.message);
                if (datas.status == "success") {
                    $(".success").html(datas.message);
                } else {
                    $(".error").html(datas.message);
                }
                $("#myView").modal("hide");
                dtablelist.fnDraw();
            },
        });
    } else {
        $("#myView").modal("hide");
        return false;
    }
});
$(document).on("keyup", ".cal", function() {
    var totalamtcost = 0;
    var tblid = $(this).data("tblid");
    var qty = $("#qty_" + tblid).val();
    var rate = $("#rate_" + tblid).val();
    if (qty == "") {
        qty = 0;
    }
    if (rate == "") {
        rate = 0;
    }
    var total = qty * rate;
    // alert(total);
    $("#total_" + tblid).val(total);
    $(".total").each(function() {
        totalamtcost += parseFloat($(this).val()); // Or this.innerHTML, this.innerText
    });
    // alert(totalamtcost);
    $("#material_cost").html(totalamtcost);
    $("#matcost").val(totalamtcost);
    // $('.calcost').keyup();
    $(".calcost").change();
});
$(document).off("click", ".btnAddParts");
$(document).on("click", ".btnAddParts", function() {
    var templete = "";
    var cnt = $(".parts_dtl").length;
    var next = cnt + 1;
    templete = '<tr class="parts_dtl" id="parts_dtl_' + next + '"><td><input type="text" name="parts_name[]" class="form-control"></td><td><input type="text" name="qty[]" data-tblid="' + next + '" class="form-control number cal " id="qty_' + next + '"></td><td><input type="text" name="rate[]" data-tblid="' + next + '" class="form-control float cal" id="rate_' + next + '"></td><td><input type="text" name="total[]" class="form-control total" id="total_' + next + '" readonly="true"></td><td><a href="javascript:void(0)" class="btn btn-sm btn-danger btnsubParts" data-id=' + next + '><i class="fa fa-minus" aria-hidden="true"></i></a></td></tr>';
    $("#tbl_parts").append(templete);
});
$(document).off("click", ".btnsubParts");
$(document).on("click", ".btnsubParts", function() {
    var id = $(this).data("id");
    var whichtr = $(this).closest("tr");
    whichtr.remove();
    var conf = confirm("Are You Want to Sure to remove?");
    if (conf) {
        $("#parts_dtl_" + id).fadeOut(1000, function() {
            $("#parts_dtl_" + id).remove();
        });
    }
    var totalamtcost = 0;
    $(".total").each(function() {
        totalamtcost += parseFloat($(this).val()); // Or this.innerHTML, this.innerText
    });
    // alert(totalamtcost);
    $("#material_cost").html(totalamtcost);
    $("#matcost").val(totalamtcost);
    $(".calcost").change();
});
$(document).on("keyup change", ".calcost", function() {
    var technicalcost = $("#technicalcost").val();
    var material_cost = $("#matcost").val();
    var othercost = $("#othercost").val();
    if (technicalcost == "" || technicalcost == NaN) {
        technicalcost = 0;
    } else {
        technicalcost = parseFloat(technicalcost);
    }
    if (material_cost == "" || material_cost == NaN) {
        material_cost = 0;
    } else {
        material_cost = parseFloat(material_cost);
    }
    if (othercost == "" || technicalcost == NaN) {
        othercost = 0;
    } else {
        othercost = parseFloat(othercost);
    }
    // console.log('mat'+material_cost);
    // console.log('tec'+technicalcost);
    // console.log('oth'+othercost);
    var grandtotal = parseFloat(technicalcost) + parseFloat(material_cost) + parseFloat(othercost);
    // console.log(grandtotal);
    $("#grandtotal").html(grandtotal);
    $("#rere_totalcost").val(grandtotal);
});
$(document).off("click", ".isparts");
$(document).on("click", ".isparts", function() {
    var is_parts = $(this).val();
    // alert(is_parts);
    if (is_parts == "Y") {
        $("#is_partsused").show(800);
    } else {
        $("#is_partsused").hide(800);
    }
});
/* --------------------------------------------End Repair Request  ------------------------*/
$(document).off("click", ".savePrint");
$(document).on("click", ".savePrint", function() {
    var formid = $(".save").closest("form").attr("id");
    var is_printsticker = $("#is_printsticker").is(":checked");
    var formdata = new FormData($("form#" + formid)[0]);
    var againsrch = $(this).data("againsrch");
    var print = $(this).data("print");
    var isvalid = check_form_validation(formid);
    var isredirect = $("#" + formid).data("isredirect");
    if (isvalid == "fail") {
        return false;
    }
    if (formid == "") {
        alert("Cann't Find Form Id");
        return false;
    }
    var action = $("#" + formid).attr("action");
    var reloadurl = $("#" + formid).data("reloadurl");
    var refresh = $("#" + formid).data("refresh");
    var operation = $(this).data("operation");
    // var ptype=$(this).data('ptype');
    // alert(operation);
    //  alert(reloadurl);
    // return false;
    if (print) {
        action = action + "/" + print;
    }
    //alert(action);
    $.ajax({
        type: "POST",
        url: action,
        // data:$('form#'+formid).serialize(),
        dataType: "html",
        contentType: false,
        processData: false,
        data: formdata,
        beforeSend: function() {
            // $(this).prop('disabled',true);
            // $(this).html('Saving..');
            $(".overlay").modal("show");
        },
        success: function(jsons) {
            // console.log(jsons);
            data = jQuery.parseJSON(jsons);
            // alert(data.status);
            if (data.status == "success") {
                // t.find('#ResponseSuccess').html(data.message);
                // ResponseSuccess
                // $("#" + formid).find(".success").html(data.message);
                // $("#" + formid).find(".success").addClass("alert");
                $(".notification").html(data.message + "&nbsp;<i class='fa fa-times '></i>");
                $(".notification").addClass("alert");
                // $('#ResponseSuccess').html(data.message);
                if (is_printsticker == true) {
                    $(".showBarcode").html(data.barcodeprint);
                    setTimeout(function() {
                        $(".printBox").printThis();
                        // $('#barcodePrint').click();
                    }, 800);
                    if (operation) {
                        setTimeout(function() {
                            $(".formdiv").load(reloadurl + "/");
                        }, 2000);
                    }
                }
                // else
                // {
                //     if(operation)
                //     {
                //         $(".formdiv").load(reloadurl+'/');
                //     }
                // }
                if (print) {
                    $(".print_report_section").show();
                    $(".print_report_section").html(data.print_report);
                    setTimeout(function() {
                        $(".printTable").printThis();
                    }, 600);
                    if (isredirect) {
                        setTimeout(function() {
                            window.location.replace(reloadurl);
                        }, 1500);
                    }
                    setTimeout(function() {
                        $(".formdiv").load(reloadurl + "/");
                    }, 4000);
                } else {
                    if (operation) {
                        $(".formdiv").load(reloadurl + "/");
                    }
                }
                setTimeout(function() {
                    $("#" + formid)[0].reset();
                    $(".print_report_section").hide();
                }, 2000);
                $(".btnRefresh").click();
                setTimeout(function() {
                    if (againsrch == "Y") {
                        $(".againSearch").click();
                    }
                }, 2000);
            } else {
                // t.find('#ResponseError').html(data.message);
                // $("#" + formid).find(".error").html(data.message);
                // $("#" + formid).find(".error").addClass("alert");
                $(".notification_error ").html(data.message);
                $(".notification_error").addClass("alert");
                // $('#ResponseError').html(data.message);
            }
            $(".overlay").modal("hide");
            setTimeout(function() {
                //remove class and html contents
                // $("#" + formid).find(".success").html("");
                // $("#" + formid).find(".success").removeClass("alert");
                // $("#" + formid).find(".error").html("");
                // $("#" + formid).find(".error").removeClass("alert");
                $(".notification ").html("");
                $(".notification").removeClass("alert");
                $(".notification_error ").html("");
                $(".notification_error").removeClass("alert");
                //$('.print_report_section').hide();
                // if(operation)
                // {
                //     setTimeout(function(){
                //     $(".formdiv").load(refresh+'/');
                //     },2000)
                // }
            }, 3000);
        },
    });
    return false;
});
$(document).off("click", ".generate_export_file");
$(document).on("click", ".generate_export_file", function() {
    // alert(test);
    console.log('export');
    var dataurlLink = $(this).data("dataurl");
    var moduleLocation = $(this).data("location");
    var tableid = $(this).data("tableid");
    var type = $(this).data("type");
    var page_orientation = $('#page_orientation').val();
    var dataurl = base_url + dataurlLink;
    if (type == "excel") {
        window.location = base_url + moduleLocation + "/?" + $.param($(tableid).DataTable().ajax.params());
    } else if (type == "pdf") {
        window.open(base_url + moduleLocation + "/?" + $.param($(tableid).DataTable().ajax.params()) + "&page_orientation=" + page_orientation, "_blank");
    }
});
//keypress table
function model_keypress() {
    var firstTR = $(".keypresstable tbody tr:first");
    var lastTR = $(".keypresstable tbody tr:last");
    firstTR.addClass("selected");
    var selectedTR = $(".keypresstable").find(".selected");
    $.singleDoubleClick = function(singleClk, doubleClk) {
        return (function() {
            var alreadyclicked = false;
            var alreadyclickedTimeout;
            return function(e) {
                if (alreadyclicked) {
                    // double
                    //end double click
                    alreadyclicked = false;
                    alreadyclickedTimeout && clearTimeout(alreadyclickedTimeout);
                    doubleClk && doubleClk(e);
                } else {
                    // single
                    var keyPressTableList = $(".keyPressTable");
                    if ($(this).hasClass("selected")) {
                        $(this).removeClass("selected");
                    } else {
                        keyPressTableList.find("tr.selected").removeClass("selected");
                        $(this).addClass("selected");
                    }
                    //end single click
                    alreadyclicked = true;
                    alreadyclickedTimeout = setTimeout(function() {
                        alreadyclicked = false;
                        singleClk && singleClk(e);
                    }, 500);
                }
            };
        })();
    };
    $(".keyPressTable tbody tr").off("click", $.singleDoubleClick);
    $(".keyPressTable tbody tr").on("click", $.singleDoubleClick(function(e) {
        //click.
        console.log("click");
    }, function(e) {
        //double click.
        console.log("doubleclick");
    }));
    $("#myView").off("keydown");
    $("#myView").on("keydown", function(event) {
        selectedTR = $(".keypresstable").find(".selected");
        selectedTR.focus();
        var rowid = selectedTR.data("rowid");
        console.log("rowid" + rowid);
        var numTR = $(".keypresstable tr").length - 1;
        console.log(numTR);
        var keypressed = event.keyCode;
        console.log(keypressed);
        if (keypressed == "40" && rowid < numTR) {
            console.log("next");
            selectedTR.removeClass("selected");
            nextTR = selectedTR.next("tr");
            nextTR.addClass("selected");
            nextTR.focus();
            // req_masterid = nextTR.data('masterid');
            setTimeout(function() {
                // alert('focus');
                nextTR.focus();
            }, 1500);
        }
        if (keypressed == "38" && rowid != "1") {
            console.log("prev");
            selectedTR.removeClass("selected");
            prevTR = selectedTR.prev("tr");
            prevTR.addClass("selected");
            // req_masterid = prevTR.data('masterid');
            setTimeout(function() {
                console.log("focus" + prevTR);
                // alert('focus');
                prevTR.focus();
            }, 1500);
        }
        if (keypressed == "13") {
            event.preventDefault()
            // console.log('enter pressed');
            $(".selected").click();
        }
    });
}

function ajaxPostSubmit(submiturl, submitdata, beforeSend = false, onSuccess = false) {
    $.ajax({
        type: "POST",
        url: submiturl,
        data: submitdata,
        dataType: "html",
        beforeSend: beforeSend,
        success: onSuccess,
    });
}

function compare_date(date1, date2, selected_element, errorMsg) {
    if (date1 > date2) {
        $(".error").html(errorMsg).show().delay(3000).fadeOut();
        $(selected_element).val(date2);
        $(selected_element).focus();
    }
    $(document).off("click", ".ndp-date");
    $(document).on("click", ".ndp-date", function() {
        $(selected_element).change();
    });
}

function checkValidValue(value = false, selector = false) {
    if (isNaN(value) || value == "" || value == "Infinity") {
        value = 0;
        if (selector) {
            $("#" + selector).val(0);
            $("#" + selector).select();
        }
    } else {
        value = parseFloat(value);
    }
    return value;
}
$(document).off("click", ".redirectedit");
$(document).on("click", ".redirectedit", function() {
    var id = $(this).data("id");
    var detailid = $(this).data("detailid");
    var date = $(this).data("date");
    var mid = $(this).data("mid"); //this is for challan entry
    var redirecturl = $(this).data("viewurl");
    $.redirectPost(redirecturl, {
        mid: mid,
        id: id,
        detailid: detailid,
        date: date,
    });
});
$(".mobile-tabs").click(function(event) {
    // console.log("clicked");
    event.preventDefault();
    $(".self-tabs").toggleClass("show");
    // $('.self-tabs').css('height', 'auto');
    $(".page-tabs").toggleClass("margin-top");
    $(".tabs-dropdown_toogle").toggleClass("arrow-up");
});
//this is for reprint section in report
$(document).off("click", ".ReprintThis");
$(document).on("click", ".ReprintThis", function() {
    $(".printTable").show();
    var print = $(this).data("print");
    var iddata = $(this).data("id");
    var id = $("#id").val();
    var actionurl = $(this).data("actionurl");
    var viewurl = $(this).data("viewdiv");
    var breakpage = $(this).data("breakpage");
    // alert(breakpage);
    if (iddata) {
        id = iddata;
    } else {
        id = id;
    }
    $.ajax({
        type: "POST",
        url: actionurl,
        data: {
            id: id
        },
        dataType: "html",
        beforeSend: function() {
            $(".overlay").modal("show");
        },
        success: function(jsons) {
            data = jQuery.parseJSON(jsons);
            // alert(data.status);
            if (data.status == "success") {
                $(".printTable").show();
                // alert(viewurl);
                $("#" + viewurl).html(data.tempform);
                if (viewurl) {
                    $("#" + viewurl).printThis();
                } else {
                    $(".printTable").printThis();
                }
                if ($(".print_break_page")[0]) {
                    $("#break_page").show();
                    $("#break_page").printThis();
                }
            } else {
                alert(data.message);
            }
            setTimeout(function() {
                $("#break_page").hide();
                $(".newPrintSection").hide();
                $("#myView").modal("hide");
            }, 2000);
            $(".overlay").modal("hide");
        },
    });
});

function convert_to_unicode() {
    var array_one = new Array("ç", "˜", ".", "'m", "]m", "Fmf", "Fm", ")", "!", "@", "#", "$", "%", "^", "&", "*", "(", "k|m", "em", "km", "Qm", "qm", "N˜", "¡", "¢", "1", "2", "4", ">", "?", "B", "I", "Q", "ß", "q", "„", "‹", "•", "›", "§", "°", "¶", "¿", "Å", "Ë", "Ì", "Í", "Î", "Ý", "å", "6«", "7«", "8«", "9«", "Ø", "|", "8Þ", "9Þ", "S", "s", "V", "v", "U", "u", "£", "3", "ª", "R", "r", "5", "H", "h", "‰", "´", "~", "`", "6", "7", "8", "9", "0", "T", "t", "Y", "y", "b", "W", "w", "G", "g", "K", "k", "ˆ", "A", "a", "E", "e", "D", "d", "o", "/", "N", "n", "J", "j", "Z", "z", "i", ":", ";", "X", "x", "cf‘", "c‘f", "cf}", "cf]", "cf", "c", "O{", "O", "pm", "p", "C", "P]", "P", "f‘", '"', "'", "+", "f", "[", "\\", "]", "}", "F", "L", "M", "्ा", "्ो", "्ौ", "अो", "अा", "आै", "आे", "ाो", "ाॅ", "ाे", "ंु", "ेे", "अै", "ाे", "अे", "ंा", "अॅ", "ाै", "ैा", "ंृ", "ँा", "ँू", "ेा", "ंे"); // Remove typing mistakes in the original file
    //"_","Ö","Ù","Ú","Û","Ü","Þ","Æ","±","-","<","=")    // Punctuation marks
    var array_two = new Array("ॐ", "ऽ", "।", "m'", "m]", "mfF", "mF", "०", "१", "२", "३", "४", "५", "६", "७", "८", "९", "फ्र", "झ", "फ", "क्त", "क्र", "ल", "ज्ञ्", "द्घ", "ज्ञ", "द्द", "द्ध", "श्र", "रु", "द्य", "क्ष्", "त्त", "द्म", "त्र", "ध्र", "ङ्घ", "ड्ड", "द्र", "ट्ट", "ड्ढ", "ठ्ठ", "रू", "हृ", "ङ्ग", "त्र", "ङ्क", "ङ्ख", "ट्ठ", "द्व", "ट्र", "ठ्र", "ड्र", "ढ्र", "्य", "्र", "ड़", "ढ़", "क्", "क", "ख्", "ख", "ग्", "ग", "घ्", "घ", "ङ", "च्", "च", "छ", "ज्", "ज", "झ्", "झ", "ञ्", "ञ", "ट", "ठ", "ड", "ढ", "ण्", "त्", "त", "थ्", "थ", "द", "ध्", "ध", "न्", "न", "प्", "प", "फ्", "ब्", "ब", "भ्", "भ", "म्", "म", "य", "र", "ल्", "ल", "व्", "व", "श्", "श", "ष्", "स्", "स", "ह्", "ह", "ऑ", "ऑ", "औ", "ओ", "आ", "अ", "ई", "इ", "ऊ", "उ", "ऋ", "ऐ", "ए", "ॉ", "ू", "ु", "ं", "ा", "ृ", "्", "े", "ै", "ँ", "ी", "ः", "", "े", "ै", "ओ", "आ", "औ", "ओ", "ो", "ॉ", "ो", "ुं", "े", "अ‍ै", "ो", "अ‍े", "ां", "अ‍ॅ", "ौ", "ौ", "ृं", "ाँ", "ूँ", "ो", "ें"); // Remove typing mistakes in the original file
    //  ")","=", ";", "’","!","%",".","”","+","(","?",".")       // Punctuation marks
    //**************************************************************************************
    // The following two characters are to be replaced through proper checking of locations:
    //**************************************************************************************
    //  "l",
    //  "ि",
    //
    // "{"
    // "र्" (reph)
    //**************************************************************************************
    var array_one_length = array_one.length;
    document.getElementById("unicode_text").value = "You have chosen SIMPLE TEXT in Preeti to convert into Unicode.";
    var modified_substring = document.getElementById("legacy_text").value;
    //****************************************************************************************
    //  Break the long text into small bunches of max. max_text_size  characters each.
    //****************************************************************************************
    var text_size = document.getElementById("legacy_text").value.length;
    var processed_text = ""; //blank
    //**********************************************
    //    alert("text size = "+text_size);
    //**********************************************
    var sthiti1 = 0;
    var sthiti2 = 0;
    var chale_chalo = 1;
    var max_text_size = 6000;
    while (chale_chalo == 1) {
        sthiti1 = sthiti2;
        if (sthiti2 < text_size - max_text_size) {
            sthiti2 += max_text_size;
            while (document.getElementById("legacy_text").value.charAt(sthiti2) != " ") {
                sthiti2--;
            }
        } else {
            sthiti2 = text_size;
            chale_chalo = 0;
        }
        //   alert(" sthiti 1 = "+sthiti1); alert(" sthit 2 = "+sthiti2)
        var modified_substring = document.getElementById("legacy_text").value.substring(sthiti1, sthiti2);
        Replace_Symbols();
        processed_text += modified_substring;
        //****************************************************************************************
        //  Breaking part code over
        //****************************************************************************************
        //  processed_text = processed_text.replace( /mangal/g , "SUCHI-DEV-708 " ) ;
        document.getElementById("unicode_text").value = processed_text;
    }
    // end of else loop for HTML case
    // --------------------------------------------------
    function Replace_Symbols() {
        //substitute array_two elements in place of corresponding array_one elements
        if (modified_substring != "") {
            // if stringto be converted is non-blank then no need of any processing.
            for (input_symbol_idx = 0; input_symbol_idx < array_one_length; input_symbol_idx++) {
                //  alert(" modified substring = "+modified_substring)
                //***********************************************************
                // if (input_symbol_idx==106)
                //  { alert(" input_symbol_idx = "+input_symbol_idx);
                //    alert(" input_symbol_idx = "+input_symbol_idx)
                //; alert(" character =" + modified_substring.CharCodeAt(input_symbol_idx))
                //     alert(" character = "+modified_string.fromCharCode(input_symbol_idx))
                //   }
                // if (input_symbol_idx == 107)
                //   { alert(" input_symbol_idx = "+input_symbol_idx);
                //    alert(" character = ",+string.fromCharCode(input_symbol_idx))
                //   }
                //***********************************************************
                idx = 0; // index of the symbol being searched for replacement
                while (idx != -1) {
                    //while-00
                    modified_substring = modified_substring.replace(array_one[input_symbol_idx], array_two[input_symbol_idx]);
                    idx = modified_substring.indexOf(array_one[input_symbol_idx]);
                } // end of while-00 loop
                // alert(" end of while loop")
            } // end of for loop
            // alert(" end of for loop")
            // alert(" modified substring2 = "+modified_substring)
            //*******************************************************
            var position_of_i = modified_substring.indexOf("l");
            while (position_of_i != -1) {
                //while-02
                var charecter_next_to_i = modified_substring.charAt(position_of_i + 1);
                var charecter_to_be_replaced = "l" + charecter_next_to_i;
                modified_substring = modified_substring.replace(charecter_to_be_replaced, charecter_next_to_i + "ि");
                position_of_i = modified_substring.search(/l/, position_of_i + 1); // search for i ahead of the current position.
            } // end of while-02 loop
            //**********************************************************************************
            // End of Code for Replacing four Special glyphs
            //**********************************************************************************
            // following loop to eliminate 'chhotee ee kee maatraa' on half-letters as a result of above transformation.
            var position_of_wrong_ee = modified_substring.indexOf("ि्");
            while (position_of_wrong_ee != -1) {
                //while-03
                var consonent_next_to_wrong_ee = modified_substring.charAt(position_of_wrong_ee + 2);
                var charecter_to_be_replaced = "ि्" + consonent_next_to_wrong_ee;
                modified_substring = modified_substring.replace(charecter_to_be_replaced, "्" + consonent_next_to_wrong_ee + "ि");
                position_of_wrong_ee = modified_substring.search(/ि्/, position_of_wrong_ee + 2); // search for 'wrong ee' ahead of the current position.
            } // end of while-03 loop
            // following loop to eliminate 'chhotee ee kee maatraa' on half-letters as a result of above transformation.
            var position_of_wrong_ee = modified_substring.indexOf("िं्");
            while (position_of_wrong_ee != -1) {
                //while-03
                var consonent_next_to_wrong_ee = modified_substring.charAt(position_of_wrong_ee + 3);
                var charecter_to_be_replaced = "िं्" + consonent_next_to_wrong_ee;
                modified_substring = modified_substring.replace(charecter_to_be_replaced, "्" + consonent_next_to_wrong_ee + "िं");
                position_of_wrong_ee = modified_substring.search(/िं्/, position_of_wrong_ee + 3); // search for 'wrong ee' ahead of the current position.
            } // end of while-03 loop
            // Eliminating reph "Ô" and putting 'half - r' at proper position for this.
            set_of_matras = "ा ि ी ु ू ृ े ै ो ौ ं : ँ ॅ";
            var position_of_R = modified_substring.indexOf("{");
            while (position_of_R > 0) {
                // while-04
                probable_position_of_half_r = position_of_R - 1;
                var charecter_at_probable_position_of_half_r = modified_substring.charAt(probable_position_of_half_r);
                // trying to find non-maatra position left to current O (ie, half -r).
                while (set_of_matras.match(charecter_at_probable_position_of_half_r) != null) {
                    // while-05
                    probable_position_of_half_r = probable_position_of_half_r - 1;
                    charecter_at_probable_position_of_half_r = modified_substring.charAt(probable_position_of_half_r);
                } // end of while-05
                charecter_to_be_replaced = modified_substring.substr(probable_position_of_half_r, position_of_R - probable_position_of_half_r);
                new_replacement_string = "र्" + charecter_to_be_replaced;
                charecter_to_be_replaced = charecter_to_be_replaced + "{";
                modified_substring = modified_substring.replace(charecter_to_be_replaced, new_replacement_string);
                position_of_R = modified_substring.indexOf("{");
            } // end of while-04
            // global conversion of punctuation marks
            //    "=","_","Ö","Ù","‘","Ú","Û","Ü","æ","Æ","±","-","<",
            //    ".",")","=", ";","…", "’","!","%","“","”","+","(","?",
            modified_substring = modified_substring.replace(/=/g, ".");
            modified_substring = modified_substring.replace(/_/g, ")");
            modified_substring = modified_substring.replace(/Ö/g, "=");
            modified_substring = modified_substring.replace(/Ù/g, ";");
            modified_substring = modified_substring.replace(/…/g, "‘");
            modified_substring = modified_substring.replace(/Ú/g, "’");
            modified_substring = modified_substring.replace(/Û/g, "!");
            modified_substring = modified_substring.replace(/Ü/g, "%");
            modified_substring = modified_substring.replace(/æ/g, "“");
            modified_substring = modified_substring.replace(/Æ/g, "”");
            modified_substring = modified_substring.replace(/±/g, "+");
            modified_substring = modified_substring.replace(/-/g, "(");
            modified_substring = modified_substring.replace(/</g, "?");
        } // end of IF  statement  meant to  supress processing of  blank  string.
    } // end of the function  Replace_Symbols
} // end of legacy_to_unicode function
//get report
$(document).off("click", ".searchReport");
$(document).on("click", ".searchReport", function() {
    // alert('adsfkaldf');
    var displayid = $(this).data("displayid");
    // var formid = $(this).data('formid');
    var formid = $(this).closest("form").attr("id");
    // alert(formid);
    if (displayid) {
        displaydiv = displayid;
    } else {
        displaydiv = "displayReportDiv";
    }
    var formurl = $(this).data("url");
    // alert(formurl);
    var action = base_url + formurl;
    $.ajax({
        type: "POST",
        url: action,
        data: $("#" + formid).serialize(),
        dataType: "html",
        beforeSend: function() {
            $(".overlay").modal("show");
        },
        success: function(jsons) {
            // console.log(jsons);
            data = jQuery.parseJSON(jsons);
            // alert(data.status);
            // alert(data.template);
            if (data.status == "success") {
                $("#" + displaydiv).html(data.template);
            } else {
                $("#" + displaydiv).html('<span class="col-sm-12 alert alert-danger text-center">' + data.message + "</span>");
                // alert(data.message);
            }
            $(".overlay").modal("hide");
        },
    });
    return false;
});
//print button
$(document).off("click", ".btn_print");
$(document).on("click", ".btn_print", function() {
    // $("#printrpt").printThis();
    // window.print(); 
    // return false;
    var thePopup = window.open('', "Print", "menubar=0,location=0,height=700,width=700");
    $('#printrpt').clone().appendTo(thePopup.document.body);
    thePopup.print();
    // setTimeout(thePopup.close(), 1000);
    $(".reportGeneration").hide();
    $("#tblwrapper").removeClass("table-wrapper");
    setTimeout(function() {
        $(".reportGeneration").show();
        $("#tblwrapper").addClass("table-wrapper");
    }, 1000);
});
//generate excel or pdf report without datatable
$(document).off("click", ".btn_gen_report");
$(document).on("click", ".btn_gen_report", function(e) {
    var target_formid = $(this).data('targetformid');
    // alert(target_formid);
    // return false;
    // var formdata=$("form#" + target_formid).serializeArray();
    // var formdata = Object.assign({},formdata);
    // console.log(formdata);
    //  return false;
    var fromdate = $("#fromdate").val();
    var todate = $("#todate").val();
    var locationid = $("#locationid").val();
    var fyear = $("#fyear").val();
    var store_id = $("#store_id").val();
    var reqno = $("#reqno").val();
    var materialtype = $("#materialtype").val();
    var depid = $("#depid").val();
    var catid = $("#catid").val();
    var departmentid = $("#deptdepid").val();
    var userid = $("#userid").val();
    var supplierid = $("#supplierid").val();
    var itemid = $("#itemid").val();
    var year = $("#year").val();
    var month = $("#month").val();
    //assets
    var asen_assettype = $("#asen_assettype").val();
    var asen_manufacture = $("#asen_manufacture").val();
    var asen_status = $("#asen_status").val();
    var asen_condition = $("#asen_condition").val();
    var asen_depreciation = $("#asen_depreciation").val();
    if ($("#is_summary").is(":checked")) {
        var is_summary = $("#is_summary").val();
    }
    var exporturl = $(this).data("exporturl");
    var exporttype = $(this).data("exporttype");
    var redirecturl = base_url + exporturl + "?=1";
    if (target_formid) {
        var formdata = $("form#" + target_formid).serializeObject();
        formdata['exporttype'] = exporttype;
        $.redirectPost(redirecturl, formdata);
        return false;
    } else {
        $.redirectPost(redirecturl, {
            departmentid: departmentid,
            store_id: store_id,
            reqno: reqno,
            fromdate: fromdate,
            todate: todate,
            fyear: fyear,
            locationid: locationid,
            fyear: fyear,
            store_id: store_id,
            materialtype: materialtype,
            depid: depid,
            catid: catid,
            is_summary: is_summary,
            userid: userid,
            supplierid: supplierid,
            itemid: itemid,
            asen_assettype: asen_assettype,
            asen_manufacture: asen_manufacture,
            asen_status: asen_status,
            asen_condition: asen_condition,
            asen_depreciation: asen_depreciation,
            year: year,
            month: month,
            exporttype: exporttype
        });
    }
});

function handleMessage(type = false, message = false) {
    if (type == "success") {
        $(".success").show().html('<span class="col-sm-12 alert alert-success">' + message + "</span>").delay(3000).fadeOut("slow");
    } else {
        $(".error").show().html('<span class="col-sm-12 alert alert-danger">' + message + "</span>").delay(3000).fadeOut("slow");
    }
}
$(document).on("keyup", ".text_filter", function(e) {
    if (e.keyCode == 38 || e.keyCode == 40) {
        $(this).blur();
        $("#myView").focus();
        setTimeout(function() {
            $(".keypresstable tr:nth-child(1)").removeClass("selected");
            $(".keypresstable tr:nth-child(2)").addClass("selected");
        }, 200);
        model_keypress();
        return false;
    }
});
$(document).off("click", ".btnredirect");
$(document).on("click", ".btnredirect", function() {
    var id = $(this).data("id");
    var url = $(this).data("viewurl");
    var otherdata = $(this).data("otherdata");
    var dashboard_data = $(this).data("dashboard_data");
    var redirecturl = url;
    $.redirectPost(redirecturl, {
        id: id,
        otherdata: otherdata,
        dashboard_data: dashboard_data,
    });
});

function calculateHeightForPageBreak() {
    console.log($(".jo_form").innerHeight());
    console.log($(".jo_footer").innerHeight());
    if ($(".jo_table").innerHeight() >= 929) {
        $(".jo_footer").css("page-break-before", "always");
    } else if ($(".jo_table").innerHeight() >= 929 && $(".jo_table").innerHeight() < 1800) {
        // $(".jo_footer").css("page-break-before" , "unset");
    }
}
$(document).off("keyup", ".arrow_keypress");
$(document).on("keyup", ".arrow_keypress", function() {
    var keypressed = event.keyCode;
    if (keypressed == "38" || keypressed == "40") {
        var keypressid = $(this).data("id");
        var fieldid = $(this).data("fieldid");
        var idname = "";
        if (fieldid) {
            idname = fieldid;
        } else {
            var active_id = this.id;
            if (active_id.indexOf("_") == -1) {
                var idname = active_id;
            } else {
                var break_id = active_id.split("_");
                idname = break_id[0];
            }
        }
        if (keypressed == "38") {
            next_fieldid = keypressid - 1;
        }
        if (keypressed == "40") {
            next_fieldid = keypressid + 1;
        }
        $("#" + idname + "_" + next_fieldid).select().focus();
    } else {
        return false;
    }
});
$(document).off("change", ".nepdatepicker, .engdatepicker");
$(document).on("change", ".nepdatepicker, .engdatepicker", function() {
    var date = $(this).val();
    checkDate = isValidDate(date);
    if (checkDate == true) {
        $(this).removeClass("form_error");
        return false;
    } else {
        $(this).addClass("form_error");
        $(this).focus();
    }
});

function isValidDate(dateString) {
    var regEx = /^\d{4}[/]\d{2}[/]\d{2}$/;
    return dateString.match(regEx) != null;
}
$(document).off("click", ".refresh_element");
$(document).on("click", ".refresh_element", function(e) {
    var targetid = $(this).data("targetid");
    var action = $(this).data("viewurl");
    $.ajax({
        type: "POST",
        url: action,
        data: {},
        dataType: "json",
        success: function(datas) {
            // $('#'+targetid).html('');
            $("#" + targetid).html(datas);
        },
    });
});
$(document).ready(function(e) {
    // $('.nepdatepicker').
    $(".nepdatepicker").each(function() {
        $(this).attr("maxlength", 10);
    });
});
$(document).off("keyup", ".nepdatepicker");
$(document).on("keyup", ".nepdatepicker", function(e) {
    $(".nepdatepicker").each(function() {
        $(this).attr("maxlength", 10);
    });
    if (e.keyCode != 8) {
        if ($(this).val().length == 4) {
            $(this).val($(this).val() + "/");
        } else if ($(this).val().length == 7) {
            $(this).val($(this).val() + "/");
        }
    }
});
// $(document).ready(function() {
//     $(window).keydown(function(event) {
//         if (event.keyCode == 13) {
//             event.preventDefault();
//             return false;
//         }
//     });
// });