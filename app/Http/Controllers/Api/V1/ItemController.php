<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\ApiResponse;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\V1\StoreItemRequest as V1StoreItemRequest;
use App\Http\Resources\V1\ItemResource;
use App\Models\Item;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        return ApiResponse::success(Item::all(), true, 200);
    }
    public function show($id)
    {
        try {
            $categorie = Item::findOrFail($id);
            return ApiResponse::success(new ItemResource($categorie), true, 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error("Failed to find Items", 404);
        }
    }

    public function store(V1StoreItemRequest $request)
    {
        try {
             Item::create($request->all());
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = 'image_' . time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('images/image', $imageName, 'public');
                $validatedData['image'] = $imagePath;
            }
            if ($request->hasFile('imageDetails')) {
                $imageDetails = $request->file('imageDetails');
                $imageDetailsName = 'image_details_' . time() . '.' . $imageDetails->getClientOriginalExtension();
                $imageDetailsPath = $imageDetails->storeAs('images/imageDetails', $imageDetailsName, 'public');
                $validatedData['imageDetails'] = $imageDetailsPath;
            }
            return ApiResponse::Message("Add Items successful", true, 200);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }
}
