<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class DelOnlineOneRecordRequest extends FormRequest
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
            'stat' => 'required|string',
            'gameId' => 'required|integer|min:1|exists:games,id',
            'source' => 'required|string|min:3|max:128|exists:onlines,source',
            'date' => 'required|date|after_or_equal:1970-01-01|before_or_equal:2030-01-01|exists:onlines,date'
        ];
    }

    protected function prepareForValidation()
    {
        return $this->merge([
            'gameId' => trim($this->gameId),
            'source' => Str::lower(trim($this->source)),
            'date' => trim($this->date) . '-01'
        ]);
    }
}
