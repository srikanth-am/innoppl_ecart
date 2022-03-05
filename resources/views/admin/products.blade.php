@extends('layouts.admin')

@section('content')
<div class="container">
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="text-end mb-3">
        <a href="{{route('create-product')}}" class="btn btn-success">Add New Product</a>
    </div>
    <div class="card" >
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="bg-primary text-white">
                    <tr class="text-center fw-bold">
                        <th width="40px">S.No</th>
                        <th>Image</th>
                        <th width="150px">Title</th>
                        <th>Description</th>
                        
                        <th width="120px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($products))
                    @foreach($products as $key => $product)

                    <tr>
                        <td class="align-middle">{{$key+1}}</td>
                        <td class="align-middle"><img src="{{url($product->img_path)}}" height=""></td>
                        <td class="align-middle">{{$product->title}}</td>
                        <td class="align-middle">{{$product->description}}</td>
                        <td class="align-middle">
                            {{-- <button class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></button> --}}
                            <form action="{{ route('delete-product', $product->id) }}" method="POST">
                                {{-- <button type="button" class="btn btn-warning btn-sm"><i class="fa fa-info-circle" aria-hidden="true"></i></button> --}}
                                <button type="button" title="Mange Product Variant" class="btn btn-warning btn-sm " data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="get_variant({{$product->id}})">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </button>
                                <a href="{{url('admin/product/edit/'.$product->id)}}" title="Edit" class="btn btn-primary btn-sm"><i class="fas fa-pen-alt"></i></a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" class="text-center bold h4">No Data!</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
   
</div>
{{--  --}}
<div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Product Variants</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="model_close"></button>
        </div>
        <div class="modal-body">
            <div id="variants">
                <table class="table">
                    <thead class="text-center">
                        <th>#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Action</th>
                    </thead>
                    <tbody id="variant_body">

                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });
    function get_variant(id){
        $("#variant_body").html('<tr class="text-center"><td colspan="4">Loading...</td></tr>');
        $.ajax({
            type: "GET",
            url: "/ecart/admin/product-variant/"+id
        }).done(function(data){
            var html = "";
            console.log(data);
            if(data.length > 0){
                var sno = 1;
                for (let i = 0; i < data.length; i++) {
                    // const element = array[i];
                    html += '<tr class="text-center">';
                    html += '<td>'+sno+'</td>';
                    html += '<td>'+data[i]['name']+'</td>';
                    html += '<td>'+data[i]['price']+'</td>';
                    html += '<td><button class="btn btn-danger btn-sm" onclick="deleteVariant('+data[i]['id']+')"><i class="fa fa-trash" aria-hidden="true"></i></button></td>';
                    html += '</tr>';
                    sno++;
                }
                $("#variant_body").html(html);
            }
        });
    }
    function deleteVariant(id){
        if(id){
            $.ajax({
                type: "POST",
                url: "/ecart/admin/delete-variant/"+id
            }).done(function(data){
                $("#model_close").click();
            });
        }
    }
</script>
@endsection