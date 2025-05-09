<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTodoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:100', 'min:3'],
            'description' => ['nullable', 'string', 'max:500'],
            'status'      => ['nullable', 'string', 'in:pending,in_progress,completed,cancelled'],
            'priority'    => ['nullable', 'string', 'in:low,medium,high'],
            'due_date'    => ['nullable', 'after_or_equal:tomorrow', 'date'],
            'category'  => ['nullable', 'exists:categories,id'],
        ];
    }
}
