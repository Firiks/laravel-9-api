<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Filters\V1\CustomersFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCustomerRequest;
use App\Http\Resources\V1\CustomerResource;
use App\Http\Requests\V1\UpdateCustomerRequest;
use App\Http\Resources\V1\CustomerCollection;

class CustomerController extends Controller
{
  /**
   * Display a listing of the resource.
   * 
   * @param \Illuminate\Http\Request $request
   * @return Response
   */
  public function index(Request $request)
  {
    $filter = new CustomersFilter();
    $queryItems = $filter->transform($request); // transform to [['column', 'operator', 'value']]

    $includeInvoices = $request->query('includeInvoices');

    if( count($queryItems) ) { // check if we have any query items
      $customers = Customer::where($queryItems);

      if( $includeInvoices ) {
        $customers = $customers->with('invoices'); // load relationship
      }

      return new CustomerCollection($customers->paginate()->appends($request->query())); // add query links to paginate links
    }

    return new CustomerCollection(Customer::paginate());
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\V1\StoreCustomerRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreCustomerRequest $request)
  {
    return new CustomerResource(Customer::create($request->all()));
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Customer  $customer
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function show(Customer $customer, Request $request)
  {
    $includeInvoices = $request->query('includeInvoices');

    if( $includeInvoices ) {
      $customer = $customer->loadMissing('invoices'); // load relationship
    }

    return new CustomerResource($customer);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\V1\UpdateCustomerRequest  $request
   * @param  \App\Models\Customer  $customer
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateCustomerRequest $request, Customer $customer)
  {
    return $customer->update($request->all());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Customer  $customer
   * @return \Illuminate\Http\Response
   */
  public function destroy(Customer $customer)
  {
    return $customer->delete();
  }
}
