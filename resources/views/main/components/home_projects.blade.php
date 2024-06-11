


<section class="latest-podcast-section section-padding pb-0 mb-5" id="section_2">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-lg-12 col-12">
                <div class="section-title-wrap mb-5">
                    <h4 class="section-title">Campaign Projects</h4>
                </div>
            </div>

            @foreach ($campaigns as $item)
            <div class="col-lg-6 col-12 mb-4">
                <div class="custom-block d-flex">
                    <div class="">
                        <div class="custom-block-icon-wrap">
                            <div class="section-overlay"></div>
                            <div class="custom-block-image-wrap">
                                <img src="/images/{{$item->img_folder.$item->image}}" class="custom-block-image img-fluid" alt="">

                               
                            </div>
                        </div>

                        <div class="mt-2">
                            <a href="javascript:void(0)"  data-title="{{$item->title}}" data-goal="N{{$item->goal_amount}}" data-type="{{$item->type}}" data-description="{{ htmlspecialchars($item->description) }}" @if ($item->type == 2)
                                data-shared="{{$item->shared_amount}}" data-stop="{{$item->invest_stop_date}}"
                            @else
                                
                            @endif data-category="{{$item->cat_title}}" data-id="{{$item->id}}" data-date="{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}" class="btn custom-btn select_campaign">
                                @if ($item->type == 1)
                                    DONATE
                                @else
                                    INVEST
                                @endif
                            </a>
                        </div>
                    </div>

                    <div class="custom-block-info">
                        <div class="custom-block-top d-flex mb-1">
                            <small class="me-4">
                                <i class="bi-clock-fill custom-icon"></i>
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}

                            </small>

                        </div>

                        <h5 class="mb-2">
                               {{$item->title}}
                        </h5>

                        <div class="profile-block d-flex">
                            <img src="/images/{{$item->user_folder.$item->user_image}}" class="profile-block-image img-fluid" alt="">

                            <p>{{$item->username}}</p>
                        </div>


                        <div class="custom-block-bottom d-flex justify-content-between mt-3">
                            <a href="javascript:void(0)" class="bi-coin me-1">
                                <span class="me-3">{{CUR.$item->goal_amount}}</span>
                            </a>

                         
                        </div>
                    </div>

                    <div class="d-flex flex-column ms-auto">
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




<!-- Modal -->
            <div id="modal-one" class="iziModal">
            <div class="modal-body p-3">
                <div class="row">
                    <div class="col-sm-6"> 
                        <span>Goal</span>
                        <p id="c_goal"></p> 
                    </div>
                    <div class="col-sm-6"> 
                        <span>Type</span>
                        <p id="c_type"></p> 
                    </div>
    
                    <div id="cc_shared" class="col-sm-6 d-none"> 
                        <span>Investment Shared</span>
                        <p id="c_shared"></p> 
                    </div>
    
                    <div id="cc_stop" class="col-sm-6 d-none"> 
                        <span>Campaign Ending Date</span>
                        <p id="c_stop"></p> 
                    </div>
    
                    <div class="col-sm-6"> 
                        <span>Category</span>
                        <p id="c_category"></p> 
                    </div>
    
                    <div class="col-sm-6"> 
                        <span>Date</span>
                        <p id="c_date"></p> 
                    </div>

                    <div class="col-sm-12"> 
                        <span>Amount to Invest / Donate</span>
                        <input class="form-control" type="number" id="c_amount" value="0"/>
                    </div>

                    <div class="col-sm-12"> 
                        <span>Description</span>
                        <p id="c_description"></p> 
                    </div>
    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="_capm_submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>




