<?php

/* if (isset($_FILES["file"]["type"])) {
  echo $_FILES["file"]["type"] . '; ' . $_FILES["file"]["size"];

  $validextensions = array("png", "png");
  $temporary = explode(".", $_FILES["file"]["name"]);
  $file_extension = end($temporary);
  if (($_FILES["file"]["type"] == "image/png") && ($_FILES["file"]["size"] / 1024 <= 1024) && in_array($file_extension, $validextensions)) {
  if ($_FILES["file"]["error"] > 0) {
  echo "Return Code: " . $_FILES["file"]["error"] . "";
  }
  }
  } */


if (isset($_FILES["file"]["type"])) {
    $validextensions = array("png", "jpg", "jpeg", "JPG", "JPEG", "PNG");
    $temporary = explode(".", $_FILES["file"]["name"]);
    $file_extension = end($temporary);
    if ((    ($_FILES["file"]["type"] == "image/png") 
	      || ($_FILES["file"]["type"] == "image/PNG")
	      || ($_FILES["file"]["type"] == "image/jpg") 
		  || ($_FILES["file"]["type"] == "image/jpeg") 
		  || ($_FILES["file"]["type"] == "image/JPG")
		  || ($_FILES["file"]["type"] == "image/JPEG")
            ) && ($_FILES["file"]["size"] <= 1048576)
            && in_array($file_extension, $validextensions)) {
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "";
        } else {
            /*if (file_exists("../../../members/" . $_FILES["file"]["name"])) {
                echo $_FILES["file"]["name"] . "already exists";
            } else {*/
                $sourcePath = $_FILES['file']['tmp_name'];
                $targetPath = "../../../members/" . $_POST["filename"].".png";
                move_uploaded_file($sourcePath, $targetPath);
                if(file_exists($targetPath)){
                    chmod($targetPath, 0777);
                    echo "uploaded ok";
                }
                /*echo "Image Uploaded Successfully...!!";
                echo "File Name: " . $_FILES["file"]["name"] . "<br>";
                echo "Type: " . $_FILES["file"]["type"] . "<br>";
                echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
                echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";*/
            //}
        }
    } else {
        echo "***Invalid file Size or Type***";
    }
}
?>
