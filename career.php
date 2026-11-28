<?php
require_once __DIR__ . '/includes/functions.php';

$roles = ['Site Engineer', 'Installation Supervisor', 'Sales Executive', 'Design / Draftsman', 'Other'];
$v = ['name' => '', 'email' => '', 'mobile' => '', 'pincode' => '', 'budget' => '', 'role' => '', 'details' => ''];
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($v as $k => $_) $v[$k] = trim((string)($_POST[$k] ?? ''));
    $mob = mobile10($v['mobile']);
    if (!empty($_POST['website']))                          { flash('success', 'Thank you! Your application has been received.'); header('Location: ' . $site . 'career.php'); exit; } // honeypot
    elseif (!csrf_ok())                                     $err = 'Session expired. Please reload the page and try again.';
    elseif (mb_strlen($v['name']) < 2)                      $err = 'Please enter your name.';
    elseif (!filter_var($v['email'], FILTER_VALIDATE_EMAIL)) $err = 'Please enter a valid email address.';
    elseif (!$mob)                                          $err = 'Please enter a valid 10-digit mobile number.';
    elseif (!preg_match('/^\d{6}$/', $v['pincode']))        $err = 'Please enter a valid 6-digit pincode.';
    elseif (!in_array($v['role'], $roles, true))            $err = 'Please select the role you are applying for.';
    elseif (!rate_ok('career'))                             $err = 'Please wait a few seconds before sending again.';
    else {
        $details = 'Role: ' . $v['role'] . "\n" . mb_substr($v['details'], 0, 2500);
        if (run("INSERT INTO career (name, email, mobile, pincode, budget, details) VALUES (?,?,?,?,?,?)", 'ssssss',
            [mb_substr($v['name'], 0, 255), mb_substr($v['email'], 0, 255), $mob, $v['pincode'], mb_substr($v['budget'], 0, 100), $details])) {
            flash('success', 'Thank you for applying! Our HR team will contact you if your profile matches.');
            header('Location: ' . $site . 'career.php'); exit;
        }
        $err = 'Something went wrong. Please try again.';
    }
}
require_once __DIR__ . '/includes/header.php';
banner('Career', 'Career');
?>
<main>
<section class="wrap cgrid">
  <div class="rv">
    <h2 class="h-ico">Build your career with Supreme Industry</h2>
    <div class="rich"><p>We design, manufacture and install PUF/PIR insulated panels and prefabricated buildings across India. If you like work you can see standing at the end of the day, we would like to hear from you.</p></div>
    <div class="perks">
      <div><b>Hands-on learning</b>Work alongside people with 24+ years of industry experience.</div>
      <div><b>Real projects</b>Cold storage, clean rooms, industrial sheds and portable buildings.</div>
      <div><b>Growth with the team</b>We are a young company, so good work gets noticed early.</div>
    </div>
  </div>
  <form class="cform rv" method="post" action="<?= e($site) ?>career.php" novalidate>
    <h2>Apply now</h2><p>Fill in your details and our HR team will get in touch.</p>
    <?= flash_html() ?>
    <?php if ($err): ?><div class="flash error" role="alert"><?= e($err) ?></div><?php endif; ?>
    <input type="hidden" name="csrf" value="<?= csrf() ?>">
    <div class="hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
    <div class="fgrid">
      <div><label for="name">Full name</label><input id="name" name="name" value="<?= e($v['name']) ?>" maxlength="255" required autocomplete="name"></div>
      <div><label for="email">Email</label><input id="email" type="email" name="email" value="<?= e($v['email']) ?>" maxlength="255" required autocomplete="email"></div>
      <div><label for="mobile">Mobile number</label><input id="mobile" type="tel" name="mobile" value="<?= e($v['mobile']) ?>" maxlength="14" required autocomplete="tel"></div>
      <div><label for="pincode">Pincode</label><input id="pincode" name="pincode" value="<?= e($v['pincode']) ?>" maxlength="6" inputmode="numeric" required autocomplete="postal-code"></div>
      <div><label for="role">Role</label><select id="role" name="role" required><option value="">Select a role</option><?php foreach ($roles as $r): ?><option <?= $v['role'] === $r ? 'selected' : '' ?>><?= e($r) ?></option><?php endforeach; ?></select></div>
      <div><label for="budget">Expected salary (per month)</label><input id="budget" name="budget" value="<?= e($v['budget']) ?>" maxlength="100" placeholder="Optional"></div>
      <div class="full"><label for="details">Experience &amp; details</label><textarea id="details" name="details" maxlength="2500" placeholder="Years of experience, current company, notice period…"><?= e($v['details']) ?></textarea></div>
    </div>
    <button class="btn" type="submit">SUBMIT APPLICATION <span>→</span></button>
  </form>
</section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
