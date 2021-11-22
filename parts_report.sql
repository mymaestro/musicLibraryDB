--- Parts for catalog number C123

SELECT `compositions`.`name` Composition, `part_types`.`name` Part
FROM `compositions`
    LEFT JOIN `parts` ON `parts`.`catalog_number` = `compositions`.`catalog_number`
    LEFT JOIN `part_types` ON `parts`.`id_part_type` = `part_types`.`id_part_type`
WHERE `compositions`.`catalog_number` = 'C123' AND `parts`.`originals_count` = 0
ORDER BY `compositions`.`name` ASC, `part_types`.`collation` ASC, `parts`.`id_part_type` ASC;

--- Pieces missing parts

SELECT `compositions`.`name` Composition, `part_types`.`name` Missing_part
FROM `compositions`
    LEFT JOIN `parts` ON `parts`.`catalog_number` = `compositions`.`catalog_number`
    LEFT JOIN `part_types` ON `parts`.`id_part_type` = `part_types`.`id_part_type`
WHERE `parts`.`originals_count` = 0
ORDER BY `compositions`.`name` ASC, `part_types`.`collation` ASC, `parts`.`id_part_type` ASC;


--- Parts information

SELECT p.catalog_number,
       c.name title,
       p.id_part_type,
       t.name type,
       p.name,
       p.description,
       p.is_part_collection,
       p.paper_size,
       z.name size,
       p.page_count,
       p.image_path,
       p.originals_count,
       p.copies_count
FROM   parts p
LEFT JOIN compositions c ON c.catalog_number = p.catalog_number
LEFT JOIN part_types t ON t.id_part_type = p.id_part_type
LEFT JOIN paper_sizes z ON z.id_paper_size = p.paper_size
WHERE  p.catalog_number = 'C123'
AND    p.id_part_type = 40;


--- Part collections information
SELECT     k.catalog_number_key,
           c.name title,
           k.id_part_type_key,
           s.name collection_name,
           k.id_part_type,
           t.name part_name,
           k.name,
           k.description
FROM       part_collections k
LEFT JOIN  compositions c ON c.catalog_number = k.catalog_number_key
LEFT JOIN  part_types s ON s.id_part_type = k.id_part_type_key
LEFT JOIN  part_types t ON t.id_part_type = k.id_part_type
ORDER BY   title, s.collation, t.collation;