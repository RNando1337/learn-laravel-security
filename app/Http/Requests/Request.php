<?php

namespace App\Http\Requests;

use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class Request extends FormRequest
{
    use HttpResponse;

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();
        
        throw new HttpResponseException(
            $this->apiResponseErrors("Validation Failed", $errors, 422)
        );
    }
}