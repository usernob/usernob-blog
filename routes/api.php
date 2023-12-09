<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/attachment/upload', function (Request $request) {
    if (!$request->hasFile('image')) {
        # send 400 No file given
        return response(["error" => "No file given"], 400);
    }
    $file = $request->file('image');
    # check if file is an image
    if (!in_array($file->extension(), ['jpg', 'jpeg', 'png', 'gif'])) {
        # send 400 Invalid file type
        return response(["error" => "Invalid file type"], 415);
    }

    $path = $file->store('attachment');
    #return the path
    return response(
        [
            'data' => [
                'filePath' => asset($path),
            ],
        ],
        200,
    );
})->name('attachment.upload');
