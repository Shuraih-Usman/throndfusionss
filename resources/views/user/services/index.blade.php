@extends('user.app')

@section('title')
    Service
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><a href="/user/dashboard" class="text-muted fw-light">Dashboard /</a>Service</h4>


    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#create">
      Create Service
    </button>

    <!-- Basic Bootstrap Table -->
    <div class="card">
    
    <div class="row">
        
        <div class="col-xl-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card shadow mt-3">
            <div id="model" data-name="services"></div>
            <div style="display: flex;justify-content: space-between;" class="mb-0 d-flex justify-content-around">
              
              <h5 class="card-header showingBy">My Services</h5>
              <div class="m-3">
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action
                    </button>
                    <ul class="dropdown-menu" style="">
                        <li> <a class="dropdown-item waves-light waves-effect activateAll" href="javascript:void(0);">Activate All</a> </li>
                        <li><a class="dropdown-item waves-light waves-effect closeAll" href="javascript:void(0);">Close All</a> </li>
                    </ul>


                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Showing By
                    </button>
                    <ul class="dropdown-menu" style="">
                        <li>  <a class="dropdown-item waves-light waves-effect showAll" href="javascript:void(0);">Show All</a> </li>
                        <li>  <a class="dropdown-item waves-light waves-effect showActive" href="javascript:void(0);">Actived</a> </li>
                        <li>  <a class="dropdown-item waves-light waves-effect showClosed" href="javascript:void(0);">Closed</a>  </li>

                    </ul>
                </div>
            </div>
        </div>
        
        <div class="table-responsive text-nowrap m-3">
                <table id="dataTable" class="table" data-filter="ALL">
                <thead>
                    <tr>
                    <th>Id</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                    <th>Date</th>
                    </tr>
                </thead>
                </table>
            </div>
        </div>
    </div>

    
        <div class="col-xl-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card shadow mt-3">
            <div id="model" data-name="services"></div>
            
            <div style="display: flex;justify-content: space-between;" class="mb-0 d-flex justify-content-around">
            
                <h5 class="card-header showingBy">On work services</h5>
                <div class="m-3">
            

                </div>
            </div>
        
        
            <div class="table-responsive text-nowrap m-3">
                <table id="onwork_services" class="table" data-filter="ALL">
                <thead>
                    <tr>
                    <th>Id</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Date</th>
                    </tr>
                </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="col-xl-12 col-sm-12 col-md-12 col-lg-12">
      <div class="card shadow mt-3">
      
      <div style="display: flex;justify-content: space-between;" class="mb-0 d-flex justify-content-around">
      
          <h5 class="card-header showingBy">Purchase Services</h5>
          <div class="m-3">
      

          </div>
      </div>
  
  
      <div class="table-responsive text-nowrap m-3">
          <table id="purchase_services" class="table" data-filter="ALL">
          <thead>
              <tr>
              <th>Id</th>
              <th>Image</th>
              <th>Name</th>
              <th>Status</th>
              <th>Date</th>
              </tr>
          </thead>
          </table>
      </div>
  </div>
