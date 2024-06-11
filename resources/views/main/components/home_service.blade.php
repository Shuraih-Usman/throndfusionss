
<section class="trending-podcast-section section-padding pt-0 mb-5">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-12">
                <div class="section-title-wrap mb-5">
                    <h4 class="section-title">Services / Gigs</h4>
                </div>
            </div>

            @foreach ($services as $item)

            <div class="col-lg-4 col-md-6 col-sm-6 mb-4 mb-lg-0">
                <div class="custom-block custom-block-full p-3">
                    <div class="custom-block-image-wrap">
                        <a href="/service/{{$item->id}}">
                            <img src="{{'/images/'.$item->img_folder.$item->image}}" class="custom-block-image img-fluid" alt="{{$item->title}}">
                        </a>
                    </div>

                    <div class="custom-block-info" style="margin:0px;padding:0px; margin-top:5px;">
                        <h5 class="mb-2" style="margin:0px;padding:0px;">
                            <a href="/service/{{$item->id}}">
                                {{$item->title}}
                            </a>
                        </h5>

                        <div class="profile-block d-flex">
                            <img src="{{'/images/'.$item->user_folder.$item->user_image}}" class="profile-block-image img-fluid" alt="{{$item->username}}">

                            <p>{{$item->username}}
                                <strong>
                                @if ($item->role == 2)
                                    Creator
                                @else
                                    User
                                @endif
                                </strong></p>
                        </div>
                        <div class="custom-block-bottom d-flex justify-content-between mt-3">
                            <a href="#" class="bi-bag-heart me-1">
                                <span>100k</span>
                            </a>

                            <a href="#" class="bi-heart me-1">
                                <span>2.5k</span>
                            </a>

                            <a href="#" class="bi-chat me-1">
                                <span>924k</span>
                            </a>
                        </div>
                    </div>

                    <div class="social-share d-flex flex-column ms-auto">
                        <a href="#" class="badge ms-auto">
                            <i class="bi-heart"></i>
                        </a>

                        <a href="#" class="badge ms-auto">
                            <i class="bi-bookmark"></i>
                        </a>
                    </div>
                </div>
            </div>

            @endforeach

            

        </div>
    </div>
</section>


    
            