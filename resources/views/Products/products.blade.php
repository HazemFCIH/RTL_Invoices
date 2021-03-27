@extends('layouts.master')
@section('title')
   المنتاجات
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
							<h4 class="content-title mb-0 my-auto"> الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتاجات</span>
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
 {{-- Succesfuly ADDED Section --}}

 @if (session()->has('ADD'))


 <div class="alert alert-success " role="alert">
     <button aria-label="Close" class="close" data-dismiss="alert" type="button">
     <span aria-hidden="true">&times;</span>
 </button>
     <strong>{{session()->get('ADD')}}</strong> 
 </div>
     
 @endif
 {{-- End Succesfuly ADDED Section --}}


     {{--Succesfuly Edited Section --}}

     @if (session()->has('EDIT'))


     <div class="alert alert-success " role="alert">
         <button aria-label="Close" class="close" data-dismiss="alert" type="button">
         <span aria-hidden="true">&times;</span>
     </button>
         <strong>{{session()->get('EDIT')}}</strong> 
     </div>
         
     @endif
     {{-- End Succesfuly Edited Section --}}


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
 {{-- Start Product Component --}}
 <div class="col-xl-12">
    <div class="card mg-b-20">
{{-- Create Modal header --}}
        <div class="card-header pb-0">
            <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
                <a class="modal-effect btn btn-success " data-effect="effect-rotate-bottom" data-toggle="modal" href="#modaldemo8">اضافة منتج</a>
            </div>
        </div>
        {{-- End Create Modal header --}}

        <div class="card-body">
            <div class="table-responsive">
                <table id="example1" class="table key-buttons text-md-nowrap" data-page-length="50">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">اسم المنتج</th>
                            <th class="border-bottom-0">الوصف</th>
                            <th class="border-bottom-0">اسم القسم</th>
                            <th class="border-bottom-0">العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=0
                        @endphp
                        @foreach ($products as $product)
                            
                        <tr>
                            <td>{{++$i}}</td>
                            <td>{{$product->product_name}}</td>
                            <td>{{$product->description}}</td>
                            <td>{{$product->section->section_name}}</td>
                            <td>
                                <a class="modal-effect btn btn-info " data-effect="effect-rotate-bottom" data-toggle="modal"
                                data-product_id="{{$product->id}}"
                                data-product_name="{{$product->product_name}}"
                                data-note="{{$product->description}}"
                                data-section_name="{{$product->section->section_name}}"
                                     href="#EditProduct" title="تعديل">
                                    <i class="las la-pen"></i>
                                </a>
                                <a class="modal-effect btn btn-danger " data-effect="effect-rotate-bottom" data-toggle="modal" 
                                   data-pro_id="{{$product->id}}" 
                                   data-pro_name="{{$product->product_name}}" 
                                   href="#DeleteProduct"
                                   title="حذف">
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
{{-- End Product Component --}}
</div>
				<!-- row closed -->
                				<!-- row opened -->
         <div class="row">
                    {{-- Create Modal --}}
                    <div class="modal" id="modaldemo8">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">اضافة منتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="{{route('products.store')}}" method="POST">
                                    @csrf
                                <div class="modal-body">
                            <div class="form-group">
                            <label for="form-label">اسم المنتج</label>
                            <input type="text" name="product_name"  class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="form-label">الوصف</label>
                                <textarea name="description" id="description" class="form-control" placeholder="" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                 <label for="form-label">القسم</label>
                                <select name="section_id" id="section_id" class="custom-select mr-sm-2" required>
<option value="" selected disabled>--حدد القسم--</option>
@foreach ($sections as $section)
<option value="{{$section->id}}">{{$section->section_name}}</option>
    
@endforeach
                                </select>
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
                    {{--End  Create Modal --}}
                    
                                          {{-- Edit Modal --}}
                                          <div class="modal" id="EditProduct">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content modal-content-demo">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">تعديل المنتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <form action="{{route('products.update','update')}}" method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                    
                                                    <div class="modal-body">
                                                <div class="form-group">
                                                  <label for="form-label">اسم المنتج</label>
                                                  <input type="hidden" name="id" id="product_id">
                                                  <input type="text" name="product_name" id="product_name" class="form-control" placeholder="" required>
                                                  
                                                </div>
                                                <div class="form-group">
                                                    <label for="form-label">القسم</label>
                                                   <select name="section_name" id="section_name" class="custom-select mr-sm-2" required>
                                                    @foreach ($sections as $section)
                                                    <option>{{$section->section_name}}</option>
                                                        
                                                    @endforeach
                                                   </select>
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
                                        {{-- End Edit Modal --}}

                                                        {{-- Delete Modal --}}
                                                        <div class="modal" id="DeleteProduct">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content modal-content-demo">
                                                                    <div class="modal-header">
                                                                        <h6 class="modal-title">حذف قسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <form action="{{route('products.destroy','destroy')}}" method="POST">
                                                                        @method('DELETE')
                                                                        @csrf
                                                                        <div class="modal-body">
                                                                            <p> هل انت متأكد من عمليه الحذف</p>
                                                                        <br> 
                                                                        <input type="hidden" name="id" id="pro_id"  value="">
                                                                        <input type="text" name="product_name" id="pro_name" class="form-control" readonly>
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

            </div>
				<!-- row closed -->

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

$('#EditProduct').on('show.bs.modal', function(event){

var button = $(event.relatedTarget)
var product_id = button.data('product_id')
var product_name = button.data('product_name')
var section_name = button.data('section_name')
var note = button.data('note')
var modal = $(this)
modal.find('.modal-body #product_id').val(product_id);
modal.find('.modal-body #product_name').val(product_name);
modal.find('.modal-body #section_name').val(section_name);

modal.find('.modal-body #note').val(note);





    }),

$('#DeleteProduct').on('show.bs.modal', function(event){

var button = $(event.relatedTarget)
var pro_id = button.data('pro_id')
var pro_name = button.data('pro_name')
var modal = $(this)
modal.find('.modal-body #pro_id').val(pro_id);
modal.find('.modal-body #pro_name').val(pro_name);

    })
</script>
@endsection