<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function GetProducts(){
        $data = Products::orderBy('created_at', 'DESC')->get();
        return view('admin.products', ["products"=>$data]);
    }
    public function GetProductDetails(){

    }
    public function GetCreateProductView(){
        return view('admin.create-product');
    }
    public function GetEditProductView($id){
        $data = [];
        $data['product'] = Products::select('id', 'title', 'description','img_path')->where('id', $id)->get()->first();
        $data['product_variants'] = ProductVariation::select('id', 'product_id', 'name', 'price')->where('product_id', $id)->orderBy('id', 'ASC')->get();
        // dd($data);
        return view('admin.edit-product', ["product"=>$data]);
    }
    public function CreateProduct(Request $request){
        $request->validate(
            [
                'title'             =>      'required|string|max:255',
                'description'       =>      'required',
                'image'             =>      'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'variant_1'         =>      'required|string|max:200',
                'price_1'           =>      'required|numeric',
                'variant_2'         =>      'string|max:200',
                'price_2'           =>      'numeric',
                'variant_3'         =>      'string|max:200',
                'price_3'           =>      'numeric',
                'variant_4'         =>      'string|max:200',
                'price_4'           =>      'numeric',
            ]
        );
        //
        //store the image
        $name = $request->file('image')->getClientOriginalName();
 
        $path = $request->file('image')->move('public/uploads', $name);
        //
        $product = new Products;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->img_path = $path;
        $product->save();
        $product_id = $product->id;
        if($product_id){
            $variants = [
                [
                    "product_id" => $product_id,
                    "id" => $request->variant_id_1,
                    "name" => $request->variant_1,
                    "price" => $request->price_1
                ]   
            ];
            if(isset($request->variant_2)){
                $a = [
                    "product_id" => $product_id,
                    "id" => ($request->variant_id_2) ? $request->variant_id_2:'',
                    "name" => $request->variant_2,
                    "price" => $request->price_2
                ];
                array_push($variants, $a);
            }
            if(isset($request->variant_3)){
                $a = [
                    "product_id" => $product_id,
                    "id" => ($request->variant_id_3) ? $request->variant_id_3:'',
                    "name" => $request->variant_3,
                    "price" => $request->price_3
                ];
                array_push($variants, $a);

            }
            if(isset($request->variant_4)){
                $a = [
                    "product_id" => $product_id,
                    "id" => ($request->variant_id_4) ? $request->variant_id_4 :'',
                    "name" => $request->variant_4,
                    "price" => $request->price_4
                ];
                array_push($variants, $a);
            }
            if(count($variants)){
                foreach($variants as $variant){
                    $product_variant = new ProductVariation;
                    $product_variant->product_id = $variant['product_id'];
                    $product_variant->name = $variant['name'];
                    $product_variant->price = $variant['price'];
                    $product_variant->save();
                }
            }
        }
        //dd($path);
        return redirect('/admin/products')->with('status', 'Product Created Successfully');

    }
    public function EditProduct(Request $request, $id){
        // dd($request->all());
        $request->validate(
            [
                'title'             =>      'required|string|max:255',
                'description'       =>      'required',
                'image'             =>      'image|mimes:jpeg,png,jpg,gif|max:2048',
                'variant_1'         =>      'required|string|max:200',
                'price_1'           =>      'required|numeric',
                'variant_2'         =>      'string|max:200',
                'price_2'           =>      'numeric',
                'variant_3'         =>      'string|max:200',
                'price_3'           =>      'numeric',
                'variant_4'         =>      'string|max:200',
                'price_4'           =>      'numeric',
            ]
        );
        //
        //store the image
        $path = "";
        if($request->hasFile('image')){
            $name = $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->move('public/uploads', $name);
            
        }
        $product = Products::find($id);
        $product->title = $request->title;
        $product->description = $request->description;
        if($path){
            $product->img_path = $path;
        }
        $product->update();
        //
        $product_id = $id;
        if($product_id ){
            $variants = [
                [
                    "product_id" => $product_id,
                    "id" => $request->variant_id_1,
                    "name" => $request->variant_1,
                    "price" => $request->price_1
                ]   
            ];
            if(isset($request->variant_2)){
                $a = [
                    "product_id" => $product_id,
                    "id" => ($request->variant_id_2) ? $request->variant_id_2:'',
                    "name" => $request->variant_2,
                    "price" => $request->price_2
                ];
                array_push($variants, $a);
            }
            if(isset($request->variant_3)){
                $a = [
                    "product_id" => $product_id,
                    "id" => ($request->variant_id_3) ? $request->variant_id_3:'',
                    "name" => $request->variant_3,
                    "price" => $request->price_3
                ];
                array_push($variants, $a);

            }
            if(isset($request->variant_4)){
                $a = [
                    "product_id" => $product_id,
                    "id" => ($request->variant_id_4) ? $request->variant_id_4 :'',
                    "name" => $request->variant_4,
                    "price" => $request->price_4
                ];
                array_push($variants, $a);
            }
            if(count($variants)){
                foreach($variants as $variant){
                    if($variant['id']){
                        DB::table('product_variations')->where('id', $variant['id'])->update($variant);
                    }else{
                        $product_variant = new ProductVariation;
                        $product_variant->product_id = $variant['product_id'];
                        $product_variant->name = $variant['name'];
                        $product_variant->price = $variant['price'];
                        $product_variant->save();
                    }
                }
            }
        }
        return redirect('/admin/products')->with('status', 'Product Updated Successfully');
    }  
    //
    public function DestroyProduct($id)
    {
        ProductVariation::where('product_id', $id)->delete();
        Products::where('id', $id)->delete();
        return redirect()->route('admin-products')
                        ->with('success','Product deleted successfully');
    }
    public function GetVariants($id){
        $data = ProductVariation::where('product_id', $id)->get();
        return response()->json($data, 200);
    }
    public function DestroyProductVariant($id){
        ProductVariation::where('id', $id)->delete();
        return [];//redirect()->route('admin-products')                        ->with('success','Product deleted successfully');
    }
}
