-- Blogs pages ka meta + schema (Supreme Industry). phpMyAdmin me run karein.
-- Bestok wali purani rows hata kar Supreme ki daal di jaati hain.
DELETE FROM meta WHERE page_url IN ('blogs.php', 'blog.php');
INSERT INTO meta (page_name, page_url, meta_title, meta_key, meta_desc, updated_at) VALUES
('Blog Page', 'blogs.php',
 'PUF Panels & Prefab Building Blog | Supreme Industry',
 'PUF panels blog, prefabricated building guide, cold storage panels, PUF insulated panel uses, prefab buildings India, Supreme Industry blog',
 'Read guides, tips and updates on PUF insulated panels, cold storage, clean rooms, portable cabins and prefabricated buildings from Supreme Industry.', NOW()),
('Blog Alias', 'blog.php',
 'PUF Panel & Prefabricated Building Articles | Supreme Industry',
 'PUF panel articles, prefabricated structures, insulated panels, Supreme Industry',
 'Articles on PUF insulated panels and prefabricated building solutions from Supreme Industry, Noida.', NOW());

DELETE FROM page_schemas WHERE page_url = 'blogs.php';
INSERT INTO page_schemas (page_name, page_url, schema_markup, updated_at) VALUES
('Blog Page', 'blogs.php',
 '{"@context":"https://schema.org","@type":"Blog","name":"Supreme Industry Blog","url":"https://www.supremeindustry.in/blogs.php","description":"Guides, tips and updates on PUF insulated panels, cold storage, clean rooms and prefabricated buildings.","publisher":{"@type":"Organization","name":"Supreme Industry","url":"https://www.supremeindustry.in/"}}', NOW());

-- Har blog ka meta/schema admin me us blog ke meta_title / meta_desc / meta_key / schema_markup fields se aata hai.
-- Schema khaali chhodne par blog.php khud BlogPosting + BreadcrumbList schema bana deta hai.
-- Custom schema paste karna ho to JSON-LD (ya poora <script type="application/ld+json"> tag) chalega.
