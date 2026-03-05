<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DelOnlineMonthRecordRequest extends FormRequest
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
            'stat' => 'required|string',
            'gameId' => 'required|integer|min:1|exists:games,id',
            'date' => 'required|date|after_or_equal:1970-01-01|before_or_equal:2030-01-01|exists:onlines,date'
        ];
    }

    protected function prepareForValidation()
    {
        return $this->merge([
            'gameId' => trim($this->gameId),
            'date' => trim($this->date) . '-01'
        ]);
    }
}
