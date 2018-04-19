jQuery(document).ready(function () {
    jQuery("div[class='enc']").each(function () {
        var process = jQuery(this).html();
        jQuery(this).attr("onclick", "expcol('" + getAbbrProcessName(process) + "')");
    });
    jQuery(document).ready(function () {
        jQuery("#xguide").click(function () {
            jQuery("#guide").show()
        })
    });

});

function getAbbrProcessName(pos) {
    switch (pos) {
        case "President": return "president"; break;
        case "Vice President": return "vicepresident"; break;
        case "Treasurer": return "treasurer"; break;
        case "Administraion": return "ad"; break;
        case "Buddy Program": return "bp"; break;
        case "Fundraising": return "fr"; break;
        case "Public Relations": return "pr"; break;
        case "Human Resources": return "hr"; break;
        case "Information Technology": return "it"; break;
        case "International Relations": return "ir"; break;
        case "Activities": return "ac"; break;
        case "Exchange+": return "ex"; break;
        case "Nation 2 Nation": return "nn"; break;
    }

    return "Unknown";
}
;
function expcol(p) {
    jQuery(".bsrow." + p).toggle();
}
;
function expcolall(t) {
    var btn = jQuery(t);
    if (btn.val() === "Expand All") {
        btn.val("Collapse All");
        jQuery("div[class^='bsrow']").show();

    } else {
        btn.val("Expand All");
        jQuery("div[class^='bsrow']").hide();
    }
}
