@extends('main.app')

@section('title')
    Home
@endsection

@section('content')

        @include('main.components.home_trending_services')

        @include('main.components.home_projects')

        @include('main.components.home_service')

           
            <section class="trending-podcast-section section-padding pt-0 mb-5">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 down">
                            <div class="col-lg-12 col-12">
                                <div class="section-title-wrap mb-5">
                                    <h4 class="section-title">Wish Lists</h4>
                                </div>
                            </div>
                    
                        </div>
                        <div class="col-md-6">
                @include('main.components.home_wishlists')
            </div>
            </div>
        </div>

            </section>
    
</main>

            @endsection