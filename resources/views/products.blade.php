@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        @if(count($products))
        @foreach($products as $product)
        <div class="col-4">
            <div class="card mb-3" style="height: 245px;max-height: 245px">
                <div class="text-center">
                    <img src="{{url($product->img_path)}}" class="card-img-top" alt="{{$product->title}}" height="150px" style="width: max-content;">
                </div>
                <div class="card-body text-center">
                  <h5 class="card-title">{{$product->title}}</h5>
                  {{-- <p class="card-text">{{$product->description}}</p> --}}
                  <div class="text-center">
                      <a href="{{route('product-details', $product->id)}}" class="btn btn-primary text-center">View details</a>
                  </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
{{-- <pre>{{print_r($products)}}</pre> --}}
@endsection