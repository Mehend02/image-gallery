<?php
function processUploadedFile()
{
    $upload_errors = [
        UPLOAD_ERR_OK => "No errors.",
        UPLOAD_ERR_INI_SIZE => "Larger than upload_max_filesize.",
        UPLOAD_ERR_FORM_SIZE => "Larger than form MAX_FILE_SIZE.",
        UPLOAD_ERR_PARTIAL => "Partial upload.",
        UPLOAD_ERR_NO_FILE => "No file.",
        UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
        UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
        UPLOAD_ERR_EXTENSION  => "File upload stopped by extension."
    ];


    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if ($_POST["folder"] == "--select--") {
            echo "<p class='alert alert-warning mx-5 mt-3' role='alert'>Please select a folder</p>";
        } else {
            $tmp_file = $_FILES["file_upload"]["tmp_name"];
            $target_file = basename($_FILES["file_upload"]["name"]);
            $upload_dir = $_POST["folder"];

            if (move_uploaded_file($tmp_file, $upload_dir . "/" . $target_file)) {
                $message = "File uploaded successfully.";
            } else {
                $error = $_FILES["file_upload"]["error"];
                $message = $upload_errors[$error];
            }
            return $message;
        }
    }
}

function displayMessage($message)
{
    if (!empty($message)) {
        echo "<p class='alert alert-info mx-5 mt-3' role='alert'>{$message}</p>";
    }
}

function displayImages($dir)
{
    if (is_dir($dir)) {
        echo "<div><h2 class='py-3 mt-4'>" . ucfirst($dir) . "</h2></div>";
        echo "<div class='box mb-5 d-flex flex-row flex-wrap bg-light'>";
        $dir_array = scandir($dir);
        foreach ($dir_array as $file) {
            if (strpos($file, ".") > 0) {
                echo "<div class='imageGroup'>";
                echo "<a href='$dir" . '/' . "$file'><img src='" . $dir . "/{$file}' alt='uploaded image'></a><br>";
                echo "<a href='?file=$dir" . '/' . "$file' title='Delete'><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='black' class='bi bi-trash mt-2 float-end' viewBox='0 0 16 16'>
                <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
              </svg></a>";
                echo "</div>";
            }
        }
        echo "</div>";
    }
}

function deleteImage()
{
    if (isset($_GET["file"])) {
        unlink($_GET["file"]);
        echo "<p class='alert alert-info mx-5 mt-3' role='alert'>File deleted from gallery.</p>";
    }
}
