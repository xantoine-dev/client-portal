<?php

namespace App\Http\Requests;

use App\Models\ChangeRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreChangeRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', ChangeRequest::class);
    }

    public function rules(): array
    {
        return [
            'project_id' => [
                'required',
                'integer',
                Rule::exists('projects', 'id')->where(function ($query) {
                    return $query->whereIn('client_id', $this->user()->clients()->pluck('clients.id'));
                }),
            ],
            'description' => ['required', 'string', 'max:2000'],
        ];
    }
}
