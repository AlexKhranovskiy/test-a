<?php

namespace App\Http\Requests;

use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    use ResponseTrait;
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:60',
            'email' => 'required|string|min:2|max:100|email:rfc',
            'phone' => 'required|string|', //string - pattern: ^[\+]{0,1}380([0-9]{9})$)
            'position_id' => 'required|integer|min:1',
            'photo' => 'required|file'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->validationErrorResponse($validator)
        );
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $file = $this->file('photo');
            if ($file?->getSize() === 0) {
                $validator->errors()->add('photo', 'Image is invalid.');
            } elseif($file?->getSize() > 5 * 1024 * 1024){
                $validator->errors()->add('photo', 'The photo size must not be greater than 5 Mbytes.');
            }
        });
    }
}
