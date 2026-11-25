<?php
require_once __DIR__ . '/certificate-functions.php';

// Delete (POST + CSRF, GET se delete nahi hota)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    if (cert_csrf_ok()) {
        $did = (int)($_POST['id'] ?? 0);
        $s = $conn->prepare("SELECT image FROM certificates WHERE cert_id = ?"); $s->bind_param('i', $did); $s->execute();
        if ($row = $s->get_result()->fetch_assoc()) {
            $d = $conn->prepare("DELETE FROM certificates WHERE cert_id = ?"); $d->bind_param('i', $did);
            if ($d->execute()) { cert_remove_image($row['image']); cert_flash('success', 'Certificate deleted.'); }
            else cert_flash('danger', 'Could not delete the certificate.');
        }
    } else cert_flash('danger', 'Session expired. Please try again.');
    header('Location: show-certificates.php'); exit;
}

$search  = trim($_GET['search'] ?? '');
$page    = max(1, (int)($_GET['page'] ?? 1));
$perPage = 10;
$like    = '%' . $search . '%';

$c = $conn->prepare("SELECT COUNT(*) FROM certificates WHERE title LIKE ?");
$c->bind_param('s', $like); $c->execute();
$totalRows  = (int)$c->get_result()->fetch_row()[0];
$totalPages = max(1, (int)ceil($totalRows / $perPage));
$page   = min($page, $totalPages);
$offset = ($page - 1) * $perPage;

$l = $conn->prepare("SELECT cert_id, title, image, status, created_at FROM certificates WHERE title LIKE ? ORDER BY cert_id DESC LIMIT ?, ?");
$l->bind_param('sii', $like, $offset, $perPage); $l->execute();
$rows = $l->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Certificate Management | Admin Panel</title>
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <?php include "links.php"; ?>
    <style>.table thead th{background:#2c3e50;color:#fff;font-weight:500}.pagination .page-item.active .page-link{background:#2c3e50;border-color:#2c3e50}</style>
</head>
<body class="crm_body_bg">
    <?php include "header.php"; ?>
    <section class="main_content dashboard_part">
        <div class="container-fluid g-0"><div class="row"><div class="col-lg-12 p-0"><?php include "top_nav.php"; ?></div></div></div>
        <div class="main_content_iner">
            <div class="container-fluid p-3">
                <div class="row justify-content-center"><div class="col-12">
                    <div class="white_card mb_30">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="mb-3 mb-md-0">
                                    <h2 class="mb-0 fw-bold">Certificate Management</h2>
                                    <p class="text-muted mb-0 small">Add, edit and delete quality certificates shown on the website</p>
                                </div>
                                <div class="d-flex">
                                    <form method="GET" class="me-3">
                                        <input type="text" class="form-control" name="search" placeholder="Search certificates..." value="<?= cert_h($search) ?>">
                                    </form>
                                    <a href="add-certificates.php" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Certificate</a>
                                </div>
                            </div>
                        </div>
                        <div class="white_card_body">
                            <?= cert_flash_html() ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered align-middle text-center">
                                    <thead class="table-light"><tr><th>#</th><th>ID</th><th>Title</th><th>Image</th><th>Status</th><th>Added On</th><th>Actions</th></tr></thead>
                                    <tbody>
                                    <?php if (!$rows): ?>
                                        <tr><td colspan="7" class="text-muted py-4">No certificates found</td></tr>
                                    <?php endif; ?>
                                    <?php foreach ($rows as $i => $r): ?>
                                        <tr>
                                            <td><?= $offset + $i + 1 ?></td>
                                            <td class="fw-bold"><?= (int)$r['cert_id'] ?></td>
                                            <td><?= cert_h($r['title']) ?></td>
                                            <td><a href="<?= cert_h(CERT_URL . rawurlencode($r['image'])) ?>" target="_blank" rel="noopener">
                                                <img src="<?= cert_h(CERT_URL . rawurlencode($r['image'])) ?>" alt="<?= cert_h($r['title']) ?>" style="width:100px;height:70px;object-fit:cover" class="img-thumbnail"></a></td>
                                            <td class="<?= $r['status'] ? 'text-success' : 'text-danger' ?>"><?= $r['status'] ? 'Active' : 'Inactive' ?></td>
                                            <td><?= $r['created_at'] ? cert_h(date('d M Y', strtotime($r['created_at']))) : '-' ?></td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="edit_certificates.php?edit_certificate=<?= (int)$r['cert_id'] ?>" class="btn btn-outline-info btn-sm me-2" title="Edit"><i class="fas fa-edit"></i></a>
                                                    <form method="post" onsubmit="return confirm('Are you sure you want to delete this certificate?')">
                                                        <input type="hidden" name="csrf" value="<?= cert_csrf() ?>">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="id" value="<?= (int)$r['cert_id'] ?>">
                                                        <button class="btn btn-outline-danger btn-sm" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php if ($totalPages > 1): $qs = '&search=' . urlencode($search); ?>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="text-muted small">Showing <?= $offset + 1 ?> to <?= min($offset + $perPage, $totalRows) ?> of <?= $totalRows ?> entries</div>
                                <ul class="pagination mb-0">
                                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="?page=<?= $page - 1 . $qs ?>">Previous</a></li>
                                    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                                        <li class="page-item <?= $p == $page ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $p . $qs ?>"><?= $p ?></a></li>
                                    <?php endfor; ?>
                                    <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>"><a class="page-link" href="?page=<?= $page + 1 . $qs ?>">Next</a></li>
                                </ul>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div></div>
            </div>
        </div>
    </section>
    <?php include "footer.php"; ?>
</body>
</html>
