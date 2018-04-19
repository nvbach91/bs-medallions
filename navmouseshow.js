var mouseX;
var mouseY;
jQuery(document).ready(function () {

    jQuery(".bsnav").each(function () {
        var t = jQuery(this);
        var theID = t.children().eq(0).attr("href");
        t.click(function () {
            jQuery("html, body").animate({ scrollTop: jQuery(theID).offset().top - 60 }, 1000);
        });
    });

    jQuery(document).mousemove(function (e) {
        mouseX = e.pageX - 150;
        mouseY = e.pageY - 80;
        jQuery('#bsshow').css({
            left: mouseX,
            top: mouseY
        });
    });

    jQuery(".bspic").each(function () {
        var bspic = jQuery(this);
        var imgname = bspic.find('input').val();
        bspic.mouseover(function () {
            var d = new Date();
            jQuery('#bsshow').css("background-image", "url('/" + document.location.pathname.split("/")[1] + "/members/" + imgname + ".png?" + d.getTime() + "')");
            jQuery('#bsshow').show();
        });
    });

    jQuery(".bspic").mouseout(function () {
        jQuery('#bsshow').hide();
    });
});
