<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::inspect('update', $this->expense)->allowed();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'description' => ['sometimes', 'required', 'max:191'],
            'owner_id' => ['sometimes', 'required', 'numeric', Rule::exists('users', 'id')],
            'date' => ['sometimes', 'required', 'date_format:Y-m-d', 'before_or_equal:today'],
            'value' => ['sometimes', 'required', 'numeric', 'gte:0'],
        ];
    }

    protected function prepareForValidation()
    {
        if (!$this->user()->isAdmin()) {
            $this->replace($this->except('owner_id'));
        }
    }
}
