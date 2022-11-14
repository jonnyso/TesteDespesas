<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class CreateExpenseRequest extends FormRequest
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
            'description' => ['required', 'max:191'],
            'owner_id' => ['required', 'numeric', Rule::exists('users', 'id')],
            'date' => ['required', 'date_format:Y-m-d', 'before_or_equal:today'],
            'value' => ['required', 'numeric', 'gte:0'],
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->shouldSetUserId()) {
            $this->merge([
                'owner_id' => $this->user()->id
            ]);
        }
    }

    protected function shouldSetUserId()
    {
        return $this->missing('owner_id') || Gate::inspect('create', User::class)->denied();
    }
}
