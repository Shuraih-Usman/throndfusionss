@extends('user.app')

@section('title')
    Messages
@endsection

@section('content')

<section style="background-color: #eee;">
    <div class="container py-5">
        <div class="row">
        <div id="model" data-name="messages"></div>
        <div id="users_message" class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0" ></div>
        <div id="real_message" class="col-md-6 col-lg-7 col-xl-8"></div>
      </div>
  
    </div>
  </section>


@endsection