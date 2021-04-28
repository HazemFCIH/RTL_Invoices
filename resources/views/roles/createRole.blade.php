
@extends('layouts.master')
@section('title')
    اضافة صلاحية

@endsection
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />
@endsection




@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة
                صلاحيات المستخدم</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    {{-- Catch Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-info">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach

        </div>

    @endif
    {{-- End Catch Validation Errors --}}
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('roles.index') }}">رجوع</a>
                        </div>
                    </div><br>
                    <form class="parsley-style-1" id="selectForm2" autocomplete="off" method="post" action="{{route('roles.store')}}">
                        @csrf

                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>اسم الصلاحية: <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20"
                                       data-parsley-class-handler="#lnWrapper" name="name" required="" type="text">
                            </div>


                        </div>


                        <div class="row mg-b-20">

                            <div class="col-lg-4">

                                <ui id="treeview1">
                                    <li><a href="#">الصلاحيات</a>
                                        <ul>

                                            @foreach($permissions as $value)
                                                <li>
                                                <label
                                                    style="font-size: 16px;">{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                                    {{ $value->name }}</label>
                                                </li>
                                                @endforeach


                                        </ul>
                                    </li>
                                </ui>
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-main-primary pd-x-20" type="submit">تاكيد</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- row closed -->
    </div>
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection

@section('js')

    <!-- Internal Treeview js -->
    <script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
@endsection
