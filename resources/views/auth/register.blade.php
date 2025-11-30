@extends('layouts.app')
@push('css')
<style>
    /* Password Toggle Icon (shared for both fields) */
    .password-toggle {
        position: absolute;
        right: 18px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #7f8c8d;
        font-size: 18px;
        transition: all 0.3s ease;
        z-index: 5;
    }

    .password-toggle:hover,
    .password-toggle.active {
        color: #ff4757;
    }

    /* Make sure input has enough right padding so text doesn't go under the eye */
    .has-toggle {
        padding-right: 55px !important;
    }
</style>
    <style>
        /* Register Form Theme Styles - Matching Login Page */
        .register-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 10px;
            margin-bottom: 50px;
            border: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .register-card:hover {
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .register-header {
            background: linear-gradient(135deg, #ff4757 0%, #ff3838 100%);
            padding: 20px 30px;
            text-align: center;
            color: white;
        }

        .register-title {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .register-body {
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

        .register-btn {
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

        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 71, 87, 0.3);
        }

        .register-btn:active {
            transform: translateY(0);
        }

        .register-btn i {
            transition: transform 0.3s ease;
        }

        .register-btn:hover i {
            transform: translateX(3px);
        }

        .login-link-wrapper {
            text-align: center;
            margin-top: 20px;
        }

        .login-link {
            color: #7f8c8d;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .login-link:hover {
            color: #ff4757;
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .register-card {
                margin: 10px 20px;
                border-radius: 16px;
            }

            .register-header {
                padding: 30px 20px;
            }

            .register-body {
                padding: 30px 20px;
            }

            .register-title {
                font-size: 24px;
            }

            .form-input {
                padding: 12px 16px 12px 45px;
                font-size: 16px;
                /* Prevent zoom on iOS */
            }
        }

        @media (max-width: 480px) {
            .register-header {
                padding: 25px 15px;
            }

            .register-body {
                padding: 25px 15px;
            }

            .register-title {
                font-size: 22px;
            }
        }
    </style>
@endpush
@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="register-card">
                    <div class="register-header">
                        <h3 class="register-title">{{ __('Register') }}</h3>
                    </div>
                    <div class="register-body">
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
                                background: #ff4757;  /* Fixed: removed invalid '0%' */
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
                        <form method="POST" action="{{ route('register') }}" class="register-form">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <div class="input-wrapper">
                                    <input id="name" type="text"
                                        class="form-input @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus
                                        placeholder="Enter your full name">
                                    <i class="input-icon fas fa-user"></i>
                                </div>
                                @error('name')
                                    <span class="error-message" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <div class="input-wrapper">
                                    <input id="email" type="email"
                                        class="form-input @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email"
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
                                        autocomplete="new-password" placeholder="Enter your password" minlength="8">
                                    <i class="input-icon fas fa-lock"></i>
                                    <i class="password-toggle fas fa-eye-slash" id="togglePassword"></i>
                                </div>
                                @error('password')
                                    <span class="error-message" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                                <div class="input-wrapper">
                                    <input id="password-confirm" type="password" class="form-input"
                                        name="password_confirmation" required autocomplete="new-password"
                                        placeholder="Confirm your password">
                                    <i class="input-icon fas fa-lock"></i>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="register-btn">
                                    <span>{{ __('Register') }}</span>
                                    <i class="fas fa-user-plus"></i>
                                </button>
                            </div>

                            <div class="login-link-wrapper">
                                <a href="{{ route('login') }}" class="login-link">
                                    {{ __('Already have an account?') }} <span
                                        style="color: #ff4757; font-weight: 600;">Login Here</span>
                                </a>
                            </div>
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
        const form = document.querySelector(".register-form"); 
        const btn = form.querySelector(".register-btn");
        console.log(form, btn);
        form.addEventListener("submit", function () {
            btn.disabled = true; 
            btn.style.background = "#ccc";
            btn.innerHTML = `<i class="fa fa-spinner fa-spin"></i> Please Wait ...`;
        });
    });
</script>
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleIcon = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');
        const confirmField = document.getElementById('password-confirm');

        toggleIcon.addEventListener('click', function () {
            // Toggle password visibility
            const isPassword = passwordField.getAttribute('type') === 'password';
            passwordField.setAttribute('type', isPassword ? 'text' : 'password');
            confirmField.setAttribute('type', isPassword ? 'text' : 'password');

            // Toggle icon
            this.classList.toggle('fa-eye-slash');
            this.classList.toggle('fa-eye');
            this.classList.toggle('active');
        });

        // Optional: Update icon color when input is focused
        [passwordField, confirmField].forEach(field => {
            field.addEventListener('focus', () => toggleIcon.style.color = '#ff4757');
            field.addEventListener('blur', () => {
                if (!toggleIcon.classList.contains('active')) {
                    toggleIcon.style.color = '#7f8c8d';
                }
            });
        });
    });
</script>
@endpush

@endpush