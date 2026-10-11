<header class="header-page">
    {{-- <div class="header-page-shape header-page-shape-middle">
        <img src="assets/images/shapes/shape-18.png" alt="shape">
    </div> --}}
    <div class="container">
        <div class="header-page-content animate-on-scroll" data-animation="animate__fadeInDown">
            <h1>{{ $pageTitle }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                </ol>
            </nav>
        </div>
    </div>
</header>