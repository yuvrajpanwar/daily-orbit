@extends('admin/admin-layout/admin-app')

@push('css')
    <style>
        
        #qrImage svg {
            position: absolute;
            right: 0%;
            top: 19%;
            z-index: 10;
            height: 45%;
            width: 21.5%;
        }

        .button {
            border: 0px;
            height: 30px;
            outline: 0;
            color: white;
            font-size: 15px;
            font-weight: 400;
            line-height: 18.3px;
            background: #007413;
            cursor: pointer;
            border-radius: 0;
        }

        .promo-code {
            position: absolute;
            right: 23%;
            bottom: 7%;
            font-weight: bold;
            font-size: 0.6rem;
            line-height: normal;
            text-align: right;
            display: block;
            max-width: fit-content;
            min-width: fit-content;
            text-wrap: nowrap;
        }
    </style>
@endpush
@section('content')
    <div class="main-container">
        <div class="content">
            <div class="row container2">
                <div class="container-fluid m-4">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <a href="{{ route('admin.members') }}"><button class="btn btn-primary"> <i
                                        class="fe fe-16 fe-arrow-left"></i>All Members </button></a>
                        </div>
                    </div>
                </div>
                <div class="col-7">
                    <h1 class="page-title">Download QR Card</h1>

                    <p class="info">
                        Affiliate Link : <span style="color: blue">{{ $url }}</span><br>
                    </p>

                    <div class="mt-2">
                        <div class="ad-container d-flex py-4 " id="qrImage" style="position: relative;">
                            <img src="{{ asset('img/newqrcard.png') }}" alt="insternship" class="img-fluid">
                            {{ $qrCode }}
                            <div>

                            </div>
                            <div class="promo-code">
                                <p style="color: black;margin-bottom:0">Promo Code: {{$referralCode}}</p>
                                <p style="color: #8c0101;">Terms & Conditions apply&nbsp;&nbsp;</p>
                            </div>
                        </div>
                        <button class="btn button mt-1 mb-4" id="printButton">Download</button>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
    <script>
        document.getElementById('printButton').addEventListener('click', function() {
            var qrImageElement = document.getElementById('qrImage');
            var scale = 3; // Scale factor to improve resolution

            domtoimage.toPng(qrImageElement, {
                    quality: 1,
                    width: qrImageElement.offsetWidth * scale,
                    height: qrImageElement.offsetHeight * scale,
                    style: {
                        transform: 'scale(' + scale + ')',
                        transformOrigin: 'top left'
                    }
                })
                .then(function(dataUrl) {
                    var link = document.createElement('a');
                    link.href = dataUrl;
                    link.download = 'qr-image.png';
                    link.click();
                })
                .catch(function(error) {
                    console.error('Failed to download image:', error);
                });
        });

        // download promo banners
        document.getElementById('downloadButton1').addEventListener('click', function() {
            downloadImage('promo-banner-1');
        });
        document.getElementById('downloadButton2').addEventListener('click', function() {
            downloadImage('promo-banner-2');
        });

        function downloadImage(imageId) {
            const image = document.getElementById(imageId);
            const link = document.createElement('a');
            link.href = image.src;
            link.download = image.src.split('/').pop(); // Use the image filename as the download name
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
@endpush
