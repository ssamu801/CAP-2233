<?php
session_start();
include 'db_connect.php';
// File upload handling
$uploadStatus = '';

if(isset($_FILES['mediaFile']['name']) && isset($_POST['mediaTitle'])){
    $fileCount = count($_FILES['mediaFile']['name']);

    $mediaTitle = $_POST['mediaTitle'];
    $added_by = $_POST['added_by'];

    for($i=0; $i<$fileCount; $i++){
        $fileName = $_FILES['mediaFile']['name'][$i];
        $fileTmpName = $_FILES['mediaFile']['tmp_name'][$i];
        $fileType = $_FILES['mediaFile']['type'][$i];
        $fileSize = $_FILES['mediaFile']['size'][$i];
        $fileError = $_FILES['mediaFile']['error'][$i];

        if($fileError === 0){
            $uploadPath = 'medias/' . $fileName;
            move_uploaded_file($fileTmpName, $uploadPath);

            // Insert file details into database
            $sql = "INSERT INTO media_files (file_name, file_type, file_size, title, added_by) VALUES ('$fileName', '$fileType', $fileSize, '$mediaTitle','$added_by')";
            if ($conn->query($sql) === TRUE) {
                $uploadStatus .= "File '$fileName' uploaded successfully.<br>";

                return 1;
            } else {
                $uploadStatus .= "Error uploading file '$fileName': " . $conn->error . "<br>";
            }
        } else {
            $uploadStatus .= "Error uploading file '$fileName': " . $fileError . "<br>";
        }
    }
}

$conn->close();
?>
