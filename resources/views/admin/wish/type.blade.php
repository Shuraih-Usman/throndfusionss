@extends('admin.app')

@section('title')
    Wishlists Category
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><a href="/admin/dashboard" class="text-muted fw-light">Dashboard /</a> Wishlists Category</h4>


    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#create">
        Wishlists Category
    </button>

    <!-- Basic Bootstrap Table -->
    <div class="card">
    
    <div id="model" data-name="wishlists_types"></div>

    

    <div style="display: flex;justify-content: space-between;" class="mb-0 d-flex justify-content-around">
      
      <h5 class="card-header showingBy"> Wishlists Cats </h5>
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
              <th>Title</th>
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


   <!-- Large Modal -->
   <div class="modal fade" id="create" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel3">Create Wishlist category</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <form class="" method="post"  id="modaddform">
          @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="nameLarge" class="form-label">Name</label>
              <input type="text" name="title" id="" class="form-control" placeholder="Enter project Name" />
            </div>
          </div>


          <div class="row">
            <div class="col mb-0">
              <textarea class="form-control mt-3 editor" id="" name="description"></textarea>

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
          </button>
          <button type="submit" class="btn btn-primary">Submit</button>
          <input type="hidden" name="action" value="add"> 
         </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="editmodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel3">Edit Wishlists Category</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <form class="" method="post"  id="modaddform">
          @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="nameLarge" class="form-label">Name</label>
              <input type="text" name="title" id="titleedit" class="form-control" placeholder="Enter project Name" />
            </div>
          </div>


          <div class="row">
            <div class="col mb-0">
              <textarea class="form-control mt-3 editor" id="desc" name="description"></textarea>

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
          </button>
          <button type="submit" class="btn btn-primary">Submit</button>
          <input type="hidden" name="action" value="edit"> 
          <input type="hidden" name="id" id="rowID"> 
         </div>
        </form>
      </div>
    </div>
  </div>


@endsection