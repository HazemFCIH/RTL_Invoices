<?php

namespace App\Http\Controllers;

use App\Models\InvoiceAttachment;
use http\Exception\BadConversionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoiceAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'file_name' => 'mimes:pdf,jpeg,png,jpg',
        ],

            [

                'file_name.mimes' => 'صيغة المرفق يجب ان تكون png,jpg,jpeg. ',

            ]);
        $attachment = $request->file('file_name');
        $attachment_name = $attachment->getClientOriginalName();
        InvoiceAttachment::create([
            'file_name' => $attachment_name,
            'invoice_number'=>$request->invoice_number,
            'invoice_id' => $request->invoice_id,
            'Created_by' =>(Auth::user()->name),

        ]);
        $attachment->move(public_path('Attachments/'.$request->invoice_number),$attachment_name);
        session()->flash('ADD','تم اضاقة المرفق بنجاح');
        return back();


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       $Invoice_attachments = InvoiceAttachment::findOrFail($request->file_id);
         $Invoice_attachments->delete();
         Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
         session()->flash('delete','تم حذف المنتج بنجاح');
         return back();
        return $Invoice_attachments;

    }
}
