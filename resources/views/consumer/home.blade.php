@extends('consumer.layout')

@section('container')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Start slider edited by me -->
    <section id="aa-slider">
      <div class="aa-slider-area">
        <div id="sequence" class="seq">
          <div class="seq-screen">
            <ul class="seq-canvas">
              @foreach ($result['sliders'] as $slider)
                <!-- single slide item -->
                <li>
                  <div class="seq-model">
                    <img data-seq src="{{ asset('/storage/slider_image/' . $slider->image) }}" alt="Men slide img" />
                  </div>
                  <div class="seq-title">
                  <span data-seq>{{ $slider->discount_title }}</span>                
                    <h2 data-seq>{{ $slider->title }}</h2>                
                    {{-- <p data-seq>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus, illum.</p> --}}
                    <a data-seq href="{{ route('category_page', [$slider->category_slug, 1, 9]) }}" class="aa-shop-now-btn aa-secondary-btn">SHOP NOW</a>
                  </div>
                </li>
              @endforeach                
            </ul>
          </div>
          <!-- slider navigation btn -->
          <fieldset class="seq-nav" aria-controls="sequence" aria-label="Slider buttons">
            <a type="button" class="seq-prev" aria-label="Previous"><span class="fa fa-angle-left"></span></a>
            <a type="button" class="seq-next" aria-label="Next"><span class="fa fa-angle-right"></span></a>
          </fieldset>
        </div>
      </div>
    </section>
    <!-- / slider -->

  <!-- Products section edited by me-->
  <section id="aa-product">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="aa-product-area">
              <div class="aa-product-inner">
                <!-- start prduct navigation -->
                  <ul class="nav nav-tabs aa-products-tab">
                      @foreach ($result['categories_display'] as $category_display)
                          <li name="category-tab"><a href="#{{ $category_display->id }}" data-toggle="tab">{{ $category_display->category_name }}</a></li>
                      @endforeach
                      <script type="text/javascript" >
                          $(document).ready(function() {
                              $('[name="category-tab"]')[0].className = "active";
                          });
                      </script>
                  </ul>
                  <!-- Tab panes -->
                  <h3 style="text-align: left;"><strong>BEST - SELLING PRODUCT</strong></h3><br>
                  <div class="tab-content">
                      @foreach ($result['categories_display'] as $category_display)
                          <div class="tab-pane fade" id="{{ $category_display->id }}">
                            <ul class="aa-product-catg">
                              <!-- start single product item -->
                              @foreach ($result['products_display'][$category_display->id] as $product_display)
                                <li>
                                  <figure>
                                    <a class="aa-product-img" href="#"><img width="250" height="300" src="{{ asset('/storage/product_image/' . $product_display->product_main_image) }}" alt="{{ $product_display->product_name }}"></a>
                                    <a class="aa-add-card-btn"href="#" onclick="event.preventDefault(); defaultAddToCart({{ $result['product_details'][$product_display->id]->id }})"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                                      <figcaption style="width: 250px; height: 300px;">
                                      <h4 class="aa-product-title"><a href="#" style="word-wrap: break-word;">{{ $product_display->product_name }}</a></h4>
                                      <span class="aa-product-price">
                                        {{ '$' . ($result['product_details'][$product_display->id]->price * (100 - $result['product_details'][$product_display->id]->discount_percent) / 100) }}
                                      </span>
                                      @if ($result['product_details'][$product_display->id]->discount_percent > 0)
                                        <span class="aa-product-price">
                                            <del>{{ '$' . $result['product_details'][$product_display->id]->price }}</del>
                                        </span>
                                      @endif
                                    </figcaption>
                                  </figure>                        
                                  <div class="aa-product-hvr-content">
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a>
                                    <a href="{{ route('product_detail', [$product_display->product_slug]) }}"><span class="fa fa-search"></span></a>                          
                                  </div>
                                  <!-- product badge -->
                                  @if ($result['product_details'][$product_display->id]->discount_percent > 0)
                                    <span class="aa-badge aa-sale" href="javascript:void(0)">SALE!</span>
                                  @endif
                                </li>
                              @endforeach              
                            </ul>
                            <a class="aa-browse-btn" href="{{ route('category_page', [$category_display->category_slug, 1, 9]) }}">Browse all Product <span class="fa fa-long-arrow-right"></span></a>
                          </div>
                      @endforeach
                      <script type="text/javascript" >
                        $(document).ready(function() {
                            $('.tab-pane.fade')[0].className += " active in";
                        });
                    </script>
                  </div><br>          
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Products section -->

  <!-- Support section -->
  <section id="aa-support">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-support-area">
            <!-- single support -->
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="aa-support-single">
                <span class="fa fa-truck"></span>
                <h4>FREE SHIPPING</h4>
                <P>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam, nobis.</P>
              </div>
            </div>
            <!-- single support -->
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="aa-support-single">
                <span class="fa fa-clock-o"></span>
                <h4>30 DAYS MONEY BACK</h4>
                <P>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam, nobis.</P>
              </div>
            </div>
            <!-- single support -->
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="aa-support-single">
                <span class="fa fa-phone"></span>
                <h4>SUPPORT 24/7</h4>
                <P>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam, nobis.</P>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Support section -->
  
  <!-- Client Brand edited by me-->
  <section id="aa-client-brand">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-client-brand-area">
            <ul class="aa-client-brand-slider">
              @foreach ($result['brands_display'] as $brand_display)
                <li><a href="#"><img style="width: 120px; height: 60px;" src="{{ asset('/storage/brand_logo/' . $brand_display->brand_logo) }}" alt="{{ $brand_display->brand_name }}"></a></li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Client Brand -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var has_alert = '{{ Session::has('alert') }}';
        if (has_alert) {
            var alert_message = '{{ Session::get('alert') }}';
            if (alert_message.indexOf("Error") == -1) {
                Swal.fire({
                    title: "Successfully!",
                    text: alert_message,
                    icon: "success",
                    customClass: "swal-wide"
                })
            } else {
                Swal.fire({
                    title: "Opps...",
                    text: alert_message,
                    icon: "error",
                    customClass: "swal-wide"
                })
            }
        }
    </script>
    <script src="{{ asset('consumer_assets/js/productListAddToCart.js') }}"></script>
@endsection