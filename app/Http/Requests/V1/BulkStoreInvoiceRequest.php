<?php

namespace App\Http\Requests\V1;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BulkStoreInvoiceRequest extends FormRequest
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
    return [ // verify array of objects
      '*.customerId' => ['required', 'integer'],
      '*.amount' => ['required', 'numeric'],
      '*.status' => ['required', Rule::in(['B', 'P', 'V', 'b', 'p', 'v' ])],
      '*.billedDate' => ['required', 'date_format:Y-m-d H:i:s'],
      '*.paidDate' => ['required', 'date_format:Y-m-d H:i:s', 'nullable'],
    ];
  }

  /**
   * Prepare data that need to be mapped to db columns
   *
   * @return void
   */
  protected function prepareForValidation()
  {
    $data = [];

    foreach( $this->toArray() as $obj ) {
      $obj['customer_id'] = $obj['customerId'] ?? null;
      $obj['billed_date'] = $obj['billedDate'] ?? null;
      $obj['paid_date'] = $obj['paidDate'] ?? null;

      $data[] = $obj;
    }

    $this->merge($data);
  }

}
