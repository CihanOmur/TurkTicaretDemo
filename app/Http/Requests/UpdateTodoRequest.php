<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTodoRequest extends FormRequest
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

    public function messages(): array
    {
        return [
            'title.required' => 'Başlık alanı zorunludur.',
            'title.string'   => 'Başlık alanı geçerli bir metin olmalıdır.',
            'title.max'      => 'Başlık alanı en fazla 100 karakter olmalıdır.',
            'title.min'      => 'Başlık alanı en az 3 karakter olmalıdır.',
            'description.string' => 'Açıklama alanı geçerli bir metin olmalıdır.',
            'description.max'    => 'Açıklama alanı en fazla 500 karakter olmalıdır.',
            'status.in'         => 'Durum alanı geçerli bir değer olmalıdır.',
            'priority.in'       => 'Öncelik alanı geçerli bir değer olmalıdır.',
            'due_date.after_or_equal' => 'Son tarih bugünden sonraki bir tarih olmalıdır.',
            'category.exists'   => 'Seçilen kategori geçersizdir.',
        ];
    }

    public function failedValidation($validator)
    {
        $response = response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
    public function response(array $errors)
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $errors,
        ], 422);
    }
}
