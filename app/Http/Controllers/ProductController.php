<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $query = Product::with('category')->get();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action' , function($item){
                    return '<a class="btn btn-primary" role="button" href="'.route('dashboard.product.edit',$item->id).'">EDIT</a>
                    <a class = "btn btn-primary" href="'.route('dashboard.product.gallery.index', $item->id).'">Picture</a>
                    <form method="post" action="'.route('dashboard.product.destroy', $item->id).'">
                    '.method_field('delete') . csrf_field() .'
                    <button type="submit" class="inline-block border border-gray-700 bg-red-700 text-white rounded-md px-3 py-2 mt-1 transition duration-500 ease select-none hover:bg-gray-800 focus:outline-none focus:shadow-outline">HAPUS</button>
                    </form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.dashboard.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = ProductCategory::all();
        return view('pages.dashboard.product.create', ['category' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request -> all();
        
        Product::create($data);

        return redirect()->route('dashboard.product.index');
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

        $data = ProductCategory::with('product')->get();
        return view('pages.dashboard.product.edit', [
            'item' => $product,
            'category' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->all();

        $product->update($data);

        return redirect()->route('dashboard.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        
        return redirect()->route('dashboard.product.index');
    }
}
