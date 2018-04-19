jQuery(document).ready(function () {

    jQuery("#bssearch").attr("onclick", "bssearch(this)");


});

function bssearch(t) {
    var searchInput = jQuery(t).parent().children().eq(0);
    var phrase = searchInput.attr("value");
    if (phrase.length !== 0) {
        jQuery(searchInput).attr("value", "Sorry this isn't working yet :(");
    } else {
        jQuery(searchInput).attr("placeholder", "Please enter something to search");
    }
}