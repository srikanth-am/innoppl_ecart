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
                
                <form action="{{ route('create-product') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" id="title" >
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" id="title" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="img" class="form-label">Image <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control" id="img" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="" class="form-label">Variant & Price <span class="text-danger">*</span></label>
                            <button type="button" class="btn btn-primary text-end btn-sm mb-2" id="add_more_btn"><i class="fa fa-plus" aria-hidden="true"></i> Add More</button>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <input type="text" class="form-control mb-2" name="variant_1" placeholder="Variant" required>
                            </div>
                            <div class="col-6">
                                <input type="number" class="form-control mb-2" name="price_1" placeholder="Price" required>
                            </div>
                        </div>
                        <div id="add_more_variants"></div>
                    </div>
                    <div><b>*</b> All Field are required</div>
                    <div class="text-end">
                        <a class="btn btn-danger mx-2" href="{{route('admin-products')}}" role="button" type="button">Back</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

                @if ($errors->any())
                <div class="bg-warning rounded p-4 mt-2">
                    <ol>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ol>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
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
        var variants = 1;
        $("#add_more_btn").click(()=>{
            if(variants < 3){
                variants++;
                    var html = "";
                    html += '<div class="mb-2" id="remove_variant_'+variants+'">';
                    html += '<div class="row">';
                    html += '<div class="col-6">';
                    html += '<input type="text" placeholder="Variant" class="form-control" required name="variant_'+ variants+ '">';
                    html += '</div>';
                    html += '<div class="col-5">';
                    html += '<input type="number" placeholder="Price" class="form-control" required name="price_'+ variants+ '">';
                    html += '</div>';
                    html += '<div class="col-1">';
                    html += '<button class="btn btn-danger delete_btn" type="button"  onclick="remove_variant('+variants+')"><i class="fa fa-times"></i></button>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                $("#add_more_variants").append(html);

            }else{
                alert("Maximum variant add limit has been reached");
            }
            
        });
    });
    function remove_variant(index){
        $('#remove_variant_'+index).remove();
    }
</script>
@endsection