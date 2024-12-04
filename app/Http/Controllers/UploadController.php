<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileUploadRequest;
use App\Services\FileService;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function __construct(private readonly FileService $fileService) {}

    public function __invoke(FileUploadRequest $request)
    {
        $file = $request->file('file');
        $path = $this->fileService->handleFileUpload($file);

        return response()->json([
            'location' => Storage::url($path),
        ]);
    }
}
