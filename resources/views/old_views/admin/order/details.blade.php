@extends('layouts.master')
@section('content')

<div class="page-content">

    <div class="row">
        <div class="col-12">
            @if (Session::has('order_status'))
            <div
                class="alert alert-{{Session::get('order_status')['success'] === true ? 'success' : 'danger'}} alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5>
                    <i class="icon fas fa-{{Session::get('order_status')['success'] === true ? 'check' : 'ban'}}"></i>
                    {{Session::get('order_status')['success'] === true ? 'Success' : 'Error'}}!
                </h5>
                {{ Session::get('order_status')['response'] }}
            </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Order Details</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <table class="table">
                                <tr>
                                    <td>
                                        <b>Order ID:</b>
                                    </td>
                                    <td>
                                        {{$data['order']->order_id}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Order Date:</b>
                                    </td>
                                    <td>
                                        {{$data['order']->created_at}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Order Status:</b>
                                    </td>
                                    <td>
                                        {{$data['order']->status}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Amount Paid:</b>
                                    </td>
                                    <td>
                                        $ {{$data['order']->shipping_cost}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- Add Status update elements here-->
                            <form action="{{route('orders.update',$data['order']->order_id)}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <h5>Update Order Status:</h5>
                                        <br>
                                        <select class="form-control" name="order_status">
                                            <option value="New" {{ $data['order']->status == "New" ? "selected" : "" }}>
                                                New</option>
                                            <option value="Pending"
                                                {{ $data['order']->status == "Pending" ? "selected" : "" }}>Pending
                                            </option>
                                            <option value="Shipped"
                                                {{ $data['order']->status == "Shipped" ? "selected" : "" }}>Shipped
                                            </option>
                                        </select>
                                        <br>
                                        <button class="btn btn-primary float-right btn-label-upload"
                                            type="submit">Update
                                            Status</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    Product details
                </div>
                <div class="card-body" style="display: block;">
                    <div class="row">
                        @foreach($data["products"] as $key=>$product)
                        <div class="col-md-4 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                </div>
                                <div class="card-body">
                                    <div class="product-card-header">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12">
                                                <img src="{{$product->image}}" alt="product-image" class="img-fluid">
                                            </div>
                                            <div class="col-md-8 col-sm-12">
                                                <div>
                                                    <span><b>{{$product->asin}}</b></span>
                                                    <br />
                                                    <small>{{$product->title}}</small>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <br>
                                    <div class="product-card-body">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <table class="table">
                                                    <tr>
                                                        <td>
                                                            <b>Price:</b>
                                                        </td>
                                                        <td>
                                                            $ {{$product->price}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <b>Qty:</b>
                                                        </td>
                                                        <td>
                                                            {{$product->qty}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <b>Weight:</b>
                                                        </td>
                                                        <td>
                                                            {{$product->a_weight}}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <table class="table">
                                                    <tr>
                                                        <td>
                                                            <b>Length:</b>
                                                        </td>
                                                        <td>
                                                            {{$product->length}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <b>Width:</b>
                                                        </td>
                                                        <td>
                                                            {{$product->width}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <b>Height:</b>
                                                        </td>
                                                        <td>
                                                            {{$product->height}}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    Bin details
                </div>
                <div class="card-body" style="display: block;">
                    <div class="row">
                        @foreach($data["bins"] as $key=>$bin)
                        <div class="col-md-4 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                </div>
                                <div class="card-body">
                                    <div class="product-card-header">
                                        <div class="row">
                                            <div class="col-md-8 col-sm-12">
                                                <img src="{{$bin['bin_image']}}" alt="bin-image" class="img-fluid"
                                                    style="height: 200px">
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div>
                                                    <span><b>{{$bin['bin_data']->name}}</b></span>
                                                    <br />
                                                    <small>{{$bin['bin_data']->name}}</small>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <br>
                                    <div class="product-card-body">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <table class="table">
                                                    <tr>
                                                        <td>
                                                            <b>Carrier:</b>
                                                        </td>
                                                        <td>
                                                            {{$bin['bin_data']->carrier_name}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <b>Price:</b>
                                                        </td>
                                                        <td>
                                                            $ {{$bin['bin_data']->carrier_price}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <b>Weight:</b>
                                                        </td>
                                                        <td>
                                                            {{$bin['bin_data']->gross_weight}}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <table class="table">
                                                    <tr>
                                                        <td>
                                                            <b>Length:</b>
                                                        </td>
                                                        <td>
                                                            {{$bin['bin_data']->d}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <b>Width:</b>
                                                        </td>
                                                        <td>
                                                            {{$bin['bin_data']->w}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <b>Height:</b>
                                                        </td>
                                                        <td>
                                                            {{$bin['bin_data']->h}}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    Label details
                </div>
                <div class="card-body" style="display: block;">

                    <div class="row">
                        @foreach($data["labels"] as $i=>$label)
                        <div class="col-md-4 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                </div>
                                <div class="card-body">
                                    <div class="product-card-header">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12">
                                                <img src="{{$label->image}}" alt="bin-image" class="img-fluid">
                                            </div>
                                            <div class="col-md-8 col-sm-12">
                                                <div>
                                                    <span><b>{{$label->asin}}</b></span>
                                                    <br />
                                                    <small>{{$label->title}}</small>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <br>
                                    <div class="product-card-body">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <span><b>Supplier:</b> {{$label->supplier_other_value}}</span>
                                                <br>
                                                <span><b>Buyer order ID:</b> {{$label->buyer_order_id}}</span>
                                            </div>

                                            <div class="col-md-6 col-sm-12 file-menu-container">
                                                <span><b>Label:</b></span>
                                                @if($label->label_file)
                                                <a href="{{Storage::disk('s3')->url($label->label_file)}}"
                                                    class="label-icon-container">
                                                    <img src="{{asset('assets/img/file-solid.svg')}}" alt="">
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

</div>

<style>
.file-menu-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.label-icon-container img {
    display: block;
    height: 60px;
    width: 60px;
    filter: invert(44%) sepia(56%) saturate(5792%) hue-rotate(333deg) brightness(104%) contrast(92%);
    margin-top: 10px;
}

.btn-label-upload,
.btn-label-upload:hover {
    background-color: #F54655;
    color: white;
    border-color: #F54655;
}

.label-icon-container:hover {
    filter: invert(17%) sepia(95%) saturate(4746%) hue-rotate(350deg) brightness(113%) contrast(103%);
}
</style>

@endsection