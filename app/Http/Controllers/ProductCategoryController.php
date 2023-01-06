<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    //    if(request()->ajax()){
        $query = ProductCategory::with('product')->get();
        return DataTables::of($query)
            ->addIndexColumn()
            ->addcolumn('action', function($item){
                return '<a class="btn btn-primary" role="button" href="'.route('dashboard.category.edit',$item->id).'">EDIT</a> 
                <form method="post" action="'. route('dashboard.category.destroy', $item->id) .'"  > 
                '.method_field('delete') . csrf_field() .'
                <button type="submit" class="inline-block border border-gray-700 bg-red-700 text-white rounded-md px-3 py-2 mt-1 transition duration-500 ease select-none hover:bg-gray-800 focus:outline-none focus:shadow-outline">HAPUS</button>
                </form>';
                  
            })
            ->rawColumns(['action'])
            ->make(true);
    //    }

       return view('pages.dashboard.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCategoryRequest $request)
    {
        $data = $request->all();

        ProductCategory::create($data);

        return redirect()->route('dashboard.category.index')->with('success', 'Category has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCategory $category)
    {
        return view('pages.dashboard.category.edit', [
            'item' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCategoryRequest $request, ProductCategory $category)
    {
        $data = $request->all();

        $category->update($data);

        return redirect()->route('dashboard.category.index')->with('success', 'Data Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $category)
    {
        $category->delete();

        return redirect()->route('dashboard.category.index')->with('success', 'Data Deleted');
    }
}
