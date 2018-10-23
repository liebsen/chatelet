chatelet website
================

# db-changelog

- alter table sale_products add column precio_lista varchar(50);
- alter table sale_products add column precio_vendido varchar(50);

oct_22
alter table homes add column display_popup_form_in_last tinyint(1) default '0';