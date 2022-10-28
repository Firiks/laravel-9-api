<?php

namespace App\Http\Requests\V1;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    $user = $this->user();

    return $user != null && $user->tokenCan('create');
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    return [
      'name' => ['required'],
      'type' => ['required', Rule::in(['I', 'B', 'i', 'b'])],
      'email' => ['required', 'email'],
      'address' => ['required'],
      'city' => ['required'],
      'state' => ['required'],
      'postalCode' => ['required'],
    ];
  }

  /**
   * Prepare data that need to be mapped to db columns
   *
   * @return void
   */
  protected function prepareForValidation() // https://laravel.com/docs/9.x/validation#preparing-input-for-validation
  {
    $this->merge([
      'postal_code' => $this->postalCode
    ]);
  }

}
