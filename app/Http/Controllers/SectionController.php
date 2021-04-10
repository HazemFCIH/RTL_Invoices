<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class SectionController extends Controller
{
    function  __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:الاقسام');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $sections = Section::all();
        return view('Sections.sections',compact('sections'));
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
        $input = $request->all();

    $secExist = Section::where('section_name','=', $input['section_name'])->exists();

if($secExist) {

    session()->flash('ERROR','خطأ القسم مسجل مسبقا');
    return redirect('sections');

}else {

    $validated = $request->validate([
        'section_name' => 'required|max:255',
        'description' => 'required',
    ]);

    Section::create([

        'section_name'=>$request->section_name,
        'description'=>$request->description,
        'Created_by' =>(Auth::user()->name),
    ]);
    session()->flash('ADD','تم اضاقة القسم بنجاح');
    return redirect('sections');

}

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $validated = $request->validate([
            'section_name' => 'required|max:255|unique:sections,section_name,'.$id,
            'description' => 'required',
        ],

        [

            'section_name.required' => 'يرجى ادخال  اسم القسم',
            'section_name.unique' => 'اسم القسم مسجل مسبقا',
            'description.required' => 'يرجي ادخال وصف القسم',




        ]);
        $section = Section::find($id);
        $section->update(['section_name'=>$request->section_name,
        'description'=>$request->description,
        ]);
        session()->flash('EDIT','تم تعديل القسم بنجاح');
        return redirect('sections');


  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Section::findOrFail($request->id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect('sections');


  }
}
