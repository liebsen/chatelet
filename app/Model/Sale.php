<?php
class Sale extends AppModel {
    public $hasAndBelongsToMany = array(
        'Product' => array(
            'className' => 'Product',
            'joinTable' => 'sale_products',
            'foreignKey' => 'sale_id',
            'associationForeignKey' => 'product_id',
            'unique' => true
        )
    );
}