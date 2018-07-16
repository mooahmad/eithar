<?php

Auth::routes();

Route::prefix('{locale}')->group(function ($locale = 'en') {
    App::setLocale($locale);

});

