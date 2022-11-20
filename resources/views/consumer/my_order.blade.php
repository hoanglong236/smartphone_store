@extends('consumer.layout')

@section('container')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <section id="checkout">
        <div class="container">
            @foreach ($result['order_ids'] as $order_id)
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkout-area">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="table-responsive">
                                        <h4>Order Details</h4>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Quantity</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $sub_total = 0;
                                                @endphp
                                                @foreach ($result[$order_id]['order_detail_ids'] as $order_detail_id)
                                                    <tr>
                                                        <td style="text-align: left; vertical-align: middle;">
                                                            <div style="float: left;">
                                                                <img style="object-fit: cover; width: 100px; height: 120px;"
                                                                    src="{{ asset('/storage/product_image/' . $result[$order_id][$order_detail_id]['image']) }}"
                                                                    alt="img"></a>
                                                            </div>
                                                            <div style="padding-left: 110px;">
                                                                <a class="aa-cart-title" href="#">
                                                                    {{ $result[$order_id][$order_detail_id]['name'] }}<br>
                                                                </a>
                                                                <div>
                                                                    @if ($result[$order_id][$order_detail_id]['product_option_name_1'] != '')
                                                                        {{ $result[$order_id][$order_detail_id]['product_option_value_1'] }}
                                                                    @endif
                                                                    @if ($result[$order_id][$order_detail_id]['product_option_name_2'] != '')
                                                                        {{ ' - ' . $result[$order_id][$order_detail_id]['product_option_value_2'] }}
                                                                    @endif
                                                                    @if ($result[$order_id][$order_detail_id]['product_option_name_3'] != '')
                                                                        {{ ' - ' . $result[$order_id][$order_detail_id]['product_option_value_3'] }}<br>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </td>
                                                        <td><input class="quantity_item" style="width: 75px;" type="number"
                                                            value="{{ $result[$order_id][$order_detail_id]['quantity'] }}"></td>
                                                        <td class="total_price_item">
                                                            {{ $result[$order_id][$order_detail_id]['total_price'] }}
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $sub_total += $result[$order_id][$order_detail_id]['total_price'];
                                                    @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="checkout-right">
                                        <h4>Order Info</h4>
                                        <div class="aa-payment-method">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="customer_name" class="control-label mb-1">Name</label>
                                                        <input name="customer_name" type="text" value="{{ $customer_name }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label mb-1">Phone</label>
                                                        <input name="phone" type="text" value="{{ $result[$order_id]['customer_phone'] }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="delivery_address" class="control-label mb-1">Delivery Address</label>
                                                <textarea name="delivery_address" rows="2" class="form-control" readonly>{{ $result[$order_id]['delivery_address'] }}</textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="sub_total" class="control-label mb-1">Sub Total</label>
                                                        <input name="sub_total" type="text" value="{{ '$' . $sub_total }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="shipping_cost" class="control-label mb-1">Shipping Cost</label>
                                                        <input name="shipping_cost" type="text" value="$1" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="total" class="control-label mb-1">Total</label>
                                                        <input name="total" type="text" value="{{ $result[$order_id]['total'] }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="payment_method" class="control-label mb-1">Payment Method</label>
                                                        <input name="payment_method" type="text" value="{{ $result[$order_id]['payment_method'] }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="payment_status" class="control-label mb-1">Payment Status</label>
                                                        <input name="payment_status" type="text" value="{{ $result[$order_id]['payment_status'] }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="total" class="control-label mb-1">Order Status</label>
                                                        <input name="total" type="text" value="{{ $result[$order_id]['status'] }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="created_at" class="control-label mb-1">Created At</label>
                                                        <input name="created_at" type="text" value="{{ \Carbon\Carbon::parse($result[$order_id]['created_at'])->format('d-m-Y  H:i:s') }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="updated_at" class="control-label mb-1">Updated At</label>
                                                        <input name="updated_at" type="text" value="{{ \Carbon\Carbon::parse($result[$order_id]['updated_at'])->format('d-m-Y  H:i:s') }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($result[$order_id]['status'] == "Received" || $result[$order_id]['status'] == "Processed" || $result[$order_id]['status'] == "Packed")
                                                <a href="#" id="{{ $order_id }}" name="cancel_order" class="aa-browse-btn checkout-add-address">Cancel Order</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            @endforeach
        </div>
    </section>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('consumer_assets/js/loadMyOrder.js') }}"></script>
@endsection
