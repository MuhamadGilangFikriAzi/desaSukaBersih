<!DOCTYPE html>
<html>

<head>
    <title>Geerate PDF Surat</title>
    <style>
        @page {
            margin: 0px;
        }

        body {
            margin: 1.5cm 1.5cm 1.5cm 2cm;
        }

        .container {
            clear: both;
            position: relative;
            height: 140px;
            /* margin-bottom: 150px; */
        }

        .container-left {
            position: absolute;
            left: 0pt;
            top: 20px;
            width: 192pt;
        }

        .container-right {
            text-align: center;
            position: absolute;
            left: 120pt;
            /* width: 192pt; */
            /* margin-right: 200pt; */
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            float: right;
        }

        .text-left {
            float: left;
        }

        .img-header {
            /* opacity: .8; */
            /* background: transparant !important; */
            width: 120px;
            height: 120px;
        }

        .m-0 {
            margin: 0;
        }

        hr {
            border: none;
            height: 5px;
            color: black;
            background-color: black;
        }

        .fs-12 {
            font-size: 16px;
        }

        .fs-14 {
            font-size: 19.2px;
        }

        .fs-16 {
            font-size: 22px;
        }

        .fs-20 {
            font-size: 26px;
        }

        .fs-24 {
            font-size: 32px;
        }

        .ff-times-new-roman {
            font-family: "Times New Roman", Times, serif;
        }

        .fw-bold {
            font-weight: bold
        }
    </style>
</head>

<body>
    <div id="header">
        <div class="container">
            <div class="container-left">
                <img src="{{ public_path('/img/kab-logo.png') }}" class="img-header">
                {{-- <img src="{{ asset('img/kab-logo.png') }}" class="img-header"> --}}
                {{-- <img src="{{ URL('img/kab-logo.png') }}" class="img-header"> --}}

            </div>
            <div class="container-right ff-times-new-roman">
                <p>
                    <span class="fs-14">
                        PEMERINTAHAN KABUPATEN BEKASI
                    </span><br>
                    <span class="fs-14">KECAMATAN TAMBELANG</span><br>
                    <span class="fs-24 fw-bold">DESA SUKA RAPIH</span><br>
                <div class="fs-1 m-0">
                    <h5 class="text-left m-0">Jln. Raya Tambelang - Sukarapih No. 02 TIP</h5>
                    <h5 class="text-right m-0">Kode Pos 17620</h5>
                </div>
                </p>

            </div>

        </div>
    </div>

    <div id="body">
        <hr>
        <div class="text-center fw-bold fs-14"><u>{{ $jenisSurat }}</u></div>
        <div class="text-center fs-14">{{ $codeSurat }}</div>
        <div class="">
            <p class="text-center fs-12">
                {!! $bodySurat !!}
            </p>
        </div>
    </div>
    <div id="footer"></div>
</body>

</html>
