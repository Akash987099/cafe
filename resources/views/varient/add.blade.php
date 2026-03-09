@extends('layout.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Add Product Variant</h6>
            </div>

            <div class="card-body px-4 pt-4 pb-2">

                <form action="{{route('varient.save')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="product_id" value="{{$product->id}}">

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">SKU</label>
                            <input type="text" name="sku" class="form-control" placeholder="Enter SKU">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Price</label>
                            <input type="number" min="0" step="0.01" value="{{$product->price}}" name="price" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Stock</label>
                            <input type="number" min="0" value="{{$product->stock}}" name="stock" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Variant Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        @foreach($attribute as $attr)

                        <div class="col-md-4">
                            <label class="form-label">{{$attr->name}}</label>

                            <select name="attributes[{{$attr->id}}]" class="form-control">
                                <option value="">Select {{$attr->name}}</option>

                                @foreach($attribute_value->where('attribute_id',$attr->id) as $val)

                                <option value="{{$val->id}}">
                                    {{$val->value}}
                                </option>

                                @endforeach

                            </select>
                        </div>

                        @endforeach

                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Add Variant</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection
