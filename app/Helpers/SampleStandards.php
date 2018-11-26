<?php
/**
 * Created by PhpStorm.
 * User: art
 * Date: 11/26/18
 * Time: 9:34 PM
 */

namespace App\Helpers;


class SampleStandards
{
    public const PRODUCT_CREATE_BULK = array(
        self::PRODUCT_CREATE_BULK_UPC => 'upc',
        self::PRODUCT_CREATE_BULK_CATEGORY => 'category',
        self::PRODUCT_CREATE_BULK_SUB_CATEGORY => 'subCategory',
        self::PRODUCT_CREATE_BULK_IMAGE => 'image',
        self::PRODUCT_CREATE_BULK_BRAND_ID => 'brand_id',
        self::PRODUCT_CREATE_BULK_TITLE => 'title',
        self::PRODUCT_CREATE_BULK_DESCRIPTION => 'description',
        self::PRODUCT_CREATE_BULK_WIDTH => 'width',
        self::PRODUCT_CREATE_BULK_HEIGHT => 'height',
        self::PRODUCT_CREATE_BULK_LENGTH => 'length',
        self::PRODUCT_CREATE_BULK_WEIGHT => 'weight',
    );

    const PRODUCT_CREATE_BULK_UPC = 0;
    const PRODUCT_CREATE_BULK_CATEGORY = 1;
    const PRODUCT_CREATE_BULK_SUB_CATEGORY = 2;
    const PRODUCT_CREATE_BULK_IMAGE = 3;
    const PRODUCT_CREATE_BULK_BRAND_ID = 4;
    const PRODUCT_CREATE_BULK_TITLE = 5;
    const PRODUCT_CREATE_BULK_DESCRIPTION = 6;
    const PRODUCT_CREATE_BULK_WIDTH = 7;
    const PRODUCT_CREATE_BULK_HEIGHT = 8;
    const PRODUCT_CREATE_BULK_LENGTH = 9;
    const PRODUCT_CREATE_BULK_WEIGHT = 10;
}