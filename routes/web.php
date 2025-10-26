<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/download/image/{path}', function ($path) {
    $cleanPath = str_replace(['storage/', 'public/'], '', $path);

    $possiblePaths = [
        storage_path('app/public/' . $cleanPath),
        public_path($cleanPath),
        public_path('reinbursement_payment/' . basename($cleanPath)),
    ];

    foreach ($possiblePaths as $filePath) {
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
    }

    abort(404, 'File not found in any known location.');
})->where('path', '.*')->name('image.download');


