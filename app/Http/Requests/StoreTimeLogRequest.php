<?php

namespace App\Http\Requests;

use App\Models\TimeLog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTimeLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', TimeLog::class);
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
            'date' => ['required', 'date'],
            'hours' => ['required', 'numeric', 'min:0.1', 'max:24'],
            'description' => ['required', 'string', 'max:1000'],
        ];
    }
}
