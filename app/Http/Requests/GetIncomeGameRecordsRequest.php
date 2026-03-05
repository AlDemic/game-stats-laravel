<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class getIncomeGameRecordsRequest extends FormRequest
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
            'id' => 'required|integer|min:1|exists:games,id',
            'date' => 'required|date|date_format:Y-m-d|after_or_equal:1970-01-01|before_or_equal:2030-01-01|exists:incomes,date'
        ];
    }

    protected function prepareForValidation()
    {
        return $this->merge([
            'id' => trim($this->id),
            'date' => $this->date . '-01'
        ]);
    }
}
