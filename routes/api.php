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
    Route::patch('products/{product}/category', 'Api\ProductController@updateCategory')->name('products.update.category');
    Route::post('products/bulk', 'Api\ProductController@storeBulk')->name('products.store.bulk');
    Route::get('products/bulk/sample', 'Api\ProductController@sampleBulk')->name('products.sample.bulk');

    Route::resource('product-versions', 'Api\ProductVersionController')->except([
        'create', 'edit'
    ]);
    Route::resource('attachments', 'Api\AttachmentController')->except([
        'create', 'edit'
    ]);
});
