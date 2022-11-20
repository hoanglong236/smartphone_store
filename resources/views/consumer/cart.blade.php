@extends('consumer.layout')

@section('container')
    <section id="cart-view">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="cart-view-area">
                        <div class="cart-view-table">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($result['cart_detail_ids'] as $cart_detail_id)
                                            <tr>
                                                <input class="product_detail_id" type="hidden"
                                                    value="{{ $result[$cart_detail_id]['product_detail_id'] }}">
                                                <input class="cart_detail_id" type="hidden" value="{{ $cart_detail_id }}">
                                                <td class="check_item">
                                                    <input class="form-check-input" style="width: 20px; height: 20px;"
                                                        type="checkbox" value="Yes"
                                                        onclick="updateSubTotalWhenItemChecked(this)">
                                                </td>
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
                                                <td class="price_item">{{ $result[$cart_detail_id]['price'] }}</td>
                                                <td><input class="quantity_item" style="width: 75px;" type="number" min="1"
                                                        max="{{ $result[$cart_detail_id]['stock_quantity'] }}"
                                                        value="{{ $result[$cart_detail_id]['quantity'] }}"
                                                        onfocusout="updateTotalPriceItem(this, {{ $cart_detail_id }}, {{ $result[$cart_detail_id]['product_detail_id'] }})">
                                                </td>
                                                <td class="total_price_item">
                                                    {{ $result[$cart_detail_id]['price'] * $result[$cart_detail_id]['quantity'] }}
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        onclick="deleteItem({{ $cart_detail_id }})"><svg
                                                            style="vertical-align: middle;"
                                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                            <path
                                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                            <path fill-rule="evenodd"
                                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                        </svg></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="4" class="cart-total"><b><i>Subtotal:</i></b></td>
                                            <td colspan="2" class="cart-total" id="sub_total">$0</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="cart-total"><b><i>Shipping Cost:</i></b></td>
                                            <td colspan="2" class="cart-total">$0</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="cart-total"><b><i id="total">Total:</i></b></td>
                                            <td colspan="2" class="cart-total">$0</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <a href="#" onclick="createSessionStorageToStoreSelectedCartItem(event)"
                                class="aa-cart-view-btn">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('consumer_assets/js/loadCart.js') }}"></script>
@endsection
