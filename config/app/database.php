<?php
/**
 * This file contains information about database tables names and column lengths.
 * Mostly using in migrations and request validations.
 */

$dbNames = [
    'brands' => 'brands',
    'categories' => 'categories',
    'products' => 'products',
    'product_versions' => 'product_versions',
    'attachments' => 'attachments',
    'category_product' => 'category_product',
];

$dbColumnLengths = [
    $dbNames['brands'] => [
        'name' => 50,
    ],

    $dbNames['categories'] => [
        'name' => 50,
    ],

    $dbNames['product_versions'] => [
        'title' => 100,
        'active' => [0, 1]
    ],

    $dbNames['attachments'] => [
        'path' => 100,
    ],
];


return [
    'dbNames' => $dbNames,

    'dbColumnLengths' => $dbColumnLengths
];
