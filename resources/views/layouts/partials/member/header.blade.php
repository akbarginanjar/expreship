  @php
      use App\Models\Tb_setting;
      use App\Models\Tb_menu;
      use App\Models\Tb_submenu;
      $setting = Tb_setting::find(1);
      $menu = Tb_menu::orderBy('urutan', 'asc')->get();
  @endphp
  <!-- ======= Header ======= -->
  <header id="header" class="bg-white fixed-top shadow">
      <div class="container p-3 d-flex align-items-center justify-content-between">


          {{-- <a href="/"> <img src="{{ asset('images/logo/logo.png') }}" class="" style="width: 300px"
                  height="50px" alt=""></a> --}}
          <a href="/" class="h4 mt-1"><b> EXPRESHIP </b></a>

          <nav id="navbar" class="navbar">
              <ul>
                  <li>
                      <a style="color: #1176BD;" class="nav-link scrollto" href="/">Beranda</a>
                  </li>
                  @foreach ($menu as $item)
                      @if ($item->id_konten == 0)
                          <li class="dropdown"><a style="color: #1176BD; font-size: 13px;"
                                  href="#"><span>{{ $item->nama }}</span>
                                  <i class="bi bi-chevron-down"></i></a>
                              <ul>
                                  <li>
                                      @php
                                          $submenu = Tb_submenu::orderBy('urutan', 'asc')
                                              ->where('id_menu', $item->id)
                                              ->get();
                                      @endphp
                                      @foreach ($submenu as $data)
                                          @if ($data->konten->link || $data->konten->link != null)
                                              <a href="{{ $data->konten->link->link }}"
                                                  style="color: #1176BD; font-size: 13px;"
                                                  class="dropdown-item {{ Request::is('') ? 'active text-warning' : '' }}">{{ $data->nama }}</a>
                                          @else
                                              <a href="/s=>{{ $data->slug }}"
                                                  style="color: #1176BD; font-size: 13px;">{{ $data->nama }}</a>
                                          @endif
                                      @endforeach
                                  </li>
                              </ul>
                          </li>
                      @else
                          @if ($item->konten->link || $item->konten->link != null)
                              <li>
                                  <a href="{{ $item->konten->link->link }}" style="color: #1176BD; font-size: 13px;"
                                      class="dropdown-item {{ Request::is('') ? 'active text-warning' : '' }}">{{ $item->nama }}</a>
                              </li>
                          @else
                              <li><a style="color: #1176BD; font-size: 13px;" class="nav-link scrollto"
                                      href="/m=>{{ $item->slug }} ">{{ $item->nama }}</a>
                              </li>
                          @endif
                      @endif
                  @endforeach
                  {{-- <li><a class="getstarted scrollto" href="/forum">Forum</a></li> --}}
              </ul>
              <i class="bi bi-list mobile-nav-toggle"></i>
          </nav><!-- .navbar -->

      </div>
  </header><!-- End Header -->
