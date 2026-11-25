<?php /* Add + Edit dono ka form. Variables: $cert (title, image, status), $btn, $isEdit, $error */ ?>
<?php if (!empty($error)): ?><div class="alert alert-danger"><?= cert_h($error) ?></div><?php endif; ?>
<form method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="csrf" value="<?= cert_csrf() ?>">
    <div class="row mb-3">
        <div class="col-md-6 mb-3">
            <label class="form-label" for="title">Certificate Title</label>
            <input type="text" class="form-control" name="title" id="title" maxlength="255"
                   placeholder="e.g. ISO 9001:2015 Certificate" value="<?= cert_h($cert['title']) ?>" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label" for="status">Status</label>
            <select class="form-control" name="status" id="status" required>
                <option value="1" <?= (int)$cert['status'] === 1 ? 'selected' : '' ?>>Active</option>
                <option value="0" <?= (int)$cert['status'] === 0 ? 'selected' : '' ?>>Deactive</option>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label" for="image">Certificate Image <?= $isEdit ? '(naya choose karein tabhi change hoga)' : '' ?></label>
            <input type="file" class="form-control" name="image" id="image" accept=".jpg,.jpeg,.png,.webp" <?= $isEdit ? '' : 'required' ?>>
            <small class="text-muted">JPG, PNG or WEBP, max 5 MB.</small>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label d-block">Preview</label>
            <img id="preview" class="img-thumbnail" style="max-height:160px;<?= $cert['image'] ? '' : 'display:none' ?>"
                 src="<?= $cert['image'] ? cert_h(CERT_URL . rawurlencode($cert['image'])) : '' ?>" alt="Certificate preview">
        </div>
    </div>
    <button type="submit" class="btn btn-primary"><?= cert_h($btn) ?></button>
    <a href="show-certificates.php" class="btn btn-light ms-2">Cancel</a>
</form>
<script>
document.getElementById('image').addEventListener('change', function () {
    var f = this.files[0], p = document.getElementById('preview');
    if (!f) return;
    p.src = URL.createObjectURL(f); p.style.display = 'inline-block';
});
</script>
