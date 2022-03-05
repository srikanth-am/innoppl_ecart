@extends('layouts.admin')
@section('content')
@if(session('status'))
<div class="alert alert-success mb-1 mt-1">
{{ session('status') }}
</div>
@endif
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin-edit-product', Request::route('id')) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" id="title" value="{{$product['product']->title}}">
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="title">{{$product['product']->description}}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="img" class="form-label">Image</label>
                        <div id="image">
                            <img src="{{url($product['product']->img_path)}}">
                            <button type="button" class="btn btn-danger btn-sm" title="Remove and add new image" id="remove_image"><i class="fa fa-times" aria-hidden="true"></i></button>
                        </div>
                        <input type="file" name="image" class="form-control" id="img" hidden>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="" class="form-label">Variant & Price</label>
                            <button type="button" class="btn btn-primary text-end btn-sm mb-2" id="add_more_btn"><i class="fa fa-plus" aria-hidden="true"></i> Add More</button>
                        </div>
                        @if(count($product['product_variants']))
                        @foreach($product['product_variants'] as $key => $variant)
                        @if($key == 0)
                        <div class="row mb-2">
                            <div class="col-6">
                                <input type="text" class="form-control mb-2" name="variant_{{$key+1}}" placeholder="Variant" value="{{$variant->name}}">
                                <input type="text" class="form-control mb-2" name="variant_id_{{$key+1}}" hidden value="{{$variant->id}}">
                            </div>
                            <div class="col-6">
                                <input type="number" class="form-control mb-2" name="price_{{$key+1}}" placeholder="Price" value="{{$variant->price}}">
                            </div>
                        </div>
                        @else
                        <div class="row mb-2" id="remove_variant_{{$key}}">
                            <div class="col-6">
                                <input type="text" class="form-control mb-2" name="variant_{{$key+1}}"  name="variant_{{$key+1}}" placeholder="Variant" value="{{$variant->name}}">
                                <input type="text" class="form-control mb-2" name="variant_id_{{$key+1}}" hidden value="{{$variant->id}}">
                            </div>
                            <div class="col-6">
                                <input type="number" class="form-control mb-2" name="price_{{$key+1}}" placeholder="Price" value="{{$variant->price}}">
                            </div>
                        </div>
                        @endif
                        @endforeach
                        @endif
                        <div id="add_more_variants"></div>
                    </div>
                    <div class="text-end">
                        <a class="btn btn-danger mx-2" href="{{route('admin-products')}}" role="button" type="button">Back</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- <pre>{{$product['product_variants']}}</pre> --}}
<style>
    body{
        overflow: hidden;
        overflow-y: auto;
    }
    .delete_btn{
        height: 37px;
        width: 37px;
    }
</style>
<script>
    $(document).ready(function(){
        var variants = "{{count($product['product_variants'])}}";
        $("#add_more_btn").click(()=>{
            if(variants < 3){
                variants++;
                    var html = "";
                    html += '<div class="mb-2" id="remove_variant_'+variants+'">';
                    html += '<div class="row">';
                    html += '<div class="col-6">';
                    html += '<input type="text" placeholder="Variant" class="form-control" name="variant_'+ variants+ '">';
                    html += '</div>';
                    html += '<div class="col-5">';
                    html += '<input type="number" placeholder="Price" class="form-control" name="price_'+ variants+ '">';
                    html += '</div>';
                    html += '<div class="col-1">';
                    html += '<button class="btn btn-danger delete_btn" type="button"  onclick="remove_variant('+variants+')"><i class="fa fa-times"></i></button>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';

                    // html += '<div class="input-group mb-2" id="remove_variant_'+variants+'">';
                    // html += '<input type="text" class="form-control" name="varient_'+ variants+ '">';
                    // html += '';
                    // html += '</div>';
                
                $("#add_more_variants").append(html);

            }else{
                alert("Maximum variant add limit has been reached");
            }
            
        });
    });
    function remove_variant(index){
        $('#remove_variant_'+index).remove();
    }
    $('#remove_image').click (()=>{
        $('#image').remove();
        $("#img").removeAttr('hidden');

    });
    
</script>
@endsection