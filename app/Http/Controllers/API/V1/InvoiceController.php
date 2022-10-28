<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Invoice;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Filters\V1\InvoicesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Resources\V1\InvoiceResource;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Requests\V1\BulkStoreInvoiceRequest;
use App\Http\Resources\V1\InvoiceCollection;

class InvoiceController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $filter = new InvoicesFilter();
    $queryItems = $filter->transform($request); // transform to [['column', 'operator', 'value']]

    if( count($queryItems) ) { // check if we have any query items
      $invoices = Invoice::where($queryItems);

      return new InvoiceCollection($invoices->paginate()->appends($request->query())); // add query links to paginate links
    }

    return new InvoiceCollection(Invoice::paginate());
  }

  /**
   * Store a newly created resources in bulk to storage.
   *
   * @param  \App\Http\Requests\V1\BulkStoreInvoiceRequest $request
   * @return \Illuminate\Http\Response
   */
  public function bulkStore(BulkStoreInvoiceRequest $request)
  {
    $bulk = collect($request->all())->map(function($arr, $key) {
      return Arr::except($arr, ['customerId', 'billedDate', 'paidDate']); // remove
    });

    return Invoice::insert($bulk->toArray());
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StoreInvoiceRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreInvoiceRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Invoice  $invoice
   * @return \Illuminate\Http\Response
   */
  public function show(Invoice $invoice)
  {
    return new InvoiceResource($invoice);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdateInvoiceRequest  $request
   * @param  \App\Models\Invoice  $invoice
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateInvoiceRequest $request, Invoice $invoice)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Invoice  $invoice
   * @return \Illuminate\Http\Response
   */
  public function destroy(Invoice $invoice)
  {
    return $invoice->delete();
  }
}
