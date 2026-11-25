<?php
require_once __DIR__ . '/certificate-functions.php';

$id = (int)($_GET['edit_certificate'] ?? 0);
$st = $conn->prepare("SELECT cert_id, title, image, status FROM certificates WHERE cert_id = ?");
$st->bind_param('i', $id);
$st->execute();
$cert = $st->get_result()->fetch_assoc();
if (!$cert) { cert_flash('danger', 'Certificate not found.'); header('Location: show-certificates.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title  = trim($_POST['title'] ?? '');
    $status = ($_POST['status'] ?? '1') === '0' ? 0 : 1;
    $cert['title'] = $title; $cert['status'] = $status;
    $newImg = $cert['image'];
    $uploaded = !empty($_FILES['image']['name']);
    if (!cert_csrf_ok())  $error = 'Session expired. Please reload the page and try again.';
    elseif ($title === '') $error = 'Certificate title is required.';
    elseif ($uploaded && !($newImg = cert_save_image($_FILES['image'], $error))) { /* $error already set */ }
    else {
        $up = $conn->prepare("UPDATE certificates SET title = ?, image = ?, status = ? WHERE cert_id = ?");
        $up->bind_param('ssii', $title, $newImg, $status, $id);
        if ($up->execute()) {
            if ($uploaded) cert_remove_image($cert['image']);   // purani image hatao
            cert_flash('success', 'Certificate updated successfully.');
            header('Location: show-certificates.php'); exit;
        }
        if ($uploaded) cert_remove_image($newImg);
        $error = 'Could not update the certificate. Please try again.';
    }
    if ($error) { $st->execute(); $cert['image'] = $st->get_result()->fetch_assoc()['image'] ?? ''; }
}
$btn = 'Update Certificate'; $isEdit = true;
?>
<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Admin - Edit Certificate</title>
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
                        <div class="white_card_header"><div class="box_header m-0"><div class="main-title"><h3 class="m-0">Edit Certificate #<?= (int)$id ?></h3></div></div></div>
                        <div class="white_card_body"><div class="card-body"><?php include __DIR__ . '/certificate-form.php'; ?></div></div>
                    </div>
                </div></div>
            </div>
        </div>
        <?php include "footer.php"; ?>
    </section>
</body>
</html>
