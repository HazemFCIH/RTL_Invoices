@extends('layouts.master')
@section('title')
    ارشيف الفواتير
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>

@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/قائمة الفواتير</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
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

        <script>

            window.onload = function () {
                notif({
                    msg: 'تم حذف الفاتورة بنجاح',
                    type: 'success'
                })
            }

        </script>

    @endif
    {{-- End Succesfuly Deleted Section --}}
    {{-- Succesfuly status_updated Section --}}


    @if (session()->has('update_status'))

        <script>

            window.onload = function () {
                notif({
                    msg: 'تم تغير حالة الفاتورة بنجاح',
                    type: 'success'
                })
            }

        </script>

    @endif
    {{-- End Succesfuly status_updated Section --}}
    {{-- Succesfuly archived file Section --}}


    @if (session()->has('invoice-archived'))

        <script>

            window.onload = function () {
                notif({
                    msg: 'تم ارشقة الفاتورة بنجاح',
                    type: 'success'
                })
            }

        </script>

    @endif
    {{-- End Succesfuly archived file Section --}}


    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <a class="modal-effect btn btn-success " href="{{route('export_invoices')}}">
                        <i class="las la-file-export"></i>
                        تصيدر الفواتير
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length="50">
                            <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">رقم الفاتورة</th>
                                <th class="border-bottom-0">تاريخ الفاتورة</th>
                                <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                <th class="border-bottom-0">المنتج</th>
                                <th class="border-bottom-0">القسم</th>
                                <th class="border-bottom-0">الخصم</th>
                                <th class="border-bottom-0">نسبة الضريبة</th>
                                <th class="border-bottom-0">قيمة الضربية</th>
                                <th class="border-bottom-0">الاجمالي</th>
                                <th class="border-bottom-0">الحالة</th>
                                <th class="border-bottom-0">ملاحضات</th>
                                <th class="border-bottom-0">العمليات</th>






                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$invoice->invoice_number}}</td>
                                    <td>{{$invoice->invoice_date}}</td>
                                    <td>{{$invoice->due_date}}</td>
                                    <td>{{$invoice->product}}</td>
                                    <td>{{$invoice->section->section_name}}</td>
                                    <td>{{$invoice->discount}}</td>
                                    <td>{{$invoice->rate_vat}}</td>
                                    <td>{{$invoice->value_vat}}</td>
                                    <td>{{$invoice->total}}</td>

                                    <td>
                                        @if($invoice->value_status == 1)
                                            <span class="text-warning">{{$invoice->status}}</span>

                                        @elseif($invoice->value_status == 2)
                                            <span class="text-danger">{{$invoice->status}}</span>
                                        @elseif($invoice->value_status == 3)
                                            <span class="text-success">{{$invoice->status}}</span>
                                        @endif

                                    </td>
                                    <td>{{$invoice->note}}</td>
                                    <td>


                                        <div class="dropdown">
                                            <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary btn-sm"
                                                    data-toggle="dropdown" id="dropdownMenuButton" type="button">العمليات<i class="fas fa-caret-down ml-1"></i></button>
                                            <div  class="dropdown-menu tx-13">
                                                <a class="dropdown-item" href="{{route('invoices.show',$invoice->id)}}">عرض الفاتورة</a>
                                                <a class="dropdown-item"href="{{route('invoices.edit',$invoice->id)}}">تعديل الفاتورة</a>
                                                <a class="dropdown-item"href="{{route('change_invoice_status',$invoice->id)}}">تغير حالة الدفع</a>

                                                <a class="dropdown-item"href="#delete_invoice"
                                                   data-toggle="modal"
                                                   data-invoice_id = "{{$invoice->id}}"

                                                >
                                                    <i class="text-danger fas fa-trash-alt"></i>
                                                    &nbsp;&nbsp;
                                                    حذف الفاتورة</a>

                                                <a class="dropdown-item"href="#restore_invoice"
                                                   data-toggle="modal"
                                                   data-invoice_id = "{{$invoice->id}}"

                                                >
                                                    <i class="text-warning fas fa-exchange-alt"></i>
                                                    &nbsp;&nbsp;
                                                    استرجاع الفاتورة</a>

                                            </div>
                                        </div>

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
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
    {{-- Delete Modal --}}
    <div class="modal" id="delete_invoice">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">حذف الفاتورة</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{route('delete_archived')}}" method="POST">
]                    @csrf
                    <div class="modal-body">
                        <p> هل انت متأكد من عمليه الحذف؟</p>
                        <br>
                        <input type="hidden" name="invoice_id" id="invoice_id"  value="">
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
    {{-- Archive Modal --}}
    <div class="modal" id="restore_invoice">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">استرجاع الفاتورة</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{route('restore_invoices')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p> هل انت متأكد من عمليه الاسترجاع؟</p>
                        <br>
                        <input type="hidden" name="invoice_id" id="invoice_id"  value="">
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>

                        <button class="btn ripple btn-success" type="submit">تأكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End archive Modal --}}
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
    <script>
        $('#delete_invoice').on('show.bs.modal', function(event){

            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>
    <script>
        $('#restore_invoice').on('show.bs.modal', function(event){

            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>
@endsection
