@extends('consumer.layout')

@section('container')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <section id="checkout">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="checkout-area">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $sub_total = 0;
                                            @endphp
                                            @foreach ($result['cart_detail_ids'] as $cart_detail_id)
                                                <tr>
                                                    <input class="product_detail_id" type="hidden"
                                                        value="{{ $result[$cart_detail_id]['product_detail_id'] }}">
                                                    <input class="cart_detail_id" type="hidden"
                                                        value="{{ $cart_detail_id }}">
                                                    <td style="text-align: left; vertical-align: middle;">
                                                        <div style="float: left;">
                                                            <img style="object-fit: cover; width: 100px; height: 120px;"
                                                                src="{{ asset('/storage/product_image/' . $result[$cart_detail_id]['image']) }}"
                                                                alt="img"></a>
                                                        </div>
                                                        <div style="padding-left: 110px;">
                                                            <a class="aa-cart-title" href="#">
                                                                {{ $result[$cart_detail_id]['name'] }}<br>
                                                            </a>
                                                            <div>
                                                                @if ($result[$cart_detail_id]['product_option_name_1'] != '')
                                                                    {{ $result[$cart_detail_id]['product_option_value_1'] }}
                                                                @endif
                                                                @if ($result[$cart_detail_id]['product_option_name_2'] != '')
                                                                    {{ ' - ' . $result[$cart_detail_id]['product_option_value_2'] }}
                                                                @endif
                                                                @if ($result[$cart_detail_id]['product_option_name_3'] != '')
                                                                    {{ ' - ' . $result[$cart_detail_id]['product_option_value_3'] }}<br>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <br>
                                                    </td>
                                                    <td class="price_item">{{ $result[$cart_detail_id]['price'] }}
                                                    </td>
                                                    <td><input class="quantity_item" style="width: 75px;" type="number"
                                                            min="1" max="{{ $result[$cart_detail_id]['stock_quantity'] }}"
                                                            value="{{ $result[$cart_detail_id]['quantity'] }}"></td>
                                                    <td class="total_price_item">
                                                        {{ $result[$cart_detail_id]['price'] * $result[$cart_detail_id]['quantity'] }}
                                                    </td>
                                                </tr>
                                                @php
                                                    $sub_total += $result[$cart_detail_id]['price'] * $result[$cart_detail_id]['quantity'];
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="checkout-right">
                                    <h4>Shipping Address</h4>
                                    <div class="aa-payment-method">
                                        @if (!empty($result['customer_address_ids']))
                                            @foreach ($result['customer_address_ids'] as $customer_address_id)
                                                <label>
                                                    <input type="radio" name="delivery_address"
                                                        value="{{ $result[$customer_address_id]['address'] }}">
                                                    {{ $result[$customer_address_id]['address'] }}
                                                </label>
                                            @endforeach
                                        @endif
                                        <a href="{{ route('profile.add_address') }}"
                                            class="aa-browse-btn checkout-add-address">Add other address</a>
                                    </div><br>
                                    <h4>Payment Method</h4>
                                    <div class="aa-payment-method">
                                        <label>
                                            <input type="radio" value="COD" name="payment_method" checked> Cash on Delivery
                                        </label>
                                    </div><br>
                                    <h4>Order Summary</h4>
                                    <div class="aa-payment-method">
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <b><i>Subtotal:</i></b>
                                            </div>
                                            <div class="col-sm-3">{{ '$' . $sub_total }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <b><i>Shipping Cost:</i></b>
                                            </div>
                                            <div class="col-sm-3">$1</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <b><i>Total Cost:</i></b>
                                            </div>
                                            <div id="total_cost" class="col-sm-3">{{ '$' . ($sub_total + 1.0) }}
                                            </div>
                                        </div>
                                        <a id="place_order" href="#" class="aa-browse-btn place_order_btn">Place Order</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('consumer_assets/js/order.js') }}"></script>
@endsection
