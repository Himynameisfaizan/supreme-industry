<?php
require_once __DIR__ . '/includes/functions.php';

$per  = 9;
$total = (int)(q1("SELECT COUNT(*) AS n FROM blogs WHERE status=1")['n'] ?? 0);
$pages = max(1, (int)ceil($total / $per));
$page  = min($pages, max(1, (int)($_GET['page'] ?? 1)));
$off   = ($page - 1) * $per;
$blogs = q("SELECT title, slug, author, image, description, created_at FROM blogs WHERE status=1 ORDER BY blog_id DESC LIMIT ?, ?", 'ii', [$off, $per]);

// SEO: meta + page_schemas table se; schema na ho to auto Blog schema
$posts = [];
foreach ($blogs as $b) $posts[] = ['@type' => 'BlogPosting', 'headline' => mb_substr($b['title'], 0, 110), 'url' => CANONICAL_BASE . '/blog.php?slug=' . rawurlencode($b['slug'])];
$seo = ['schema' => page_schema('blogs.php') ?: json_encode(['@context' => 'https://schema.org', '@type' => 'Blog', 'name' => 'Supreme Industry Blog',
        'url' => CANONICAL_BASE . '/blogs.php', 'publisher' => ['@type' => 'Organization', 'name' => 'Supreme Industry', 'url' => CANONICAL_BASE . '/'], 'blogPost' => $posts],
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG)];
if ($page > 1) {
    $seo['path']  = 'blogs.php?page=' . $page;
    $seo['title'] = (page_meta('blogs.php')['meta_title'] ?? 'Blogs | Supreme Industry') . ' - Page ' . $page;
}
require_once __DIR__ . '/includes/header.php';
banner('Blogs', 'Blogs');
?>
<main>
<section class="wrap sec" style="padding-top:20px">
  <h2 class="ptitle">Latest From Our Blog</h2>
  <?php if (!$blogs): ?><p>No blog posts yet.</p><?php else: ?>
  <div class="bgrid rv">
    <?php foreach ($blogs as $b): $im = bimg($b['image']); ?>
      <a class="bcard" href="<?= e($site) ?>blog.php?slug=<?= e($b['slug']) ?>">
        <div class="pi"><?php if ($im): ?><img src="<?= e($im) ?>" alt="<?= e($b['title']) ?>" loading="lazy"><?php endif; ?></div>
        <div class="bbody">
          <span class="bmeta"><?= $b['created_at'] ? e(date('d M Y', strtotime($b['created_at']))) : '' ?><?= $b['author'] ? ' · ' . e($b['author']) : '' ?></span>
          <h3><?= e($b['title']) ?></h3>
          <p><?= e(plain($b['description'], 120)) ?></p>
          <span class="more">READ MORE →</span>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
  <?php if ($pages > 1): ?>
  <nav class="pager" aria-label="Blog pages">
    <?php if ($page > 1): ?><a href="?page=<?= $page - 1 ?>">‹ Prev</a><?php endif; ?>
    <?php for ($i = 1; $i <= $pages; $i++): ?><?= $i === $page ? '<span class="on">' . $i . '</span>' : '<a href="?page=' . $i . '">' . $i . '</a>' ?><?php endfor; ?>
    <?php if ($page < $pages): ?><a href="?page=<?= $page + 1 ?>">Next ›</a><?php endif; ?>
  </nav>
  <?php endif; endif; ?>
</section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
