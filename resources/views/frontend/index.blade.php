@extends('layouts.main')

@section('title', 'RACAi Discipleship — Equipping Believers. Raising Leaders & Refining Destinies')

@section('content')

    <!-- header -->
    <header>
        <div id="rev_slider_26_1_wrapper" class="rev_slider_wrapper fullscreen-container header-revolution bg-black" data-alias="mask-showcase" data-source="gallery" style="background:#aaaaaa;padding:0px;">
            <!-- revolution slider -->
            <div id="rev_slider_26_1" class="rev_slider fullscreenbanner tiny_bullet_slider" style="display:none;" data-version="5.4.1">
                <ul>
                    <!-- slide 1 -->
                    <li data-index="rs-1" data-transition="zoomout" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="2000" data-thumb="" data-rotate="0" data-saveperformance="off" data-title="Slide">
                        <!-- main image -->
                        <img src="{{ asset('assets/images/index-1-header/header-hero-1.jpg') }}" class="bg-color" style='background:linear-gradient(90deg, rgba(134,143,150,1) 0%, rgba(89,97,100,1) 100%)' alt="RACAi Discipleship" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-no-retina data-bgparallax="10">
                        <!-- layers -->
                        <!-- layer nr. 1 -->
                        <div class="tp-caption header-overlay tp-shape tp-shapewrapper" 
                            id="slide-1-layer-1" 
                            data-x="['right','right','right','right']" data-hoffset="['0','0','0','0']" 
                            data-y="['top','top','top','top']" data-voffset="['0','0','0','0']" 
                            data-width="['1200']"
                            data-height="full"
                            data-whitespace="nowrap"
                            data-type="shape" 
                            data-basealign="slide" 
                            data-responsive_offset="on" 
                            data-responsive="off"
                            data-frames='[{"from":"opacity:0;","speed":1500,"to":"o:1;","delay":750,"ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"ease":"nothing"}]'
                            data-textAlign="['left','left','left','left']"
                            style="z-index: 5;background-image: linear-gradient(267deg, rgba(255, 255, 255, 0.9) 65%, rgba(255, 255, 255, 0.8) 72%, rgba(255, 255, 255, 0.8) 59%, transparent 87%);">
                        </div>
                        <!-- layer nr. 2 -->
                        <div class="tp-caption header-small-text tp-resizeme" 
                            id="slide-1-layer-2" 
                            data-x="['left','center','center','center']" data-hoffset="['800','0','0','0']" 
                            data-y="['middle','middle','middle','middle']" data-voffset="['-187','-177','-177','-200']" 
                            data-width="none"
                            data-fontsize="['17','17','15','14']"
                            data-height="none"
                            data-whitespace="nowrap"
                            data-type="text" 
                            data-responsive_offset="on" 
                            data-textAlign="['left','center','center','center']"
                            data-frames='[{"delay":750,"speed":750,"sfxcolor":"#0067da","sfx_effect":"blockfromleft","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#ffffff","sfx_effect":"blocktoleft","frame":"999","to":"z:0;","ease":"Power4.easeOut"}]'
                            data-paddingtop="[0,0,0,0]"
                            data-paddingright="[20,20,20,20]"
                            data-paddingbottom="[0,0,0,0]"
                            data-paddingleft="[20,20,20,20]"
                            style="z-index: 7; white-space: nowrap;"><i class="flaticon-open-book"></i> ROCK OF AGES CHRISTIAN ASSEMBLY INT'L
                        </div>
                        <!-- layer nr. 3 -->
                        <div class="tp-caption color-white header-title tp-resizeme" 
                            id="slide-1-layer-3" 
                            data-x="['left','center','center','center']" data-hoffset="['800','0','0','0']" 
                            data-y="['middle','middle','middle','middle']" data-voffset="['-50','-50','-50','-90']" 
                            data-fontsize="['80','70','70','45']"
                            data-lineheight="['90','70','70','60']"
                            data-width="['700','650','620','420']"
                            data-height="none"
                            data-whitespace="normal"
                            data-type="text" 
                            data-responsive_offset="on" 
                            data-frames='[{"delay":1000,"speed":750,"sfxcolor":"#0067da","sfx_effect":"blockfromleft","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#ffffff","sfx_effect":"blocktoleft","frame":"999","to":"z:0;","ease":"Power4.easeOut"}]'
                            data-textAlign="['left','center','center','center']"
                            data-paddingtop="[0,0,0,0]"
                            data-paddingright="[20,20,20,20]"
                            data-paddingbottom="[30,30,30,30]"
                            data-paddingleft="[20,20,20,20]"
                            style="z-index: 8; min-width: 650px; max-width: 650px; white-space: normal;">RACAi <span>Discipleship</span> 
                        </div>
                        <!-- layer nr.4 -->
                        <div class="tp-caption color-white header-paragraph tp-resizeme" 
                            id="slide-1-layer-4" 
                            data-x="['left','center','center','center']" data-hoffset="['800','0','0','0']" 
                            data-y="['middle','middle','middle','middle']" data-voffset="['80','60','60','30']" 
                            data-width="['700','650','620','380']"
                            data-lineheight="['30','30','30','30']"
                            data-fontsize="['20','20','16','15']"
                            data-height="none"
                            data-whitespace="normal"
                            data-type="text" 
                            data-responsive_offset="on"
                            data-frames='[{"delay":1500,"speed":750,"sfxcolor":"#0067da","sfx_effect":"blockfromleft","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#ffffff","sfx_effect":"blocktoleft","frame":"999","to":"z:0;","ease":"Power4.easeOut"}]'
                            data-textAlign="['left','center','center','center']"
                            data-paddingtop="[0,0,0,0]"
                            data-paddingright="[20,20,20,20]"
                            data-paddingbottom="[0,0,0,0]"
                            data-paddingleft="[20,20,20,20]"
                            style="z-index: 7; white-space: normal;">Equipping Believers. Raising Leaders &amp; Refining Destinies. Grow in the Word, develop your gifts, and strengthen your leadership.
                        </div>
                        <!-- layer nr. 5 -->
                        <div class="tp-caption main-btn btn tp-resizeme" 
                            id="slide-1-layer-5" 
                            data-x="['left','center','left','left']" data-hoffset="['820','-110','160','25']" 
                            data-y="['middle','middle','middle','middle']" data-voffset="['170','150','150','130']" 
                            data-width="none"
                            data-height="none"
                            data-whitespace="nowrap"
                            data-type="button" 
                            data-responsive_offset="on"
                            data-frames='[{"delay":1800,"speed":1000,"sfxcolor":"#0067da","sfx_effect":"blockfromleft","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#ffffff","sfx_effect":"blocktoleft","frame":"999","to":"z:0;","ease":"Power4.easeOut"},{"frame":"hover","speed":"0","ease":"Linear.easeNone","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgb(0,0,0);bg:rgb(255,255,255);"}]'
                            data-textAlign="['inherit','inherit','inherit','inherit']"
                            data-paddingtop="[10,0,0,0]"
                            data-paddingright="[25,30,30,30]"
                            data-paddingbottom="[10,0,0,0]"
                            data-paddingleft="[25,30,30,30]"
                            style="z-index: 5; white-space: nowrap; line-height: 50px; letter-spacing: 0">
                            @auth
                                <a href="{{ route('student.dashboard') }}">GO TO DASHBOARD <i class="flaticon-right-arrow"></i></a>
                            @else
                                <a href="{{ route('register') }}">START LEARNING <i class="flaticon-right-arrow"></i></a>
                            @endauth
                        </div>
                        <!-- layer nr. 6 -->
                        <div class="tp-caption main-btn btn btn-white tp-resizeme" 
                            id="slide-1-layer-6" 
                            data-x="['left','center','left','left']" data-hoffset="['1060','120','410','260']" 
                            data-y="['middle','middle','middle','middle']" data-voffset="['170','150','150','130']" 
                            data-width="none"
                            data-height="none"
                            data-whitespace="nowrap"
                            data-type="button" 
                            data-responsive_offset="on"
                            data-frames='[{"delay":2100,"speed":1000,"sfxcolor":"#0067da","sfx_effect":"blockfromleft","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#ffffff","sfx_effect":"blocktoleft","frame":"999","to":"z:0;","ease":"Power4.easeOut"},{"frame":"hover","speed":"0","ease":"Linear.easeNone","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgb(255,255,255);bg:rgb(0,103,218);"}]'
                            data-textAlign="['inherit','inherit','inherit','inherit']"
                            data-paddingtop="[10,0,0,0]"
                            data-paddingright="[25,30,30,30]"
                            data-paddingbottom="[10,0,0,0]"
                            data-paddingleft="[25,30,30,30]"
                            style="z-index: 5; white-space: nowrap; line-height: 50px; letter-spacing: 0"><a href="{{ route('courses.index') }}">EXPLORE COURSES <i class="flaticon-online-learning"></i></a>
                        </div>
                    </li>
                    <!-- slide 2 -->
                    <li data-index="rs-2" class="bg-color" data-transition="zoomout" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="2000" data-thumb="" data-rotate="0" data-saveperformance="off" data-title="Slide">
                        <!-- main image -->
                        <img src="{{ asset('assets/images/index-1-header/header-hero-2.jpg') }}" class="bg-color" style='background:linear-gradient(90deg, rgba(134,143,150,1) 0%, rgba(89,97,100,1) 100%)' alt="RACAi Discipleship" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-no-retina data-bgparallax="10">
                        <!-- layers -->
                        <!-- layer nr. 1 -->
                        <div class="tp-caption header-overlay bg-color tp-shape tp-shapewrapper" 
                            id="slide-2-layer-1" 
                            data-x="['left','left','left','left']" data-hoffset="['0','0','0','0']" 
                            data-y="['top','top','top','top']" data-voffset="['0','0','0','0']" 
                            data-width="['1200']"
                            data-height="full"
                            data-whitespace="nowrap"
                            data-type="shape" 
                            data-basealign="slide" 
                            data-responsive_offset="on" 
                            data-responsive="off"
                            data-frames='[{"from":"opacity:0;","speed":1500,"to":"o:1;","delay":750,"ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"ease":"nothing"}]'
                            data-textAlign="['left','left','left','left']"
                            style="z-index: 5;background-image: linear-gradient(90deg, rgba(255, 255, 255, 0.9) 65%, rgba(255, 255, 255, 0.8) 72%, rgba(255, 255, 255, 0.8) 59%, transparent 87%);">
                        </div>
                        <!-- layer nr. 2 -->
                        <div class="tp-caption header-small-text tp-resizeme" 
                            id="slide-2-layer-2" 
                            data-x="['right','center','center','center']" data-hoffset="['800','0','0','0']" 
                            data-y="['middle','middle','middle','middle']" data-voffset="['-187','-177','-177','-200']" 
                            data-width="none"
                            data-fontsize="['17','17','15','14']"
                            data-height="none"
                            data-whitespace="nowrap"
                            data-type="text" 
                            data-responsive_offset="on" 
                            data-textAlign="['right','center','center','center']"
                            data-frames='[{"delay":750,"speed":750,"sfxcolor":"#0067da","sfx_effect":"blockfromright","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#ffffff","sfx_effect":"blocktoright","frame":"999","to":"z:0;","ease":"Power4.easeOut"}]'
                            data-paddingtop="[0,0,0,0]"
                            data-paddingright="[20,20,20,20]"
                            data-paddingbottom="[0,0,0,0]"
                            data-paddingleft="[20,20,20,20]"
                            style="z-index: 7; white-space: nowrap;"><i class="flaticon-open-book"></i> GROW BEYOND SUNDAY
                        </div>
                        <!-- layer nr. 3 -->
                        <div class="tp-caption color-white header-title tp-resizeme" 
                            id="slide-2-layer-3" 
                            data-x="['right','center','center','center']" data-hoffset="['800','0','0','0']" 
                            data-y="['middle','middle','middle','middle']" data-voffset="['-50','-50','-50','-90']" 
                            data-fontsize="['80','70','70','45']"
                            data-lineheight="['80','70','70','60']"
                            data-width="['700','650','620','420']"
                            data-height="none"
                            data-whitespace="normal"
                            data-type="text" 
                            data-responsive_offset="on" 
                            data-frames='[{"delay":1000,"speed":750,"sfxcolor":"#0067da","sfx_effect":"blockfromright","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#ffffff","sfx_effect":"blocktoright","frame":"999","to":"z:0;","ease":"Power4.easeOut"}]'
                            data-textAlign="['right','center','center','center']"
                            data-paddingtop="[0,0,0,0]"
                            data-paddingright="[20,20,20,20]"
                            data-paddingbottom="[30,30,30,30]"
                            data-paddingleft="[20,20,20,20]"
                            style="z-index: 8; min-width: 650px; max-width: 650px; white-space: normal;">Equip <span>Believers</span> &amp; Lead <span>Effectively</span>
                        </div>
                        <!-- layer nr.4 -->
                        <div class="tp-caption color-white header-paragraph tp-resizeme" 
                            id="slide-2-layer-4" 
                            data-x="['right','center','center','center']" data-hoffset="['800','0','0','0']" 
                            data-y="['middle','middle','middle','middle']" data-voffset="['80','60','60','30']" 
                            data-width="['700','650','620','380']"
                            data-lineheight="['30','30','30','30']"
                            data-fontsize="['20','20','16','15']"
                            data-height="none"
                            data-whitespace="normal"
                            data-type="text" 
                            data-responsive_offset="on"
                            data-frames='[{"delay":1500,"speed":750,"sfxcolor":"#0067da","sfx_effect":"blockfromright","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#ffffff","sfx_effect":"blocktoright","frame":"999","to":"z:0;","ease":"Power4.easeOut"}]'
                            data-textAlign="['right','center','center','center']"
                            data-paddingtop="[0,0,0,0]"
                            data-paddingright="[20,20,20,20]"
                            data-paddingbottom="[0,0,0,0]"
                            data-paddingleft="[20,20,20,20]"
                            style="z-index: 7; white-space: normal;">Access structured biblical teaching and practical discipleship designed to help you grow consistently in your walk with God.
                        </div>
                        <!-- layer nr. 5 -->
                        <div class="tp-caption main-btn btn tp-resizeme" 
                            id="slide-2-layer-5" 
                            data-x="['left','center','left','left']" data-hoffset="['260','-110','160','25']" 
                            data-y="['middle','middle','middle','middle']" data-voffset="['170','150','150','130']" 
                            data-width="none"
                            data-height="none"
                            data-whitespace="nowrap"
                            data-type="button" 
                            data-responsive_offset="on" 
                            data-frames='[{"delay":1800,"speed":1000,"sfxcolor":"#0067da","sfx_effect":"blockfromright","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#ffffff","sfx_effect":"blocktoright","frame":"999","to":"z:0;","ease":"Power4.easeOut"},{"frame":"hover","speed":"0","ease":"Linear.easeNone","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgb(0,0,0);bg:rgb(255,255,255);"}]'
                            data-textAlign="['inherit','inherit','inherit','inherit']"
                            data-paddingtop="[10,0,0,0]"
                            data-paddingright="[25,30,30,30]"
                            data-paddingbottom="[10,0,0,0]"
                            data-paddingleft="[25,30,30,30]"
                            style="z-index: 5; white-space: nowrap; line-height: 50px; letter-spacing: 0">
                            @auth
                                <a href="{{ route('student.dashboard') }}">GO TO DASHBOARD <i class="flaticon-right-arrow"></i></a>
                            @else
                                <a href="{{ route('register') }}">START LEARNING <i class="flaticon-right-arrow"></i></a>
                            @endauth
                        </div>
                        <!-- layer nr. 6 -->
                        <div class="tp-caption main-btn btn btn-white tp-resizeme" 
                            id="slide-2-layer-6" 
                            data-x="['left','center','left','left']" data-hoffset="['485','120','410','260']" 
                            data-y="['middle','middle','middle','middle']" data-voffset="['170','150','150','130']" 
                            data-width="none"
                            data-height="none"
                            data-whitespace="nowrap"
                            data-type="button" 
                            data-responsive_offset="on" 
                            data-frames='[{"delay":2100,"speed":1000,"sfxcolor":"#0067da","sfx_effect":"blockfromright","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#ffffff","sfx_effect":"blocktoright","frame":"999","to":"z:0;","ease":"Power4.easeOut"},{"frame":"hover","speed":"0","ease":"Linear.easeNone","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgb(255,255,255);bg:rgb(0,103,218);"}]'
                            data-textAlign="['inherit','inherit','inherit','inherit']"
                            data-paddingtop="[10,0,0,0]"
                            data-paddingright="[25,30,30,30]"
                            data-paddingbottom="[10,0,0,0]"
                            data-paddingleft="[25,30,30,30]"
                            style="z-index: 5; white-space: nowrap; line-height: 50px; letter-spacing: 0"><a href="{{ route('courses.index') }}">EXPLORE COURSES <i class="flaticon-online-learning"></i></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- .end revolution slider -->
    </header>
    <!-- .end header -->


    <!-- GROW BEYOND SUNDAY SECTION -->
    <section class="py-5 bg-off-white position-relative overflow-hidden" id="grow-beyond">
        <div class="container py-4">
            <div class="row align-items-center g-5">
                <div class="col-12 col-lg-6 animate-on-scroll" data-animation="animate__fadeInLeft">
                    <span class="text-uppercase text-primary fw-bold letter-spacing-2 small d-block mb-2">Intentional Christian Growth</span>
                    <h2 class="display-5 fw-bold text-dark mb-4">
                        Grow Beyond <span class="text-primary">Sunday</span>
                    </h2>
                    <p class="fs-5 text-secondary mb-4" style="line-height: 1.8;">
                        Your spiritual growth shouldn't stop when the service ends.
                    </p>
                    <p class="text-muted mb-4 fs-6" style="line-height: 1.8;">
                        <strong>RACAi Discipleship</strong> gives you access to structured teaching and practical Discipleship designed to help you grow consistently in your walk with God and your assignment.
                    </p>

                    <div class="mantra-strip p-3 rounded-3 bg-white shadow-sm border mb-4 animate-on-scroll" data-animation="animate__fadeInUp">
                        <div class="row text-center g-2">
                            <div class="col-3 border-end">
                                <span class="d-block fw-bold text-primary fs-5">Learn.</span>
                                <span class="text-muted small">The Truth</span>
                            </div>
                            <div class="col-3 border-end">
                                <span class="d-block fw-bold text-success fs-5">Grow.</span>
                                <span class="text-muted small">In Grace</span>
                            </div>
                            <div class="col-3 border-end">
                                <span class="d-block fw-bold text-warning fs-5">Serve.</span>
                                <span class="text-muted small">The Body</span>
                            </div>
                            <div class="col-3">
                                <span class="d-block fw-bold text-danger fs-5">Lead.</span>
                                <span class="text-muted small">With Purpose</span>
                            </div>
                        </div>
                    </div>

                    @auth
                        <a href="{{ route('student.dashboard') }}" class="btn main-btn">
                            Access Your Learning Dashboard <i class="flaticon-right-arrow ms-1"></i>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn main-btn">
                            Begin Your Spiritual Journey <i class="flaticon-right-arrow ms-1"></i>
                        </a>
                    @endauth
                </div>

                <div class="col-12 col-lg-6 animate-on-scroll" data-animation="animate__fadeInRight">
                    <div class="row g-3 stagger-group">
                        <div class="col-6 animate-on-scroll" data-animation="animate__zoomIn">
                            <div class="p-4 bg-white rounded-4 shadow-sm border h-100 hover-lift">
                                <div class="pillar-icon bg-blue-subtle text-primary mb-3">
                                    <i class="flaticon-open-book fs-3"></i>
                                </div>
                                <h4 class="h5 fw-bold text-dark mb-2">Learn</h4>
                                <p class="text-muted small mb-0">Ground yourself in deep scriptural understanding and kingdom principles.</p>
                            </div>
                        </div>
                        <div class="col-6 animate-on-scroll" data-animation="animate__zoomIn">
                            <div class="p-4 bg-white rounded-4 shadow-sm border h-100 hover-lift">
                                <div class="pillar-icon bg-green-subtle text-success mb-3">
                                    <i class="flaticon-reading fs-3"></i>
                                </div>
                                <h4 class="h5 fw-bold text-dark mb-2">Grow</h4>
                                <p class="text-muted small mb-0">Develop spiritual disciplines, character, and prayer consistency.</p>
                            </div>
                        </div>
                        <div class="col-6 animate-on-scroll" data-animation="animate__zoomIn">
                            <div class="p-4 bg-white rounded-4 shadow-sm border h-100 hover-lift">
                                <div class="pillar-icon bg-amber-subtle text-warning mb-3">
                                    <i class="flaticon-satisfaction fs-3"></i>
                                </div>
                                <h4 class="h5 fw-bold text-dark mb-2">Serve</h4>
                                <p class="text-muted small mb-0">Deploy your God-given spiritual gifts to build up the church and society.</p>
                            </div>
                        </div>
                        <div class="col-6 animate-on-scroll" data-animation="animate__zoomIn">
                            <div class="p-4 bg-white rounded-4 shadow-sm border h-100 hover-lift">
                                <div class="pillar-icon bg-purple-subtle text-danger mb-3">
                                    <i class="flaticon-web fs-3"></i>
                                </div>
                                <h4 class="h5 fw-bold text-dark mb-2">Lead</h4>
                                <p class="text-muted small mb-0">Influence your sphere with righteousness, excellence, and vision.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- .end GROW BEYOND SUNDAY SECTION -->


    <!-- WHAT YOU CAN LEARN SECTION -->
    <section class="py-5 bg-white position-relative" id="discipleship">
        <div class="container py-4">
            <div class="text-center max-w-700-px mx-auto mb-5 animate-on-scroll" data-animation="animate__fadeInDown">
                <span class="text-uppercase text-primary fw-bold letter-spacing-2 small d-block mb-2">Curriculum &amp; Focus Areas</span>
                <h2 class="display-6 fw-bold text-dark mb-3">
                    What You <span class="text-primary">Can Learn</span>
                </h2>
                <p class="text-muted fs-6">
                    A comprehensive spiritual curriculum designed to refine your character, clarify your destiny, and prepare you for impactful kingdom service.
                </p>
            </div>

            <div class="row g-4 stagger-group">
                <!-- 1. Biblical Foundation -->
                <div class="col-12 col-md-6 col-lg-4 animate-on-scroll" data-animation="animate__fadeInUp">
                    <div class="card h-100 border-0 shadow-sm rounded-4 stream-card p-4 hover-lift">
                        <div class="stream-card-header d-flex align-items-center gap-3 mb-3">
                            <div class="stream-emoji">📖</div>
                            <div>
                                <h3 class="h5 fw-bold text-dark mb-1">Biblical Foundation</h3>
                                <span class="badge bg-primary-soft text-primary small">Doctrine &amp; Scriptures</span>
                            </div>
                        </div>
                        <p class="text-secondary small mb-0" style="line-height: 1.7;">
                            Build a strong foundation in God's Word and understand how to apply biblical principles to everyday life.
                        </p>
                    </div>
                </div>

                <!-- 2. Discipleship -->
                <div class="col-12 col-md-6 col-lg-4 animate-on-scroll" data-animation="animate__fadeInUp">
                    <div class="card h-100 border-0 shadow-sm rounded-4 stream-card p-4 hover-lift">
                        <div class="stream-card-header d-flex align-items-center gap-3 mb-3">
                            <div class="stream-emoji">🙏</div>
                            <div>
                                <h3 class="h5 fw-bold text-dark mb-1">Discipleship</h3>
                                <span class="badge bg-success-soft text-success small">Spiritual Maturity</span>
                            </div>
                        </div>
                        <p class="text-secondary small mb-0" style="line-height: 1.7;">
                            Develop spiritual maturity through structured discipleship and intentional Christian growth.
                        </p>
                    </div>
                </div>

                <!-- 3. Leadership -->
                <div class="col-12 col-md-6 col-lg-4 animate-on-scroll" data-animation="animate__fadeInUp" id="leadership">
                    <div class="card h-100 border-0 shadow-sm rounded-4 stream-card p-4 hover-lift">
                        <div class="stream-card-header d-flex align-items-center gap-3 mb-3">
                            <div class="stream-emoji">👑</div>
                            <div>
                                <h3 class="h5 fw-bold text-dark mb-1">Leadership</h3>
                                <span class="badge bg-warning-soft text-warning small">Influence &amp; Vision</span>
                            </div>
                        </div>
                        <p class="text-secondary small mb-0" style="line-height: 1.7;">
                            Learn how to lead yourself, influence others, and serve effectively in God's Kingdom.
                        </p>
                    </div>
                </div>

                <!-- 4. Purpose & Calling -->
                <div class="col-12 col-md-6 col-lg-4 animate-on-scroll" data-animation="animate__fadeInUp">
                    <div class="card h-100 border-0 shadow-sm rounded-4 stream-card p-4 hover-lift">
                        <div class="stream-card-header d-flex align-items-center gap-3 mb-3">
                            <div class="stream-emoji">🎯</div>
                            <div>
                                <h3 class="h5 fw-bold text-dark mb-1">Purpose &amp; Calling</h3>
                                <span class="badge bg-info-soft text-info small">Destiny Refinement</span>
                            </div>
                        </div>
                        <p class="text-secondary small mb-0" style="line-height: 1.7;">
                            Discover your gifts, understand your assignment, and develop the discipline to pursue God's purpose.
                        </p>
                    </div>
                </div>

                <!-- 5. Life & Career -->
                <div class="col-12 col-md-6 col-lg-4 animate-on-scroll" data-animation="animate__fadeInUp">
                    <div class="card h-100 border-0 shadow-sm rounded-4 stream-card p-4 hover-lift">
                        <div class="stream-card-header d-flex align-items-center gap-3 mb-3">
                            <div class="stream-emoji">💼</div>
                            <div>
                                <h3 class="h5 fw-bold text-dark mb-1">Life &amp; Career</h3>
                                <span class="badge bg-purple-soft text-purple small">Practical Wisdom</span>
                            </div>
                        </div>
                        <p class="text-secondary small mb-0" style="line-height: 1.7;">
                            Gain practical wisdom for work, business, relationships, finances, and everyday life.
                        </p>
                    </div>
                </div>

                <!-- 6. Ministry Discipleship -->
                <div class="col-12 col-md-6 col-lg-4 animate-on-scroll" data-animation="animate__fadeInUp">
                    <div class="card h-100 border-0 shadow-sm rounded-4 stream-card p-4 hover-lift">
                        <div class="stream-card-header d-flex align-items-center gap-3 mb-3">
                            <div class="stream-emoji">⛪</div>
                            <div>
                                <h3 class="h5 fw-bold text-dark mb-1">Ministry Discipleship</h3>
                                <span class="badge bg-danger-soft text-danger small">Church Equipping</span>
                            </div>
                        </div>
                        <p class="text-secondary small mb-0" style="line-height: 1.7;">
                            Develop the knowledge and skills required to serve effectively within the church.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- .end WHAT YOU CAN LEARN SECTION -->


    <!-- LEARNING JOURNEY DESIGNED FOR YOU -->
    <section class="py-5 bg-off-white position-relative" id="journey">
        <div class="container py-4">
            <div class="text-center max-w-700-px mx-auto mb-5 animate-on-scroll" data-animation="animate__fadeInDown">
                <span class="text-uppercase text-primary fw-bold letter-spacing-2 small d-block mb-2">Step-By-Step Pathway</span>
                <h2 class="display-6 fw-bold text-dark mb-3">
                    A Learning Journey <span class="text-primary">Designed For You</span>
                </h2>
                <p class="text-muted fs-6">
                    A clear, self-paced roadmap built to accompany you from your first step in faith to mature leadership and ministry service.
                </p>
            </div>

            <div class="row g-4 position-relative stagger-group">
                <!-- 01 Start -->
                <div class="col-12 col-md-6 col-lg-3 animate-on-scroll" data-animation="animate__fadeInUp">
                    <div class="journey-card bg-white p-4 rounded-4 shadow-sm h-100 border hover-lift">
                        <div class="step-badge mb-3">01</div>
                        <h4 class="h5 fw-bold text-dark mb-2">Start</h4>
                        <p class="text-muted small mb-0" style="line-height: 1.6;">
                            Create your RACAi Discipleship account and discover available courses.
                        </p>
                    </div>
                </div>

                <!-- 02 Learn -->
                <div class="col-12 col-md-6 col-lg-3 animate-on-scroll" data-animation="animate__fadeInUp">
                    <div class="journey-card bg-white p-4 rounded-4 shadow-sm h-100 border hover-lift">
                        <div class="step-badge mb-3">02</div>
                        <h4 class="h5 fw-bold text-dark mb-2">Learn</h4>
                        <p class="text-muted small mb-0" style="line-height: 1.6;">
                            Watch teachings, study materials, and complete structured lessons at your own pace.
                        </p>
                    </div>
                </div>

                <!-- 03 Grow -->
                <div class="col-12 col-md-6 col-lg-3 animate-on-scroll" data-animation="animate__fadeInUp">
                    <div class="journey-card bg-white p-4 rounded-4 shadow-sm h-100 border hover-lift">
                        <div class="step-badge mb-3">03</div>
                        <h4 class="h5 fw-bold text-dark mb-2">Grow</h4>
                        <p class="text-muted small mb-0" style="line-height: 1.6;">
                            Complete assessments, activities, and discipleship milestones.
                        </p>
                    </div>
                </div>

                <!-- 04 Serve -->
                <div class="col-12 col-md-6 col-lg-3 animate-on-scroll" data-animation="animate__fadeInUp">
                    <div class="journey-card bg-white p-4 rounded-4 shadow-sm h-100 border hover-lift">
                        <div class="step-badge mb-3">04</div>
                        <h4 class="h5 fw-bold text-dark mb-2">Serve</h4>
                        <p class="text-muted small mb-0" style="line-height: 1.6;">
                            Put what you've learned into practice and become better equipped to serve.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- .end LEARNING JOURNEY DESIGNED FOR YOU -->


    <!-- BUILT AROUND THE WORD SECTION -->
    <section class="py-5 bg-blue text-white position-relative overflow-hidden" id="word">
        <div class="container py-4 position-relative" style="z-index: 2;">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-lg-10 text-center">
                    <div class="scripture-badge mb-4 animate-on-scroll" data-animation="animate__fadeInDown">
                        <i class="flaticon-book-of-black-cover-closed me-2"></i> Scriptural Anchor
                    </div>
                    
                    <h2 class="display-6 fw-bold mb-4 text-white animate-on-scroll" data-animation="animate__fadeInUp">Built Around the Word</h2>

                    <div class="scripture-card mx-auto p-4 p-md-5 rounded-4 mb-4 animate-on-scroll" data-animation="animate__zoomIn">
                        <i class="flaticon-quote fs-1 text-light-gold mb-3 d-block"></i>
                        <p class="scripture-quote display-6 fst-italic mb-3 fw-normal text-white" style="font-size: calc(1.3rem + 0.8vw); line-height: 1.6;">
                            “Study to shew thyself approved unto God, a workman that needeth not to be ashamed, rightly dividing the word of truth.”
                        </p>
                        <cite class="fs-5 fw-bold text-light-gold d-block">— 2 Timothy 2:15</cite>
                    </div>

                    <p class="fs-5 text-white-90 max-w-700-px mx-auto mb-4 animate-on-scroll" data-animation="animate__fadeInUp" style="line-height: 1.8;">
                        RACAi Discipleship is designed to make biblical learning 
                        <strong class="text-gold">accessible, structured, practical, and consistent.</strong>
                    </p>

                    <div class="d-flex flex-wrap justify-content-center gap-3 animate-on-scroll" data-animation="animate__fadeInUp">
                        <span class="badge bg-white-20 text-white px-3 py-2 rounded-pill fs-6"><i class="flaticon-checked me-1 text-gold"></i> Accessible Anytime</span>
                        <span class="badge bg-white-20 text-white px-3 py-2 rounded-pill fs-6"><i class="flaticon-checked me-1 text-gold"></i> Structured Curriculum</span>
                        <span class="badge bg-white-20 text-white px-3 py-2 rounded-pill fs-6"><i class="flaticon-checked me-1 text-gold"></i> Practical Application</span>
                        <span class="badge bg-white-20 text-white px-3 py-2 rounded-pill fs-6"><i class="flaticon-checked me-1 text-gold"></i> Consistent Growth</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- .end BUILT AROUND THE WORD SECTION -->


    <!-- FOR EVERY STAGE OF YOUR JOURNEY -->
    <section class="py-5 bg-white position-relative" id="stages">
        <div class="container py-4">
            <div class="text-center max-w-700-px mx-auto mb-5 animate-on-scroll" data-animation="animate__fadeInDown">
                <span class="text-uppercase text-primary fw-bold letter-spacing-2 small d-block mb-2">Tailored Discipleship</span>
                <h2 class="display-6 fw-bold text-dark mb-3">
                    For Every Stage of <span class="text-primary">Your Journey</span>
                </h2>
                <p class="text-muted fs-6">
                    Wherever you are in your spiritual walk, there is a dedicated track to strengthen and elevate your faith.
                </p>
            </div>

            <div class="row g-4 stagger-group">
                <!-- 1. New Believers -->
                <div class="col-12 col-md-6 col-lg-3 animate-on-scroll" data-animation="animate__fadeInUp">
                    <div class="stage-card p-4 rounded-4 border h-100 text-center hover-lift">
                        <div class="stage-icon-wrap bg-blue-subtle text-primary mx-auto mb-3">
                            <i class="flaticon-reading fs-3"></i>
                        </div>
                        <h3 class="h5 fw-bold text-dark mb-2">New Believers</h3>
                        <p class="text-muted small mb-0" style="line-height: 1.6;">
                            Build the foundation for your Christian walk.
                        </p>
                    </div>
                </div>

                <!-- 2. Growing Believers -->
                <div class="col-12 col-md-6 col-lg-3 animate-on-scroll" data-animation="animate__fadeInUp">
                    <div class="stage-card p-4 rounded-4 border h-100 text-center hover-lift">
                        <div class="stage-icon-wrap bg-green-subtle text-success mx-auto mb-3">
                            <i class="flaticon-open-book fs-3"></i>
                        </div>
                        <h3 class="h5 fw-bold text-dark mb-2">Growing Believers</h3>
                        <p class="text-muted small mb-0" style="line-height: 1.6;">
                            Go deeper in the Word and develop spiritual maturity.
                        </p>
                    </div>
                </div>

                <!-- 3. Leaders -->
                <div class="col-12 col-md-6 col-lg-3 animate-on-scroll" data-animation="animate__fadeInUp">
                    <div class="stage-card p-4 rounded-4 border h-100 text-center hover-lift">
                        <div class="stage-icon-wrap bg-amber-subtle text-warning mx-auto mb-3">
                            <i class="flaticon-satisfaction fs-3"></i>
                        </div>
                        <h3 class="h5 fw-bold text-dark mb-2">Leaders</h3>
                        <p class="text-muted small mb-0" style="line-height: 1.6;">
                            Develop the character, knowledge, and skills required to lead.
                        </p>
                    </div>
                </div>

                <!-- 4. Ministers & Workers -->
                <div class="col-12 col-md-6 col-lg-3 animate-on-scroll" data-animation="animate__fadeInUp">
                    <div class="stage-card p-4 rounded-4 border h-100 text-center hover-lift">
                        <div class="stage-icon-wrap bg-purple-subtle text-danger mx-auto mb-3">
                            <i class="flaticon-instructions fs-3"></i>
                        </div>
                        <h3 class="h5 fw-bold text-dark mb-2">Ministers &amp; Workers</h3>
                        <p class="text-muted small mb-0" style="line-height: 1.6;">
                            Strengthen your capacity to serve God's people effectively.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- .end FOR EVERY STAGE OF YOUR JOURNEY -->


    <!-- FEATURED DYNAMIC COURSES CATALOG -->
    <section class="py-5 bg-off-white position-relative" id="courses">
        <div class="container py-4">
            <div class="d-flex flex-wrap align-items-end justify-content-between mb-5 animate-on-scroll" data-animation="animate__fadeInDown">
                <div>
                    <span class="text-uppercase text-primary fw-bold letter-spacing-2 small d-block mb-2">Equipping &amp; Discipleship</span>
                    <h2 class="display-6 fw-bold text-dark mb-1">
                        Our Latest <span class="text-primary">Courses</span>
                    </h2>
                    <p class="text-muted mb-0">Practical teachings to deepen your biblical knowledge and leadership capacity.</p>
                </div>
                <div class="mt-3 mt-md-0">
                    <a href="{{ route('courses.index') }}" class="btn btn-outline-primary fw-semibold px-4 py-2">
                        View All Courses <i class="flaticon-right-arrow ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="row g-4 stagger-group">
                @forelse($courses as $course)
                    <div class="col-12 col-md-6 col-lg-4 animate-on-scroll" data-animation="animate__fadeInUp" data-delay="{{ ($loop->index % 3) * 0.15 }}s">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden course-racai-card">
                            <div class="position-relative course-thumb-wrap">
                                <a href="{{ route('courses.show', $course->slug) }}">
                                    <img src="{{ $course->thumbnail ? asset($course->thumbnail) : asset('assets/images/courses/course-image-' . (($loop->index % 16) + 1) . '.jpg') }}" 
                                         alt="{{ $course->title }}" 
                                         class="w-100 course-thumb-img" 
                                         onerror="this.src='{{ asset('assets/images/courses/course-image-1.jpg') }}'">
                                </a>
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-gold text-dark fw-bold px-3 py-2 rounded-pill shadow-sm">
                                        {{ ucfirst($course->level ?? 'All Levels') }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex align-items-center gap-3 text-muted small mb-2">
                                    <span><i class="flaticon-online-learning-1 me-1 text-primary"></i> {{ $course->lessons->count() }} Lessons</span>
                                    <span><i class="flaticon-reading me-1 text-primary"></i> {{ $course->enrollments->count() }} Enrolled</span>
                                    @if($course->duration_hours)
                                        <span><i class="flaticon-time me-1 text-primary"></i> {{ $course->duration_hours }}h</span>
                                    @endif
                                </div>
                                
                                <h4 class="h5 fw-bold text-dark mb-2">
                                    <a href="{{ route('courses.show', $course->slug) }}" class="text-decoration-none text-dark hover-primary">
                                        {{ $course->title }}
                                    </a>
                                </h4>

                                <p class="text-secondary small mb-4 flex-grow-1" style="line-height: 1.6;">
                                    {{ Str::limit($course->subtitle ?? $course->description, 100) }}
                                </p>

                                <div class="d-flex align-items-center justify-content-between pt-3 border-top mt-auto">
                                    <span class="badge bg-success-soft text-success px-2 py-1 fw-semibold">Free Enrollment</span>
                                    
                                    @auth
                                        @php
                                            $isEnrolled = Auth::user()->enrollments()->where('course_id', $course->id)->exists();
                                        @endphp
                                        @if($isEnrolled)
                                            <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-primary btn-sm px-3 fw-semibold">
                                                Continue <i class="flaticon-right-arrow ms-1"></i>
                                            </a>
                                        @else
                                            <form action="{{ route('student.enroll', $course->id) }}" method="POST" class="m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm px-3 fw-semibold">
                                                    Enroll Free <i class="flaticon-edit ms-1"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-primary btn-sm px-3 fw-semibold">
                                            Enroll Free <i class="flaticon-right-arrow ms-1"></i>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 animate-on-scroll" data-animation="animate__fadeInUp">
                        <div class="p-5 bg-white rounded-4 shadow-sm border">
                            <i class="flaticon-open-book display-4 text-primary mb-3 d-block"></i>
                            <h3 class="mb-2 fw-bold text-dark">Courses Launching Soon</h3>
                            <p class="text-muted mb-4">New discipleship and leadership courses are currently being uploaded by the RACAi faculty.</p>
                            <a href="{{ route('courses.index') }}" class="btn main-btn">Browse Course Catalog</a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- .end FEATURED DYNAMIC COURSES CATALOG -->


    <!-- LEARN FROM TRUSTED VOICES -->
    <section class="py-5 bg-white position-relative">
        <div class="container py-4">
            <div class="row align-items-center g-5">
                <div class="col-12 col-lg-6 animate-on-scroll" data-animation="animate__fadeInLeft">
                    <span class="text-uppercase text-primary fw-bold letter-spacing-2 small d-block mb-2">Experienced Mentorship</span>
                    <h2 class="display-6 fw-bold text-dark mb-4">
                        Learn From <span class="text-primary">Trusted Voices</span>
                    </h2>
                    <p class="fs-5 text-secondary mb-4" style="line-height: 1.8;">
                        Access teachings and Discipleship from pastors, ministers, leaders, and experienced instructors within the RACAi community.
                    </p>

                    <div class="row g-3 mb-4 stagger-group">
                        <div class="col-12 animate-on-scroll" data-animation="animate__fadeInUp">
                            <div class="d-flex align-items-start gap-3 p-3 rounded-3 bg-light border hover-lift">
                                <div class="text-primary fs-4 mt-1"><i class="flaticon-checked"></i></div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">Practical Teaching</h5>
                                    <p class="text-muted small mb-0">Direct, actionable guidance you can readily apply in everyday personal life, family, and ministry.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 animate-on-scroll" data-animation="animate__fadeInUp">
                            <div class="d-flex align-items-start gap-3 p-3 rounded-3 bg-light border hover-lift">
                                <div class="text-primary fs-4 mt-1"><i class="flaticon-checked"></i></div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">Biblical Foundation</h5>
                                    <p class="text-muted small mb-0">Rooted unreservedly in the truth and integrity of the Holy Scriptures.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 animate-on-scroll" data-animation="animate__fadeInUp">
                            <div class="d-flex align-items-start gap-3 p-3 rounded-3 bg-light border hover-lift">
                                <div class="text-primary fs-4 mt-1"><i class="flaticon-checked"></i></div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">Real Transformation</h5>
                                    <p class="text-muted small mb-0">Experience renewal of the mind, character elevation, and purposeful kingdom destiny.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6 animate-on-scroll" data-animation="animate__fadeInRight">
                    <div class="voice-card bg-off-white p-4 p-md-5 rounded-4 shadow-sm border text-center position-relative hover-lift">
                        <div class="voice-quote-badge mb-3">
                            <i class="flaticon-quote fs-2 text-primary"></i>
                        </div>
                        <p class="fs-5 fst-italic text-dark mb-4" style="line-height: 1.8;">
                            “When believers are equipped with sound doctrine and practical skills, their light shines indisputably in every sector of life.”
                        </p>
                        <div class="mt-4 pt-3 border-top">
                            <h5 class="fw-bold text-dark mb-0">RACAi Leadership &amp; Faculty</h5>
                            <span class="small text-muted">Rock of Ages Christian Assembly</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- .end LEARN FROM TRUSTED VOICES -->


    <!-- YOUR GROWTH IS A JOURNEY (CTA SECTION) -->
    <section class="py-5 bg-navy text-white position-relative overflow-hidden" id="cta">
        <div class="cta-backdrop-glow"></div>
        <div class="container py-5 position-relative" style="z-index: 2;">
            <div class="row justify-content-center text-center">
                <div class="col-12 col-lg-8 animate-on-scroll" data-animation="animate__fadeInUp">
                    <span class="text-uppercase text-gold fw-bold letter-spacing-2 small d-block mb-3">Take Your Next Step</span>
                    <h2 class="display-5 fw-bold mb-4 text-white">Your Growth Is a Journey</h2>
                    
                    <div class="row g-3 justify-content-center my-4 stagger-group">
                        <div class="col-12 col-md-4 animate-on-scroll" data-animation="animate__zoomIn">
                            <div class="p-3 rounded-3 cta-pill hover-lift">
                                <span class="d-block text-white-70 small">Don't just attend church.</span>
                                <strong class="fs-5 text-gold">Become a disciple.</strong>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 animate-on-scroll" data-animation="animate__zoomIn">
                            <div class="p-3 rounded-3 cta-pill hover-lift">
                                <span class="d-block text-white-70 small">Don't just receive teaching.</span>
                                <strong class="fs-5 text-gold">Apply it.</strong>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 animate-on-scroll" data-animation="animate__zoomIn">
                            <div class="p-3 rounded-3 cta-pill hover-lift">
                                <span class="d-block text-white-70 small">Don't just discover your gifts.</span>
                                <strong class="fs-5 text-gold">Use them.</strong>
                            </div>
                        </div>
                    </div>

                    <h3 class="h4 fw-normal text-white-90 my-4 animate-on-scroll" data-animation="animate__fadeInUp">
                        Start your <strong>RACAi Discipleship</strong> journey today.
                    </h3>

                    <div class="mt-4 animate-on-scroll" data-animation="animate__fadeInUp">
                        @auth
                            <a href="{{ route('student.dashboard') }}" class="btn btn-gold btn-lg px-5 py-3 fw-bold rounded-3 shadow">
                                Access Your Student Portal <i class="flaticon-right-arrow ms-2"></i>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-gold btn-lg px-5 py-3 fw-bold rounded-3 shadow">
                                Create Your Account <i class="flaticon-edit ms-2"></i>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- .end YOUR GROWTH IS A JOURNEY -->

@endsection

@push('styles')
<style>
/* RACAi Custom Aesthetic Tokens */
.racai-hero-section {
    background: linear-gradient(135deg, #09182d 0%, #003673 50%, #0067da 100%);
    position: relative;
    padding-top: 60px;
    padding-bottom: 60px;
}
.hero-bg-overlay {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 80% 20%, rgba(245, 158, 11, 0.15) 0%, transparent 60%);
    pointer-events: none;
}
.hero-badge {
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}
.badge-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #f59e0b;
    box-shadow: 0 0 8px #f59e0b;
}
.text-gradient-gold {
    background: linear-gradient(135deg, #fef08a 0%, #fbbf24 50%, #f59e0b 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.text-light-gold {
    color: #fbbf24;
}
.text-gold {
    color: #f59e0b;
}
.text-white-90 {
    color: rgba(255, 255, 255, 0.9);
}
.text-white-80 {
    color: rgba(255, 255, 255, 0.8);
}
.text-white-70 {
    color: rgba(255, 255, 255, 0.7);
}
.border-white-20 {
    border-color: rgba(255, 255, 255, 0.2) !important;
}
.btn-gold {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    color: #0f172a;
    border: none;
    transition: all 0.3s ease;
}
.btn-gold:hover {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: #000;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(245, 158, 11, 0.35);
}
.hero-visual-card {
    background: #ffffff;
    border: 1px solid rgba(255, 255, 255, 0.4);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
}
.emblem-bubble {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: #fef3c7;
    display: flex;
    align-items: center;
    justify-content: center;
}
.hover-lift {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08) !important;
}
.pillar-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.bg-blue-subtle { background-color: #e0f2fe; }
.bg-green-subtle { background-color: #dcfce7; }
.bg-amber-subtle { background-color: #fef3c7; }
.bg-purple-subtle { background-color: #f3e8ff; }
.bg-primary-soft { background-color: rgba(0, 103, 218, 0.1); }
.bg-success-soft { background-color: rgba(22, 163, 74, 0.1); }
.bg-warning-soft { background-color: rgba(217, 119, 6, 0.1); }
.bg-info-soft { background-color: rgba(14, 165, 233, 0.1); }
.bg-purple-soft { background-color: rgba(147, 51, 234, 0.1); }
.bg-danger-soft { background-color: rgba(220, 38, 38, 0.1); }
.bg-navy { background-color: #0b1528; }

.stream-card {
    transition: all 0.3s ease;
    border: 1px solid #edf2f7 !important;
}
.stream-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 28px rgba(0, 103, 218, 0.08) !important;
    border-color: #cbd5e1 !important;
}
.stream-emoji {
    font-size: 2rem;
    line-height: 1;
}

.step-badge {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: #0067da;
    color: #fff;
    font-weight: 800;
    font-size: 1.15rem;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 6px 14px rgba(0, 103, 218, 0.25);
}
.stage-icon-wrap {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.scripture-card {
    background: rgba(255, 255, 255, 0.1) !important;
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border: 1px solid rgba(255, 255, 255, 0.22) !important;
    box-shadow: 0 20px 45px rgba(0, 0, 0, 0.3) !important;
    max-width: 920px;
}
.scripture-card blockquote,
.scripture-card .scripture-quote {
    background: transparent !important;
    background-color: transparent !important;
    padding: 0 !important;
    margin: 0 0 1.25rem 0 !important;
    border: none !important;
    color: #ffffff !important;
}
.scripture-card .scripture-quote::before,
.scripture-card blockquote::before {
    display: none !important;
}
.scripture-badge {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 30px;
    background: rgba(245, 158, 11, 0.15);
    border: 1px solid rgba(245, 158, 11, 0.4);
    color: #fbbf24;
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.course-racai-card {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    border: 1px solid #edf2f7;
}
.course-racai-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 32px rgba(0, 0, 0, 0.1) !important;
}
.course-thumb-img {
    height: 200px;
    object-fit: cover;
}
.bg-gold {
    background-color: #f59e0b;
}
.cta-pill {
    background: rgba(255, 255, 255, 0.06);
    border: 1px solid rgba(255, 255, 255, 0.12);
}
.cta-backdrop-glow {
    position: absolute;
    width: 400px;
    height: 400px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: radial-gradient(circle, rgba(0, 103, 218, 0.35) 0%, transparent 70%);
    pointer-events: none;
}
.max-w-700-px {
    max-width: 700px;
}
.letter-spacing-1 {
    letter-spacing: 1px;
}
.letter-spacing-2 {
    letter-spacing: 2px;
}
</style>
@endpush