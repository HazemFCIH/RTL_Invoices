<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Notifications\addInvoice;
use App\Notifications\AddInvoiceDb;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Models\InvoiceDetail;
use App\Models\InvoiceAttachment;
use Illuminate\Support\Facades\Storage;
use App\Exports\InvoiceExport;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{
    function  __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:الفواتير');



    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::all();
        return view('Invoices.invoices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::all();
        return view('Invoices.createInvoice', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
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

            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_Date,
            'due_date' => $request->Due_date,
            'section_id' => $request->section,
            'product' => $request->product,
            'amount_collection' => $request->Amount_collection,
            'amount_commission' => $request->Amount_Commission,
            'discount' => $request->discount,
            'rate_vat' => $request->rate_vat,
            'value_vat' => $request->value_vat,
            'total' => $request->total,
            'note' => $request->note,
            'status' => 'غير مدفوعه',
            'value_status' => 2,
            'user' => (Auth::user()->name),
        ]);
        $invoice_id = Invoice::latest()->first()->id;
        InvoiceDetail::create([
            'invoice_id' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->section,
            'status' => 'غير مدفوعه',
            'value_status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),

        ]);

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $file_name = $image->getClientOriginalName();
            InvoiceAttachment::create([
                'file_name' => $file_name,
                'invoice_number' => $request->invoice_number,
                'invoice_id' => $invoice_id,
                'Created_by' => (Auth::user()->name),

            ]);
            $image->move(public_path('Attachments/' . $request->invoice_number), $file_name);

        }
       // for one user
        /*
        $user = Auth::user()
        $user->notify(new \App\Notifications\AddInvoiceDb($invoice));;*/
        // for all users in the system

        $user = User::get();


       // send email notification
        // Notification::send($user, new addInvoice($invoice_id));
        $invoice = Invoice::latest()->first();
        Notification::send($user, new AddInvoiceDb($invoice));

        session()->flash('ADD', 'تم اضاقة الفاتورة بنجاح');
        return redirect('invoices');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        $invoice_data = Invoice::where('id', $invoice->id)->first();
        $invoice_details = InvoiceDetail::where('invoice_id', $invoice->id)->get();
        $invoice_attachmnets = InvoiceAttachment::where('invoice_id', $invoice->id)->get();

        return view('Invoices.showInvoiceDetails', compact('invoice_details', 'invoice_attachmnets', 'invoice_data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        $sections = Section::all();
        return view('Invoices.editInvoice', compact('sections', 'invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|max:255|unique:invoices,invoice_number,' . $invoice->id,

        ],

            [

                'invoice_number.required' => 'يرجى ادخال  اسم الفاتورة',
                'invoice_number.unique' => 'اسم الفاتورة مسجل مسبقا',

            ]);

        $invoice->update($request->all());
        session()->flash('EDIT', 'تم تعديل الفاتورة بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoice = Invoice::findOrFail($request->invoice_id);
        $attachments = InvoiceAttachment::where('invoice_id', $invoice->id)->first();
        if (!empty($attachments->invoice_number)) {

            Storage::disk('public_uploads')->deleteDirectory($attachments->invoice_number);
        }
        $invoice->forceDelete();
        session()->flash('delete');
        return redirect('invoices');


    }

    public function getProducts($id)
    {
        $products = DB::table('products')->where("section_id", $id)->pluck("product_name", "id");
        return json_encode($products);

    }

    public function getfile($invoice_number, $file_name)
    {
        $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number . '/' . $file_name);
        return response()->download($files);
    }

    public function openfile($invoice_number, $file_name)
    {
        $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number . '/' . $file_name);
        return response()->file($files);
    }

    public function change_invoice_status($id)
    {
        $invoice = Invoice::where('id', $id)->first();
        return view('Invoices.updateInvoiceStatus', compact('invoice'));
    }

    public function status_update(Request $request)
    {
        $invoice = Invoice::findOrFail($request->invoice_id);
        if ($request->status == 1) {
            $invoice->update([

                'status' => 'مدفوعة جزئيا',
                'value_status' => $request->status,
                'payment_date' => $request->payment_date,
            ]);

        } elseif ($request->status == 3) {
            $invoice->update([

                'status' => 'مدفوعة كليا',
                'value_status' => $request->status,
                'payment_date' => $request->payment_date,
            ]);
        }
        InvoiceDetail::create([
            'invoice_id' => $request->invoice_id,
            'invoice_number' => $invoice->invoice_number,
            'product' => $invoice->product,
            'section' => $invoice->section_id,
            'status' => $invoice->status,
            'value_status' => $invoice->value_status,
            'user' => (Auth::user()->name),
            'note' => $invoice->note,
        ]);
        session()->flash('update_status');
        return redirect('invoices');

    }


    public function paid_invoices()
    {
        $invoices = Invoice::where('value_status', 3)->get();
        return view('Invoices.paidInvoices', compact('invoices'));
    }

    public function unpaid_invoices()
    {
        $invoices = Invoice::where('value_status', 2)->get();
        return view('Invoices.unPaidInvoices', compact('invoices'));
    }

    public function partial_paid_invoices()
    {
        $invoices = Invoice::where('value_status', 1)->get();
        return view('Invoices.partialPaidInvoices', compact('invoices'));
    }


/* archive Invoices with soft delete */

    public function archive_invoices(Request $request)
    {

        $invoice = Invoice::findOrFail($request->invoice_id);
        $invoice->delete();
        session()->flash('invoice-archived');
        return redirect('/invoice_archive');
    }


/* print Invoice as a pdf */
    public function print_invoice($id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('Invoices.printInvoice', compact('invoice'));
    }


/* export invoice as an Excel sheet*/
    public function export()
    {
        return Excel::download(new InvoiceExport(), 'invoices.xlsx');


    }
}
