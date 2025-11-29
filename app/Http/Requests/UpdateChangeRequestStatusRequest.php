<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateChangeRequestStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin() || $this->user()->isStaff();
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(['open', 'in_review', 'completed'])],
        ];
    }
}
