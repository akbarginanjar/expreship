@extends('layouts.member')

@section('js')
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
        integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
        crossorigin=""></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.2/dist/css/select2.min.css" rel="stylesheet" />
@endsection


@section('content')
    @php
        use Illuminate\Support\Facades\Http;
        use App\Models\Tb_tentang;
        use App\Models\Tb_keuntungan;
        use App\Models\Tb_pertanyan;
        use App\Models\Produk;
        use App\Models\Tb_artikel;
        use App\Models\Tb_slide;
        use App\Models\Tb_galeri;
        use App\Models\Tb_video;
        use Illuminate\Support\Carbon;
        use App\Models\Tb_setting;
        use App\Models\KalenderKegiatan;

        $kalender = KalenderKegiatan::orderBy('created_at', 'asc')->get();
        if (isset($request->year)) {
            $year = $request->input('year');
            $kalender = KalenderKegiatan::whereYear('waktu_kegiatan', $year)->get();
        }
        $setting = Tb_setting::find(1);
        $tentang = Tb_tentang::find(1);
        $keuntungan = Tb_keuntungan::find(1);
        $pertanyaan = Tb_pertanyan::all();
        $artikel = Tb_artikel::orderBy('created_at', 'desc')->paginate(8);
        $berita = Tb_artikel::orderBy('created_at', 'desc')->where('id_kategori_konten', 3)->paginate(3);
        $slide = Tb_slide::orderBy('created_at', 'desc')->get();
        $galeri = Tb_galeri::orderBy('created_at', 'desc')->get();
        $video = Tb_video::orderBy('created_at', 'desc')->paginate(7);
    @endphp
    <!-- ======= Hero Section ======= -->
    <br><br><br>
    <div
        style="background: rgb(59,182,77);
background: linear-gradient(54deg, rgba(59,182,77,1) 27%, rgba(17,118,189,1) 100%);">
        <div class="container">
            <div class="row" data-aos="fade-up">
                <div class="col-sm-5">
                    <img src="{{ asset('images/driv.png') }}" class="img-fluid" alt="">
                </div>
                <div class="col-sm d-flex align-items-center justify-content-end">
                    <div class="card text-white mb-3" style="background: rgba(0, 0, 0, 0.24); border-radius: 20px;">
                        <div class="p-5">
                            <h1><b>Kirim Lebih Cepat Dengan Expreship</b></h1>
                            <div>Platform Pengiriman Instan</div>
                            <a href="" class="btn btn-lg btn-light mt-4 text--primary">Kirim Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <div class="container">
        <div class="row" data-aos="fade-up">
            <div class="col-sm">
                <div class="card border-0 mb-2 shadow text-white" style="background: #1176BD; border-radius: 20px;">
                    <div class="p-4">
                        <h4><b>Bisnis</b></h4>
                        Solusi pengiriman instan untuk semua bisnis <br><br>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card border-0 mb-2 shadow text-white" style="background: #1176BD; border-radius: 20px;">
                    <div class="p-4">
                        <h4><b>Personal</b></h4>
                        Terhubung dengan kurir pengiriman kapanpun dan dimanapun
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card border-0 mb-2 shadow text-white" style="background: #1176BD; border-radius: 20px;">
                    <div class="p-4">
                        <h4><b>Driver</b></h4>
                        Lakukan pengiriman bersama Expreship dengan waktu kerja yang fleksibel
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br><br><br>
    <div class="container" data-aos="fade-up">
        <!-- Tab Menu -->
        <center>
            <h3><b>Pengirimanmu InsyaAllah Aman, Cari Posisinya</b></h3>
            <div>Masukan kode resimu dan klik tombol lacak untuk melihat posisinya.</div>
        </center>
        <br><br>
        <div class="tab-menu">
            <button class="tab-link active me-2" onclick="openTab(event, 'Tab1')"><i class="bi bi-receipt me-1"></i> Cek
                Resi</button>
            <button class="tab-link ms-2" onclick="openTab(event, 'Tab2')"><i class="bi bi-cash-coin me-1"></i> Cek
                Ongkir</button>
        </div>

        <!-- Tab Content -->
        <div id="Tab1" class="tab-content">
            <center>
                <h5 class="mt-2"><b> Cek Resi</b></h5>
                <br>
                <div class="col-lg-5">
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="bi bi-receipt me-1"></i></span>
                        <input type="text" class="form-control" placeholder="No Resi" aria-describedby="addon-wrapping">
                    </div>
                    <button type="submit" class="btn w-100 text-white mt-2" style="background: #3bb64d;">Lacak</button>
                </div>
            </center>
        </div>

        <div id="Tab2" class="tab-content" style="display:none;" data-aos="fade-up">
            <center>
                <h5 class="mt-2"><b> Cek Ongkir</b></h5>
                <br>
                <div class="col-lg-5">
                    <div class="text-start mb-1 mt-2" style="font-size: 13px;">
                        Kecamatan Asal
                    </div>
                    <input type="text" class="form-control" placeholder="" aria-describedby="addon-wrapping">
                    <div class="text-start mb-1 mt-2" style="font-size: 13px;">
                        Kecamatan Tujuan
                    </div>
                    <input type="text" class="form-control" placeholder="" aria-describedby="addon-wrapping">
                    <div class="text-start mb-1 mt-2" style="font-size: 13px;">
                        Berat Barang
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="decrease" style="cursor: pointer;">-</span>
                        <span class="input-group-text" id="increase" style="cursor: pointer;">+</span>
                        <input type="text" class="form-control" id="quantity" value="0" aria-label="Amount">
                        <span class="input-group-text">Kg</span>
                    </div>
                    <button type="submit" class="btn w-100 text-white mt-1" style="background: #3bb64d;">Cek Harga</button>
                </div>
            </center>
        </div>
    </div>
    <br><br><br>
    <section id="services" class="services"
        style="background: #5de7723d; border-top-left-radius: 150px; border-top-right-radius: 150px;">

        <div class="container" data-aos="fade-up">

            <header class="section-header text-center">
                <p>Kenapa Expreship?</p>
                <h2 class="mt-3 text-dark">Berikut beberapa alasan tepat untuk memilih Expreship</h2>
            </header>

            <div class="row gy-4 mt-4">

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-box bg-white green" style="border-radius: 20px;">
                        <i class="bi bi-cash-coin icon"></i>
                        <h3 class="text-dark">Harga Murah</h3>
                        <p class="text-dark">Dengan skema biaya pengiriman yang terjangkau.</p>
                        <a href="#" class="read-more text-success"><span>Read More</span> <i
                                class="bi bi-arrow-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-box bg-white green" style="border-radius: 20px;">
                        <i class="bi bi-calendar2-day icon"></i>
                        <h3 class="text-dark">Adanya Paket Sameday</h3>
                        <p class="text-dark">Kiriman cepat dengan estimasi sampai di hari yang sama atau 8 jam pengiriman.
                        </p>
                        <a href="#" class="read-more text-success"><span>Read More</span> <i
                                class="bi bi-arrow-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-box bg-white green" style="border-radius: 20px;">
                        <i class="bi bi-calendar-week icon"></i>
                        <h3 class="text-dark">Adanya paket Reguler</h3>
                        <p class="text-dark">Paket akan tiba 1-2 Hari Kerja. (Hari Ahad dan tgl Merah tidak terhitung)</p>
                        <a href="#" class="read-more text-success"><span>Read More</span> <i
                                class="bi bi-arrow-right"></i></a>
                    </div>
                </div>

            </div>

        </div>

    </section>
    <section id="values" class="values"
        style="background: rgb(255,255,255);
