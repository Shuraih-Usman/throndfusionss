@extends('admin.app')

@section('title')
    My Profile
@endsection
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><a href="/admin/dashboard" class="text-muted fw-light">Dashboard /</a>   My Profile</h4>
      <div id="model" data-name="users"></div>
      <!-- Basic Layout -->
      <div class="row">

        <ul class="nav nav-pills flex-column flex-md-row m-3">
            <li class="nav-item">
              <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Account</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages-account-settings-notifications.html"><i class="bx bx-bell me-1"></i> Notifications</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages-account-settings-connections.html"><i class="bx bx-link-alt me-1"></i> Connections</a>
            </li>
          </ul>
        
        <div class="col-xl">
          <div class="card mb-4">
            
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Profile Details </h5>
            </div>

            <div class="card-body">
                <div class="d-flex align-items-start align-items-sm-center gap-4">
                  <img src="/{{'images/admin'.Admin('image_folder').Admin('image')}}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar">
                  <div class="button-wrapper">
                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                      <span class="d-none d-sm-block">{{Admin('name')}}</span>
                      <i class="bx bx-upload d-block d-sm-none"></i>
                    </label>

                    <p class="text-muted mb-0">@if (Admin('superAdmin') == 1)
                        Official Admin
                    @else
                        Admin
                    @endif</p>
                  </div>
                </div>
              </div>
              <hr class="my-0">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6 col-md-6 mb-3">
                  <label class="form-label" for="basic-icon-default-fullname">Full Name</label>
                  <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                      ><i class="bx bx-user"></i
                    ></span>
                    <div class="form-control"> {{Admin('name')}} </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-6 mb-3">
                  <label class="form-label" for="basic-icon-default-email">Username</label>
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                    <div class="form-control"> {{Admin('username')}} </div>
                  
                  </div>
                  
                </div>
                <div class="col-sm-6 col-md-6 mb-3">
                  <label class="form-label" for="basic-icon-default-email">Email</label>
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                    <div class="form-control"> {{Admin('email')}} </div>
                    
                  </div>
                </div>

                <div class="col-sm-6 col-md-6 mb-3">
                  <label class="form-label" for="basic-icon-default-phone">Phone No</label>
                  <div class="input-group input-group-merge">
                    <span id="basic-icon-default-phone2" class="input-group-text"
                      ><i class="bx bx-phone"></i
                    ></span>
                    <div class="form-control"> {{Admin('phone')}} </div>
                  </div>
                </div>

                <div class="col-sm-6 col-md-6 mb-3">
                    <label class="form-label" for="basic-icon-default-phone">Admin type</label>
                    <div class="input-group input-group-merge">
                      
                        <div class="form-control"> @if (Admin('superAdmin') == 1)
                            Official Admin
                            @else 
                            Admin
                        @endif </div>
                    </div>
                  </div>

                  <div class="col-sm-6 col-md-6 mb-3">
                    <label class="form-label" for="basic-icon-default-phone">Gender</label>
                    <div class="input-group input-group-merge">
                      
                     @if (Admin('gender') == 1)
                         Male 
                    @else
                    Female
                     @endif
                    </div>
                  </div>

                  <div class="col-sm-6 col-md-6 mb-3">
                    <label class="form-label" for="basic-icon-default-phone">Date Of Birth</label>
                    <div class="input-group input-group-merge">
                      <span id="basic-icon-default-phone2" class="input-group-text"
                      ><i class="bx bx-date"></i
                    ></span>
                    <div class="form-control">
                    @php
                      $date = \Illuminate\Support\Carbon::parse(Admin('dob'));
                    @endphp 
                    {{$date->format('d l, F Y')}}
                </div>
                    </div>
                  </div>

                 

                  <div class="col-sm-6 col-md-6 mb-3">
                    <label class="form-label" for="basic-icon-default-phone">Address</label>
                    <div class="input-group input-group-merge">
                      <span id="basic-icon-default-phone2" class="input-group-text"
                        ><i class="bx bx-street-view"></i
                      ></span>
                    <div class="form-control">{{Admin('address')}}</div>
                    </div>
                  </div>

                  <div class="col-sm-6 col-md-4 mb-3">
                    <label class="form-label" for="basic-icon-default-phone">Country</label>
                    <div class="input-group input-group-merge">
                      <span id="basic-icon-default-phone2" class="input-group-text"
                        ><i class="bx bx-country"></i
                      ></span>
                      <div class="form-control">{{Admin('country')}}</div>
                    </div>
                  </div>

                  <div class="col-sm-6 col-md-4 mb-3">
                    <label class="form-label" for="basic-icon-default-phone">State</label>
                    <div class="input-group input-group-merge">
                      <span id="basic-icon-default-phone2" class="input-group-text"
                        ><i class="bx bx-country"></i
                      ></span>
                      <div class="form-control">{{Admin('state')}}</div>
                    </div>
                  </div>

                  <div class="col-sm-6 col-md-4 mb-3">
                    <label class="form-label" for="basic-icon-default-phone">LGA / City</label>
                    <div class="input-group input-group-merge">
                      <span id="basic-icon-default-phone2" class="input-group-text"
                        ><i class="bx bx-country"></i
                      ></span>
                      <div class="form-control">{{Admin('lga')}}</div>
                    </div>
                  </div>

                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection

  