<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\ProductVariation;
use Session;
class ProductController extends Controller
{
    //
    public function __construct(){
        //Session::put('cart', []);
        //session()->put('cart',[]);
    }
    public function index(){
        if (auth()->user()) 
        {
            return redirect()->to('/admin/products');
        }
        //
        $products = $this->GetProducts();
        //
        return view('products',['products'=> $products]);
    }
    //
    public function GetProductDetails($id){
        $data = [];
        $data['product'] = Products::where('id', $id)->get()->first();
        $data['product-variant'] = ProductVariation::where('product_id', $id)->get();
        return view('product-details', ['data' => $data]);
    }
    //
    public function GetCartView(){
        return view('cart');
    }
    //
    private function GetProducts(){
        return Products::orderBy('created_at', 'DESC')->get();
    }
    //
    public function GetProductsForAdmin(){
        $data = $this->GetProducts();
        return view('admin.products', ["products"=>$data]);
    }
    public function AddCart(Request $request){
        $vArr = explode("_&_", $request->variant);
        
        // session()->forget('cart');
        // session()->flush();
        $productsArr = session()->get('cart');
        
        $productsArr[$request->variant]['name'] = $request->title;
        $productsArr[$request->variant]['img_path'] = $request->img_path;
        $productsArr[$request->variant]['variant'] = $vArr[0];
        $productsArr[$request->variant]['price'] = $vArr[1];
        $productsArr[$request->variant]['quantity'] = $request->quantity;
        session()->put('cart',$productsArr);
        return redirect()->back()->with('status', 'Product added to cart');
    }
    public function RemoveCart(Request $request){
        $productsArr = session()->get('cart');
        if(isset($productsArr[$request->name])){
            unset($productsArr[$request->name]);
            session()->put('cart',$productsArr);
        }

        return redirect()->back()->with('status', 'Product added to cart');

    }
}
