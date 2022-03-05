@extends('layouts.app')

@section('content')
{{-- <pre>{{print_r($data)}}</pre> --}}
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="bold h2">
                {{$data['product']->title}}
            </div>
            <div class="pt-2">
                <span class="fw-bold h4">Price</span> :
                <span class="h3 fw-bold" id="price">00.00</span>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{url($data['product']->img_path)}}" class="rounded w-100" alt="...">
                </div>
                <div class="col-md-8">
                    <p>{{$data['product']->description}}</p>
                    <div class="card bg-light">
                        <div class="card-body">
                            @if(session()->has('status'))
                                <div class="alert alert-warning">
                                    {{ session()->get('status') }}
                                </div>
                            @endif
                            <form action="{{route('add-cart')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                        <div>
                                            <input type="text" name="title" value="{{$data['product']->title}}" hidden>
                                            <input type="text" name="img_path" value="{{$data['product']->img_path}}" hidden>
                                            <p>Variant</p>
                                            <select name="variant" id="variant" class="form-control">
                                                @foreach($data['product-variant'] as $variant)
                                                <option value="{{$variant->name}}_&_{{$variant->price}}" data-value="{{$variant->price}}">{{$variant->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div>
                                            <p>Quantity</p>
                                            <input type="number" value="1" name="quantity" id="quantity" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-success btn-block">Add to Cart</button>
                                        </div>
                                    </div>
                                </div>
                                {{-- <pre>{{print_r(session()->get('cart'))}}</pre> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        var product = {};
        update_price();
        $('#variant,#quantity').on('change', function() {
            update_price();
        });
    });
    function update_price(){
        var current_variant = $("#variant").val();
        var quantity = $("#quantity").val();
        var price = $('#variant option:selected').attr('data-value');
        var total = quantity * price;
        if(total > 0){
            $("#price").text(total);
        }
    }
</script>
@endsection