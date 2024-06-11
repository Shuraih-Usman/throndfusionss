@extends('main.app')

@section('title')
    {{$service->title}}
@endsection

@section('content')

<header class="site-header d-flex flex-column justify-content-center align-items-center">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-12 text-center">

                <h2 class="mb-0">{{$service->title}}</h2>
            </div>

        </div>
    </div>
</header>


<section class="latest-podcast-section section-padding pb-0 mb-5" id="section_2">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-lg-10 col-12">
                <div class="section-title-wrap mb-5">
                    <h4 class="section-title">{{$service->title}} by <a href="/account/{{$service->username}}">{{$service->username}} </a> </h4>
                </div>

                
                <div class="row">
        <div class="col-sx-12 col-sm-12 col-md-8 col-lg-8  pb-3">
            <div class="card border-0 shadow h-100">
                <img src="/images/{{$service->img_folder.$service->image}}" alt="{{$service->title}}" class="card-img-top">
                <div class="card-body pt-40px pb-30px">
                    <div class="d-flex justify-content-between">
                        <div class="text-center mb-2">
                            <span class="text-muted small">{{$service->created_at->format('D d M, Y')}}</span>
                        </div>
                        <div class="">
                            <button class="feature-icon rounded-circle badge-soft-primary mb-4">
                                <svg fill="#000000" height="22px" width="22px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-143 145 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M113,145c-141.4,0-256,114.6-256,256s114.6,256,256,256s256-114.6,256-256S254.4,145,113,145z M272.8,560.7 c-20.8,20.8-44.9,37.1-71.8,48.4c-27.8,11.8-57.4,17.7-88,17.7c-30.5,0-60.1-6-88-17.7c-26.9-11.4-51.1-27.7-71.8-48.4 c-20.8-20.8-37.1-44.9-48.4-71.8C-107,461.1-113,431.5-113,401s6-60.1,17.7-88c11.4-26.9,27.7-51.1,48.4-71.8 c20.9-20.8,45-37.1,71.9-48.5C52.9,181,82.5,175,113,175s60.1,6,88,17.7c26.9,11.4,51.1,27.7,71.8,48.4 c20.8,20.8,37.1,44.9,48.4,71.8c11.8,27.8,17.7,57.4,17.7,88c0,30.5-6,60.1-17.7,88C309.8,515.8,293.5,540,272.8,560.7z"></path> <path d="M146.8,313.7c10.3,0,21.3,3.2,21.3,3.2l6.6-39.2c0,0-14-4.8-47.4-4.8c-20.5,0-32.4,7.8-41.1,19.3 c-8.2,10.9-8.5,28.4-8.5,39.7v25.7H51.2v38.3h26.5v133h49.6v-133h39.3l2.9-38.3h-42.2v-29.9C127.3,317.4,136.5,313.7,146.8,313.7z"></path> </g> </g></svg>
                            </button>
                            <button class="feature-icon rounded-circle badge-soft-secondary mb-4">
                                <svg fill="#000000" viewBox="-2 -2 22 22" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMinYMin" class="jam jam-twitter-circle"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm0 2C4.477 20 0 15.523 0 10S4.477 0 10 0s10 4.477 10 10-4.477 10-10 10z"></path><path d="M15 6.947c-.368.16-.763.27-1.178.318.424-.25.748-.646.902-1.117-.398.231-.836.4-1.304.49A2.06 2.06 0 0 0 11.923 6c-1.133 0-2.051.905-2.051 2.02 0 .158.018.312.053.46a5.854 5.854 0 0 1-4.228-2.11 1.982 1.982 0 0 0-.278 1.015c0 .7.363 1.32.913 1.681a2.076 2.076 0 0 1-.93-.253v.025a2.03 2.03 0 0 0 1.646 1.98 2.108 2.108 0 0 1-.927.034 2.049 2.049 0 0 0 1.916 1.403 4.156 4.156 0 0 1-2.548.864c-.165 0-.328-.01-.489-.028A5.863 5.863 0 0 0 8.144 14c3.774 0 5.837-3.078 5.837-5.748l-.007-.262A4.063 4.063 0 0 0 15 6.947z"></path></g></svg>
                            </button>

                            <button class="feature-icon rounded-circle badge-soft-secondary mb-4">
                                <svg viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M13.803 5.33333C13.803 3.49238 15.3022 2 17.1515 2C19.0008 2 20.5 3.49238 20.5 5.33333C20.5 7.17428 19.0008 8.66667 17.1515 8.66667C16.2177 8.66667 15.3738 8.28596 14.7671 7.67347L10.1317 10.8295C10.1745 11.0425 10.197 11.2625 10.197 11.4872C10.197 11.9322 10.109 12.3576 9.94959 12.7464L15.0323 16.0858C15.6092 15.6161 16.3473 15.3333 17.1515 15.3333C19.0008 15.3333 20.5 16.8257 20.5 18.6667C20.5 20.5076 19.0008 22 17.1515 22C15.3022 22 13.803 20.5076 13.803 18.6667C13.803 18.1845 13.9062 17.7255 14.0917 17.3111L9.05007 13.9987C8.46196 14.5098 7.6916 14.8205 6.84848 14.8205C4.99917 14.8205 3.5 13.3281 3.5 11.4872C3.5 9.64623 4.99917 8.15385 6.84848 8.15385C7.9119 8.15385 8.85853 8.64725 9.47145 9.41518L13.9639 6.35642C13.8594 6.03359 13.803 5.6896 13.803 5.33333Z" fill="#1C274C"></path> </g></svg>
                            </button>
                        </div>
                    </div>
                   
                    <h4 class="mb-3 text-center">{{$service->title}}</h4>
                    <p> By <a href="/account/{{$service->username}}">{{$service->username}} </a> </p>
                    
                    <h5 class="text-center">Descripion </h5>
                    <div class="">
                    {!!$service->description!!}
                    </div>

                    <div class="mt-3 d-flex flex-column align-items-center">
                        @if (auth()->check())
                        <a class="btn btn-primary mb-3 w-50" href="#service_checkout">
                            CONTINUE
                        </a>
                        <a class="btn btn-primary mb-3 w-50" href="/message?service={{$service->id}}&user={{$service->user_id}}">
                            ASK QUESTION
                        </a>

                        <button class="btn btn-primary mb-3 w-50 trigger" data-iziModal-open="#service_message_user">Message User</button>

                        <div id="service_pay_user" class="iziModal" data-izimodal-title="Payment Method" data-izimodal-subtitle="Pls select your Preferred payment type / method">
                            <div class="d-flex flex-column justify-content-between align-items-center">
                                <div class="d-flex justify-content-center m-2">
                                    <button id="pay_service_monnify" class="btn btn-primary m-2">MONNIFY</button>
                                    <button id="pay_service_paystack" class="btn btn-success m-2">PAYSTACK</button>
                                </div>
                            </div>
                            

                        </div>


                    <div id="service_message_user" class="iziModal" data-izimodal-title="{{$service->title}}" data-izimodal-subtitle="Messaging {{$service->username}}">
                        
                        <div class=" card p-4">
                            <div class="row">
                                <form id="service_message" method="post">
                                    @csrf
                                <div class="col-12">
                                    <textarea class="form-control" name="message" id="urmessage"> Hi {{$service->username}} i want to know more about this service :  {{$service->title}}  </textarea>
                                </div>
                                <input type="hidden" name="creator_id" value="{{$service->user_id}}">
                                <input type="hidden" name="user_id" value="{{Admin('id')}}">
                                <input type="hidden" name="action" value="service_send_message">
                                <div class="col-12 mt-3"><button type="submit" class="btn btn-primary" id="submiturmessage">SEND</button>  </div>
                                </form>
                            </div>
                        </div>
                    </div>

                        @else
                        <a class="btn btn-primary mb-3 w-50" href="/login">
                            Login
                        </a>
                        <a class="btn btn-primary mb-3 w-50" href="/register">
                           Register
                        </a>
                        @endif
                       
                    </div>


                    



                </div>

                
            </div>
            
        </div>
        <div class="col-sx-12 col-sm-12 col-md-4 col-lg-4 pb-3">
            <div class="card border-0 shadow  sticky-top">
                <div class="card-body">
                    <div class="text-center mb-2 d-flex flex-column align-items-center"><h4 class="mb-3 text-center">Details</h4></div>
                    
                    <div class="d-flex align-items-center justify-content-center">
                        <label class="mr-3" for="quantity">Quantity </label>
                        <input type="number" id="service_quantity" class="form-control" value="1">
                        <input type="hidden" id="service_price" class="form-control" value="{{$service->price}}">
                        <input type="hidden" id="service_id" class="form-control" value="{{$service->id}}">
                        <input type="hidden" id="user_id_pay" class="form-control" value="{{Admin('id')}}">
                        <input type="hidden" id="user_fullname" class="form-control" value="{{Admin('fullname')}}">
                        <input type="hidden" id="tite_name" class="form-control" value="{{$service->title}}">
                        <input type="hidden" id="user_email" class="form-control" value="{{Admin('email')}}">
                    </div>
                    <div class="d-flex flex-column align-items-center">
                    <p class="mt-3"> Total : <span class="" id="total_service">{{$service->price}}</span></p>

                    @if(auth()->check()) 

                    <button id="service_checkout" class="btn btn-primary mb-3 w-50">
                        Checkout
                    </button>
                    @else 
                    <button id="" class="btn btn-primary mb-3 w-50" data-iziModal-open="#login-custom">
                        Checkout
                    </button>
                    @endif
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
    </div>
</section>

</div>
</main>


@endsection
