jQuery(document).ready(function () {
    jQuery("input[class='button-primary remove']").attr("onclick", "bsremove(this)");
});

function bsremove(t) {
    var bsrow = jQuery(t).parent().parent();
    confirmRemove(bsrow);
};

function confirmRemove(r) {
    r.find(".bserror").remove();
    if (!jQuery(r).find("#confirm").length) {
        jQuery(r).append("<div id=\"cancel\" class=\"bsbtn\"><input type=\"button\" value=\"Cancel\" class=\"button-primary\" onclick=\"xCancel(this)\" /></div>");
        jQuery(r).append("<div id=\"confirm\" class=\"bsbtn\"><input type=\"button\" value=\"Confirm\" class=\"button-primary\"  onclick=\"xRemove(this)\"/></div>");
    }
};

function xCancel(t) {
    var bsrow = jQuery(t).parent().parent();
    bsrow.find("#confirm").remove();
    bsrow.find("#cancel").remove();
};

function xRemove(t) {
    var bsrow = jQuery(t).parent().parent();
    var id = bsrow.children().eq(0).html();
    var auth = bsrow.children().eq(1).html();
    var pic = bsrow.children().eq(4).children().eq(0).val()+".png";
    var result = "no resp";
    jQuery.ajax({
        async: false,
        url: "/" + document.location.pathname.split("/")[1] + "/wp-content/plugins/bs-medallions/bsremove.php",
        data: {id: id, auth: auth, pic: pic},
        type: "post",
        success: function (resp) {
            result = resp;
        },
        error: function () {
            result = "ajax error :(";
        }
    });
    if (result === "removed") {
        bsrow.remove();
        jQuery("#bsreload").click();
    } else {
        if (!bsrow.find("#bserror").length) {
            bsrow.append("<div class=\"bserror\" style=\"color: purple;\">" + result + "</div>");
        }
    }

};