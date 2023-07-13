<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class ViaCEPAddress implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $address = $value;
        $cep = str_replace('-', '', $address['cep']);

        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

        if (!$response->successful()) {
            $fail('Unable to validate the address. Please try again later.');
            return;
        }

        if ($response->json('erro')) {
            $fail('The provided CEP is incorrect or does not exist.');
            return;
        }

        unset($address['number'], $address['complement']);
        $viaCepData = $response->json();

        $viaCepDataFormated = [
            'cep' => $viaCepData['cep'],
            'street' => $viaCepData['logradouro'],
            'neighborhood' => $viaCepData['bairro'],
            'city' => $viaCepData['localidade'],
            'state' => $viaCepData['uf'],
        ];

        if (!($address === $viaCepDataFormated)) {
            $fail('The address provided is incorrect.');
        }
    }
}
