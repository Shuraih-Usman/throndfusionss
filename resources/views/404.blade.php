@extends('main.app')

@section('title')
    404 | Page not found
@endsection

@section('content')
<section class="mb-5 py-5">
    <div class="row">
        <div class="col-md-6 col-lg-5 offset-lg-1">
            <img src="/main/assets/images/content_section/img_5.png" alt="content" class="img-fluid">
        </div>
        <div class="col-md-6 col-lg-5 d-flex flex-column justify-content-center">
            <h1 class="text-center mb-3">404 Page not found.</h1>
            <p class="text-gray mb-3">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of  type and scrambled it to make a type specimen book.</p>
            <div><button class="btn btn-danger">Go back</button></div>
        </div>
    </div>
</section>
@endsection