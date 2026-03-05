<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddGameRequest extends FormRequest
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
            'title' => ['required', 'string', 'min:3', 'max:64',
                        Rule::unique('games', 'title')->whereNull('deleted_at')
            ],
            'title' => 'required|string|min:3|max:64|unique:games,title',
            'year' => 'required|integer|min:1970|max:2030',
            'logo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'title' => trim($this->title)
        ]);
    }
}
