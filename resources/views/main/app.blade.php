<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from demo.bootstrapdash.com/lead-ui-kit/demo/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Mar 2024 23:52:56 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | {{APP_NAME}}</title>
    <!-- partial:partials/_head.html -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
        
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&family=Sono:wght@200;300;400;500;700&display=swap" rel="stylesheet">
     
    <link rel="stylesheet" href="/main/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/main/assets/css/bootstrap-icons.css">
    <link rel="stylesheet" href="/main/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/main/assets/css/owl.theme.default.min.css">
    <link href="/main/assets/css/templatemo-pod-talk.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.6.1/css/iziModal.min.css" integrity="sha512-3c5WiuZUnVWCQGwVBf8XFg/4BKx48Xthd9nXi62YK0xnf39Oc2FV43lIEIdK50W+tfnw2lcVThJKmEAOoQG84Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/assets/css/sweetalert.css" />
    <script src="/main/src/vendors/jquery/jquery.min.js"></script>
    <script src="/assets/js/sweetalert.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.6.1/js/iziModal.min.js" integrity="sha512-lR/2z/m/AunQdfBTSR8gp9bwkrjwMq1cP0BYRIZu8zd4ycLcpRYJopB+WsBGPDjlkJUwC6VHCmuAXwwPHlacww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="/assets/css/nice-select2.css" />
    <link rel="stylesheet" type="text/css" href="/main/src/css/toastify.min.css">
    
    <style>
        
.hide{
  display: none;
}

.trigger-custom{
  padding:10px 20px;
  border-radius:3px;
  border:0;
  background:#ccc;
  font-size:14px;
  border-top:1px solid #FFF;
  border-bottom:1px solid #aaa;
  cursor:pointer;
}
.trigger-custom:hover{
  background:#d5d5d5;
}

#login-custom .iziModal-content header{
    background: #eee;
    margin-bottom: 10px;
    overflow: hidden;
    border-radius: 3px 3px 0 0;
    width: 100%;
}
#login-custom .iziModal-content header a{
    display: block;
    float: left;
    width: 50%;
    padding: 0;
    text-align: center;
    background: #ddd;
    color: #999;
    height: 73px;
    vertical-align: middle;
    line-height: 73px;
}
#login-custom .iziModal-content header a.active{
    background: #fff;
    color: #777;
}
#login-custom .iziModal-content section{
    padding: 30px;
}
#login-custom .iziModal-content section input:not([type="checkbox"]), #login-custom .iziModal-content section button{
    width: 100%;
    border-radius: 3px;
    border: 1px solid #ddd;
    margin-bottom: 26px;
    padding: 15px;
    font-size: 14px;
}
#login-custom .iziModal-content section button{
  height: 46px;
  padding: 0;
}
#login-custom .iziModal-content section input:focus{
    border-color:#28CA97;
}
#login-custom .iziModal-content section label[for="check"]{
    margin-bottom: 26px;
    font-size: 14px;
    color: #999;
    display: block;
}
#login-custom .iziModal-content section footer{
    overflow: hidden;
}
#login-custom .iziModal-content section button{
    background: #28CA97;
    color: white;
    margin: 0;
    border: 0;
    cursor: pointer;
    width: 50%;
    float: left;
}
#login-custom .iziModal-content section button:hover{
    opacity: 0.8;
}
#login-custom .iziModal-content section button:nth-child(1){
    border-radius: 3px 0 0 3px;
    background: #aaa;
}
#login-custom .iziModal-content section button:nth-child(2){
    border-radius: 0 3px 3px 0;
}

#login-custom .iziModal-content .icon-close{
    background: #FFF;
    margin-bottom: 10px;
    position: absolute;
    right: -8px;
    top: -8px;
    font-size: 14px;
    font-weight: bold;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    border: 0;
    color: #a9a9a9;
    cursor: pointer;
}
#login-custom .iziModal-content .icon-close:hover, #login-custom .iziModal-content .icon-close:focus{
  color: black;
}





