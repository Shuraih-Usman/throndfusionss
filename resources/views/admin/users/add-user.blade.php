@extends('admin.app')

@section('title')
    Add User
@endsection
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><a href="/admin/dashboard" class="text-muted fw-light">Dashboard /</a> <a href="/admin/users" class="text-muted fw-light">Users /</a>  Add User</h4>
      <div id="model" data-name="users"></div>
      <!-- Basic Layout -->
      <div class="row">
        
        <div class="col-xl">
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Fill User Data </h5>
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
                    />
                  
                  </div>
                  
                </div>
                <div class="col-sm-6 col-md-6 mb-3">
                  <label class="form-label" for="basic-icon-default-company">Image</label>
                  <div class="input-group input-group-merge">
                    <span id="basic-icon-default-company2" class="input-group-text"
                      ><i class="bx bx-image"></i
                    ></span>
                    <input
                      type="file"
                      name="image"
                      id="basic-icon-default-company"
                      class="form-control"
                    />
                  </div>
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
                    />
                  </div>
                </div>

                <div class="col-sm-6 col-md-6 mb-3">
                    <label class="form-label" for="basic-icon-default-phone">Account type</label>
                    <div class="input-group input-group-merge">
                      
                      <select name="role" id="select_role" class="form-control">
                        <option value="1"> Normal User </option>
                        <option value="2"> Creator </option>
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-6 col-md-6 mb-3">
                    <label class="form-label" for="basic-icon-default-phone">Gender</label>
                    <div class="input-group input-group-merge">
                      
                      <select name="gender" id="select_gender" class="form-control">
                        <option value="1"> Male </option>
                        <option value="2"> Female </option>
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
                      />
                    </div>
                  </div>

                  <div class="col-sm-6 col-md-6 mb-3">
                    <label class="form-label" for="basic-icon-default-phone">Address</label>
                    <div class="input-group input-group-merge">
                      <span id="basic-icon-default-phone2" class="input-group-text"
                        ><i class="bx bx-street-view"></i
                      ></span>
                      <textarea name="address" class="form-control"></textarea>
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
                        name="city"
                        id=""
                        class="form-control"
                        aria-describedby="basic-icon-default-phone2"
                      />
                    </div>
                  </div>

                  

                  <div class="col-sm-6 col-md-6 mb-3">
                    <div class="input-group input-group-merge">
                      
                      <label class="toggle2">
                        <input name="status" class="toggle-checkbox" type="checkbox" checked>
                        <div class="toggle-switch"></div>
                        <span class="toggle-label">Status</span>
                      </label>
                    </div>
                  </div>

                  <input type="hidden" name="action" value="add">
                <button id="submit" type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection

  