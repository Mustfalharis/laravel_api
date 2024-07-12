<?php

namespace App\Http\Requests\V1;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class StoreItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'imageDetails' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'required|numeric|min:0|max:5',
            'popular' => 'boolean',
            'categorieId' => 'required|exists:categories,id'
        ];
    }
    function prepareForValidation()
    {
        $this->merge([
            "image_details"=>$this->imageDetails,
            "categorie_id"=>$this->categorieId,
        ]);
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422));
    }

}
