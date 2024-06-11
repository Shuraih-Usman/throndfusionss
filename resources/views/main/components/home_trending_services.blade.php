<section class="hero-section">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-12">
                <div class="text-center mb-5 pb-2">
                    <h1 class="text-white">Most Viewed Service</h1>

                    <p class="text-white">Here the list of our most engaged services / gigs</p>

                    <a href="javascript:void(0)" class="btn custom-btn smoothscroll mt-3">Engaged</a>
                </div>

                
            </div>

        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="owl-carousel owl-theme">
                    @foreach ($services as $item)
    
                   
                    <div class="owl-carousel-info-wrap item">
                        <a href="/service/{{$item->id}}">
                        <img src="{{'/images/'.$item->img_folder.$item->image}}" class="owl-carousel-image img-fluid" alt="">
    
                        <div class="owl-carousel-info">
                            <h6 class="mb-0" style="margin:0px 0px;">
                                {{$item->title}}
                            </h6>
                            <span>{{$item->username}} </span>
                           
                            <span class="badge" style="margin:0px 0px;">{{$item->cat_title}}</span>
                           
    
                        </div>
    
                        <div class="social-share">
                            <ul class="social-icon">
                                <li class="social-icon-item">
                                    <a href="#" class="social-icon-link bi-twitter"></a>
                                </li>
    
                                <li class="social-icon-item">
                                    <a href="#" class="social-icon-link bi-facebook"></a>
                                </li>
                            </ul>
                        </div>
                        </a>
                    </div>
                    @endforeach
                    
    
                </div>
            </div>
            
        </div>
    </div>
</section>




