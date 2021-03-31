<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\InvoiceDetail;
use App\Models\InvoiceAttachment;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::all();
        return view('Invoices.invoices',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::all();
        return view('Invoices.createInvoice',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|max:255|unique:invoices',
        ],

            [

                'product_name.unique' => 'رقم الفاتورة مسجل مسبقا',

            ]);
        Invoice::create([

            'invoice_number'=>$request->invoice_number,
            'invoice_date'=>$request->invoice_Date,
            'due_date'=>$request->Due_date,
            'section_id'=>$request->section,
            'product'=>$request->product,
            'amount_collection'=>$request->Amount_collection,
            'amount_commission'=>$request->Amount_Commission,
            'discount' =>$request->discount,
            'rate_vat' =>$request->rate_vat,
            'value_vat' =>$request->value_vat,
            'total' =>$request->total,
            'note' =>$request->note,
            'status' =>'غير مدفوعه',
            'value_status' =>2,
            'user' =>(Auth::user()->name),
        ]);
        $invoice_id = Invoice::latest()->first()->id;
        InvoiceDetail::create([
            'invoice_id'=>$invoice_id,
            'invoice_number'=>$request->invoice_number,
            'product'=>$request->product,
            'section'=>$request->section,
            'status' =>'غير مدفوعه',
            'value_status' =>2,
            'note' =>$request->note,
            'user' =>(Auth::user()->name),

        ]);

        if($request->hasFile('image')){

            $image = $request->file('image');
            $file_name = $image->getClientOriginalName();
            InvoiceAttachment::create([
            'file_name' => $file_name,
            'invoice_number'=>$request->invoice_number,
            'invoice_id' => $invoice_id,
            'Created_by' =>(Auth::user()->name),

            ]);
           $image->move(public_path('Attachments/'.$request->invoice_number),$file_name);

        }

        session()->flash('ADD','تم اضاقة الفاتورة بنجاح');
        return redirect('invoices');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        $invoice_data = Invoice::where('id',$invoice->id)->first();
        $invoice_details = InvoiceDetail::where('invoice_id',$invoice->id)->get();
        $invoice_attachmnets = InvoiceAttachment::where('invoice_id',$invoice->id)->get();

        return view('Invoices.showInvoiceDetails',compact('invoice_details','invoice_attachmnets','invoice_data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        $sections = Section::all();
        return view('Invoices.editInvoice',compact('sections','invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|max:255|unique:invoices,invoice_number,'.$invoice->id,

        ],

            [

                'invoice_number.required' => 'يرجى ادخال  اسم الفاتورة',
                'invoice_number.unique' => 'اسم الفاتورة مسجل مسبقا',

            ]);

        $invoice->update($request->all());
        session()->flash('EDIT','تم تعديل الفاتورة بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoice = Invoice::findOrFail($request->invoice_id);
        $attachments = InvoiceAttachment::where('invoice_id',$invoice->id)->get();
        if(!empty($attachments->invoice_number)){

            Storage::disk('public_uploads')->deleteDirectory($attachments->invoice_number);
        }
        $invoice->forceDelete();
        session()->flash('delete');
        return redirect('invoices');


    }
    public function getProducts($id) {
        $products = DB::table('products')->where("section_id",$id)->pluck("product_name","id");
        return  json_encode($products);

    }
    public function getfile($invoice_number,$file_name){
        $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        return response()->download($files);
    }
    public function openfile($invoice_number,$file_name){
        $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        return response()->file($files);
    }
}
