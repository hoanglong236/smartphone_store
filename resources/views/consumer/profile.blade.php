@extends('consumer.layout')

@section('container')
    <section id="cart-view">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="cart-view-area">
                        <div class="container">
                            <div class="cart-view-table">
                                <form>
                                    {{-- <div class="form-group" style="text-align: center;">
                                        <img class="customer_image"
                                            src="{{ asset('/storage/product_image/1649691589.jpg') }}">
                                    </div>
                                    <hr> --}}
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label for="firstname">First Name</label>
                                                <input id="firstname" name="firstname" type="text" class="form-control"
                                                    value="{{ $customer->firstname }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label for="lastname">Last Name</label>
                                                <input id="lastname" name="lastname" type="text" class="form-control"
                                                    value="{{ $customer->lastname }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="gender">Gender</label>
                                                <select id="gender" name="gender" class="form-select select-address" required disabled>
                                                    <option value="Male" 
                                                        @if ($customer->gender == 'Male') selected @endif>Male</option>
                                                    <option value="Female"
                                                        @if ($customer->gender == 'Female') selected @endif>Female</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="phone">Phone</label>
                                                <input id="phone" name="phone" type="text" class="form-control"
                                                    value="{{ $customer->phone }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input id="email" name="email" type="email" class="form-control"
                                                    value="{{ $customer->email }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <a href="#" id="update_profile" class="btn btn-primary">Update Profile</a>
                                    <a href="#" id="save" class="btn btn-primary" style="float: right;" disabled>Save</a>
                                    <a href="#" id="cancel" class="btn btn-primary" style="float: right; margin-right: 10px;" disabled>Cancel</a>
                                </form>
                                <br>
                                <a href="{{ route('profile.add_address') }}" class="btn btn-primary">Add Address</a>
                            </div>
                        </div>
                    </div>
                    @foreach ($customer_addresses as $customer_address)
                        <div class="cart-view-area">
                            <div class="container">
                                <div class="cart-view-table">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="city_or_province">Provine or City:</label>
                                                <input name="city_or_province" class="form-control"
                                                    value="{{ $customer_address->city_or_province }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="district">District</label>
                                                <input name="district" class="form-control"
                                                    value="{{ $customer_address->district }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="ward_or_commune">Ward or Commune</label>
                                                <input name="ward_or_commune" type="text" class="form-control"
                                                    value="{{ $customer_address->ward_or_commune }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <label for="specific_address">Specific Address</label>
                                                <input name="specific_address" type="text" class="form-control"
                                                    value="{{ $customer_address->specific_address }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="ZIP_code">ZIP Code</label>
                                                <input name="ZIP_code" type="text" class="form-control"
                                                    value="{{ $customer_address->ZIP_code }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Address Type:</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="address_type"
                                                        value="Home" @if ($customer_address->address_type == 'Home') checked @endif
                                                        disabled>
                                                    <label class="form-check-label" for="address_type">
                                                        Home
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="address_type"
                                                        value="Office" @if ($customer_address->address_type == 'Office') checked @endif
                                                        disabled>
                                                    <label class="form-check-label" for="address_type">
                                                        Office
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="default_address[]"
                                                value="Yes" @if ($customer_address->default_address == 'Yes') checked @endif disabled>
                                            <label class="form-check-label" for="default_address">
                                                Set as default Address
                                            </label>
                                        </div>
                                    </div>
                                    {{-- <a href="{{ route('profile.update_address', [$customer_address->id]) }}" class="btn btn-primary">Update Address</a> --}}
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
    </section>
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
                    icon: 'error',
                    title: 'Oops...',
                    text: $alert_message,
                    customClass: "swal-wide",
                })
            }
        }
    </script>
    <script src="{{ asset('consumer_assets/js/consumer_profile.js') }}"></script>
@endsection
