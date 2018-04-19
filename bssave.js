jQuery(document).ready(function () {
    jQuery("input[class='button-primary save']").attr("onclick", "bssave(this)");
});

function bssave(t) {
    var bsrow = jQuery(t).parent().parent();
    //bsrow.find(".bserror").html("saving...");
    var rc = bsrow.children();
    var pos = rc.eq(3).children().eq(0).find(":selected").val();
    var pic = rc.eq(4).children().eq(0).val() + ".png";
    var currentNumberOfMemberInDestinationProcess = jQuery(".bsrow." + pos).size();
    var changeORsave = "save";
    if (pic.substr(0, pic.length - 5) !== pos) {
        //alert("Sorry, changing processes is not supported yet! Please delete the medallion and then add it to the actual process");
        changeORsave = "change";
        if (currentNumberOfMemberInDestinationProcess >= 99) {
            alert("Sorry, each process can only have max 99 members");
            return;
        }

    } //else {
    var en = rc.eq(5).children().eq(0).val();
    var cs = rc.eq(6).children().eq(0).val();
    var id = rc.eq(0).html();
    var auth = rc.eq(1).html();
    var name = rc.eq(2).children().eq(0).val();
    var pic = rc.eq(4).children().eq(0).val() + ".png";

    var result = "no resp";
    jQuery.ajax({
        async: false,
        url: "/" + document.location.pathname.split("/")[1] + "/wp-content/plugins/bs-medallions/bs" + changeORsave + ".php",
        data: { id: id, auth: auth, pos: pos, name: sqlEscape(name), en: sqlEscape(en), cs: sqlEscape(cs), pic: pic, nm: currentNumberOfMemberInDestinationProcess },
        type: "post",
        dataType: "text",
        success: function (resp) {
            result = resp;
        },
        error: function () {
            result = "ajax error";
        }
    });
    if (result === "saved") {
        bsrow.find(".bserror").remove();
        bsrow.append("<div class=\"bserror\" style=\"color: green;\">" + result + "</p>");
        if (changeORsave === "change") {
            jQuery("#bsreload").click();
        } else {
            setTimeout(function () { bsrow.find(".bserror").remove(); }, 5000);
        }
    } else {
        bsrow.find(".bserror").remove();
        bsrow.append("<div class=\"bserror\" style=\"color: red;\">" + result + "</div>");
        setTimeout(function () { bsrow.find(".bserror").remove(); }, 5000);
    }
    //}
}
;

function sqlEscape(str) {
    return str.replace(/[\0\x08\x09\x1a\n\r"'\\\%]/g, function (char) {
        switch (char) {
            case "\0":
                return "\\0";
            case "\x08":
                return "\\b";
            case "\x09":
                return "\\t";
            case "\x1a":
                return "\\z";
            case "\n":
                return "\\n";
            case "\r":
                return "\\r";
            case "\"":
            case "'":
            case "\\":
            case "%":
                return "\\" + char; // prepends a backslash to backslash, percent,
            // and double/single quotes
        }
    });
};


function bschange() {

}
;