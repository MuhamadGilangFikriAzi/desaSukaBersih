<!DOCTYPE html>
<html>

<head>
    <title>Geerate PDF Surat</title>
    <style>
        @page {
            margin: 180px 50px;
        }

        .text {
            align-items: center;
            text-align: center;
        }

        .container {
            display: grid;
            align-items: center;
            grid-template-columns: 0.2fr 0.6fr;
            column-gap: 5px;
        }

        img {
            max-width: 100%;
            max-height: 100%;
        }

        text-align-center {
            text-align: center;
        }

        .text-align-right {
            float: right;
        }

        .text-align-left {
            float: left;
        }

        .img-header {
            /* opacity: .8; */
            /* background: transparant !important; */
            width: 200px;
            height: 150px;
        }

        .m-0 {
            margin: 0;
        }

        body {
            padding: 3px;
            /* margin-top: -150px; */
        }

        hr {
            border: none;
            height: 5px;
            color: #333;
            background-color: #333;
        }
    </style>
</head>

<body>
    <div id="header">
        <div class="container">
            <div class="image">
                <img src="{{ public_path('img/kab-logo.png') }}" class="img-header">
                {{-- <img src="{{ asset('img/kab-logo.png') }}" class="img-header"> --}}
                {{-- <img src="{{ URL('img/kab-logo.png') }}" class="img-header"> --}}

            </div>
            <div class="text">
                <p>
                <h3 class="m-0">PEMERINTAHAN KABUPATEN BEKASI</h3>
                <h3 class="m-0">KECAMATAN TAMBELANG</h3>
                <h1 class="m-0"><b>DESA SUKARAPIH</b></h1>
                <div class="m-0">
                    <h5 class="text-align-left m-0">Jln. Raya Tambelang - Sukarapih No. 02 TIP</h5>
                    <h5 class="text-align-right m-0">Kode Pos 17620</h5>
                </div>
                </p>

            </div>

        </div>
    </div>
    <hr>
    <div id="body">
        <h1 class="text-center"><u><b>{{ $jenisSurat }}</b></u></h1>
        <h4>{{ $codeSurat }}</h4>
        <p>
            {!! $bodySurat !!}
        </p>
    </div>
    <div id="footer"></div>
</body>

</html>
