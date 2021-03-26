@extends('layouts.master')
@section('title')
    الاقسام
@endsection
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!---Internal Owl Carousel css-->
<link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet">
<!---Internal  Multislider css-->
<link href="{{URL::asset('assets/plugins/multislider/multislider.css')}}" rel="stylesheet">
<!--- Select2 css -->
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الاقسام</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
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
@if (session()->has('ERROR'))


<div class="alert alert-danger" role="alert">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
	   <span aria-hidden="true">&times;</span>
  </button>
    <strong>{{session()->get('ERROR')}}</strong> 
</div>
    
@endif
@if (session()->has('ADD'))


<div class="alert alert-success " role="alert">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
	   <span aria-hidden="true">&times;</span>
  </button>
    <strong>{{session()->get('ADD')}}</strong> 
</div>
    
@endif
@if (session()->has('EDIT'))


<div class="alert alert-success " role="alert">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
	   <span aria-hidden="true">&times;</span>
  </button>
    <strong>{{session()->get('EDIT')}}</strong> 
</div>
    
@endif
@if (session()->has('delete'))


<div class="alert alert-success " role="alert">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
	   <span aria-hidden="true">&times;</span>
  </button>
    <strong>{{session()->get('delete')}}</strong> 
</div>
    
@endif
				<!-- row -->
				<div class="row">
                    <div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-header pb-0">
                                <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
                                    <a class="modal-effect btn btn-success " data-effect="effect-rotate-bottom" data-toggle="modal" href="#modaldemo8">اضافة قسم</a>
                                </div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="example1" class="table key-buttons text-md-nowrap">
										<thead>
											<tr>
                                                <th class="border-bottom-0">#</th>
												<th class="border-bottom-0">اسم القسم</th>
												<th class="border-bottom-0">الوصف</th>
												<th class="border-bottom-0">العمليات</th>
											</tr>
										</thead>
										<tbody>
                                            @php
                                                $i=0
                                            @endphp
                                            @foreach ($sections as $section)
                                                
											<tr>
												<td>{{++$i}}</td>
												<td>{{$section->section_name}}</td>
												<td>{{$section->description}}</td>
												<td>
                                                    <a class="modal-effect btn btn-info " data-effect="effect-rotate-bottom" data-toggle="modal" data-id="{{$section->id}}" data-section_name="{{$section->section_name}}" data-note="{{$section->description}}"  href="#exampleModal2" title="تعديل">
                                                        <i class="las la-pen"></i>
                                                    </a>
                                                    <a class="modal-effect btn btn-danger " data-effect="effect-rotate-bottom" data-toggle="modal" data-sec_id="{{$section->id}}" data-sec_name="{{$section->section_name}}"   href="#exampleModal3" title="حذف">
                                                        <i class="las la-trash"></i>
                                                    </a>

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
                <div class="row">
                      {{-- Create Modal --}}
                    <div class="modal" id="modaldemo8">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">اضافة قسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="{{route('sections.store')}}" method="POST">
                                    @csrf
                                <div class="modal-body">
                            <div class="form-group">
                              <label for="form-label">اسم القسم</label>
                              <input type="text" name="section_name"  class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="form-label">الوصف</label>
                                <textarea name="description" id="description" class="form-control" placeholder="" rows="3" required></textarea>
                              </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn ripple btn-primary" type="submit">حفظ</button>
                                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                                          {{-- Edit Modal --}}
                                          <div class="modal" id="exampleModal2">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content modal-content-demo">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">تعديل قسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <form action="{{route('sections.update','update')}}" method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                    
                                                    <div class="modal-body">
                                                <div class="form-group">
                                                  <label for="form-label">اسم القسم</label>
                                                  <input type="hidden" name="id" id="id">
                                                  <input type="text" name="section_name" id="section_name" class="form-control" placeholder="" required>
                                                  
                                                </div>
                                                <div class="form-group">
                                                    <label for="form-label">الوصف</label>
                                                    <textarea name="description" id="note" class="form-control" placeholder="" rows="3" required></textarea>
                                                  </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn ripple btn-primary" type="submit">حفظ</button>
                                                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
                                                    </div>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Delete Modal --}}
                                        <div class="modal" id="exampleModal3">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content modal-content-demo">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">حذف قسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <form action="{{route('sections.destroy','delete')}}" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <div class="modal-body">
                                                            <p> هل انت متأكد من عمليه الحذف</p>
                                                           <br> 
                                                           <input type="hidden" name="id" id="sec_id"  value="">
                                                           <input type="text" name="section_name" id="sec_name" class="form-control" readonly>
                                                        </div>
                                                    <div class="modal-footer">
                                                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>

                                                        <button class="btn ripple btn-danger" type="submit">تأكيد</button>
                                                    </div>
                                                </form>
                                                </div>
                                            </div>
                                        </div>

                </div>
                
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
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

<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
<script>

$('#exampleModal2').on('show.bs.modal', function(event){

var button = $(event.relatedTarget)
var id = button.data('id')
var section_name = button.data('section_name')
var note = button.data('note')
var modal = $(this)
modal.find('.modal-body #id').val(id);
modal.find('.modal-body #section_name').val(section_name);
modal.find('.modal-body #note').val(note);




    }),

$('#exampleModal3').on('show.bs.modal', function(event){

var button = $(event.relatedTarget)
var sec_id = button.data('sec_id')
var sec_name = button.data('sec_name')
var modal = $(this)
modal.find('.modal-body #sec_id').val(sec_id);
modal.find('.modal-body #sec_name').val(sec_name);

    })
</script>
@endsection