<?php
require_once __DIR__ . '/certificate-functions.php';

$cert = ['title' => '', 'image' => '', 'status' => 1];
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cert['title']  = trim($_POST['title'] ?? '');
    $cert['status'] = ($_POST['status'] ?? '1') === '0' ? 0 : 1;
    if (!cert_csrf_ok())                       $error = 'Session expired. Please reload the page and try again.';
    elseif ($cert['title'] === '')             $error = 'Certificate title is required.';
    elseif (empty($_FILES['image']['name']))   $error = 'Please choose a certificate image.';
    elseif ($img = cert_save_image($_FILES['image'], $error)) {
        $st = $conn->prepare("INSERT INTO certificates (title, image, status) VALUES (?, ?, ?)");
        $st->bind_param('ssi', $cert['title'], $img, $cert['status']);
        if ($st->execute()) { cert_flash('success', 'Certificate added successfully.'); header('Location: show-certificates.php'); exit; }
        cert_remove_image($img);
        $error = 'Could not save the certificate. Please try again.';
    }
}
$btn = 'Add Certificate'; $isEdit = false;
?>
<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Sales - Add Certificate</title>
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <?php include "links.php"; ?>
</head>
<body class="crm_body_bg">
    <?php include "header.php"; ?>
    <section class="main_content dashboard_part large_header_bg">
        <div class="container-fluid g-0"><div class="row"><div class="col-lg-12 p-0"><?php include "top_nav.php"; ?></div></div></div>
        <div class="main_content_iner">
            <div class="container-fluid p-0 sm_padding_15px">
                <div class="row justify-content-center"><div class="col-lg-12">
                    <div class="white_card card_height_100 mb_30">
                        <div class="white_card_header"><div class="box_header m-0"><div class="main-title"><h3 class="m-0">Fill the Certificate details</h3></div></div></div>
                        <div class="white_card_body"><div class="card-body"><?php include __DIR__ . '/certificate-form.php'; ?></div></div>
                    </div>
                </div></div>
            </div>
        </div>
        <?php include "footer.php"; ?>
    </section>
</body>
</html>
