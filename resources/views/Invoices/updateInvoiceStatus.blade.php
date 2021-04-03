@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل حالة الفاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
        <div class="table-responsive mt-15">
            <table class="table table-striped" style="text-align:center">
                <tbody>
                <tr>
                    <th scope="row">رقم الفاتورة</th>
                    <td>{{$invoice->invoice_number}}</td>
                    <th scope="row">تاريخ الاصدار</th>
                    <td>{{$invoice->invoice_date}}</td>

                    <th scope="row">تاريخ الاستحقاق</th>
                    <td>{{$invoice->due_date}}</td>

                    <th scope="row">القسم</th>
                    <td>{{$invoice->section->section_name}}</td>


                </tr>
                <tr>
                    <th scope="row">المنتج</th>
                    <td>{{$invoice->product}}</td>
                    <th scope="row">مبلغ التحصيل</th>
                    <td>{{$invoice->amount_collection}}</td>

                    <th scope="row">مبلغ العموله</th>
                    <td>{{$invoice->amount_commission}}</td>

                    <th scope="row">الخصم</th>
                    <td>{{$invoice->discount}}</td>


                </tr>
                <tr>
                    <th scope="row">نسبة الضريبة</th>
                    <td>{{$invoice->rate_vat}}</td>
                    <th scope="row">قيمة الضريبة</th>
                    <td>{{$invoice->value_vat}}</td>

                    <th scope="row">الاجمالي مع الضريبة</th>
                    <td>{{$invoice->total}}</td>

                    <th scope="row">الحاله الحالية</th>
                    <td>@if($invoice->value_status==2)
                            <span class="badge badge-pill badge-danger">{{$invoice->status}}</span>
                        @elseif($invoice->value_status==3)
                            <span class="badge badge-pill badge-success">{{$invoice->status}}</span>

                        @elseif($invoice->value_status==1)
                            <span class="badge badge-pill badge-warning">{{$invoice->status}}</span>

                        @endif



                    </td>
                </tr>
                <tr>

                    <th scope="row">الملاحاظات</th>
                    <td>{{$invoice->note}}</td>
                </tr>
                </tbody>
            </table>

        </div>
            </div>
        </div>

    </div>
    <form method="post" action="{{route('status_update')}}">
        @csrf
    <div class="row">

        <input type="hidden" value="{{$invoice->id}}" name="invoice_id">
        <div class="col">
            <label>حالة الدفع</label>
            <select name="status" id="status" class="form-control" required>
                <option selected  disabled>-- حدد حالة الدفع </option>
                <option value="3">مدفوعة</option>
                <option value="1">مدفوعة جزئيا</option>
            </select>
        </div>

    <div class="col">
        <label>تاريخ الدفع</label>
        <input type="text" class="form-control fc-datepicker" name="payment_date" placeholder="YYYY-MM-DD" type="text" required value="{{date('Y-m-d')}}">
    </div>


    </div>
        <br>
        <div class="row">
        <div class="col">
            <button type="submit" class="btn btn-primary">تحديث حالة الدفع</button>
        </div>
        </div>

    </form>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>
@endsection
