@extends('consumer.layout')

@section('container')
    <section id="cart-view">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="cart-view-area">
                        <div class="container">
                            <div class="cart-view-table">
                                <form action="{{ route('profile.add_address_handle') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="city_or_province">Provine or City:</label>
                                                <select id="provine_select" name="city_or_province" class="form-select select-address" required>
                                                    {{-- <option selected>Open this select menu</option> --}}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="district">District</label>
                                                <select id="district_select" name="district" class="form-select select-address" required>
                                                    {{-- <option selected>Open this select menu</option> --}}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="ward_or_commune">Ward or Commune</label>
                                                <select id="ward_select" name="ward_or_commune" class="form-select select-address" required>
                                                    {{-- <option selected>Open this select menu</option> --}}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <label for="specific_address">Specific Address</label>
                                                <input name="specific_address" type="text" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="ZIP_code">ZIP Code</label>
                                                <input name="ZIP_code" type="text" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Address Type:</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" value="Home" name="address_type">
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
                                                    <input class="form-check-input" type="radio" name="address_type" value="Office" checked>
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
                                                value="Yes" checked=>
                                            <label class="form-check-label" for="default_address">
                                                Set as default Address
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                                <br><a href="{{ route('profile') }}" class="btn btn-primary">
                                    Back to Profile
                                </a><br><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <script src="{{ asset('consumer_assets/js/get_address_ProvineAPI.js') }}"></script>
@endsection
