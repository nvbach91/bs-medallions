jQuery(document).ready(function ($) {
    $("div[class$='bpname']").attr("onclick", "ec(this);");
    $("div[class='bpmember']").attr("onclick", "showbio(this)");
    $("#ec").attr("onclick", "ec_all()");

    /*this is to reload member images everytime a visitor comes due to frequent changes - DISABLE FOR BETTER NET TRAFFIC*/
    $(".bpimg").each(function () {
        var timestamp = new Date().getTime();
        var t = $(this);
        var imgdiv = t.children().eq(0);
        var imgsrc = imgdiv.attr("src");
        imgdiv.attr("src", imgsrc + "?" + timestamp);
    });
    return false;
});

function pageIsCS() {
    var url = window.location.href;
    return url.indexOf("/cs/") >= 0;
}

function ec(bpname) {
    var members = jQuery(bpname).parent().children().eq(1);

    if (members.css("display") === "block") {
        members.hide();
        jQuery(bpname).parent().children().eq(2).html("");
        jQuery(bpname).parent().children().eq(1).find("img").removeClass("bpcolor");
    } else {
        members.show();
    }
};

function ec_all() {
    var collapseall = "Collapse All";
    var expandall = "Expand All";
    if (pageIsCS()) {
        collapseall = "Sbalit vše";
        expandall = "Rozbalit vše";
    }
    if (jQuery("#e-c").hasClass("xhidden")) { /*expand*/
        jQuery("div[class$='bphide']").removeAttr("style");
        jQuery("div[class$='bphide']").removeClass("bphide");
        jQuery("#e-c").removeClass("xhidden");
        jQuery("#ec").html(collapseall);
    } else { /*collapse*/
        jQuery("div[class$='bpmembers']").addClass("bphide");
        jQuery("div[class$='bphide']").removeAttr("style");
        jQuery("#e-c").addClass("xhidden");
        jQuery("#ec").html(expandall);
        jQuery("div[class^='bpbio']").html("");
        jQuery("img").removeClass("bpcolor");

    }
};

function ajax_getbio(pid) {
    var url = document.URL;
    var lang = "en";
    if (url.indexOf("/cs/") > -1) { lang = "cs"; }
    var biotext = "Hey dude, have a nice day! (:";
    jQuery.ajax({
        async: false,
        url: "/" + document.location.pathname.split("/")[1] + "/wp-content/plugins/bs-medallions/bio_server.php",
        data: "position=" + pid + "&lang=" + lang,
        type: "post",
        success: function (resp) { biotext = resp; },
        error: function () { biotext = "ajax error :("; }
    });
    return biotext;
};

function showbio(bpmember) {
    var jBpmember = jQuery(bpmember).addClass('active');
    jBpmember.siblings().removeClass('active');
    var pid = jBpmember.find("img").attr("alt");
    if (jBpmember.parent().attr("class") === 'bpmembers no') {
        showlbio(pid);
    } else {
        showpbio(pid);
    }
}

function showlbio(pid) {
    pid = pid.substr(2, pid.length);
    var biotext = ajax_getbio(pid);
    var lb = jQuery("#leaderbio");
    lb.hide();
    lb.html(biotext);
    lb.fadeIn(500);
    jQuery("img[alt^='l_']").removeClass("bpcolor");
    jQuery("img[alt='l_" + pid + "']").addClass("bpcolor");
};

function showpbio(pid) {
    var biotext = ajax_getbio(pid);
    var process = pid.replace(/[0-9]/g, "");

    var pb = jQuery("div[class='bpbio " + process + "']");
    pb.hide();
    pb.html(biotext);
    pb.fadeIn(500);
    jQuery("img[alt^='" + process + "']").removeClass("bpcolor");
    jQuery("img[alt='" + pid + "']").addClass("bpcolor");

};

/*Active Mouse Tooltip by NVB*/
var mouseX;
var mouseY;
jQuery(document).ready(function () {
    //jQuery('#bstooltip').html("Click for short biography");

    /*jQuery(document).mousemove(function(e) {
       mouseX = e.pageX+20; 
       mouseY = e.pageY-10;
        jQuery('#bstooltip').css({
           left:  mouseX,
           top:   mouseY
        });
    });  
  
    jQuery(".bpmember").each(function(){
          var bsmember=jQuery(this);
          bsmember.mouseover(function(){
              jQuery('#bstooltip').show();
          });
    });
  
    jQuery(".bpmember").mouseout(function(){
      jQuery('#bstooltip').hide();
    });*/

    var processWrapper = jQuery('#bp-content');


    var url = window.location.href;
    var isEN = url.indexOf("/en/aboutus") >= 0;
    processWrapper.find(".membercap").each(function () {
        var t = jQuery(this);
        var text = t.html();
        var index = text.indexOf("vedoucí");
        if (index >= 0) {
            if (isEN) {
                t.html(text.substring(0, index - 1) + "(Leader)");
            }
            t.parent().prependTo(t.parent().parent());
        }
    });


    // click on president at page load
    processWrapper.children('.bprocess').eq(0).find('.bpmember').eq(0).click();
    jQuery('#bp-navigator').children().click(function () {
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
    })

});
