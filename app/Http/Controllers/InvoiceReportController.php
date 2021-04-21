<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Section;
use Illuminate\Http\Request;

class InvoiceReportController extends Controller
{
    function  __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:التقارير');



    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reports.invoiceReports');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function search_invoices(Request $request){


        if($request->radio == 1)
        {
            if($request->type == 'حدد نوع الفواتير'){
                return back();
            }
            if($request->start_at == null && $request->end_at == null){

                if($request->type == 0 || $request->type ==  'الكل'){

                    $invoices = Invoice::all();
                    $type = 'الكل';
                    return view('reports.invoiceReports',compact('invoices','type'));
                }else{
                    $invoices = Invoice::where('value_status',$request->type)->get();
                    if($request->type == 1 || $request->type == 'مدفوعة جزئيا'){
                        $type = 'مدفوعة جزئيا';


                    }elseif ($request->type == 2  || $request->type == 'غير مدفوعة'){
                        $type = 'غير مدفوعة';


                    }elseif ($request->type == 3  || $request->type == 'مدفوعة'){
                        $type = 'مدفوعة';

                    }
                    return view('reports.invoiceReports',compact('invoices','type'));


                }
            }else{
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                if($request->type == 0){
                $invoices = Invoice::whereBetween('invoice_date',[$start_at,$end_at])->get();
                }else{
                    $invoices = Invoice::whereBetween('invoice_date',[$start_at,$end_at])->where('value_status',$request->type)->get();
                }
                return view('reports.invoiceReports',compact('invoices'));





            }// else for date is null


        }//end if for search with date
        else{

            $invoices = Invoice::where('invoice_number',$request->invoice_number)->get();
            return view('reports.invoiceReports',compact('invoices'));

        }
    }

    // Clients reports index
    public function client_index(){

        $sections = Section::all();
        return view('reports.ClientReports',compact('sections'));
    }
    // Search Clients
    public function client_search(Request $request){
        $validated = $request->validate([
            'section' => 'required',
            'product' => 'required',

        ],

            [

                'section.required' => 'يرجى ادخال  اسم القسم',
                'product.required' => 'يرجى ادخال  اسم المنتج',





            ]);
        if($request->start_at == '' && $request->end_at == ''){
            $sections = Section::all();
            $invoices = Invoice::where('section_id',$request->section)->where('product',$request->product)->get();
            return view('reports.ClientReports',compact('invoices','sections'));
        }else{
            $start_at = date($request->start_at);
            $end_at = date($request->end_at);
            $invoices = Invoice::whereBetween('invoice_date',[$start_at,$end_at])->where('section_id',$request->section)->where('product',$request->product)->get();
            $sections = Section::all();
            return view('reports.ClientReports',compact('invoices','sections'));



        }

    }


}
