@extends('front.layout')
@section('page_title', 'Cart')
@section('container')

    <!-- Cart view section -->
    <section id="cart-view">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="cart-view-area">
                        @if (isset($cart[0]))
                            <div class="cart-view-table">
                                <form action="">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Image</th>
                                                    <th>Product</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cart as $data)
                                                    <tr id="cart_box{{ $data->attr_id }}">
                                                        <td><a class="remove" href="javascript:void(0)"
                                                                onclick="deleteCartProduct('{{ $data->pid }}','{{ $data->size }}','{{ $data->color }}','{{ $data->attr_id }}')">
                                                                <fa class="fa fa-close"></fa>
                                                            </a></td>
                                                        <td><a href="{{ url('product/' . $data->slug) }}"><img
                                                                    src="{{ asset('storage/upload/Product_Image/' . $data->image) }}"
                                                                    alt="img"></a></td>
                                                        <td><a class="aa-cart-title"
                                                                href="{{ url('product/' . $data->slug) }}">{{ $data->name }}</a><br>
                                                            @if ($data->size != '')
                                                                Size : {{ $data->size }}<br>
                                                            @endif
                                                            @if ($data->color != '')
                                                                Color : {{ $data->color }}
                                                            @endif
                                                        </td>
                                                        <td>Rs. {{ $data->price }}</td>
                                                        <td><input id="qty{{ $data->attr_id }}" class="aa-cart-quantity"
                                                                type="number"
                                                                onchange="updateQty('{{ $data->pid }}','{{ $data->size }}','{{ $data->color }}','{{ $data->attr_id }}')"
                                                                value={{ $data->qty }}></td>
                                                        @php
                                                            $price = $data->price;
                                                            $qty = $data->qty;
                                                            $total = $price * $qty;
                                                        @endphp
                                                        <td>Rs. {{ $total }}</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="6" class="aa-cart-view-bottom">
                                                        {{-- <div class="aa-cart-coupon">
                                                            <input class="aa-coupon-code" type="text"
                                                                placeholder="Coupon">
                                                            <input class="aa-cart-view-btn" type="submit"
                                                                value="Apply Coupon">
                                                        </div> --}}
                                                        @php
                                                            $totalPrice = 0;
                                                        @endphp
                                                        @foreach ($cart as $data)
                                                            @php $totalPrice = $totalPrice + ($data->qty * $data->price); @endphp
                                                        @endforeach
                                                        <div class="cart-view-total">
                                                            <h4>Cart Totals</h4>
                                                            <table class="aa-totals-table">
                                                                <tbody>
                                                                    <tr>
                                                                        <th>Total Price</th>
                                                                        <td>{{ $totalPrice }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <input class="aa-cart-view-btn" type="button" value="Checkout">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                                <!-- Cart Total view -->
                            </div>
                        @else
                            <h3>No Data Found</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- / Cart view section -->

    <!-- Subscribe section -->
    <section id="aa-subscribe">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="aa-subscribe-area">
                        <h3>Subscribe our newsletter </h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex, velit!</p>
                        <form action="" class="aa-subscribe-form">
                            <input type="email" name="" id="" placeholder="Enter your Email">
                            <input type="submit" value="Subscribe">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- / Subscribe section -->

    <input type="hidden" id="qty" value="1" />
    <form id="frmAddToCart">
        @csrf
        <input type="hidden" id="size_id" name="size_id">
        <input type="hidden" id="color_id" name="color_id">
        <input type="hidden" id="pqty" name="pqty">
        <input type="hidden" id="product_id" name="product_id">
    </form>

@endsection
