-- Supreme Industry ka asli (old website wala) About content database mein daalne ke liye.
-- Images admin panel se upload karke image_url update karein (e.g. uploads/about_us/house.jpg).
INSERT INTO about_us (image_url, title, content, updated_at) VALUES
('', 'Prefabricated Structure Manufacturers & Installation',
'<p>Built on 24+ years of Industry Experience Supreme Industry was established in Jan. 2025, backed by over two decades of hands-on experience in the prefabricated building and insulated panel industry. Supreme Industry has been a pioneer in prefabricated and insulated Building solutions, offering clean rooms, cold storage, prefab buildings &amp; offices, Labour colonies, Prefab Banquet Halls, Marriage Halls, PUF panels, and more. Combining innovation, durability, and precision, we cater to industrial, commercial, and residential projects. Trusted by clients nationwide, Our approach is simple : Understand the requirement. Engineer the right solution. Execute with responsibility.</p>', NOW());

-- Our Team (founder). Sabse chhota section_order = pehli row = Our Team section.
INSERT INTO about_sections (title, content, image_url, section_order) VALUES
('Mr. Vineet Vats-Founder & Director',
'<p>A visionary leader, Mr. Vineet Vats has steered Supreme Industry to 24 years of excellence in prefabricated solutions. With a passion for innovation and quality, he ensures every project reflects precision, durability, and client satisfaction, making Supreme Industry a trusted name in industrial, commercial, and residential construction.</p>',
'', 0);
