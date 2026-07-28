<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['sometimes', 'required', 'string', 'max:255'],
            'descripcion' => ['sometimes', 'required', 'string'],
            'estado' => ['sometimes', 'required', Rule::in(['pendiente', 'en_progreso', 'completada'])],
            'fecha_vencimiento' => ['nullable', 'date'],
            'prioridad_id' => ['sometimes', 'required', 'integer', 'exists:priorities,id'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer', 'exists:tags,id'],
        ];
    }
}
