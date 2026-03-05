<?php

namespace App\Http\Requests;

//ADDITIONAL
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class AddIncomeRecordRequest extends FormRequest
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
            'id' => 'required|integer|min:1|exists:games,id',
            'date' => ['required','date','after_or_equal:1970-01-01','before_or_equal:2030-01-01',
                        Rule::unique('incomes')->where(fn ($query) => $query->where('game_id', $this->id)->where('source', $this->source))
            ],
            'stat_number' => 'required|integer|min:1',
            'source' => 'required|string|min:3|max:128',
            'stat' => 'required|string'
        ];
    }

    protected function prepareForValidation() {
        return $this->merge([
            'id' => trim($this->id),
            'date' => $this->date . '-01',
            'stat_number' => trim($this->stat_number),
            'source' => Str::lower(trim($this->source))
        ]);
    }
}
