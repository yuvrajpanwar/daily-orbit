@extends('layouts.app')

@push('css')
<style>
    .coming-soon-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin: 40px auto;
        /* max-width: 800px; */
        border: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .coming-soon-card:hover {
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        transform: translateY(-3px);
    }

    .coming-soon-header {
        background: linear-gradient(135deg, #ff4757 0%, #ff3838 100%);
        padding: 30px 20px;
        text-align: center;
        color: white;
    }

    .coming-soon-title {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .coming-soon-body {
        padding: 40px 30px;
        text-align: center;
    }

    .coming-soon-icon {
        font-size: 48px;
        color: #ff4757;
        margin-bottom: 20px;
    }

    .coming-soon-text {
        color: #2c3e50;
        font-size: 16px;
        line-height: 1.7;
        margin-bottom: 30px;
        font-weight: 500;
    }

    .btn-group {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-modern {
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        text-decoration: none;
        min-width: 140px;
        justify-content: center;
    }

    .btn-home {
        background: linear-gradient(135deg, #ff4757 0%, #ff3838 100%);
        color: white;
        border: none;
    }

    .btn-home:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(255, 71, 87, 0.3);
    }

    .btn-back {
        background: #f8f9fa;
        color: #2c3e50;
        border: 2px solid #e1e8ed;
    }

    .btn-back:hover {
        background: #e9ecef;
        border-color: #ff4757;
        color: #ff4757;
        transform: translateY(-2px);
    }

    .btn-modern i {
        transition: transform 0.3s ease;
    }

    .btn-modern:hover i {
        transform: translateX(3px);
    }

    @media (max-width: 576px) {
        .coming-soon-card {
            margin: 20px 15px;
            border-radius: 16px;
        }

        .coming-soon-header {
            padding: 25px 15px;
        }

        .coming-soon-title {
            font-size: 24px;
        }

        .coming-soon-body {
            padding: 30px 20px;
        }

        .btn-group {
            flex-direction: column;
            align-items: center;
        }

        .btn-modern {
            width: 100%;
            max-width: 200px;
        }
    }
</style>
@endpush

@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="coming-soon-card">
                <div class="coming-soon-header">
                    <h3 class="coming-soon-title">Coming Soon</h3>
                </div>
                <div class="coming-soon-body">
                    <div class="coming-soon-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <p class="coming-soon-text">
                        This feature is under development and will be available soon.
                    </p>
                    <div class="btn-group">
                        <a href="javascript:history.back()" class="btn-modern btn-back">
                            <i class="fas fa-arrow-left"></i> Go Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection