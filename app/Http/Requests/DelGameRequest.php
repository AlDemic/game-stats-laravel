<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DelGameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|integer|min:1|exists:games,id'
        ];
    }
}
