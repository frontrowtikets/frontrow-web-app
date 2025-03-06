<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BannerImage;
use Illuminate\Support\Facades\Storage;

class BannerImagesController extends Controller
{
    public function index()
    {
        $images = BannerImage::all()->map(function ($image) {
            return [
                'id' => $image->id,
                'url' => asset('storage/' . $image->path)
            ];
        });

        return response()->json(['images' => $images]);
    }

    public function saveBannerImages(Request $request)
    {
        $savedImages = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('images', 'public');

                $image = BannerImage::create([
                    'path' => $path
                ]);

                $savedImages[] = [
                    'id' => $image->id,
                    'url' => asset('storage/' . $path)
                ];
            }
        }

        return response()->json(['images' => $savedImages]);
    }


    public function deleteImage(BannerImage $image)
    {
        Storage::disk('public')->delete($image->path);

        $image->delete();

        return response()->json(['message' => 'Image deleted successfully']);
    }
}