@-webkit-keyframes wobble {
  from {
    -webkit-transform: none;
    transform: none;
  }

  15% {
    -webkit-transform: translate3d(-25%, 0, 0) rotate3d(0, 0, 1, -5deg);
    transform: translate3d(-25%, 0, 0) rotate3d(0, 0, 1, -5deg);
  }

  30% {
    -webkit-transform: translate3d(20%, 0, 0) rotate3d(0, 0, 1, 3deg);
    transform: translate3d(20%, 0, 0) rotate3d(0, 0, 1, 3deg);
  }

  45% {
    -webkit-transform: translate3d(-15%, 0, 0) rotate3d(0, 0, 1, -3deg);
    transform: translate3d(-15%, 0, 0) rotate3d(0, 0, 1, -3deg);
  }

  60% {
    -webkit-transform: translate3d(10%, 0, 0) rotate3d(0, 0, 1, 2deg);
    transform: translate3d(10%, 0, 0) rotate3d(0, 0, 1, 2deg);
  }

  75% {
    -webkit-transform: translate3d(-5%, 0, 0) rotate3d(0, 0, 1, -1deg);
    transform: translate3d(-5%, 0, 0) rotate3d(0, 0, 1, -1deg);
  }

  to {
    -webkit-transform: none;
    transform: none;
  }
}

@keyframes wobble {
  from {
    -webkit-transform: none;
    transform: none;
  }

  15% {
    -webkit-transform: translate3d(-25%, 0, 0) rotate3d(0, 0, 1, -5deg);
    transform: translate3d(-25%, 0, 0) rotate3d(0, 0, 1, -5deg);
  }

  30% {
    -webkit-transform: translate3d(20%, 0, 0) rotate3d(0, 0, 1, 3deg);
    transform: translate3d(20%, 0, 0) rotate3d(0, 0, 1, 3deg);
  }

  45% {
    -webkit-transform: translate3d(-15%, 0, 0) rotate3d(0, 0, 1, -3deg);
    transform: translate3d(-15%, 0, 0) rotate3d(0, 0, 1, -3deg);
  }

  60% {
    -webkit-transform: translate3d(10%, 0, 0) rotate3d(0, 0, 1, 2deg);
    transform: translate3d(10%, 0, 0) rotate3d(0, 0, 1, 2deg);
  }

  75% {
    -webkit-transform: translate3d(-5%, 0, 0) rotate3d(0, 0, 1, -1deg);
    transform: translate3d(-5%, 0, 0) rotate3d(0, 0, 1, -1deg);
  }

  to {
    -webkit-transform: none;
    transform: none;
  }
}

.wobble {
  -webkit-animation-name: wobble;
  animation-name: wobble;
  -webkit-animation-duration: 1s;
  animation-duration: 1s;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
}
    </style>

       <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- partial -->
</head>

<body>

    <main>

        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand me-lg-5 me-0" href="index.html">
                    <img src="/main/assets/images/logo.svg" class="logo-image img-fluid" alt="{{APP_NAME}}">
                </a>

                <form action="#" method="get" class="custom-form search-form flex-fill me-3" role="search">
                    <div class="input-group input-group-lg">    
                        <input name="search" type="search" class="form-control" id="search" placeholder="Search Podcast" aria-label="Search">

                        <button type="submit" class="form-control" id="submit">
                            <i class="bi-search"></i>
                        </button>
                    </div>
                </form>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
            </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-lg-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.html">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="about.html">About</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Pages</a>

                            <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                                <li><a class="dropdown-item" href="listing-page.html">Listing Page</a></li>

                                <li><a class="dropdown-item" href="detail-page.html">Detail Page</a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="contact.html">Contact</a>
                        </li>
                    
                    @if (auth()->check())
                    <li class="nav-item ms-4">
                        <a href="#" class="btn custom-btn custom-border-btn smoothscroll m-1">Get started</a>
                    </li>
                    @else
                    <li class="nav-item ms-4">
                        <a href="/login" class="btn custom-btn custom-border-btn smoothscroll m-1">Login</a>
                    </li>
                    <li class="nav-item ms-4">
                        <a href="/register" class="btn custom-btn custom-border-btn smoothscroll m-1">Sign Up</a>
                    </li>
                    @endif
                </ul>
                </div>
            </div>
        </nav>


    <div id="" class="overlay2 d-none">
                    
        <span class="loader-shu"></span>
