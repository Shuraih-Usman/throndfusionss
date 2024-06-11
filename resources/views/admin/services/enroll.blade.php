@extends('admin.app')

@section('title')
    Enrolled Services
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><a href="/admin/dashboard" class="text-muted fw-light">Dashboard /</a> <a href="{{route('admin.services')}}" class="text-muted fw-light">Services /</a> Enrolled Services</h4>

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#create">
      Create Category
    </button>

    <!-- Basic Bootstrap Table -->
    <div class="card">
    
    <div id="model" data-name="service_enrolls"></div>

    

    <div style="display: flex;justify-content: space-between;" class="mb-0 d-flex justify-content-around">
      
      <h5 class="card-header showingBy"> Services </h5>
      <div class="m-3">
        <div class="btn-group">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action
            </button>
            <ul class="dropdown-menu" style="">
                <li> <a class="dropdown-item waves-light waves-effect activateAll" href="javascript:void(0);">Activate All</a> </li>
                <li><a class="dropdown-item waves-light waves-effect draftAll" href="javascript:void(0);">Draft All</a> </li>
            </ul>


        </div>

        <div class="btn-group">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Showing By
            </button>
            <ul class="dropdown-menu" style="">
                <li>  <a class="dropdown-item waves-light waves-effect showAll" href="javascript:void(0);">Show All</a> </li>
                <li>  <a class="dropdown-item waves-light waves-effect showActive" href="javascript:void(0);">Active</a> </li>
                <li>  <a class="dropdown-item waves-light waves-effect showDraft" href="javascript:void(0);">Draft</a>  </li>
            </ul>
        </div>
    </div>
</div>


      <div class="table-responsive text-nowrap m-3">
        <table id="dataTable" class="table" data-filter="ALL">
          <thead>
            <tr>
              <th>Id</th>
              <th>Image </th>
              <th>Title</th>
              <th>User </th>
              <th>Buyer </th>
              <th>Price</th>
              <th>Delivery</th>
              <th>Status</th>
              <th>Actions</th>
              <th>Date</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
    <!--/ Basic Bootstrap Table -->
  </div>


  <div class="modal fade" id="service_enroll_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="se_title"></h5>
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
                <p id="se_img"></p>
            </div>
            <div class="col-sm-6 col-md-6">
              <span>Price</span>
              <p id="se_price"></p>
            </div>

            <div class="col-sm-6 col-md-6">
              <span>Quantity</span>
              <p id="se_quantity"></p>
            </div>

            <div class="col-sm-6 col-md-6">
              <span>Total</span>
              <p id="se_toal"></p>
            </div>

            <div class="col-sm-6 col-md-6">
                <span>User</span>
                <p id="se_user"></p>
              </div>

            

            <div class="col-sm-6 col-md-6">
              <span>Buyer</span>
              <p id="se_buyer"></p>
            </div>

            <div class="col-sm-6 col-md-6">
                <span>Transaction id</span>
                <p id="se_transactionid"></p>
              </div>

            <div class="col-sm-6 col-md-6">
              <span>Delivery Day</span>
              <p id="se_delivery"></p>
            </div>

            <div class="col-sm-6 col-md-6">
                <span>Acquire date</span>
                <p id="se_date"></p>
              </div>

            <div class="col-sm-6 col-md-6">
              <span>Status</span>
              <p id="se_status"></p>
            </div>
            <div class="col-sm-12">
              <h2 class="mt-3">Description</h2>
              <p id="se_desc"></p>
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


  <div class="modal fade" id="proof_details" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="proof_title"></h5>
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
                <h3> Image Proof </h3>
                <p id="proof_img"></p>
            </div>
            <div class="col-sm-12">
              <h3>Text Proof</h3>
              <p id="proof_text"></p>
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

  <div class="modal fade" id="require_details" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="require_title"></h5>
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
                <h3> Image </h3>
                <p id="require_img"></p>
            </div>
            <div class="col-sm-12">
              <h3>Requirement</h3>
              <p id="require_text"></p>
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


@endsection