<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function  __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:المنتجات');



    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all();
        $products = Product::all();
            return view('Products.products',compact('products','sections'));
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
            'product_name' => 'required|max:255|unique:products',
            'description' => 'required',
            'section_id' => 'required',
        ],

        [

            'product_name.required' => 'يرجى ادخال  اسم منتج',
            'product_name.unique' => 'اسم المنتج مسجل مسبقا',
            'description.required' => 'يرجي ادخال وصف المنتج',




        ]);

    Product::create([

        'product_name'=>$request->product_name,
        'description'=>$request->description,
        'section_id'=>$request->section_id,
        'Created_by' =>(Auth::user()->name),
    ]);
    session()->flash('ADD','تم اضاقة المنتج بنجاح');
    return redirect('products');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
$section_id = Section::where('section_name',$request->section_name)->first()->id;
$validated = $request->validate([
    'product_name' => 'required|max:255|unique:products,product_name,'.$id,
    'description' => 'required',

],

[

    'product_name.required' => 'يرجى ادخال  اسم منتج',
    'product_name.unique' => 'اسم المنتج مسجل مسبقا',
    'description.required' => 'يرجي ادخال وصف المنتج',




]);
$products = Product::findOrFail($request->id);
$products->update([
'product_name' => $request->product_name,
'section_id'   => $section_id,
'description'  => $request->description,
]);
session()->flash('EDIT','تم تعديل القسم بنجاح');
return redirect('products');



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Product::findOrFail($request->id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect('products');

    }
}
