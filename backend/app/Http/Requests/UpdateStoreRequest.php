<?php

namespace App\Http\Requests;

use App\Rules\ViaCEPAddress;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3'],
            'description' => ['string', 'nullable'],
            'cnpj' => ['required', 'string', 'regex:/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/'],

            'address.cep' => ['required', 'string', 'regex:/^\d{5}-\d{3}$/'],
            'address.number' => ['required', 'integer'],
            'address.street' => ['required', 'string', 'min:3'],
            'address.complement' => ['nullable', 'string', 'min:3'],
            'address.neighborhood' => ['required', 'string', 'min:3'],
            'address.city' => ['required', 'string', 'min:3'],
            'address.state' => ['required', 'string', 'size:2'],

            'address' => [new ViaCEPAddress]
        ];
    }

    public function messages()
    {
        return [
            'address.cep.regex' => 'The cep field format is invalid. The field must be in the format "00000-000".',

            'address.*.required' => 'The fields cep, number, street, neighborhood, city, and state are required.',
            'address.*.string' => 'The fields cep, street, complement, neighborhood, city, and state  must be strings.',
            'address.*.integer' => 'The field number must be a number',
            'address.*.min' => 'The fields cep, number, street, complement, neighborhood, city, and state  must have at least :min characters.',

            'address.state.size' => 'The state field must be 2 characters.'
        ];
    }
}
