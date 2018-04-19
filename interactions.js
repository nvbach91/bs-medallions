jQuery(document).ready(function ($) {
    /*this is to reload member images everytime a visitor comes due to frequent changes -
     DISABLE FOR BETTER NET TRAFFIC*/
    $(".bpimg").each(function () {
        var timestamp = new Date().getTime();
        var t = $(this);
        var imgdiv = t.children().eq(0);
        var imgsrc = imgdiv.attr("src");
        imgdiv.attr("src", imgsrc + "?" + timestamp);
    });

    var processWrapper = jQuery('#bp-content');
    var url = window.location.href;
    var isEN = url.indexOf("/en/aboutus") >= 0;
    var members = processWrapper.find(".bpmember");
    members.each(function () {
        var t = jQuery(this);
        var membercap = t.find(".membercap");
        var membercapText = membercap.html();
        var index = membercapText.indexOf("vedoucí");
        if (index >= 0) {
            if (isEN) {
                membercap.html(membercapText.substring(0, index - 1) + "(Leader)");
            }
        }
        if (index >= 0 || /^(president|vicepresident|treasurer)$/.test(t.parent().parent().attr("pr"))) {
            var bpLeaderContainer = t.parent().siblings(".bpleader");
            bpLeaderContainer.prepend(t);
        }
    });

    $(".bpleader .bpmember").attr("onclick", "showbio(this)");

    // click on president at page load
    processWrapper.children('.bprocess').eq(0).find('.bpmember').eq(0).click();
    
    var navigator = jQuery('#bp-navigator');
    navigator.children().click(function () {
        var t = $(this);
        t.addClass('active');
        t.siblings().removeClass('active');
        processWrapper.children().each(function () {
            var bprocess = $(this);
            if (t.attr('pr') !== bprocess.attr('pr')) {
                bprocess.removeClass('active');
            } else {
                bprocess.addClass('active');

                // click on leader as default bio text // or click on the first if ther is only one
                var bpmembers = bprocess.find('.bpmember');
                if (bpmembers.size() === 1) {
                    bpmembers.eq(0).click();
                } else {
                    bpmembers.each(function () {
                        var bpmember = $(this);
                        var name = bpmember.find('.membercap').text();
                        if (name.includes('Leader') || name.includes('vedoucí')) {
                            bpmember.click();
                            return false;
                        }
                    });
                }
            }
        });
    });
    var presidentProcess = $('.bprocess[pr=president]');
    processWrapper.find('.bprocess[pr=vicepresident],.bprocess[pr=treasurer]').each(function () {
        var bpmember = $(this).find(".bpmember");
        presidentProcess.find('.bpbio').before(bpmember);
    });
    navigator.children('[pr=vicepresident],[pr=treasurer]').remove();
    navigator.children('[pr=president]').text('Leadership');
});

function pageIsCS() {
    var url = window.location.href;
    return url.indexOf("/cs/") >= 0;
}

function ajax_getbio(pid) {
    var url = document.URL;
    var lang = "en";
    if (url.indexOf("/cs/") > -1) { lang = "cs"; }
    return jQuery.ajax({
        url: "/" + document.location.pathname.split("/")[1] + "/wp-content/plugins/bs-medallions/bio_server.php",
        data: "position=" + pid + "&lang=" + lang,
        type: "post"
    });
};

function showbio(bpmember) {
    var jBpmember = jQuery(bpmember).addClass('active');
    jBpmember.siblings().removeClass('active');
    var pid = jBpmember.find("img").attr("alt");
    var pb = jBpmember.siblings(".bpbio");
    pb.html('...');
    ajax_getbio(pid).done(function (resp) {
        var process = pid.replace(/[0-9]/g, "");
        pb.html(resp);
        jQuery("img[alt^='" + process + "']").removeClass("bpcolor");
        jQuery("img[alt='" + pid + "']").addClass("bpcolor");
    });
}
