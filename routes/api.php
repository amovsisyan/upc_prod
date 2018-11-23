<?php

Route::prefix('/v1')->group(function () {
    Route::resource('brands', 'Api\BrandController')->except([
        'create', 'edit'
    ]);
    Route::resource('categories', 'Api\CategoryController')->except([
        'create', 'edit'
    ]);
    Route::resource('products', 'Api\ProductController')->except([
        'create', 'edit'
    ]);
    Route::resource('product-versions', 'Api\ProductVersionController')->except([
        'create', 'edit'
    ]);
});
