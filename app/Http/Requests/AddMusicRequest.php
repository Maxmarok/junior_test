<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddMusicRequest extends FormRequest
{

    public function rules()
    {
        return [
            'title' => 'required|string',
            'author' => 'sometimes|nullable|string',
            'album' => 'sometimes|nullable|string',
            'url' => 'required|string',

        ];
    }
}
