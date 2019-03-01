<?php
namespace App\Http\Controllers;

use App\GalleryImages;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    private $imageManager;

    public function __construct(ImageService $imageService)
    {
        $this->imageManager = $imageService;
    }

    public function showImages()
    {
        $images = GalleryImages::orderBy('position_order', 'asc')->get();
        $imagesPreview = $this->imageManager->prepareImagesPreview($images);
        $imagesConfig = $this->imageManager->prepareImagesConfig($images);

        return view('images', [
            'imagesPreview' => $imagesPreview,
            'imagesConfig' => $imagesConfig,
        ]);
    }

    public function uploadImage(Request $request)
    {
        if (!empty($request->allFiles())) {
            $image = $this->imageManager->saveImages($request);
            $response = $this->imageManager->prepareResponseData($image);
        } else {
            $response['error'] = 'No files provided';
        }

        return response()->json($response);
    }

    public function deleteImage(Request $request)
    {
        $id = $request->get('key');
        $image = GalleryImages::find($id);

        Storage::disk('gallery')->delete($image->filename);
        GalleryImages::destroy($image->id);

        return response()->json('File successfully deleted!');
    }

    public function sortImage(Request $request)
    {
        $position = $request->get('images')['stack'];

        foreach ($position as $orderNumber => $item)
        {
            GalleryImages::where('id', $item['key'])
                ->where('position_order', '!=' ,$orderNumber)
                ->update(['position_order' => $orderNumber]);
        }

        return response('Your change successfully saved!');
    }
}
