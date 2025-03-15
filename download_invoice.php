<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['invoice_filename'])) {
    $invoice_filename = basename($_POST['invoice_filename']);

    if (file_exists($invoice_filename)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $invoice_filename);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($invoice_filename));
        readfile($invoice_filename);
        exit;
    } else {
        echo "Error: Invoice file not found.";
    }
} else {
    echo "Invalid request.";
}
?>
