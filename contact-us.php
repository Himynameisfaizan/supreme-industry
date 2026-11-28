<?php
require_once __DIR__ . '/includes/functions.php';

$v = ['name' => '', 'email' => '', 'phone' => '', 'subject' => '', 'message' => ''];
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($v as $k => $_) $v[$k] = trim((string)($_POST[$k] ?? ''));
    $ph = mobile10($v['phone']);
    if (!empty($_POST['website']))                          { flash('success', 'Thank you! We will contact you shortly.'); header('Location: ' . $site . 'contact-us.php'); exit; } // honeypot
    elseif (!csrf_ok())                                     $err = 'Session expired. Please reload the page and try again.';
    elseif (mb_strlen($v['name']) < 2)                      $err = 'Please enter your name.';
    elseif (!filter_var($v['email'], FILTER_VALIDATE_EMAIL)) $err = 'Please enter a valid email address.';
    elseif (!$ph)                                           $err = 'Please enter a valid 10-digit mobile number.';
    elseif (mb_strlen($v['message']) < 10)                  $err = 'Please tell us a little more about your requirement.';
    elseif (!rate_ok('contact'))                            $err = 'Please wait a few seconds before sending again.';
    elseif (run("INSERT INTO inquiries (name, email, phone, subject, message, status) VALUES (?,?,?,?,?,0)", 'sssssi',
        [mb_substr($v['name'], 0, 255), mb_substr($v['email'], 0, 255), $ph, mb_substr($v['subject'] ?: 'Website enquiry', 0, 255), mb_substr($v['message'], 0, 3000), 0])) {
        flash('success', 'Thank you! Your enquiry has been received and our team will contact you shortly.');
        header('Location: ' . $site . 'contact-us.php'); exit;
    } else $err = 'Something went wrong. Please try again or call us directly.';
}
require_once __DIR__ . '/includes/header.php';
$mapSrc = (!empty($C['map']) && preg_match('/src=["\']([^"\']+)["\']/', $C['map'], $mm) && strpos($mm[1], 'https://www.google.com/maps') === 0) ? $mm[1] : '';
$tel = fn($n) => preg_replace('/[^+\d]/', '', $n);
banner('Contact Us', 'Contact Us');
?>
<main>
<section class="wrap cgrid">
  <div class="info rv">
    <div><h3>Office Address</h3><p><?= e($C['address'] ?? 'Unit No. 603-604 6th Floor Tower B Bhutani Alphathum, Sector 90 Noida (UP) Pin code 201305.') ?></p>
      <?php if (!empty($C['address2'])): ?><p><?= e($C['address2']) ?></p><?php endif; ?></div>
    <div><h3>Call Us</h3>
      <?php foreach (array_filter([$C['phone'] ?? '+91-8743062634', $C['phone2'] ?? '', $C['telephone'] ?? '']) as $n): ?><a href="tel:<?= e($tel($n)) ?>"><?= e($n) ?></a><?php endforeach; ?></div>
    <div><h3>Email</h3>
      <?php foreach (array_filter([$C['email'] ?? 'supremeindustry.in@gmail.com', $C['email2'] ?? '', $C['email3'] ?? '']) as $m): ?><a href="mailto:<?= e($m) ?>"><?= e($m) ?></a><?php endforeach; ?></div>
    <?php if (!empty($C['working_hours'])): ?><div><h3>Working Hours</h3><p><?= e($C['working_hours']) ?></p></div><?php endif; ?>
  </div>
  <form class="cform rv" method="post" action="<?= e($site) ?>contact-us.php" novalidate>
    <h2>Send us your requirement</h2><p>Tell us about your project and we will get back to you.</p>
    <?= flash_html() ?>
    <?php if ($err): ?><div class="flash error" role="alert"><?= e($err) ?></div><?php endif; ?>
    <input type="hidden" name="csrf" value="<?= csrf() ?>">
    <div class="hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
    <div class="fgrid">
      <div><label for="name">Full name</label><input id="name" name="name" value="<?= e($v['name']) ?>" maxlength="255" required autocomplete="name"></div>
      <div><label for="email">Email</label><input id="email" type="email" name="email" value="<?= e($v['email']) ?>" maxlength="255" required autocomplete="email"></div>
      <div><label for="phone">Mobile number</label><input id="phone" type="tel" name="phone" value="<?= e($v['phone']) ?>" maxlength="14" required autocomplete="tel"></div>
      <div><label for="subject">Subject</label><input id="subject" name="subject" value="<?= e($v['subject']) ?>" maxlength="255" placeholder="e.g. PUF panel cold room"></div>
      <div class="full"><label for="message">Your requirement</label><textarea id="message" name="message" maxlength="3000" required><?= e($v['message']) ?></textarea></div>
    </div>
    <button class="btn" type="submit">SEND ENQUIRY <span>→</span></button>
  </form>
</section>
<?php if ($mapSrc): ?><div class="map rv"><iframe src="<?= e($mapSrc) ?>" title="Supreme Industry location" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe></div><?php endif; ?>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