background: linear-gradient(180deg, rgba(255,255,255,1) 32%, #1175bd31 100%);">

        <div class="container" data-aos="fade-up">

            <center>
                <h3><b>Layanan Expreship</b></h3>
                <div>Cepat. Mudah. Terjangkau.</div>
            </center>
            <br><br>

            <div class="row">

                <div class="col-lg" data-aos="fade-up" data-aos-delay="200">
                    <div class="box bg-white" style="border-radius: 20px;">
                        <img src="{{ asset('images/sameday.png') }}" class="" style="width: 350px;"
                            alt="">
                        <h3>Sameday</h3>
                        <p>Kiriman cepat dengan estimasi sampai di hari yang sama atau 8 jam pengiriman.</p>
                    </div>
                </div>

                <div class="col-lg mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="400">
                    <div class="box bg-white" style="border-radius: 20px;">
                        <img src="{{ asset('images/reguler.png') }}" class="" style="width: 350px;"
                            alt="">
                        <h3>Reguler</h3>
                        <p>Layanan pengiriman paket dengan tarif ekonomis estimasi tiba 1-2 hari.</p>
                    </div>
                </div>
            </div>

        </div>

    </section>

    <div style="background: rgb(255,255,255);
background: linear-gradient(0deg, rgba(255,255,255,1) 32%, #1175bd31 100%);">
        <div class="container">

            <div class="card border-0 shadow" style="border-radius: 20px;" data-aos="fade-up">
                <div class="card-body">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.5449116316972!2d107.6565309758133!3d-6.944861867988802!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e7e4b5dc7c15%3A0x579f78c01b2a8266!2sIcommits%20IT%20Consultant%20Indonesia!5e0!3m2!1sid!2sid!4v1724664071040!5m2!1sid!2sid"
                        allowfullscreen="" loading="lazy"
                        style="width: 100%; object-fit: cover; height: 400px; border-radius: 15px;"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <div class="container">
        <div class="card border-0 text-white"
            style="border-radius: 20px; background: rgb(59,182,77);
    background: linear-gradient(54deg, rgba(59,182,77,1) 27%, rgba(17,118,189,1) 100%);"
            data-aos="fade-up">
            <div class="p-5">
                <div class="row">
                    <div class="col-sm">
                        <h2><b>Siap lakukan pengiriman?</b></h2>
                        Download Expreship sekarang dan lakukan pengiriman ke berbagai tempat.
                    </div>
                    <div class="col-sm">
                        <img src="https://play.google.com/intl/en_us/badges/images/generic/en_badge_web_generic.png?hl=id"
                            width="200px;" style="float: right;" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // script.js
        function openTab(evt, tabName) {
            // Hide all tab content
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Remove the active class from all tab links
            tablinks = document.getElementsByClassName("tab-link");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Show the current tab and add the active class to the clicked tab link
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }
        // script.js
        document.addEventListener('DOMContentLoaded', function() {
            const decreaseButton = document.getElementById('decrease');
            const increaseButton = document.getElementById('increase');
            const quantityInput = document.getElementById('quantity');

            // Fungsi untuk mengurangi nilai
            decreaseButton.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                if (!isNaN(currentValue) && currentValue > 0) {
                    quantityInput.value = currentValue - 1;
                }
            });

            // Fungsi untuk menambah nilai
            increaseButton.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                if (!isNaN(currentValue)) {
                    quantityInput.value = currentValue + 1;
                }
            });
        });
    </script>
@endsection
