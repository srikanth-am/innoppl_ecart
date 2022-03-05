@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="text-center">
                    <th>#</th>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Variant</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </thead>
                <tbody class="text-center">
                    @if(session()->has('cart') && count(session()->get('cart')))
                    @foreach(session()->get('cart') as $key=>$cart)
                        <tr>
                            <td>{{ $loop->index + 1}}</td> 
                            <td><img src="{{$cart['img_path']}}" height="50px" width="50px"></td> 
                            <td>{{$cart['name']}}</td> 
                            <td>{{$cart['variant']}}</td> 
                            <td id="price_{{$loop->index}}">{{$cart['price']}}</td> 
                            <td><input type="number" value="{{$cart['quantity']}}" name="quantity" id="quantity_{{$loop->index}}" onchange="updatePrice({{$loop->index}})" class="form-control"></td> 
                            <td id="total_price_{{$loop->index}}">{{$cart['price'] * $cart['quantity']}}</td> 
                            <td>
                                <form action="{{route('remove-cart')}}" method="POST">
                                    @csrf
                                    <input type="text" name="name" id="" hidden value="{{$key}}">
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8" class="text-center fw-bold">Your Cart Is Empty!</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        {{-- <pre>{{print_r(session()->get('cart'))}}</pre> --}}
    </div>
</div>
<script>
    function updatePrice(index){
        var price = $("#price_"+index).text();
        var quantity = $("#quantity_"+index).val();
        var updated_price = quantity * price;
        $("#total_price_"+index).text(updated_price);
    }
</script>
@endsection