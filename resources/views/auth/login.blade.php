@extends('layouts.app')
@push('css')
    <style>
        /* Login Form Theme Styles */
        .login-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 10px;
            margin-bottom: 50px;
            border: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .login-card:hover {
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .login-header {
            background: linear-gradient(135deg, #ff4757 0%, #ff3838 100%);
            padding: 20px 30px;
            text-align: center;
            color: white;
        }

        .login-title {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .login-body {
            padding: 25px 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border: 2px solid #e1e8ed;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
            color: #2c3e50;
        }

        .form-input:focus {
            outline: none;
            border-color: #ff4757;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(255, 71, 87, 0.1);
            transform: translateY(-1px);
        }

        .form-input.is-invalid {
            border-color: #e74c3c;
            background: #fdf2f2;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #7f8c8d;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-input:focus+.input-icon {
            color: #ff4757;
        }

        .error-message {
            display: block;
            margin-top: 8px;
            color: #e74c3c;
            font-size: 13px;
            font-weight: 500;
        }

        .remember-wrapper {
            display: flex;
            align-items: center;
        }

        .remember-label {
            display: flex;
            align-items: center;
            cursor: pointer;
            user-select: none;
            margin: 0;
        }

        .remember-input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .remember-checkmark {
            position: relative;
            height: 20px;
            width: 20px;
            background-color: #f8f9fa;
            border: 2px solid #e1e8ed;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .remember-checkmark:after {
            content: "";
            position: absolute;
            display: none;
            left: 6px;
            top: 2px;
            width: 6px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .remember-input:checked~.remember-checkmark {
            background-color: #ff4757;
            border-color: #ff4757;
        }

        .remember-input:checked~.remember-checkmark:after {
            display: block;
        }

        .remember-text {
            margin-left: 12px;
            color: #2c3e50;
            font-size: 14px;
            font-weight: 500;
        }

        .login-btn {
            width: 100%;
            padding: 16px 24px;
            background: linear-gradient(135deg, #ff4757 0%, #ff3838 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 71, 87, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .login-btn i {
            transition: transform 0.3s ease;
        }

        .login-btn:hover i {
            transform: translateX(3px);
        }

        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-link {
            color: #7f8c8d;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-link:hover {
            color: #ff4757;
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-card {
                margin: 10px 20px;
                border-radius: 16px;
            }

            .login-header {
                padding: 30px 20px;
            }

            .login-body {
                padding: 30px 20px;
            }

            .login-title {
                font-size: 24px;
            }

            .form-input {
                padding: 12px 16px 12px 45px;
                font-size: 16px;
                /* Prevent zoom on iOS */
            }
        }

        @media (max-width: 480px) {
            .login-header {
                padding: 25px 15px;
            }

            .login-body {
                padding: 25px 15px;
            }

            .login-title {
                font-size: 22px;
            }
        }
    </style>
@endpush
@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-card">
                    <div class="login-header">
                        <h3 class="login-title">{{ __('Login') }}</h3>
                    </div>
                    <div class="login-body">
                        <div class="form-group text-center">
                            <a href="{{ route('google.login') }}" class="google-btn">
                                <i class="fab fa-google"></i> Continue with Google
                            </a>
                        </div>
                        <style>
                            .google-btn {
                                display: inline-flex;
                                align-items: center;
                                justify-content: center;
                                gap: 8px;
                                width: 100%;
                                background: #ff4757 0%;
                                color: #fff !important;
                                font-weight: 600;
                                border-radius: 10px;
                                padding: 10px;
                                text-decoration: none;
                                transition: background 0.3s ease;
                            }

                            .google-btn:hover {
                                background: #ff4757;
                                color: #fff !important;
                            }

                            .google-btn i {
                                font-size: 16px;
                            }
                        </style>

                        <form method="POST" action="{{ route('login') }}" class="login-form">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <div class="input-wrapper">
                                    <input id="email" type="email"
                                        class="form-input @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus
                                        placeholder="Enter your email">
                                    <i class="input-icon fas fa-envelope"></i>
                                </div>
                                @error('email')
                                    <span class="error-message" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <div class="input-wrapper">

                                    <input id="password" type="password"
                                        class="form-input @error('password') is-invalid @enderror" name="password" required
                                        autocomplete="current-password" placeholder="Enter your password">
                                    <i class="input-icon fas fa-lock"></i>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="forgot-link float-right">
                                            {{ __('Forgot Password?') }}
                                        </a>
                                    @endif
                                </div>
                                @error('password')
                                    <span class="error-message" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="remember-wrapper">
                                    <label class="remember-label">
                                        <input class="remember-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <span class="remember-checkmark"></span>
                                        <span class="remember-text">{{ __('Remember Me') }}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="login-btn">
                                    <span>{{ __('Login') }}</span>
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                            <a href="{{ route('register') }}" class="forgot-link">
                                {{ __("Don't have an account?") }} <span style="color: blue"> Register Now</span>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector(".login-form"); 
        const btn = form.querySelector(".login-btn");
        console.log(form, btn);
        form.addEventListener("submit", function () {
            btn.disabled = true; 
            btn.style.background = "#ccc";
            btn.innerHTML = `<i class="fa fa-spinner fa-spin"></i> Please Wait ...`;
        });
    });
</script>

@endpush
