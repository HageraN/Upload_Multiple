<?php


$extensionAccepted=[
  'image/png' =>'png',
  'image/jpeg' =>'jpg',
  'image/gif' =>'gif',
];

if(isset($_POST['delete'])){
    unlink($_POST['path']);
}

if(isset($_POST['submit'])){
    if(count($_FILES['upload']['name']) > 0){
        //Loop through each file
        for($i=0; $i<count($_FILES['upload']['name']); $i++) {
            //Get the temp file path
            $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

            //Make sure we have a filepath
            if($tmpFilePath != ""){

                //save the filename
                $shortname = $_FILES['upload']['name'][$i];

                $extension = $extensionAccepted[$_FILES['upload']['type'][$i]];

                //save the url and the file
                $filePath = "upload/" . 'image'.uniqid().'.'.$extension;

                //Upload the file into the temp dir
                if(move_uploaded_file($tmpFilePath, $filePath)) {

                    $files[] = $shortname;
                    //insert into db
                    //use $shortname for the filename
                    //use $filePath for the relative url to the file

                }
            }
        }
    }

    //show success message
    echo "<h1>Uploaded:</h1>";
    if(is_array($files)){
        echo "<ul>";
        foreach($files as $file){
            echo "<li>$file</li>";
        }
        echo "</ul>";
    }

}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Upload File</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
</head>
<body>
<div class="container">
    <div class="row">
        <h3>Télécharge ton fichier : </h3>
        <form class="col s12" action="" enctype="multipart/form-data" method="post">
            <div class="file-field input-field">
                <div class="btn">
                    <span>Fichier(s)</span>
                    <input id="upload" name="upload[]" type="file" multiple="multiple">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                </div>
            </div>
            <input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
            <input type="submit" name="submit" value="Submit" class="waves-effect waves-light btn grey">
        </form>
    </div>

    <div class="row">
        <?php
        $dir = '/Applications/MAMP/htdocs/wcs_test/Upload_Multiple/upload';
        $files1 = scandir($dir);

        foreach ($files1 as $f){
            if ($f != '.' && $f != '..') {
                echo '<div class="col s4">
            <div class="card" style="overflow: hidden;">
                <div class="card-image waves-effect waves-block waves-light">
                    <img class="activator" src="upload/' . $f . '">
                </div>
                <div class="card-content">
<span class="card-title activator grey-text text-darken-4">'.$f.'</span>
                </div>
                <div class="card-reveal" style="display: none; transform: translateY(0px);">
<span class="card-title grey-text text-darken-4">
<p>Here is some more information about this product that is only revealed once clicked on.</p>
                </div>
                <div class="card-action">
                    <form method="post">
                    <input type="hidden" value="'.$dir.'/'.$f.'" name="path">
                    <input type="submit" value="delete" name="delete" class="btn-red">
                    </form>
                </div>
            </div>
        </div>';
            }
        }
        ?>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>
</body>
</html>