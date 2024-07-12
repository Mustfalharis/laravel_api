<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreUpdateCategoire;
use App\Http\Resources\V1\CategoireCollection;
use App\Http\Resources\V1\CategoireResource;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoireController extends Controller
{
    public function index()
    {
        return ApiResponse::success(new CategoireCollection(Categorie::all()), true, 200);
    }

    public function show($id)
    {
        try {
            $categorie = Categorie::findOrFail($id);
            return ApiResponse::success(new CategoireResource($categorie), true, 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error("Failed to find category", 404);
        }
    }
    public function store(StoreUpdateCategoire $request)
    {
        try {
            Categorie::create($request->all());
            return ApiResponse::Message("add categoire successful", true, 200);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    public function update($id, StoreUpdateCategoire $request)
    {
        try {
            $categorie = Categorie::findOrFail($id);
            $categorie->fill($request->all());
            $updated = $categorie->save();
            if ($updated) {
                ApiResponse::Message("The categoire has been updated successfully.", true, 200);
            } else {
                ApiResponse::error("Failed to update categoire. Please try again.'", 500);
            }
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error("Failed to find category", 404);
        }
    }
}
