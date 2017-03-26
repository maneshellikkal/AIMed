<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDatasetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize ()
    {
        return auth()->check() && auth()->user()->datasets()->whereSlug($this->route('dataset'))->count();
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules ()
    {
        return [
            'name'         => 'required|string|between:6,50',
            'overview'     => 'required|string|between:20,80',
            'description'  => 'required|max:20000',
            'image'        => 'image|mimes:jpeg,png|max:5120',
        ];
    }
}
