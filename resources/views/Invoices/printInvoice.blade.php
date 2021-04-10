@extends('layouts.master')
@section('title')
    طباعة الفواتير
@endsection
@section('css')
    @media print {
    #
    }
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ طباعة فاتورة</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice" id="print">
                <div class="card card-invoice">
                    <div class="card-body">
                        <div class="invoice-header">
                            <h1 class="invoice-title">فاتورة تحصيل</h1>
                            <div class="billed-from">
                                <h6>New Cairo - Egypt.</h6>
                                <p>First Settelment 8th street<br>
                                    Tel No: 324 445-4544<br>
                                    Email: hazem@companyname.com</p>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <label class="tx-gray-600">Billed To</label>
                                <div class="billed-to">
                                    <h6>Juan Dela Cruz</h6>
                                    <p>4033 Patterson Road, Staten Island, NY 10301<br>
                                        Tel No: 324 445-4544<br>
                                        Email: youremail@companyname.com</p>
                                </div>
                            </div>
                            <div class="col-md">
                                <label class="tx-gray-600">تفاصيل الفاتورة</label>
                                <p class="invoice-info-row"><span>رقم الفاتورة</span> <span>{{$invoice->invoice_number}}</span></p>
                                <p class="invoice-info-row"><span>تاريخ الاصدار</span> <span>{{$invoice->invoice_date}}</span></p>
                                <p class="invoice-info-row"><span>تاريخ الاستحقاق</span> <span>{{$invoice->due_date}}</span></p>
                                <p class="invoice-info-row"><span>القسم</span> <span>{{$invoice->section->section_name}}</span></p>
                                <p class="invoice-info-row"><span>المنتج</span> <span>{{$invoice->product}}</span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <label class="tx-gray-600">اجمالي الفاتورة</label>
                                <p class="invoice-info-row"><span>مبلغ التحصيل</span> <span>{{number_format($invoice->amount_collection,2)}}</span></p>
                                <p class="invoice-info-row"><span>مبلغ العموله</span> <span>{{number_format($invoice->amount_commission,2)}}</span></p>
                                <p class="invoice-info-row"><span>قيمة الضريبة</span> <span>{{$invoice->value_vat}}</span></p>
                                <p class="invoice-info-row"><span>نسبة الضريبة</span> <span>{{$invoice->rate_vat}}</span></p>
                                <p class="invoice-info-row"><span>الخصم</span> <span>{{number_format($invoice->discount,2)}}</span></p>
                                <h5 class="invoice-info-row"><span>الاجمالى</span> <span>{{number_format($invoice->total,2)}}</span></h5>

                            </div>
                        </div>
                        <hr class="mg-b-40">

                        <button id="printButton" onclick="printFun()" class="btn btn-danger float-left mt-3 mr-2">
                            <i class="mdi mdi-printer ml-1"></i>Print
                        </button>
                        <a href="#" class="btn btn-success float-left mt-3">
                            <i class="mdi mdi-telegram ml-1"></i>Send Invoice
                        </a>
                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
    <script type="text/javascript">
        function printFun(){
      var print_invoice = document.getElementById('print').innerHTML;
      var orginalContent = document.body.innerHTML;
      document.body.innerHTML = print_invoice;
      window.print();
      document.body.innerHTML = orginalContent;
      location.reload();

        }

    </script>
@endsection
