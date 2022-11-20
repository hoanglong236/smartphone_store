@extends('consumer.layout')

@section('container')
    <!-- Cart view section -->
    <section id="aa-myaccount">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="aa-myaccount-area">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="aa-myaccount-register">
                                    <h4>Register</h4>
                                    <form class="aa-login-form" action="{{ route('register_handle') }}" method="POST">
                                        @csrf
                                        <label for="email">Email address<span>*</span></label>
                                        <input type="email" name="email" placeholder="Email">
                                        @error('email')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <label for="">Password<span>*</span></label>
                                        <input type="password" name="password" placeholder="Password">
                                        <label for="retype_password">Retype password<span>*</span></label>
                                        <input type="password" name="retype_password" placeholder="Retype password">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="">First name<span>*</span></label>
                                                <input type="text" name="firstname" placeholder="First name">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="">Last name<span>*</span></label>
                                                <input type="text" name="lastname" placeholder="Last name">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label for="gender" class="control-label mb-1">Gender</label>
                                                <select name="gender" class="form-control">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-8">
                                                <label for="">Phone number<span>*</span></label>
                                                <input type="text" name="phone" placeholder="Phone number">
                                            </div>
                                        </div>
                                        @if (session()->has('error_mess_register'))
                                            <div class="alert alert-danger" role="alert">
                                                {{session('error_mess_register')}}
                                            </div>
                                        @endif
                                        <button type="submit" class="aa-browse-btn">Register</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-5">
                                <div class="aa-myaccount-login">
                                    <h4>Login</h4>
                                    <form class="aa-login-form" action="{{ route('auth') }}" method="POST">
                                        @csrf
                                        <label for="">Email address<span>*</span></label>
                                        <input type="email" name="email" placeholder="Email">
                                        <label for="">Password<span>*</span></label>
                                        <input type="password" name="password" placeholder="Password">
                                        @if (session()->has('error_mess_login'))
                                            <div class="alert alert-danger" role="alert">
                                                {{session('error_mess_login')}}
                                            </div>
                                        @endif
                                        <button type="submit" class="aa-browse-btn">Login</button>
                                        <label class="rememberme" for="rememberme"><input type="checkbox"
                                            id="rememberme"> Remember me </label>
                                        <p class="aa-lost-password"><a href="#">Lost your password?</a></p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- / Cart view section -->
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
@endsection
