@extends('user.app')

@section('title')
    Project Campaigns
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><a href="/user/dashboard" class="text-muted fw-light">Dashboard /</a>Fund Raising Campaigns</h4>


    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#create">
      Create Campaign Project
    </button>

    <!-- Basic Bootstrap Table -->
    <div class="card">
    
    <div id="model" data-name="campaigns"></div>

    

    <div style="display: flex;justify-content: space-between;" class="mb-0 d-flex justify-content-around">
      
      <h5 class="card-header showingBy"> My Campaigns</h5>
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
                <li>  <a class="dropdown-item waves-light waves-effect showPending" href="javascript:void(0);">Pending</a>  </li>

            </ul>
        </div>
    </div>
</div>


      <div class="table-responsive text-nowrap m-3">
        <table id="dataTable" class="table" data-filter="ALL">
          <thead>
            <tr>
              <th>Id</th>
              <th>Name</th>
              <th>Type</th>
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


    <div class="card mt-5">
      <h2 class="card-header">Investments</h2>

      <div class="card-block">
        <div class="table-responsive text-nowrap m-3">
          <table id="investment_table" class="table" data-filter="ALL">
            <thead>
              <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Date</th>
              </tr>
            </thead>
          </table>
        </div> 
      </div>
    </div>


    <div class="card mt-5">
      <h2 class="card-header">Donations</h2>

      <div class="card-block">
        <div class="table-responsive text-nowrap m-3">
          <table id="donation_table" class="table" data-filter="ALL">
            <thead>
              <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Date</th>
              </tr>
            </thead>
          </table>
        </div> 
      </div>
    </div>
  
  

  </div>


   <!-- Large Modal -->
   <div class="modal fade" id="create" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel3">Create Fund Raising Project</h5>
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
              <label for="nameLarge" class="form-label">Raising Type</label>
              <select name="project_type" id="select_type" class="wide">
                <option value="1"> Donation </option>
                <option value="2"> Investing </option>
              </select>

            </div>

            <div class="col-sm-6 mb-3" id="sharedAmount" style="display:none;">
              <label for="emailLarge" class="form-label nice-select-search">Shared Amount to investors</label>
              <input type="number" name="shared" id="shared" class="form-control" placeholder="0.0" disabled>
              </select>
            </div>

            <div class="col-sm-6 mb-3" id="stopDate" style="display:none;">
              <label for="emailLarge" class="form-label">Stop date</label>
              <input type="date" name="stopdate" id="stop_date" class="form-control" placeholder="0.0" disabled>
            </div>

          </div>

          <div class="row g2">
            <div class="col-sm-6 mb-3">
              <label for="emailLarge" class="form-label nice-select-search">Project Type</label>
              <select name="campaign_type" id="select_project" class="wide">
              </select>
            </div>

            <div class="col-sm-6 mb-3">
              <label for="emailLarge" class="form-label">Goal Amount</label>
              <input type="number" name="goal" class="form-control" placeholder="0.0" />
            </div>

          <div class="col-sm-12 mb-3">
            <label for="" class="form-label">Image</label>
            <input type="file" name="image" class="form-control" placeholder=""/>
          </div>
        </div>

          <div class="row">
            <div class="col mb-0">
              <label for="" class="form-label">Description</label>
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
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel3">Edit</h5>
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
              <input type="text" name="title" id="title" class="form-control" placeholder="Enter project Name" />
            </div>
         
            <div class="col-sm-6 mb-3">
              <label for="nameLarge" class="form-label">Raising Type</label>
              <input type="text" id="project_type" class="form-control" disabled>

            </div>

            <div class="col-sm-6 mb-3" id="sharedAmountEdit" style="display:none;">
              <label for="emailLarge" class="form-label nice-select-search">Shared Amount to investors</label>
              <input type="number" name="shared" id="edit-shared" class="form-control" placeholder="0.0" disabled>
              </select>
            </div>

            <div class="col-sm-6 mb-3" id="stopDateEdit" style="display:none;">
              <label for="emailLarge" class="form-label">Stop date</label>
              <input type="date" name="stopdate" id="stop_date_edit" class="form-control" placeholder="0.0" disabled>
            </div>
          </div>

          <div class="row g2">
            <div class="col-sm-6 mb-3">
              <label for="emailLarge" class="form-label nice-select-search">Project Type</label>
              <select name="campaign_type" id="select_project2" class="wide">
              </select>
            </div>

            <div class="col-sm-6 mb-3">
              <label for="emailLarge" class="form-label">Goal Amount</label>
              <input type="number" name="goal" id="goal" class="form-control" placeholder="0.0" />
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
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
      </div>
    </div>
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
            <div class="col-sm-6">
              <span>Goal</span>
              <p id="inv_goal"></p>
            </div>

            <div class="col-sm-6">
              <span>Amount Paid</span>
              <p id="inv_amount"></p>
            </div>

            <div class="col-sm-6">
              <span>Share</span>
              <p id="inv_shared"></p>
            </div>

            

            <div class="col-sm-6">
              <span>Creation Date</span>
              <p id="inv_cre_date"></p>
            </div>

            <div class="col-sm-6">
              <span>Ending Date</span>
              <p id="inv_end_date"></p>
            </div>

            <div class="col-sm-6">
              <span>Project Status</span>
              <p id="inv_pr_status"></p>
            </div>
            <div class="col-sm-6">
              <span>Payment Status</span>
              <p id="inv_p_status"></p>
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
              <span>Creation Date</span>
              <p id="don_cre_date"></p>
            </div>


            <div class="col-sm-6">
              <span>Project Status</span>
              <p id="don_pr_status"></p>
            </div>
            <div class="col-sm-6">
              <span>Payment Status</span>
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