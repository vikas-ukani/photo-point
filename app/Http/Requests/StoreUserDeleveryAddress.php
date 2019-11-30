<?php

namespace App\Http\Requests;

// use Illuminate\Foundation\Http\FormRequest;

class StoreUserDeleveryAddress extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required',
            'name' => 'required',
            'mobile' => 'required',
            'alternate_mobile' => 'required',
            'pincode' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.required' => 'User Name Is Must.',
            // 'sku_no.required' => 'An SKU NO is required',
            // 'price.required' => 'The price is required',
        ];

        //   return [
        //     'title.required' => 'A title is required',
        //     'body.required'  => 'A message is required',
        // ];
    }
}
