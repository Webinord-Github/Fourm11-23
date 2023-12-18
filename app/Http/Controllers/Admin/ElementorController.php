<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use App\Models\Media;
use Auth;

class ElementorController extends Controller
{
    public function medias()
    {
        $medias = Media::where('path', '=', '/storage/medias/')
        ->where(function($query) {
            $query->where('provider', '=', 'jpg')
            ->orWhere('provider', '=', 'jpeg')
            ->orWhere('provider', '=', 'png')
            ->orWhere('provider', '=', 'webp');
        })
        ->get();

        echo json_encode($medias);
    }

    public function upload(Request $request)
    {   
        $file_original_name = $request->file('image')->getClientOriginalName();
        $file_name_only = pathinfo($file_original_name, PATHINFO_FILENAME);
        $file_provider = pathinfo($file_original_name, PATHINFO_EXTENSION);
        $file_size = $request->file('image')->getSize() / 1024;
        $existing_file_url = Media::where('name', '=', $file_original_name)->first();
        $count_file = Media::where('original_name', '=', $file_original_name)->count();

        if($existing_file_url) {
            $file_name = $file_name_only . "_" . $count_file . "." . $file_provider;
        } else {
            $file_name = $file_original_name;
        }

        $media = new Media();
        $media->user_id = Auth::user()->id;
        $media->path = '/storage/medias/';
        $media->name = $file_name;
        $media->original_name = $file_original_name;
        $media->size = $file_size;
        $media->provider = $file_provider;
        $media->save();
        Storage::putFileAs('public/medias',$request->file('image'), $file_name);

        $response = [
            'id' => $media->id,
            'user_id' => $media->user_id,
            'path' => $media->path,
            'name' => $media->name,
            'original_name' => $media->original_name,
            'size' => $media->size,
            'provider' => $media->provider,
        ];

        
        return response()->json($response);
    }
}
