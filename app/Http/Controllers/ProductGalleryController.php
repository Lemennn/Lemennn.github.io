<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductGalleryRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use Yajra\DataTables\Facades\DataTables;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        if(Request()->ajax()){
            $query = ProductGallery::where('products_id', $product->id)->get();
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function($item){
                    return '
                    <form  method="POST" action="'. route('dashboard.gallery.destroy', $item->id) .'"  > 
                    <button type="submit" class="inline-block border border-gray-700 bg-red-700 text-white rounded-md px-3 py-2 mt-1 transition duration-500 ease select-none hover:bg-gray-800 focus:outline-none focus:shadow-outline">HAPUS</button>
                    '.method_field('delete') . csrf_field() .'
                    </form>
                    ';
                })
                ->editColumn('url', function ($item) {
                    return '<img style="max-width: 150px;" src="'. asset('storage/' . $item->url) .'"/>';
                })
                ->rawColumns(['action', 'url'])
                ->make(true);
        }        
        return view('pages.dashboard.galeri.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        return view('pages.dashboard.galeri.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductGalleryRequest $request, Product $product)
    {
        $url = $request->file('files');
    
        if($request->hasFile('files')){
            foreach($url as $files){

                $path = $files->store('gallery');

                ProductGallery::create([
                    'products_id' => $product->id,
                    'url' => $path
                ]);
                
            }
        }   

        return redirect()->route('dashboard.product.gallery.index', $product->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductGallery  $productGallery
     * @return \Illuminate\Http\Response
     */
    public function show(ProductGallery $productGallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductGallery  $productGallery
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductGallery $productGallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductGallery  $productGallery
     * @return \Illuminate\Http\Response
     */
    public function update(ProductGalleryRequest $request, ProductGallery $productGallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductGallery  $productGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ProductGallery::where('id', $id)->first();
        $productID = $data->products_id;
        $data->delete();

        return redirect()->route('dashboard.product.gallery.index', $productID);
        // return redirect()->route('dashboard.product.gallery.index', $productGallery->products_id);
    }
}
