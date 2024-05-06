<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uploadDir = 'uploads/';
    $uploadedFiles = [];
    foreach ($_FILES['file']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['file']['name'][$key];
        $file_tmp = $_FILES['file']['tmp_name'][$key];
        $file_type = $_FILES['file']['type'][$key];
        $file_size = $_FILES['file']['size'][$key];
        $file_error = $_FILES['file']['error'][$key];

        if ($file_error == UPLOAD_ERR_OK && is_uploaded_file($file_tmp)) {
            if (!move_uploaded_file($file_tmp, $uploadDir . $file_name)) {
                echo "Przepraszamy, wystąpił problem podczas przesyłania plików.";
            } else {
                $uploadedFiles[] = $file_name;
            }
        } else {
            echo "Przepraszamy, wystąpił problem podczas przesyłania plików.";
        }
    }

    // Wyświetlenie przesłanych plików
    if (!empty($uploadedFiles)) {
        echo "Przesłano następujące pliki:<br>";
        foreach ($uploadedFiles as $file) {
            echo $file . "<br>";
        }
    }
}
?>