</div>


            @yield('content')
    </main>

 

    <div id="login-custom" data-iziModal-group="grupo1">
        <button data-iziModal-close class="icon-close">x</button>
        <header>
            <a href="" id="signin">Sign in</a>
            <a href="" class="active">New Account</a>
        </header>
        <section>
            <input type="text" id="custom-login-email" placeholder="Email">
            <input type="password" id="custom-login-password" placeholder="Password">
            <footer>
                <button data-iziModal-close>Cancel</button>
                <button id="submit-custom-login" class="submit">Log in</button>            
            </footer>
        </section >
        <section class="hide">
            <input type="text" placeholder="Username">
            <input type="text" placeholder="Email">
            <input type="password" placeholder="Password">
            <label for="check"><input type="checkbox" name="checkbox" id="check" value="1"> I agree to the <u>Terms</u>.</label>
            <footer>
                <button data-iziModal-close>Cancel</button>
                <button class="submit">Create Account</button>            
            </footer>
        </section>
    </div>
        <!-- partial:partials/_footer.html -->
       
        <footer class="site-footer">   
            <div class="container">
                <div class="row">

                    <div class="col-lg-6 col-12 mb-5 mb-lg-0">
                        <div class="subscribe-form-wrap">
                            <h6>Subscribe. Every weekly.</h6>

                            <form class="custom-form subscribe-form" action="#" method="get" role="form">
                                <input type="email" name="subscribe-email" id="subscribe-email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="Email Address" required="">

                                <div class="col-lg-12 col-12">
                                    <button type="submit" class="form-control" id="">Subscribe</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12 mb-4 mb-md-0 mb-lg-0">
                        <h6 class="site-footer-title mb-3">Contact</h6>

                        <p class="mb-2"><strong class="d-inline me-2">Phone:</strong> 010-020-0340</p>

                        <p>
                            <strong class="d-inline me-2">Email:</strong>
                            <a href="#">inquiry@pod.co</a> 
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12">
                        <h6 class="site-footer-title mb-3">Download Mobile</h6>

                        <div class="site-footer-thumb mb-4 pb-2">
                            <div class="d-flex flex-wrap">
                                <a href="#">
                                    <img src="images/app-store.png" class="me-3 mb-2 mb-lg-0 img-fluid" alt="">
                                </a>

                                <a href="#">
                                    <img src="images/play-store.png" class="img-fluid" alt="">
                                </a>
                            </div>
                        </div>

                        <h6 class="site-footer-title mb-3">Social</h6>

                        <ul class="social-icon">
                            <li class="social-icon-item">
                                <a href="#" class="social-icon-link bi-instagram"></a>
                            </li>

                            <li class="social-icon-item">
                                <a href="#" class="social-icon-link bi-twitter"></a>
                            </li>

                            <li class="social-icon-item">
                                <a href="#" class="social-icon-link bi-whatsapp"></a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="container pt-5">
                <div class="row align-items-center">

                    <div class="col-lg-2 col-md-3 col-12">
                        <a class="navbar-brand" href="index.html">
                            <img src="/main/assets/images/logo.svg" class="logo-image img-fluid" alt="templatemo pod talk">
                        </a>
                    </div>

                    <div class="col-lg-7 col-md-9 col-12">
                        <ul class="site-footer-links">
                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">Homepage</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">Browse episodes</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">Help Center</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">Contact Us</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-12">
                        <p class="copyright-text mb-0">Copyright © 2036 Talk Pod Company
                        <br><br>
                        Design: <a rel="nofollow" href="https://templatemo.com/page/1" target="_parent">TemplateMo</a></p>
                    </div>
                </div>
            </div>
        </footer>
        
        <script src="https://sdk.monnify.com/plugin/monnify.js"></script>
        <script src="https://js.paystack.co/v2/inline.js"></script>
        <script src="/main/assets/js/bootstrap.bundle.min.js"></script>
        <script src="/main/assets/js/owl.carousel.min.js"></script>
        <script src="/main/src/vendors/feather-icons/feather.min.js"></script>
        <script src="/main/assets/js/custom.js"></script>
        <script type="text/javascript" src="/main/src/js/toastify-js.js"></script>
        <script type="text/javascript" src="/main/src/js/lead-ui-kit.js"></script>
        <script src="/assets/js/nice-select2.js"></script>
        <script>
            feather.replace();
        </script>
        <!-- partial -->
    </body>
    
    </html>