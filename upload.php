<?php

// Adres e-mail, na który mają być wysłane pliki
$to = 'biuro@cleanep.pl';

// Temat wiadomości e-mail
$subject = 'Nowe pliki przesłane przez formularz';

// Treść wiadomości e-mail
$message = 'Nowe pliki przesłane przez formularz:';

// Iterujemy przez każdy przesłany plik
foreach ($_FILES['file']['tmp_name'] as $key => $tmp_name) {
    $file_name = $_FILES['file']['name'][$key];
    $file_tmp = $_FILES['file']['tmp_name'][$key];

    // Dodajemy załącznik do wiadomości e-mail
    $file = file_get_contents($file_tmp);
    $content = chunk_split(base64_encode($file));
    $uid = md5(uniqid(time()));
    $file_type = $_FILES['file']['type'][$key];
    $file_size = $_FILES['file']['size'][$key];

    $message .= "\r\n";
    $message .= "--" . $uid . "\r\n";
    $message .= "Content-Type: " . $file_type . "; name=\"" . $file_name . "\"\r\n";
    $message .= "Content-Transfer-Encoding: base64\r\n";
    $message .= "Content-Disposition: attachment; filename=\"" . $file_name . "\"\r\n";
    $message .= "\r\n";
    $message .= $content . "\r\n";
}

// Dodajemy końcówkę wiadomości e-mail
$message .= "\r\n";
$message .= "--" . $uid . "--";

// Nagłówki e-maila
$headers = "From: your_email@example.com\r\n";
$headers .= "Reply-To: your_email@example.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\r\n";

// Wysyłamy e-mail
if (mail($to, $subject, $message, $headers)) {
    echo 'Pliki zostały wysłane na Twój adres e-mail.';
} else {
    echo 'Wystąpił błąd podczas wysyłania plików.';
}

?>
