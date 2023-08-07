<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Invoice;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StoreInvoiceRequest;
use App\Http\Requests\v1\UpdateInvoiceRequest;
use App\Http\Resources\v1\InvoiceResource;
use App\Filters\v1\InvoicesFilter;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new InvoicesFilter();
        $queryItems = $filter->transform($request); // [['column', 'operator', 'value']]

        if(count($queryItems) === 0) { // 
            return InvoiceResource::collection(Invoice::paginate());
        } else {
            $invoices = Invoice::where($queryItems)->paginate();
            return InvoiceResource::collection($invoices->appends($request->query()));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        return new InvoiceResource(Invoice::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update($request->all());

        return new InvoiceResource($invoice);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return response()->json(null, 204);
    }
}
