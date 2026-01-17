@extends('layouts.app')
@section('main')

    <main>
        <!-- Contact Details Start -->
        <div class="about-details section-padding30">
            <div class="container">
                <div class="row">
                    <div class="offset-xl-1 col-lg-8">
                        <div class="about-details-cap mb-50">
                            <h4>Contact Daily Orbit</h4>
                            <p>We welcome your queries, feedback, grievances or collaboration requests. Reach out using the details below.</p>
                        </div>

                        <div class="about-details-cap mb-50">
                            <h4>Official Contact Information</h4>
                            <ul class="contact-list">
                                <li><strong>Email:</strong> <a href="mailto:info@dailyorbit.in">info@dailyorbit.in</a></li>
                                <li><strong>Phone:</strong> <a href="tel:+918126935236">+918126935236</a></li>
                                <li><strong>Address:</strong><br>
                                    1202 , Rishivihar <br>
                                    Dehradun , Uttarakhand - 248001<br>
                                    India
                                </li>
                            </ul>
                        </div>

                        <div class="about-details-cap mb-50">
                            <h4>Request a Callback</h4>
                            <p>Fill in your details and we’ll get back to you within 24 hours.</p>

                            @if (session('success'))
                                <div class="alert alert-success mb-30">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger mb-30">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form id="callback-form" action="{{ route('coming-soon') }}" method="POST" class="contact-form">
                                @csrf

                                <div class="form-group mb-20">
                                    <input type="text" name="name" placeholder="Your Full Name *" required minlength="2" maxlength="50"
                                        value="{{ old('name') }}">
                                </div>

                                <div class="form-group mb-20">
                                    <input type="email" name="email" placeholder="Your Email Address *" required
                                        value="{{ old('email') }}">
                                </div>

                                <div class="form-group mb-20">
                                    <input type="tel" name="phone" placeholder="Your Phone Number (with country code) *" required
                                        pattern="\+?[0-9\s\-\(\)]{10,15}" value="{{ old('phone') }}">
                                </div>

                                <div class="form-group mb-30">
                                    <textarea name="message" placeholder="Your Message *" rows="4" maxlength="500" required minlength="10">{{ old('message') }}</textarea>
                                </div>

                                <button type="submit" id="submit-btn" class="btn post-btn w-100">
                                    <span class="btn-text">Request Callback</span>
                                    <i class="fas fa-paper-plane ms-2"></i>
                                </button>
                            </form>
                        </div>

                        <div class="about-details-cap">
                            <p><small><strong>Note:</strong> This information is for official verification, press, partnerships, and legal compliance. All communications are recorded for quality and security.</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact Details End -->

        <!-- Support CTA Area -->
        <div class="support-company-area pt-100 pb-100 section-bg fix bg-dark" >
            <div class="container">
                <div class="row align-items-center">
                   
                    <div class="col-xl-6 col-lg-6">
                        <div class="right-caption">
                            <div class="section-tittles section-tittles2 mb-50">
                                <span>We’re Here to Help</span>
                                <h2>Let’s Connect</h2>
                            </div>
                            <div class="support-caption">
                                <p class="pera-top">Whether it's a story idea, partnership, or support — your message matters.</p>
                                <p class="mb-65">Our team responds promptly and professionally.</p>
                                <a href="mailto:info@dailyorbit.in" class="btn post-btn">Email Us Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Support Area -->

        
    </main>

    <style>
        .contact-list { list-style: none; padding: 0; margin: 0; }
        .contact-list li { margin-bottom: 12px; font-size: 16px; }
        .contact-list a { color: #007bff; text-decoration: none; }
        .contact-list a:hover { text-decoration: underline; }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 15px;
            transition: border 0.3s;
        }
        .contact-form input:focus,
        .contact-form textarea:focus {
            outline: none;
            border-color: #007bff;
        }

        .alert {
            padding: 15px;
            border-radius: 6px;
            font-size: 15px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert ul { margin: 0; padding-left: 20px; }
    </style>
@endsection

@push('scripts')
    <script>
    document.getElementById('callback-form').addEventListener('submit', function () {
        const btn = document.getElementById('submit-btn');
        const textSpan = btn.querySelector('.btn-text');
        const icon = btn.querySelector('i');

        // Disable button
        btn.disabled = true;

        // Change text & icon to loading
        textSpan.textContent = 'Submitting...';
        icon.className = 'fas fa-spinner fa-spin ms-2';

        // Re-enable after 4 seconds (fallback in case redirect fails)
        setTimeout(() => {
            btn.disabled = false;
            textSpan.textContent = 'Request Callback';
            icon.className = 'fas fa-paper-plane ms-2';
        }, 3000);
    });

    // Optional: Re-enable on page load if form failed (Laravel errors)
    window.addEventListener('load', function () {
        const btn = document.getElementById('submit-btn');
        if (btn && btn.disabled) {
            setTimeout(() => {
                btn.disabled = false;
                btn.querySelector('.btn-text').textContent = 'Request Callback';
                btn.querySelector('i').className = 'fas fa-paper-plane ms-2';
            }, 100);
        }
    });
</script>
@endpush