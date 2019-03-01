<?php

namespace App\Services;


use App\GalleryImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageService
{

    const DELETE_IMAGE_ROUTE = 'delete-image';

    public function saveImages(Request $request)
    {
        $galleryImage = '';
        $files = $request->allFiles();

        foreach ($files as $item){
            $extension = $item->getClientOriginalExtension();

            $galleryImage = new GalleryImages();
            $galleryImage->mime = $item->getClientMimeType();
            $galleryImage->original_filename = $item->getClientOriginalName();
            $galleryImage->filename= $item->getFilename(). '.' . $extension;
            $galleryImage->size = $item->getSize();
            $galleryImage->position_order = GalleryImages::all()->count();
            $galleryImage->save();

            Storage::disk('gallery')->put($item->getFilename().'.'.$extension,  File::get($item));
        }

        return $galleryImage;
    }

    public function prepareImagesPreview($images)
    {
        $initialPreview = [];
        foreach ($images as $image)
        {
            $initialPreview[] = gallery_images($image->filename);;
        }

        return $initialPreview;
    }

    public function prepareImagesConfig($images)
    {
        $initialConfig = [];
        foreach ($images as $image)
        {
            $initialConfig[] =
                "{
                    caption: '". ($image->original_filename) . "', 
                    size: ". $image->size .", 
                    width: '120px', 
                    url: '".static::DELETE_IMAGE_ROUTE."', 
                    key: ". $image->id .",
                    order: ". $image->position_order ."
                }"
            ;
        }

        return $initialConfig;
    }

    public function prepareResponseData($image)
    {
        $initialPreview = gallery_images($image->filename);
        $initialPreviewConfig = [
            'caption' => $image->original_filename,
            'size' => $image->size,
            'width' => '120px',
            'url' => static::DELETE_IMAGE_ROUTE,
            'key' => $image->id,
            'order' => $image->position_order,
        ];

        $response['append'] = true;
        $response['initialPreview'] = $initialPreview;
        $response['initialPreviewConfig'][] = $initialPreviewConfig;

        return $response;
    }

}