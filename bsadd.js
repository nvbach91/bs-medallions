jQuery(document).ready(function () {

    jQuery("#bsadd").attr("onclick", "bsadd(this)");


});


function bsadd(t) {
    var bsrow = jQuery(t).parent().parent();
    var rc = bsrow.children();
    var name = rc.eq(0).children().eq(0).val();
    if (name.length < 1) {
        rc.eq(0).children().eq(0).attr("placeholder", "Please type a name!");
    } else {
        var auth = jQuery(".bsauth").eq(1).html();
        var pos = rc.eq(1).children().eq(0).find(":selected").val();
        var result = "no resp";
        jQuery.ajax({
            async: false,
            url: "/" + document.location.pathname.split("/")[1] + "/wp-content/plugins/bs-medallions/bsadd.php",
            data: { auth: auth, pos: pos, name: name },
            type: "post",
            success: function (resp) {
                result = resp;
            },
            error: function () {
                result = "ajax error";
            }
        });
        if (result === "added") {
            jQuery("#bsreload").click();
        } else {
            bsrow.find(".bserror").remove();
            bsrow.append("<div class=\"bserror\" style=\"color: red;\">" + result + "</div>");

        }
    }
};