<div class="hero overlay" style="background-image: url({{ asset('home/images/hero1.jpg') }});">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 ml-auto">
                <h1 class="text-white">World Cup Event</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta, molestias repudiandae
                    pariatur.</p>
                <div id="date-countdown"></div>
                <p>
                    @auth
                    @if (Auth::user()->role == '0')
                    <a href="{{ route('0.dashboard') }}" class="btn btn-primary py-3 px-4 mr-3">Kembali
                        Kedashboard</a>
                    @else
                    <a href="{{ route('1.dashboard') }}" class="btn btn-primary py-3 px-4 mr-3">Kembali
                        Kedashboard</a>
                    @endif
                    @endauth
                    @guest
                    <a href="{{ route('register') }}" class="btn btn-primary py-3 px-4 mr-3">Pendaftaran</a>
                    <a href="{{ route('login') }}" class="more light">Masuk</a>
                    @endguest
                </p>
            </div>
        </div>
    </div>
</div>