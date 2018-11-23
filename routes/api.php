<?php

Route::prefix('/v1')->group(function () {
    Route::resource('brands', 'Api\BrandController')->except([
        'create', 'edit'
    ]);
});
