chatelet website
================

# db-changelog

- alter table sale_products add column precio_lista varchar(50);
- alter table sale_products add column precio_vendido varchar(50);

oct_22
alter table homes add column display_popup_form_in_last tinyint(1) default '0';

2019
create table stock_count (id int unsigned auto_increment primary key, cod_articulo varchar(50), stock int default '0', updated datetime default CURRENT_TIMESTAMP);

alter table stock_count add column article_id varchar(20);

alter table products add column stock_total int default '1';
