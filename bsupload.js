jQuery(document).ready(function () {
    jQuery(".bspic>input").each(function () {
        initDragDrop(this);
    });
});

function bsupload(t) {

}

function endsWith(str, suffix) {
    return str.indexOf(suffix, str.length - suffix.length) !== -1;
}

function initDragDrop(z) {


    z.ondrop = function (e) {
        e.stopPropagation();
        e.preventDefault();

        var formData = new FormData();
        var xhr = new XMLHttpRequest();
        var isValidToUpload = false;
        var reason = "";
        if (e.dataTransfer.files.length > 1) {
            isValidToUpload = false;
            reason = "Only 1 file allowed";

        } else {
            for (var i = 0; i < e.dataTransfer.files.length; i++) {
                var name = e.dataTransfer.files[i].name;
                var size = Math.round(e.dataTransfer.files[i].size / 1024);
                if (size > 1024) {
                    isValidToUpload = false;
                    reason = "File is too big (max 1024 kB)";
                    reason += "\n\n\"" + name + "\" (" + size + " kB)";
                    break;
                } else if (!endsWith(name, ".png")&&!endsWith(name, ".jpg")&&!endsWith(name, ".jpeg")&&!endsWith(name, ".JPG")&&!endsWith(name, ".JPEG")&&!endsWith(name, ".PNG")) {
                    isValidToUpload = false;
                    reason = "Not a valid file extension (must be .png, .jpg, .JPG, .jpeg or .JPEG)";
                    reason += "\n\n\"" + name + "\"";
                    break;
                } else {
                    formData.append('file', e.dataTransfer.files[i]);                    
                    formData.append('filename', z.value);
                    isValidToUpload = true;
                }
            }
        }

        xhr.onload = function () {
            if(this.responseText === "uploaded ok"){
                jQuery("body").append("<div class=\"notice\">Picture Uploaded (:</div>");
                var notice=jQuery(".notice");
                setTimeout(function(){notice.fadeOut(1000);},2000);
                setTimeout(function(){notice.remove();},3000);

            }else{
                alert("Something went wrong when uploading, please try again later: " + this.responseText);
            }
        };
        if (isValidToUpload) {
            xhr.open("post", "/" + document.location.pathname.split("/")[1] + "/wp-content/plugins/bs-medallions/bsupload.php");
            xhr.send(formData);
        } else {
            alert(reason);

            z.style.backgroundColor = "#eee";
            z.style.color = "rgb(51,51,51)";
        }

    };

    z.ondragover = function () {
        this.style.backgroundColor = "green";
        this.style.color = "white";
        return false;
    };

    z.ondragleave = function () {
        this.style.backgroundColor = "#eee";
        this.style.color = "gray";
        return false;
    };

}
;