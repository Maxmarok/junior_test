<?php

namespace App\Http\Requests\Music;

use Illuminate\Foundation\Http\FormRequest;

class AddMusic extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'=> 'string|nullable',
            'author'=> 'string|nullable',
            'album'=> 'string|nullable',
            'url'=> 'string|required',
        ];
    }
}
