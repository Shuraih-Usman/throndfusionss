
@extends('user.app')

@section('title')
   Dashboard
@endsection

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-lg-7 col-md-7 mb-4">
        <div class="card">
          <div class="d-flex align-items-end row">
            <div class="col-sm-7">
              <div class="card-body">
                <h5 class="card-title text-primary">Wellcome Back {{Admin('fullname')}} </h5>
                <p class="mb-4">
                  Dive and explore our astonishing services
                </p>

                <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a>
              </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
              <div class="card-body pb-0 px-0 px-md-4">
                <img
                  src="/assets/img/illustrations/man-with-laptop-light.png"
                  height="140"
                  alt="View Badge User"
                  data-app-dark-img="illustrations/man-with-laptop-dark.png"
                  data-app-light-img="illustrations/man-with-laptop-light.png"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-5 col-md-5">
        <div class="row">
          <div class="col-lg-6 col-md-6  col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <img
                      src="/assets/img/icons/unicons/chart-success.png"
                      alt="chart success"
                      class="rounded"
                    />
                  </div>
                  <div class="dropdown">
                    <button
                      class="btn p-0"
                      type="button"
                      id="cardOpt3"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                      {{-- <a class="dropdown-item" href="javascript:void(0);">View More</a>
                      <a class="dropdown-item" href="javascript:void(0);">Delete</a> --}}
                    </div>
                  </div>
                </div>
                <span class="fw-semibold d-block mb-1">Month Deposits </span>
                <h3 class="card-title mb-2">{{CUR.$allPayments}}</h3>
              </div>
            </div>
          </div>


          <div class="col-lg-6 col-md-6 col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <img
                      src="/assets/img/icons/unicons/wallet-info.png"
                      alt="Credit Card"
                      class="rounded"
                    />
                  </div>
                  <div class="dropdown">
                    <button
                      class="btn p-0"
                      type="button"
                      id="cardOpt6"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                      {{-- <a class="dropdown-item" href="javascript:void(0);">View More</a>
                      <a class="dropdown-item" href="javascript:void(0);">Delete</a> --}}
                    </div>
                  </div>
                </div>
                <span>Month Withdraw</span>
                <h3 class="card-title text-nowrap mb-1">{{CUR.$allWithdraw}}</h3>
              </div>
            </div>
          </div>
        </div>
      </div>






      <!-- Total Revenue -->
      <div class="col-12 mb-4">
        <div class="card">
          <div class="row row-bordered g-0">


                  <!-- Expense Overview -->
     
                  <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header">
            <ul class="nav nav-pills" role="tablist">
              <li class="nav-item">
                <button
                  type="button"
                  class="nav-link active"
                  role="tab"
                  data-bs-toggle="tab"
                  data-bs-target="#navs-tabs-line-card-income"
                  aria-controls="navs-tabs-line-card-income"
                  aria-selected="true"
                >
                  Payments / Deposits
                </button>
              </li>
            </ul>
          </div>
          <div class="card-body px-0">
            <div class="tab-content p-0">
              <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                <div class="d-flex p-4 pt-3">
                  <div class="avatar flex-shrink-0 me-3">
                    <img src="../assets/img/icons/unicons/wallet.png" alt="User" />
                  </div>
                  <div>
                    <small class="text-muted d-block">Total This year</small>
                    <div class="d-flex align-items-center">
                      <h6 class="mb-0 me-1">{{CUR.$payment_this_year}}</h6>
                      <small class="text-success fw-semibold">
                       
                      </small>
                    </div>
                  </div>
                </div>
                <div id="incomeChart"></div>
                <div class="d-flex justify-content-center pt-4 gap-2">
                 
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--/ Expense Overview -->

      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header">
            <ul class="nav nav-pills" role="tablist">
              <li class="nav-item">
                <button
                  type="button"
                  class="nav-link active"
                  role="tab"
                  data-bs-toggle="tab"
                  data-bs-target="#navs-tabs-line-card-income"
                  aria-controls="navs-tabs-line-card-income"
                  aria-selected="true"
                >
                  Withdraw
                </button>
              </li>
            </ul>
          </div>
          <div class="card-body px-0">
            <div class="tab-content p-0">
              <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                <div class="d-flex p-4 pt-3">
                  <div class="avatar flex-shrink-0 me-3">
                    <img src="/assets/img/icons/unicons/wallet.png" alt="User" />
                  </div>
                  <div>
                    <small class="text-muted d-block">Total This year</small>
                    <div class="d-flex align-items-center">
                      <h6 class="mb-0 me-1">{{CUR.$withdrawal_this_year}}</h6>
                      <small class="text-success fw-semibold">
                       
                      </small>
                    </div>
                  </div>
                </div>
                <div id="incomeChart2"></div>
                <div class="d-flex justify-content-center pt-4 gap-2">
                  
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


          </div>
        </div>
      </div>


      
      <!--/ Total Revenue -->


      <div class="col-12">
        <div class="row">
          <div class="col-md-3 col-sm-6 col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <i class="bx bxs-server rounded"></i>
                  </div>
                  <div class="dropdown">
                    <button
                      class="btn p-0"
                      type="button"
                      id="cardOpt4"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                      <a class="dropdown-item" href="{{route('user.services')}}">View More</a>
                    </div>
                  </div>
                </div>
                <span class="d-block mb-1">Enrolled Service</span>
                <h3 class="card-title text-nowrap mb-2">{{$total_users}}</h3>
              </div>
            </div>
          </div>


          <div class="col-md-3 col-sm-6 col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <i class="bx bxs-server"></i>
                  </div>
                  <div class="dropdown">
                    <button
                      class="btn p-0"
                      type="button"
                      id="cardOpt1"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="cardOpt1">
                      <a class="dropdown-item" href="{{route('user.services')}}">View More</a>
                    </div>
                  </div>
                </div>
                <span class="fw-semibold d-block mb-1">Total Services</span>
                <h3 class="card-title mb-2">{{$total_services}}</h3>
              </div>
            </div>
          </div>


          <div class="col-md-3 col-sm-6 col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <i class="bx bx-copy"></i>
                  </div>
                  <div class="dropdown">
                    <button
                      class="btn p-0"
                      type="button"
                      id="cardOpt1"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="cardOpt1">
                      <a class="dropdown-item" href="{{route('user.campaigns')}}">View More</a>
                    </div>
                  </div>
                </div>
                <span class="fw-semibold d-block mb-1">Total Campaigns</span>
                <h3 class="card-title mb-2">{{$total_campaign}}</h3>
              </div>
            </div>
          </div>


          <div class="col-md-3 col-sm-6 col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <i class="bx bxs-gift"></i>
                  </div>
                  <div class="dropdown">
                    <button
                      class="btn p-0"
                      type="button"
                      id="cardOpt1"
                      data-bs-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false"
                    >
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="cardOpt1">
                      <a class="dropdown-item" href="{{route('user.services')}}">View More</a>
                    </div>
                  </div>
                </div>
                <span class="fw-semibold d-block mb-1">Total Wishes</span>
                <h3 class="card-title mb-2">{{$total_services}}</h3>
              </div>
            </div>
          </div>
          <!-- </div>
<div class="row"> -->


        </div>
      </div>
    </div>


  
  </div>


  @endsection