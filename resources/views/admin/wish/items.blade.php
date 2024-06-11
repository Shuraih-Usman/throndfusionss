@extends('admin.app')

@section('title')
Wishes Items
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><a href="/admin/dashboard" class="text-muted fw-light">Dashboard /</a> Wishes Items</h4>


    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#create">
        Wishes Items
    </button>

    <!-- Basic Bootstrap Table -->
    <div class="card">
    
    <div id="model" data-name="wishlist_items"></div>

    

    <div style="display: flex;justify-content: space-between;" class="mb-0 d-flex justify-content-around">
      
      <h5 class="card-header showingBy"> Wishes Items </h5>
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
    <!--/ Basic Bootstrap Table -->

  </div>


   <!-- Large Modal -->
   <div class="modal fade" id="create" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel3">Add Item</h5>
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
            <div class="col-sm-6 mb-3">
              <label for="nameLarge" class="form-label">Name</label>
              <input type="text" name="title" id="" class="form-control" placeholder="Enter project Name" />
            </div>

            <div class="col-sm-6 mb-3">
                <label for="nameLarge" class="form-label">Price</label>
                <input type="number" name="price" id="" class="form-control" />
              </div>
          </div>


          <div class="row">
            <div class="col-12 mb-3">
                <input type="file" name="image" class="form-control"/>
              </div>
            <div class="col-12 mb-0">
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
            <div class="col-sm-6 mb-3">
              <label for="nameLarge" class="form-label">Name</label>
              <input type="text" name="title" id="titleedit" class="form-control" placeholder="" />
            </div>

            <div class="col-sm-6 mb-3">
                <label for="nameLarge" class="form-label">Price</label>
                <input type="number" name="price" id="price" class="form-control" />
              </div>
          </div>


          <div class="row">
            <div class="col-sm-6 mb-3">
                <div id="img_preview"></div>
            </div>
            <div class="col-sm-6 mb-3">
                <input type="file" name="image" class="form-control"/>
              </div>

            <div class="col-12 mb-0">
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
          <input type="hidden" name="img" id="hiddenimg"> 
          <input type="hidden" name="img_folder" id="hiddenfolder"> 
         </div>
        </form>
      </div>
    </div>
  </div>


@endsection