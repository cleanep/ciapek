<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $file = $_FILES['file'];
    $file_name = $file['name'];
    $file_temp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];

    // Sprawdź rozmiar pliku
    if ($file_size < 1000000) { // 1MB limit
        $file_destination = 'uploads/' . $file_name;
        move_uploaded_file($file_temp, $file_destination);
        echo "Plik został przesłany pomyślnie.";
    } else {
        echo "Twój plik jest za duży!";
    }
}
?>
