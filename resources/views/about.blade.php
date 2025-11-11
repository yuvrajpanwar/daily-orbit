@extends('layouts.app')

@section('main')
    
    <main>
        <!-- About Details Start -->
        <div class="about-details section-padding30">
            <div class="container">
                <div class="row">
                    <div class="offset-xl-1 col-lg-8">

                        <!-- Introduction -->
                        <div class="about-details-cap mb-50">
                            <h4>About Daily Orbit</h4>
                            <p>Daily Orbit is a modern digital community platform that brings together blogs, articles, forums, news, and personal stories, offering a space for sharing timely, accurate, and unbiased information.</p>
                            <p>Founded in 2025, we aim to foster informed discussions, empower readers, and build a trusted space for ideas and insights.</p>
                        </div>

                        <!-- Our Mission -->
                        <div class="about-details-cap mb-50">
                            <h4>Our Mission</h4>
                            <p>To provide reliable, accessible, and engaging content that informs, educates, and connects people in an increasingly digital world.</p>
                            <p>We are committed to journalistic integrity, user privacy, and fostering respectful, meaningful conversations in our community forums.</p>
                        </div>

                        <!-- Our Vision -->
                        <div class="about-details-cap mb-50">
                            <h4>Our Vision</h4>
                            <p>To become the most trusted and interactive digital platform in India for opinions, community-driven storytelling and news.</p>
                            <p>We envision a space where every voice matters, facts are verified, and knowledge flows freely.</p>
                        </div>

                        <!-- Our Values -->
                        <div class="about-details-cap mb-50">
                            <h4>Our Core Values</h4>
                            <ul>
                                <li><strong>Accuracy:</strong> We verify facts before publishing.</li>
                                <li><strong>Transparency:</strong> Clear policies, open communication.</li>
                                <li><strong>Respect:</strong> Safe, inclusive, and civil discourse.</li>
                                <li><strong>Innovation:</strong> Always improving user experience.</li>
                            </ul>
                        </div>

                        <!-- Contact Info -->
                        <div class="about-details-cap mb-50">
                            <h4>Contact Us</h4>
                            <ul>
                                <li><strong>For contact details, please visit:</strong> <a href="{{route('contact-us')}}">Contact Us</a></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- About Details End -->

        <!-- Services / CTA Area -->
        <div class="support-company-area pt-100 pb-100 section-bg fix bg-dark">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-6">
                        <div class="right-caption">
                            <div class="section-tittles section-tittles2 mb-50">
                                <span>What We Offer</span>
                                <h2>Our Key Services</h2>
                            </div>
                            <div class="support-caption">
                                <p class="pera-top">Daily Orbit delivers in-depth articles, expert blogs, interactive forums, premium advertising opportunities, and curated news — all in one trusted platform.</p>
                                <p class="pera-top">From community engagement to targeted ad placements and breaking headlines, we help you stay informed, connected, and reach the right audience.</p>
                                <a href="{{ route('contact-us') }}" class="btn post-btn">
                                    Get in Touch 
                                    <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Services Area -->

        <!-- Team Section -->
        <div class="team-area section-padding30">
            <div class="container">
                <div class="row">
                    <div class="cl-xl-7 col-lg-8 col-md-10">
                        <div class="section-tittles mb-70">
                            <span>Meet Our Team</span>
                            <h2>Our Dedicated Members</h2>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <!-- Team Member 1 -->
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-">
                        <div class="single-team mb-30">
                            <div class="team-img">
                                <img src="assets/img/gallery/team1.png" alt="Founder & Editor-in-Chief">
                            </div>
                            <div class="team-caption">
                                <h3><a href="#">Aarav Sharma</a></h3>
                                <span>Founder & Editor-in-Chief</span>
                            </div>
                        </div>
                    </div>

                    <!-- Team Member 2 -->
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-">
                        <div class="single-team mb-30">
                            <div class="team-img">
                                <img src="assets/img/gallery/team2.png" alt="Chief Technology Officer">
                            </div>
                            <div class="team-caption">
                                <h3><a href="#">Priya Mehta</a></h3>
                                <span>Chief Technology Officer</span>
                            </div>
                        </div>
                    </div>

                    <!-- Team Member 3 -->
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-">
                        <div class="single-team mb-30">
                            <div class="team-img">
                                <img src="assets/img/gallery/team3.png" alt="Community Manager">
                            </div>
                            <div class="team-caption">
                                <h3><a href="#">Rohan Kapoor</a></h3>
                                <span>Community & Content Manager</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Team End -->

    </main>

@endsection