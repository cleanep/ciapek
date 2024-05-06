<?php
if(isset($_POST['submit'])) {
    $to = "biuro@cleanep.pl";
    $from = $_POST['email'];
    $name = $_POST['name'];
    $subject = "Nowa wiadomość ze strony Clean EP";

    $message = "Imię: " . $name . "\n";
    $message .= "Email: " . $from . "\n";
    $message .= "Wiadomość:\n" . $_POST['message'];

    $separator = md5(time());

    // Dane pliku
    $filename = $_FILES['uploaded_file']['name'];
    $file_size = $_FILES['uploaded_file']['size'];
    $file_tmp = $_FILES['uploaded_file']['tmp_name'];
    $file_type = $_FILES['uploaded_file']['type'];

    // Przygotowanie pliku do załączenia
    $attachment = chunk_split(base64_encode(file_get_contents($file_tmp)));

    // Nagłówki wiadomości
    $headers = "From: $from\r\n";
    $headers .= "Reply-To: $from\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"\r\n";

    // Treść wiadomości
    $body = "--" . $separator . "\r\n";
    $body .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n";
    $body .= "\r\n" . $message . "\r\n";
    $body .= "--" . $separator . "\r\n";
    $body .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n";
    $body .= "Content-Disposition: attachment\r\n\r\n" . $attachment . "\r\n";
    $body .= "--" . $separator . "--";

    // Wysłanie wiadomości
    if (mail($to, $subject, $body, $headers)) {
        echo "Wiadomość została wysłana";
    } else {
        echo "Wystąpił błąd podczas wysyłania wiadomości";
    }
}
?>
