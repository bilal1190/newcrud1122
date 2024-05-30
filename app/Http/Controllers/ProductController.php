<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\File;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('created_at','DESC')->get();
        return view('products.list',[
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|min:5',
            'sku'=> 'required|min:3',
            'price'=> 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // dd($request->all());
        // Here we will insert product in db 
        $product = new Product();
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $image->move(public_path('uploads/products'), $imageName);
            $product->image = $imageName;
        }
        $product->save();

        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $ext = $image->getClientOriginalExtension();  // Use getClientOriginalExtension() instead of getClientOriginalName()
        //     $imageName = time() . '.' . $ext;
        //     $image->move(public_path('uploads/products'), $imageName);
    
        //     $product = new Product();  // Or fetch an existing product instance
        //     $product->image = $imageName;
        //     $product->save();
        // }

       return redirect()->route('products.index')->with('success','form submitted successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit',[
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      $product = Product::findOrFail($id);

      $request->validate([
        'name' => 'required|min:5',
        'sku' => 'required|min:3',
        'price' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
       ]);

      // Update product details
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
        // Delete the old image if a new one is uploaded
          
             File::delete(public_path('uploads/products/' . $product->image));

        // Upload the new image
        $image = $request->file('image');
        $ext = $image->getClientOriginalExtension();
        $imageName = time() . '.' . $ext;
        $image->move(public_path('uploads/products'), $imageName);
        $product->image = $imageName;
     }

     $product->save();

    return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    
    {
       $product = Product::findOrFail($id);
       // Log product details for debugging
       Log::info('Deleting product: ' . $product->id);
       // Delete the image file if it exists
       if ($product->image && File::exists(public_path('uploads/products/' . $product->image))) {
         Log::info('Image file exists: ' . public_path('uploads/products/' . $product->image));
         File::delete(public_path('uploads/products/' . $product->image));
         Log::info('Image file deleted.');
        } else {
            Log::info('Image file does not exist.');
        }
        // Delete the product record from the database
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
   }

}
