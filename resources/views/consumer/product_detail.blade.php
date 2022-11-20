@extends('consumer.layout')

@section('container')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- product category -->
    <section id="aa-product-details">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="aa-product-details-area">
                        <div class="aa-product-details-content">
                            <div class="row">
                                <!-- Modal view slider edited by me-->
                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <div class="aa-product-view-slider">
                                        <div class="simpleLens-gallery-container">
                                            @if ($result['product_images']->isNotEmpty())
                                                <div class="simpleLens-container">
                                                    <div class="simpleLens-big-image-container product-image-frame">
                                                        <img id="main_image_frame"
                                                            src="{{ asset('/storage/product_image/' . $result['product_images'][0]->image) }}"
                                                            class="simpleLens-big-image">
                                                    </div>
                                                </div><br>
                                                <div class="simpleLens-thumbnails-container product-image-slider">
                                                    @foreach ($result['product_images'] as $product_image)
                                                        <a style="margin-left: 5px; margin-right: 5px;" href="#"
                                                            onclick="event.preventDefault();">
                                                            <img name="small_image_frame"
                                                                src="{{ asset('/storage/product_image/' . $product_image->image) }}">
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="simpleLens-container">
                                                    <div class="simpleLens-big-image-container product-image-frame">
                                                        <img id="main_image_frame"
                                                            src="{{ asset('/storage/product_image/' . $result['product']->product_main_image) }}"
                                                            class="simpleLens-big-image">
                                                    </div>
                                                </div><br>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal view content edited by me-->
                                <input id="product_id" value="{{ $result['product']->id }}" hidden>
                                <input id="product_detail_id" type="text" value="" hidden readonly>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <div class="aa-product-view-content">
                                        <h3>{{ $result['product']->product_name }}</h3>
                                        <div class="aa-price-block">
                                            <span class="aa-product-view-price" id="price"></span>
                                            <p class="aa-product-avilability">Avilability: <span id="stock_status"></span>
                                            </p>
                                        </div>
                                        <div id="short_desc"></div>
                                        <div id="option_part1"></div>
                                        <div id="option_part2"></div>
                                        <div id="option_part3"></div>
                                        <div class="aa-prod-quantity">
                                            <span>Quantity: &nbsp;</span>
                                            <button id="decr_btn" type="button" onclick="">-</button>
                                            <input id="product_quantity"
                                                style="width: 15%; margin: 0; padding: 0; text-align: center;" ;
                                                type="number" min="0" value="1">
                                            <button id="incr_btn" type="button">+</button>
                                            <input id="stock_quantity" type="number" value="" hidden>
                                        </div><br>
                                        <p class="aa-prod-category">
                                            Category: <a href="#"
                                                style="font-size:17px; color: rgb(247, 63, 57);">&nbsp;{{ $result['category_name'] }}</a>
                                        </p>
                                        <div class="aa-prod-view-bottom">
                                            <a id="add_to_cart" class="aa-add-to-cart-btn" href="#">Add To Cart</a>
                                            <a class="aa-add-to-cart-btn" href="#">Wishlist</a>
                                            <a class="aa-add-to-cart-btn" href="#">Compare</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="aa-product-details-bottom">
                            <ul class="nav nav-tabs" id="myTab2">
                                <li><a href="#description" data-toggle="tab">Description</a></li>
                                <li><a href="#review" data-toggle="tab">Reviews</a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="description">
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                        unknown printer took a galley of type and scrambled it to make a type specimen book.
                                        It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially unchanged. It was popularised in the 1960s with
                                        the release of Letraset sheets containing Lorem Ipsum passages, and more recently
                                        with desktop publishing software like Aldus PageMaker including versions of Lorem
                                        Ipsum.</p>
                                    <ul>
                                        <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod, culpa!</li>
                                        <li>Lorem ipsum dolor sit amet.</li>
                                        <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                                        <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor qui eius esse!
                                        </li>
                                        <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam, modi!</li>
                                    </ul>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum, iusto earum
                                        voluptates autem esse molestiae ipsam, atque quam amet similique ducimus aliquid
                                        voluptate perferendis, distinctio!</p>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis ea, voluptas!
                                        Aliquam facere quas cumque rerum dolore impedit, dicta ducimus repellat dignissimos,
                                        fugiat, minima quaerat necessitatibus? Optio adipisci ab, obcaecati, porro unde
                                        accusantium facilis repudiandae.</p>
                                </div>
                                <div class="tab-pane fade " id="review">
                                    <div class="aa-product-review-area">
                                        <h4>2 Reviews for T-Shirt</h4>
                                        <ul class="aa-review-nav">
                                            <li>
                                                <div class="media">
                                                    <div class="media-left">
                                                        <a href="#">
                                                            <img class="media-object" src="img/testimonial-img-3.jpg"
                                                                alt="girl image">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading"><strong>Marla Jobs</strong> - <span>March
                                                                26, 2016</span></h4>
                                                        <div class="aa-product-rating">
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star-o"></span>
                                                        </div>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="media">
                                                    <div class="media-left">
                                                        <a href="#">
                                                            <img class="media-object" src="img/testimonial-img-3.jpg"
                                                                alt="girl image">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading"><strong>Marla Jobs</strong> - <span>March
                                                                26, 2016</span></h4>
                                                        <div class="aa-product-rating">
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star-o"></span>
                                                        </div>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <h4>Add a review</h4>
                                        <div class="aa-your-rating">
                                            <p>Your Rating</p>
                                            <a href="#"><span class="fa fa-star-o"></span></a>
                                            <a href="#"><span class="fa fa-star-o"></span></a>
                                            <a href="#"><span class="fa fa-star-o"></span></a>
                                            <a href="#"><span class="fa fa-star-o"></span></a>
                                            <a href="#"><span class="fa fa-star-o"></span></a>
                                        </div>
                                        <!-- review form -->
                                        <form action="" class="aa-review-form">
                                            <div class="form-group">
                                                <label for="message">Your Review</label>
                                                <textarea class="form-control" rows="3" id="message"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" placeholder="Name">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email"
                                                    placeholder="example@gmail.com">
                                            </div>

                                            <button type="submit" class="btn btn-default aa-review-submit">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Related product edited by me-->
                        <div class="aa-product-related-item">
                            <h3>Related Products</h3>
                            <ul class="aa-product-catg aa-related-item-slider">
                                <!-- start single product item -->
                                @foreach ($result['related_products'] as $related_product)
                                    <li>
                                        <figure>
                                            <div class="related-product-image-frame">
                                                <a href="#"><img
                                                        src="{{ asset('/storage/product_image/' . $related_product->product_main_image) }}"
                                                        alt="polo shirt img"></a>
                                            </div>

                                            <a class="aa-add-card-btn" href="#"
                                                onclick="event.preventDefault(); defaultAddToCart({{ $result['first_option_related_product_detail'][$related_product->id]->id }});"><span
                                                    class="fa fa-shopping-cart"></span>Add To Cart</a>
                                            <figcaption>
                                                <h4 class="aa-product-title"><a
                                                        href="#">{{ $related_product->product_name }}</a></h4>
                                                @php
                                                    $discount_percent = $result['first_option_related_product_detail'][$related_product->id]->discount_percent;
                                                    $price = $result['first_option_related_product_detail'][$related_product->id]->price;
                                                @endphp
                                                @if ($discount_percent == 0)
                                                    <span class="aa-product-price">{{ '$' . $price }}</span>
                                                @else
                                                    <span
                                                        class="aa-product-price">{{ '$' . $price * (1 - $discount_percent / 100) }}</span>
                                                    <span class="aa-product-price"><del>{{ '$' . $price }}</del></span>
                                                @endif
                                            </figcaption>
                                        </figure>
                                        <div class="aa-product-hvr-content">
                                            <a href="#" data-toggle="tooltip" data-placement="top"
                                                title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span
                                                    class="fa fa-exchange"></span></a>
                                            <a href="{{ route('product_detail', [$related_product->product_slug]) }}"
                                                data-toggle="tooltip" data-placement="top" title="View detail"><span
                                                    class="fa fa-search"></span></a>
                                        </div>
                                        <!-- product badge -->
                                        @if ($discount_percent != 0)
                                            <span class="aa-badge aa-sale" href="#">SALE!</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- / product category -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('consumer_assets/js/loadProductDetail.js') }}"></script>
    <script src="{{ asset('consumer_assets/js/productListAddToCart.js') }}"></script>
@endsection
