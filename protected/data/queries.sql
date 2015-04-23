SELECT t2.*,t3.caption FROM images_of_page t1
JOIN images t2 ON t1.image_id = t2.id
JOIN images_trl t3 ON t3.image_id = t2.id
JOIN languages t4 ON t3.lng_id = t4.id  
WHERE t1.page_id = 8 AND t4.prefix = 'ru'


SELECT * FROM contacts_page t1
WHERE t1.id = 1
LIMIT 1
UNION
SELECT * FROM contacts_page_trl t2
WHERE t2.page_id = 1 AND t2.lng_id = 2
LIMIT 1

