<?php
require_once __DIR__ . '/includes/functions.php';

$slug = trim((string)($_GET['slug'] ?? ''));
$b = $slug !== '' ? q1("SELECT * FROM blogs WHERE slug=? AND status=1 LIMIT 1", 's', [$slug]) : null;
if (!$b) http_response_code(404);

if ($b) {
    $url   = CANONICAL_BASE . '/blog.php?slug=' . rawurlencode($b['slug']);
    $desc  = trim((string)$b['meta_desc']) ?: plain($b['description'], 155);
    $imgAbs = trim((string)$b['image']) !== '' ? CANONICAL_BASE . '/admin/assets/img/' . D_BLOG . rawurlencode(trim($b['image'])) : null;
    $isOrg = in_array(strtolower(trim((string)$b['author'])), ['', 'admin'], true);
    $when  = strtotime((string)$b['created_at']) ?: time();
    // Blog ka apna schema na ho to BlogPosting + Breadcrumb auto
    $auto = json_encode(['@context' => 'https://schema.org', '@graph' => [
        array_filter(['@type' => 'BlogPosting', '@id' => $url . '#post', 'headline' => mb_substr($b['title'], 0, 110), 'description' => $desc, 'image' => $imgAbs,
            'author' => ['@type' => $isOrg ? 'Organization' : 'Person', 'name' => $isOrg ? 'Supreme Industry' : $b['author']],
            'publisher' => ['@type' => 'Organization', 'name' => 'Supreme Industry', 'url' => CANONICAL_BASE . '/'],
            'datePublished' => date('c', $when), 'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $url]]),
        ['@type' => 'BreadcrumbList', 'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => CANONICAL_BASE . '/'],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Blogs', 'item' => CANONICAL_BASE . '/blogs.php'],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $b['title'], 'item' => $url]]],
    ]], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
    $seo = ['title' => trim((string)$b['meta_title']) ?: $b['title'] . ' | Supreme Industry', 'desc' => $desc, 'key' => (string)$b['meta_key'],
            'schema' => clean_schema($b['schema_markup']) ?: $auto, 'path' => 'blog.php?slug=' . rawurlencode($b['slug']), 'image' => $imgAbs];
} else {
    $seo = ['title' => 'Blog not found | Supreme Industry', 'desc' => '', 'key' => '', 'schema' => '', 'path' => 'blogs.php'];
}
require_once __DIR__ . '/includes/header.php';

$title = $b['title'] ?? 'Blog not found';
$recent = $b ? q("SELECT title, slug, image, created_at FROM blogs WHERE status=1 AND blog_id<>? ORDER BY blog_id DESC LIMIT 5", 'i', [(int)$b['blog_id']]) : [];
banner($title, [['Blogs', $site . 'blogs.php'], $title]);
$su = rawurlencode($canonical); $sn = rawurlencode($title);
?>
<main>
<?php if (!$b): ?>
<section class="wrap sec"><h2>Blog not found</h2><p style="margin:10px 0 16px">The article you are looking for is not available.</p><a class="btn" href="<?= e($site) ?>blogs.php">VIEW ALL BLOGS <span>→</span></a></section>
<?php else: $im = bimg($b['image']); ?>
<section class="wrap pd">
  <article class="rv">
    <?php if ($im): ?><img class="pd-img" src="<?= e($im) ?>" alt="<?= e($title) ?>"><?php endif; ?>
    <p class="bmeta" style="margin-top:14px"><?= $b['created_at'] ? e(date('d M Y', strtotime($b['created_at']))) : '' ?><?= $b['author'] ? ' · By ' . e($b['author']) : '' ?></p>
    <div class="rich"><?= blog_html($b['description']) ?></div>
    <div class="share"><b>Social Share:</b>
      <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $su ?>" target="_blank" rel="noopener" aria-label="Share on Facebook">f</a>
      <a href="https://twitter.com/intent/tweet?url=<?= $su ?>&amp;text=<?= $sn ?>" target="_blank" rel="noopener" aria-label="Share on X">X</a>
      <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $su ?>" target="_blank" rel="noopener" aria-label="Share on LinkedIn">in</a>
      <a href="https://wa.me/?text=<?= $sn . '%20' . $su ?>" target="_blank" rel="noopener" aria-label="Share on WhatsApp">wa</a>
    </div>
  </article>
  <aside class="aside rv">
    <?php if ($recent): ?>
    <div class="sbox"><h3>Recent Posts</h3>
      <?php foreach ($recent as $r): $ri = bimg($r['image']); ?>
        <a class="rp" href="<?= e($site) ?>blog.php?slug=<?= e($r['slug']) ?>">
          <?php if ($ri): ?><img src="<?= e($ri) ?>" alt="" loading="lazy"><?php endif; ?>
          <span><b><?= e($r['title']) ?></b><small><?= $r['created_at'] ? e(date('d M Y', strtotime($r['created_at']))) : '' ?></small></span>
        </a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <div class="sbox"><h3>Need a PUF Panel Solution?</h3>
      <p style="font-size:13.5px;color:var(--muted);margin-bottom:10px">Tell us your requirement and our team will get back to you.</p>
      <a class="btn" href="<?= e($site) ?>contact-us.php">GET A QUOTE <span>→</span></a>
    </div>
  </aside>
</section>
<?php endif; ?>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
