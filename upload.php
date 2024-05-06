<?php
// Sprawdzamy, czy plik został przesłany poprawnie
if(isset($_FILES['file'])) {
    $errors = [];
    $path = 'uploads/';

    // Iterujemy przez tablicę przesłanych plików
    foreach($_FILES['file']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['file']['name'][$key];
        $file_size = $_FILES['file']['size'][$key];
        $file_tmp = $_FILES['file']['tmp_name'][$key];
        $file_type = $_FILES['file']['type'][$key];

        // Sprawdzamy, czy rozmiar pliku nie przekracza 1MB (1048576 bajtów)
        if($file_size > 1048576) {
            $errors[] = 'Plik ' . $file_name . ' jest zbyt duży. Maksymalny rozmiar pliku to 1MB.';
        }

        // Przenosimy plik do folderu uploads, jeśli nie ma żadnych błędów
        if(empty($errors)) {
            move_uploaded_file($file_tmp, $path . $file_name);
            echo 'Plik ' . $file_name . ' został pomyślnie przesłany.';
        } else {
            // Jeśli wystąpiły błędy, wyświetlamy je użytkownikowi
            foreach($errors as $error) {
                echo $error . '<br>';
            }
        }
    }
}
?>
