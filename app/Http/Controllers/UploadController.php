<?php

namespace App\Http\Controllers;

use App\Models\TempFile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        $mimeTypes = ['image/jpeg', 'image/png', 'image/svg+xml', 'image/webp'];

        if ($request->hasFile('image') && in_array(File::mimeType($request->file('image')), $mimeTypes)) {
            $file = $request->file('image');
            $filename = Str::slug(str_replace("'", '', $file->getClientOriginalName()));
            $folder = 'tmp/' . uniqid() . '-' . now()->timestamp;
            Storage::putFileAs($folder, $file, $filename);

            TempFile::create([
                'folder' => $folder,
                'filename' => $filename,
            ]);

            return $folder;
        }

        return response('Failed upload', 500);
    }
}
