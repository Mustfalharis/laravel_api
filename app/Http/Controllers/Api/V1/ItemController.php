<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\ApiResponse;
use App\Http\Requests\V1\StoreItemRequest;
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

    public function store(StoreItemRequest $request)
    {
        try {
            $image= null;
            $imageDetails= null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = '' . time() . '.' . $image->getClientOriginalName();
                $image->storeAs('images/image', $imageName, 'public');
            }
            if ($request->hasFile('imageDetails')) {
                $imageDetails = $request->file('imageDetails');
                $imageDetailsName = '' . time() . '.' . $imageDetails->getClientOriginalName();
                $imageDetails->storeAs('images/imageDetails', $imageDetailsName, 'public');
            }
            $item = new Item();
            $item->fill($request->all());
            $item->image = $imageName;
            $item->image_details = $imageDetailsName;
            $item->save();
            return ApiResponse::Message("Add Items successful", true, 200);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }






    
}
