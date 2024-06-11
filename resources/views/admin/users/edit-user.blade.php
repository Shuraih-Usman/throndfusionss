@extends('admin.app')

@section('title')
    Edit User
@endsection
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><a href="/admin/dashboard" class="text-muted fw-light">Dashboard /</a> <a href="{{route('admin.users')}}" class="text-muted fw-light">Users /</a>  Edit User</h4>
      <div id="model" data-name="users"></div>
      <!-- Basic Layout -->
      <div class="row">
        
        <div class="col-xl">
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Edit User Data </h5>
            </div>
            <div class="card-body">
              <form id="addform" class="row" enctype="multipart/form-data">
                @csrf
                <div class="col-sm-6 col-md-6 mb-3">
                  <label class="form-label" for="basic-icon-default-fullname">Full Name</label>
                  <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                      ><i class="bx bx-user"></i
                    ></span>
                    <input
                      type="text"
                      name="fullname"
                      class="form-control"
                      id="basic-icon-default-fullname"
                      placeholder="John Doe"
                      aria-label="John Doe"
                      aria-describedby="basic-icon-default-fullname2"
                      value="{{$user->fullname}}"
                    />
                  </div>
                </div>
                <div class="col-sm-6 col-md-6 mb-3">
                  <label class="form-label" for="basic-icon-default-email">Username</label>
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                    <input
                      type="text"
                      
                      name="username"
                      id="basic-icon-default-email"
                      class="form-control"
                      aria-describedby="basic-icon-default-email2"
                      value="{{$user->username}}"
                    />
                  
                  </div>
                  
                </div>
                <div class="col-sm-6 col-md-6 mb-3">
                  <label class="form-label" for="basic-icon-default-company">Image</label>
                  <div class="input-group input-group-merge">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{'/images/'.$user->image_folder.$user->image}}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar">
                        <div class="button-wrapper">
                          <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Upload new photo</span>
                            <i class="bx bx-upload d-block d-sm-none"></i>
                            <input type="file" name="image" id="upload" class="account-file-input" hidden="" accept="image/png, image/jpeg">
                          </label>
                          <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                            <i class="bx bx-reset d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset</span>
                          </button>

                          <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                        </div>
                      </div>
                  </div>
                  <input type="hidden" name="img" value="{{$user->image}}"/>
                  <input type="hidden" name="img_folder" value="{{$user->image_folder}}"/>
                </div>
                <div class="col-sm-6 col-md-6 mb-3">
                  <label class="form-label" for="basic-icon-default-email">Email</label>
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                    <input
                      type="text"
                      name="email"
                      id="basic-icon-default-email"
                      class="form-control"
                      placeholder="@example.com"
                      aria-label="@example.com"
                      aria-describedby="basic-icon-default-email2"
                      value="{{$user->email}}"
                    />
                    <span id="basic-icon-default-email2" class="input-group-text">@example.com</span>
                  </div>
                  <div class="form-text">You can use letters, numbers & periods</div>
                </div>

                <div class="col-sm-6 col-md-6 mb-3">
                  <label class="form-label" for="basic-icon-default-phone">Phone No</label>
                  <div class="input-group input-group-merge">
                    <span id="basic-icon-default-phone2" class="input-group-text"
                      ><i class="bx bx-phone"></i
                    ></span>
                    <input
                      type="text"
                      name="phone"
                      id="basic-icon-default-phone"
                      class="form-control phone-mask"
                      placeholder="658 799 8941"
                      aria-label="658 799 8941"
                      aria-describedby="basic-icon-default-phone2"
                      value="{{$user->phone}}"
                    />
                  </div>
                </div>

                <div class="col-sm-6 col-md-6 mb-3">
                    <label class="form-label" for="basic-icon-default-phone">Account type</label>
                    <div class="input-group input-group-merge">
                      
                      <select name="role" id="select_role" class="form-control">
                        <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Normal User</option>
                        <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Creator</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-6 col-md-6 mb-3">
                    <label class="form-label" for="basic-icon-default-phone">Gender</label>
                    <div class="input-group input-group-merge">
                      
                      <select name="gender" id="select_gender" class="form-control">
                        <option value="1" {{$user->gender == 1 ? 'selected' : ''}}> Male </option>
                        <option value="2" {{$user->gender == 2 ? 'selected' : ''}}> Female </option>
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-6 col-md-6 mb-3">
                    <label class="form-label" for="basic-icon-default-phone">Date Of Birth</label>
                    <div class="input-group input-group-merge">
                      <span id="basic-icon-default-phone2" class="input-group-text"
                      ><i class="bx bx-date"></i
                    ></span>
                      <input
                      type="date"
                      name="dob"
                      id=""
                      class="form-control"
                      aria-describedby="basic-icon-default-phone2"
                      value="{{$user->dob}}"
                    />
                    </div>
                  </div>

                  <div class="col-sm-6 col-md-6 mb-3">
                    <label class="form-label" for="basic-icon-default-phone">Organizations</label>
                    <div class="input-group input-group-merge">
                      <span id="basic-icon-default-phone2" class="input-group-text"
                        ><i class="bx bx-group"></i
                      ></span>
                      <input
                        type="text"
                        name="organization"
                        id=""
                        class="form-control"
                        aria-describedby="basic-icon-default-phone2"
                        value="{{$user->organization}}"
                      />
                    </div>
                  </div>

                  <div class="col-sm-6 col-md-6 mb-3">
                    <label class="form-label" for="basic-icon-default-phone">Address</label>
                    <div class="input-group input-group-merge">
                      <span id="basic-icon-default-phone2" class="input-group-text"
                        ><i class="bx bx-street-view"></i
                      ></span>
                      <textarea name="address" class="form-control">{{$user->address}}</textarea>
                    </div>
                  </div>

                  <div class="col-sm-6 col-md-4 mb-3">
                    <label class="form-label" for="basic-icon-default-phone">Country</label>
                    <div class="input-group input-group-merge">
                      <span id="basic-icon-default-phone2" class="input-group-text"
                        ><i class="bx bx-country"></i
                      ></span>
                      <input
                        type="text"
                        name="country"
                        id=""
                        class="form-control"
                        aria-describedby="basic-icon-default-phone2"
                        value="{{$user->country}}"
                      />
                    </div>
                  </div>

                  <div class="col-sm-6 col-md-4 mb-3">
                    <label class="form-label" for="basic-icon-default-phone">State</label>
                    <div class="input-group input-group-merge">
                      <span id="basic-icon-default-phone2" class="input-group-text"
                        ><i class="bx bx-country"></i
                      ></span>
                      <input
                        type="text"
                        name="state"
                        id=""
                        class="form-control"
                        aria-describedby="basic-icon-default-phone2"
                        value="{{$user->state}}"
                      />
                    </div>
                  </div>

                  <div class="col-sm-6 col-md-4 mb-3">
                    <label class="form-label" for="basic-icon-default-phone">LGA / City</label>
                    <div class="input-group input-group-merge">
                      <span id="basic-icon-default-phone2" class="input-group-text"
                        ><i class="bx bx-country"></i
                      ></span>
                      <input
                        type="text"
                        name="lga"
                        id=""
                        class="form-control"
                        aria-describedby="basic-icon-default-phone2"
                        value="{{$user->lga}}"
                      />
                    </div>
                  </div>

                  

                  <div class="col-sm-6 col-md-6 mb-3">
                    <div class="input-group input-group-merge">
                      
                      <label class="toggle2">
                        <input name="status" class="toggle-checkbox" type="checkbox" {{$user->status == 1 ? 'checked' : ''}}>
                        <div class="toggle-switch"></div>
                        <span class="toggle-label">Status</span>
                      </label>
                    </div>
                  </div>
                  <input type="hidden" name="id" value="{{$user->id}}">
                  <input type="hidden" name="action" value="edit">
                <button id="submit" type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection

  