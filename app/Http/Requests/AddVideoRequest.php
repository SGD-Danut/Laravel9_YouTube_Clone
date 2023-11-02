<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddVideoRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'videoFile' => 'required|max:450000', // Echivalentul a 450MB
            'needsCompression' => 'required',
            'title' => 'required|max:50',
            'description' => 'required|max:250',
            'video_category' => 'required'
        ];
    }
}
