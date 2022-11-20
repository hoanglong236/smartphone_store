@extends('consumer.layout')

@section('container')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- product search -->
    <section id="aa-product-category">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-8 col-md-push-3">
                    <div class="aa-product-catg-content">
                        <div class="aa-product-catg-head">
                            <div class="aa-product-catg-head-left">
                                <h3><b>{{ 'Result for keyword: "' . $result['keyword'] . '".' }}</b></h3>
                            </div>
                        </div>
                        <div class="aa-product-catg-head">
                            <div class="aa-product-catg-head-left">
                                <label for="">Sort by</label>
                                <select id="sort" class="form-select">
                                    <option value="1" selected="Default">Default</option>
                                    <option value="2">Name</option>
                                    <option value="3">Price</option>
                                    <option value="4">Date</option>
                                </select>&nbsp;&nbsp;&nbsp;&nbsp;
                                <label for="">Page size</label>
                                <select id="page_size" class="form-select">
                                    <option value="9" @if ($result['page_size']==9) selected @endif>9</option>
                                    <option value="18" @if ($result['page_size']==18) selected @endif>18</option>
                                </select>
                            </div>
                            <div class="aa-product-catg-head-right">
                                <a id="grid-catg" href="#"><span class="fa fa-th"></span></a>
                                <a id="list-catg" href="#"><span class="fa fa-list"></span></a>
                            </div>
                        </div>
                        <div class="aa-product-catg-body">
                            <ul class="aa-product-catg">
                                @foreach ($result['products'] as $product)
                                    <li>
                                        <figure>
                                            <a class="aa-product-img" href="#"><img width="250" height="300"
                                                    src="{{ asset('/storage/product_image/' . $product->product_main_image) }}"
                                                    alt="{{ $product->product_name }}"></a>
                                            <a class="aa-add-card-btn" href="#"
                                                onclick="event.preventDefault(); defaultAddToCart({{ $result[$product->id]['product_detail']->id }})"><span
                                                    class="fa fa-shopping-cart"></span>Add To
                                                Cart</a>
                                            <figcaption>
                                                <h4 class="aa-product-title"><a href="#"
                                                        style="word-wrap: break-word;">{{ $product->product_name }}</a>
                                                </h4>
                                                <span class="aa-product-price">
                                                    {{ '$' . ($result[$product->id]['product_detail']->price * (100 - $result[$product->id]['product_detail']->discount_percent)) / 100 }}
                                                </span>
                                                @if ($result[$product->id]['product_detail']->discount_percent > 0)
                                                    <span class="aa-product-price">
                                                        <del>{{ '$' . $result[$product->id]['product_detail']->price }}</del>
                                                    </span>
                                                @endif
                                            </figcaption>
                                        </figure>
                                        <div class="aa-product-hvr-content">
                                            <a href="#" data-toggle="tooltip" data-placement="top"
                                                title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span
                                                    class="fa fa-exchange"></span></a>
                                            <a href="{{ route('product_detail', [$product->product_slug]) }}"><span class="fa fa-search"></span></a>
                                        </div>
                                        <!-- product badge -->
                                        @if ($result[$product->id]['product_detail']->discount_percent > 0)
                                            <span class="aa-badge aa-sale" href="#">SALE!</span>
                                        @endif

                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="row">
                            <input id="keyword" type="hidden" value="{{ $result['keyword'] }}"
                                readonly>
                            <div class="col-sm-3"><input id="page_index" style="width: 75px; margin-top: 20px;"
                                    min="1" max="{{ $result['page_count'] }}" type="number"
                                    value="{{ $result['page_index'] }}"><span>&nbsp;&nbsp;of {{ $result['page_count'] }}
                                    pages</span>
                            </div>
                            <div class="col-sm-6">
                                <nav aria-label="Page navigation example" style="text-align: center;">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item @if (intval($result['page_index']) == 1) disabled @endif">
                                            <a id="go_to_first_btn" class="page-link" href="#" @if (intval($result['page_index']) == 1) tabindex="-1" @endif>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-chevron-double-left"
                                                    viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
                                                    <path fill-rule="evenodd"
                                                        d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
                                                </svg>
                                            </a>
                                        </li>
                                        <li class="page-item @if ($result['page_index'] == 1) disabled @endif">
                                            <a id="previous_btn" class="page-link" href="#" @if ($result['page_index'] == 1) tabindex="-1" @endif>Previous</a>
                                        </li>
                                        <li class="page-item active"><a id="current_page" class="page-link" href="#">{{ $result['page_index'] }}</a></li>
                                        <li class="page-item @if (intval($result['page_index']) == intval($result['page_count'])) disabled @endif">
                                            <a id="next_btn" class="page-link" href="#" @if (intval($result['page_index']) == intval($result['page_count'])) tabindex="-1" @endif">Next</a>
                                        </li>
                                        <li class="page-item @if (intval($result['page_index']) == intval($result['page_count'])) disabled @endif">
                                            <a id="go_to_last_btn" class="page-link" href="#" @if (intval($result['page_index']) == intval($result['page_count'])) tabindex="-1" @endif">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-chevron-double-right"
                                                    viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z" />
                                                    <path fill-rule="evenodd"
                                                        d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-md-pull-9">
                    <aside class="aa-sidebar">
                        <!-- single sidebar -->
                        <div class="aa-sidebar-widget">
                            <h3>Category</h3>
                            <ul class="aa-catg-nav">
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                        <label class="form-check-label" style="font-weight: normal;" for="defaultCheck1">
                                            Default checkbox
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- single sidebar -->
                        <div class="aa-sidebar-widget">
                            <h3>Brand</h3>
                            <ul class="aa-catg-nav">
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                        <label class="form-check-label" style="font-weight: normal;" for="defaultCheck1">
                                            Default checkbox
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- single sidebar -->
                        <div class="aa-sidebar-widget">
                            <h3>Tags</h3>
                            <div class="tag-cloud">
                                <a href="#">Fashion</a>
                                <a href="#">Ecommerce</a>
                                <a href="#">Shop</a>
                                <a href="#">Hand Bag</a>
                                <a href="#">Laptop</a>
                                <a href="#">Head Phone</a>
                                <a href="#">Pen Drive</a>
                            </div>
                        </div>
                        <!-- single sidebar -->
                        <div class="aa-sidebar-widget">
                            <h3>Shop By Price</h3>
                            <!-- price range -->
                            <div class="aa-sidebar-price-range">
                                <form action="">
                                    <div id="skipstep" class="noUi-target noUi-ltr noUi-horizontal noUi-background">
                                        <div class="noUi-base">
                                            <div class="noUi-origin noUi-connect" style="left: 20%;">
                                                <div class="noUi-handle noUi-handle-lower"></div>
                                            </div>
                                            <div class="noUi-origin noUi-background" style="left: 60%;">
                                                <div class="noUi-handle noUi-handle-upper"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <span id="skip-value-lower" class="example-val">20.00</span>
                                    <span id="skip-value-upper" class="example-val">60.00</span>
                                    <button class="aa-filter-btn" type="submit">Filter</button>
                                </form>
                            </div>
                        </div>

                        <!-- single sidebar -->
                        <div class="aa-sidebar-widget">
                            <h3>Recently Views</h3>
                            <div class="aa-recently-views">
                                <ul>
                                    <li>
                                        <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-2.jpg"></a>
                                        <div class="aa-cartbox-info">
                                            <h4><a href="#">Product Name</a></h4>
                                            <p>1 x $250</p>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-1.jpg"></a>
                                        <div class="aa-cartbox-info">
                                            <h4><a href="#">Product Name</a></h4>
                                            <p>1 x $250</p>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-2.jpg"></a>
                                        <div class="aa-cartbox-info">
                                            <h4><a href="#">Product Name</a></h4>
                                            <p>1 x $250</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
    <!-- / product search -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('consumer_assets/js/productListAddToCart.js') }}"></script>
    <script src="{{ asset('consumer_assets/js/loadSearchPagination.js') }}"></script>
@endsection
