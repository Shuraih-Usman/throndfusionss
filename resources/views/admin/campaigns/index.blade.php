@extends('admin.app')

@section('title')
    Campaigns
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><a href="/admin/dashboard" class="text-muted fw-light">Dashboard /</a>  Campaigns</h4>



    <!-- Basic Bootstrap Table -->
<div class="card">
    
    <div id="model" data-name="campaigns"></div>

    

    <div style="display: flex;justify-content: space-between;" class="mb-0 d-flex justify-content-around">
      
      <h5 class="card-header showingBy"> Types </h5>
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
          <th>Type</th>
          <th>Name</th>
          <th>Username</th>
          <th>Goal Amount</th>
          <th>Current Amount</th>
          <th>Donators / Investors</th>
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




  <div class="modal fade" id="invest_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="inv_title"></h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
       
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6 col-md-6">
              <span>Goal</span>
              <p id="inv_goal"></p>
            </div>

            <div class="col-sm-6 col-md-6">
              <span>Current Amount</span>
              <p id="inv_amount"></p>
            </div>

            <div class="col-sm-6 col-md-6">
              <span>Investors Shared</span>
              <p id="inv_shared"></p>
            </div>

            <div class="col-sm-6 col-md-6">
                <span>Category</span>
                <p id="inv_category"></p>
              </div>

            

            <div class="col-sm-6 col-md-6">
              <span>Creation Date</span>
              <p id="inv_cre_date"></p>
            </div>

            <div class="col-sm-6 col-md-6">
              <span>Ending Date</span>
              <p id="inv_end_date"></p>
            </div>

            <div class="col-sm-6 col-md-6">
              <span>Project Status</span>
              <p id="inv_pr_status"></p>
            </div>
            <div class="col-sm-12">
              <h2 class="mt-3">Description</h2>
              <p id="inv_description"></p>
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

  <div class="modal fade" id="donate_modal" tabindex="-1" aria-hidden="true">
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
              <span>Goal</span>
              <p id="don_goal"></p>
            </div>

            <div class="col-sm-6">
              <span>Amount Paid</span>
              <p id="don_amount"></p>
            </div>

            <div class="col-sm-6">
                <span>Category</span>
                <p id="don_category"></p>
              </div>

            <div class="col-sm-6">
              <span>Creation Date</span>
              <p id="don_cre_date"></p>
            </div>


            <div class="col-sm-6">
              <span>Project Status</span>
              <p id="don_pr_status"></p>
            </div>
            <div class="col-sm-6">
                <span>Project By</span>
                <p id="don_username"></p>
              </div>

            <div class="col-12">
              <h2 class="mt-3">Description</h2>
              <p id="don_p_status"></p>
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