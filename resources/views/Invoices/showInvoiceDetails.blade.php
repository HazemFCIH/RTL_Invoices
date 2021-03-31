@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل الفاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    {{-- Catch Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach

        </div>

    @endif
    {{-- End Catch Validation Errors --}}
    {{-- Successfully ADDED Section --}}

    @if (session()->has('ADD'))


        <div class="alert alert-success " role="alert">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{session()->get('ADD')}}</strong>
        </div>

    @endif
    {{-- End Successfully ADDED Section --}}
    {{-- Succesfuly Deleted Section --}}


    @if (session()->has('delete'))


        <div class="alert alert-danger " role="alert">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{session()->get('delete')}}</strong>
        </div>

    @endif
    {{-- End Succesfuly Deleted Section --}}
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
        <div class="panel panel-primary tabs-style-3">
            <div class="tab-menu-heading">
                <div class="tabs-menu ">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs">
                        <li class=""><a href="#tab11" class="active" data-toggle="tab"><i class="fa fa-laptop"></i> معلومات الفاتورة</a></li>
                        <li><a href="#tab12" data-toggle="tab"><i class="fa fa-cube"></i>حالات الدفع</a></li>
                        <li><a href="#tab13" data-toggle="tab"><i class="fa fa-file"></i> المرفقات</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body tabs-menu-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab11">
                        <div class="table-responsive mt-15">
                            <table class="table table-striped" style="text-align:center">
                                <tbody>
                                <tr>
                                    <th scope="row">رقم الفاتورة</th>
                                    <td>{{$invoice_data->invoice_number}}</td>
                                    <th scope="row">تاريخ الاصدار</th>
                                    <td>{{$invoice_data->invoice_date}}</td>

                                    <th scope="row">تاريخ الاستحقاق</th>
                                    <td>{{$invoice_data->due_date}}</td>

                                    <th scope="row">القسم</th>
                                    <td>{{$invoice_data->section->section_name}}</td>


                                </tr>
                                <tr>
                                    <th scope="row">المنتج</th>
                                    <td>{{$invoice_data->product}}</td>
                                    <th scope="row">مبلغ التحصيل</th>
                                    <td>{{$invoice_data->amount_collection}}</td>

                                    <th scope="row">مبلغ العموله</th>
                                    <td>{{$invoice_data->amount_commission}}</td>

                                    <th scope="row">الخصم</th>
                                    <td>{{$invoice_data->discount}}</td>


                                </tr>
                                <tr>
                                    <th scope="row">نسبة الضريبة</th>
                                    <td>{{$invoice_data->rate_vat}}</td>
                                    <th scope="row">قيمة الضريبة</th>
                                    <td>{{$invoice_data->value_vat}}</td>

                                    <th scope="row">الاجمالي مع الضريبة</th>
                                    <td>{{$invoice_data->total}}</td>

                                    <th scope="row">الحاله الحالية</th>
                                    <td>@if($invoice_data->value_status==2)
                                            <span class="badge badge-pill badge-danger">{{$invoice_data->status}}</span>
                                        @elseif($invoice_data->value_status==3)
                                            <span class="badge badge-pill badge-success">{{$invoice_data->status}}</span>

                                        @elseif($invoice_data->value_status==1)
                                            <span class="badge badge-pill badge-warning">{{$invoice_data->status}}</span>

                                        @endif



                                    </td>
                                </tr>
                                <tr>

                                    <th scope="row">الملاحاظات</th>
                                    <td>{{$invoice_data->note}}</td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="tab-pane" id="tab12">
                        <div class="table-responsive mt-15">
                            <table class="table center-aligend-table mb-0 table-hover" style="text-align:center">
                                <thead>
                                <tr class="text-dark">
                                    <th>#</th>
                                    <th>رقم الفاتورة</th>
                                    <th> نوع المنتج</th>
                                    <th>القسم</th>
                                    <th>حالة الدفع</th>
                                    <th>تاريخ الدفع</th>
                                    <th>ملاحاظات</th>
                                    <th>تاريخ الاضافة</th>
                                    <th>المستخدم</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr>
                                    @foreach($invoice_details as $det)
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$det->invoice_number}}</td>
                                    <td>{{$det->product}}</td>
                                    <td>{{$det->sections->section_name}}</td>
                                        <td>@if($det->value_status==2)
                                                <span class="badge badge-pill badge-danger">{{$det->status}}</span>
                                            @elseif($det->value_status==3)
                                                <span class="badge badge-pill badge-success">{{$det->status}}</span>

                                            @elseif($det->value_status==1)
                                                <span class="badge badge-pill badge-warning">{{$det->status}}</span>

                                            @endif



                                        </td>


                                        <td>@if(!($det->invoices->payment_date))
                                                في انتظار الدفع
                                            @else
                                            {{$det->invoices->payment_date}}
                                            @endif
                                        </td>
                                    <td>{{$det->note}}</td>
                                    <td>{{$det->created_at}}</td>
                                    <td>{{$det->user}}</td>
                                    @endforeach

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab13">
                        <div class="card card-statistics">
                            <div class="card-body">

                                <p class="text-danger"> صيغة المرفق * pdf,jpeg, jpj , png</p>
                                <h5 class="card-title"> اضافة مرفاقات</h5>
                                <form method="post" action="{{route('attachment')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">

                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="file_name" name="file_name" >
                                        <input type="hidden" id="invoice_number" name="invoice_number" value="{{$invoice_data->invoice_number}}">
                                        <input type="hidden" id="invoice_id" name="invoice_id" value="{{$invoice_data->id}}">
                                        <label for="file_name" class="custom-file-label"> حدد المرفق</label>
                                    </div>
                                    </div>
                                    <div class="form-group">
                                    <button class="btn btn-primary btn-sm" type="submit" name="uploadedFile">

                                        تأكيد
                                    </button>
                                    </div>

                                </form>

                            </div>

                        </div>
                        <div class="table-responsive mt-15">
                            <table class="table center-aligend-table mb-0 table-hover" style="text-align:center">
                                <thead>
                                <tr class="text-dark">
                                    <th scope="col">#</th>
                                    <th scope="col">اسم الملف</th>
                                    <th scope="col">قام بالاضافه</th>
                                    <th scope="col">تاريخ الاضافة</th>
                                    <th scope="col">العمليات</th>


                                </tr>
                                </thead>
                                <tbody>

                                @foreach($invoice_attachmnets as $attach)
                                    <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$attach->file_name}}</td>
                                        <td>{{$attach->Created_by}}</td>
                                        <td>{{$attach->created_at}}</td>
                                    <td>
                                        <a class="btn btn-outline-success btn-sm"
                                        href="{{url('view_file')}}/{{$invoice_data->invoice_number}}/{{$attach->file_name}}"
                                        role="button"><i class="fas fa-eye"></i>&nbsp;
                                            عرض</a>
                                        <a class="btn btn-outline-info btn-sm"
                                           href="{{url('download')}}/{{$invoice_data->invoice_number}}/{{$attach->file_name}}"
                                           role="button"><i class="fas fa-download"></i>&nbsp;
                                            تحميل</a>
                                        <button class="modal-effect btn btn-outline-danger btn-sm" data-effect="effect-rotate-bottom" data-toggle="modal"
                                                data-file_name = "{{$attach->file_name}}"
                                                data-invoice_number = "{{$invoice_data->invoice_number}}"
                                                data-file_id="{{$attach->id}}"
                                                href="#delete_file">
                                            حذف
                                        </button>










                                    </td>



                                    </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    {{-- Delete Modal --}}
    <div class="modal" id="delete_file">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">حذف المرفق</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{route('delete_file')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <p> هل انت متأكد من عمليه الحذف؟</p>
                        <br>
                        <input type="hidden" name="file_name" id="file_name"  value="">
                        <input type="hidden" name="invoice_number" id="invoice_number" >
                        <input type="hidden" name="file_id" id="file_id" >
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>

                        <button class="btn ripple btn-danger" type="submit">تأكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Delete Modal --}}
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <script>

        $('#delete_file').on('show.bs.modal', function(event){

            var button = $(event.relatedTarget)
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var file_id = button.data('file_id')

            var modal = $(this)
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
            modal.find('.modal-body #file_id').val(file_id);


        })

    </script>
@endsection
