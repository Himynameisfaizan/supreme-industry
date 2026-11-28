<?php
// FSSAI: certificate ki image dikhani nahi hai, sirf information. Yahin se edit karein.
$fssai = ['name' => 'Mr.B.Hari Kumar', 'licence_no' => ''];   // licence_no khaali ho to hide rehta hai
?>
<section class="fssai rv"><div class="wrap">
  <h2 class="h-ico">FSSAI Registration</h2>
  <p>FSSAI (Food Safety and Standards Authority of India) is the national authority that regulates food businesses in India. A registration or licence under FSSAI is required for businesses that handle food products.</p>
  <dl>
    <div><dt>Registered Name</dt><dd><?= e($fssai['name']) ?></dd></div>
    <?php if ($fssai['licence_no'] !== ''): ?><div><dt>Registration / Licence No.</dt><dd><?= e($fssai['licence_no']) ?></dd></div><?php endif; ?>
  </dl>
  <p>For verification details, please <a href="<?= e($site) ?>contact-us.php">contact us</a>.</p>
</div></section>