</div>

    </div>
    </div>

  </div>


   <!-- Large Modal -->
   <div class="modal fade" id="create" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel3">Create Service</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <form class="" id="addform">
          @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6 mb-3">
              <label for="nameLarge" class="form-label">Name</label>
              <input type="text" name="title" id="" class="form-control" placeholder="Enter project Name" />
            </div>
         
            <div class="col-sm-6 mb-3">
              <label for="nameLarge" class="form-label">Category</label>
              
              <select name="category" id="cats_services" class="wide">
                
              </select>

            </div>

            <div class="col-12 mb-3" id="">
              <label for="emailLarge" class="form-label nice-select-search">Image</label>
              <input type="file" name="image" id="" class="form-control">
              </select>
            </div>


          </div>

          <div class="row g2">
            
            <div class="col-sm-6 mb-3" id="stopDate" style="">
                <label for="emailLarge" class="form-label">Price</label>
                <input type="number" name="price" id="" class="form-control" placeholder="0.0">
              </div>
            <div class="col-sm-6 mb-3">
              <label for="emailLarge" class="form-label nice-select-search">Delivery Day</label>
              <input type="text" name="delivery" class="form-control" placeholder="0" />
              <small>amount of days it would take you to accomplish the tasks </small>
            </div>
        </div>


          <div class="row">
            <div class="col mb-0">
              <label for="emailLarge" class="form-label">Description</label>
              <textarea class="form-control mt-3 editor" id="" name="description"></textarea>

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
          </button>
          <input type="hidden" name="action" value="add">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="editmodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="">Edit</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <form class="" id="modaddform">
          @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6 mb-3">
              <label for="nameLarge" class="form-label">Name</label>
              <input type="text" name="title" id="title" class="form-control"/>
            </div>
         
            <div class="col-sm-6 mb-3">
              <label for="nameLarge" class="form-label">Category</label>
              <select class="wide" name="category" id="service_cat_edit">

              </select>

            </div>

            <div class="col-sm-6 mb-3">
                <label for="emailLarge" class="form-label">Image Preview</label>
                <div id="img_preview"></div>
              </div>

              <div class="col-sm-6 mb-3">
                <label for="emailLarge" class="form-label">Image</label>
                <input type="file" name="image" id="" class="form-control"/>
              </div>

          </div>

          <div class="row g2">
            <div class="col-sm-6 mb-3">
              <label for="emailLarge" class="form-label">Price</label>
              <input type="number" name="price" id="price_edit" class="form-control" placeholder="0.0" />
            </div>

            <div class="col-sm-6 mb-3">
              <label for="emailLarge" class="form-label">Delivery Day</label>
              <input type="number" name="delivery" id="delivery_edit" class="form-control" placeholder="0.0" />
            </div>
          </div>

          <div class="row">
 
           

            <div class="col mb-0">
              <label for="emailLarge" class="form-label">Description</label>
              <textarea class="form-control mt-3 " id="edit" name="description"></textarea>

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
          </button>
          <input type="hidden" name="action" value="edit">
          <input type="hidden" id="rowID" name="id" value="">
          <input type="hidden" id="imghidden" name="hiddenimg" value="">
          <input type="hidden" id="folderhidden" name="hiddenfolder" value="">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="viewSModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="">Service Detail</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
      
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6 mb-3">
              <label for="nameLarge" class="form-label">Name</label>
              <div class="form-control" id="view_name"> </div>
            </div>
         
            <div class="col-sm-6 mb-3">
              <label for="nameLarge" class="form-label">Category</label>
              
              <div class="form-control" id="view_cat"> </div>

            </div>

            <div class="col-12 mb-3" id="">
              <label for="emailLarge" class="form-label nice-select-search">Image</label>
              <div class="form-control" id="view_image"> </div>
            </div>


            <div class="col-sm-6 mb-3" id="" style="">
                <label for="emailLarge" class="form-label">Price</label>
                <div class="form-control" id="view_price"> </div>
              </div>
            <div class="col-sm-6 mb-3">
              <label for="emailLarge" class="form-label nice-select-search">Delivery Day</label>
              <div class="form-control" id="view_delivery"> </div>
            </div>



            <div class="col mb-0">
              <label for="emailLarge" class="form-label">Description</label>
              <div class="form-control" id="view_desc"> </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
          </button>
          
        </div>
    
      </div>
    </div>
  </div>


  <div class="modal fade" id="service_details_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="don_title"></h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
       
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6">
              <span>Price in Total</span>
              <p id="don_goal"></p>
            </div>

            <div class="col-sm-6">
              <span>Quantity</span>
              <p id="don_amount"></p>
            </div>

            <div class="col-sm-6">
              <span>Date</span>
              <p id="don_cre_date"></p>
            </div>


            <div class="col-sm-6">
              <span>Delivery days</span>
              <p id="don_pr_status"></p>
            </div>
            <div class="col-sm-6">
              <span>Days Remain</span>
              <p id="don_p_status"></p>
            </div>

            <div class="col-sm-6">
              <span>Buyer</span>
              <p id="serv_buyer"></p>
            </div>

            <div class="col-12">
              <h2 class="modal-title mb-2"> Deliver / Finish </h2>
              <h5> Proof </h5>
            </div>
            <form method="POST" id="addform">
              @csrf
            <div class="col-12">
              <label> Image Proof</label>
              <input type="file" name="image" class="form-control mb-2" placeholder="Image Proof">
            </div>
            <div class="col-12">
              <label>Text Proof </label>
              <textarea name="proof" class="form-control mt-2"></textarea>
            </div>
            <div class="col-12 mt-2">
              <input type="hidden" name="id" id="enroll_id">
              <input type="hidden" name="action" value="deliver_service">
              <button type="submit" class="btn btn-primary">
                SUBMIT
              </button>
            </div>
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
          </button>
          
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="service_proof_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="don_title"></h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
       
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <h2 class="modal-title mb-2"> Check Proof of work </h2>
            </div>
            <div class="col-12 mb-3">
              <h2 class="mb-2">Image</h2>
              <div id="img_preview_service"></div>
            </div>

            <div class="col-12 mb-3">
              <h2 class="mb-2">Text Proof</h2>
              <p id="prf_service"></p>
            </div>



            <div class="col-12">
              <h2 class="modal-title mb-2"> Approve </h2>
            </div>
            <form method="POST" id="addform">
              @csrf
            <div class="col-12 mt-2">
              <input type="hidden" name="id" id="enroll_id_2">
              <input type="hidden" name="action" value="approve_service">
              <button type="submit" class="btn btn-primary">
                SUBMIT
              </button>
            </div>
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
          </button>
          
        </div>
      </div>
    </div>
  </div>
</div>


@endsection