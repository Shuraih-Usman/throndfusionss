@extends('user.app')

@section('title')
    Wishes
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><a href="/user/dashboard" class="text-muted fw-light">Dashboard /</a>Wishes</h4>


    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#create">
      Create a Wishes
    </button>

    <!-- Basic Bootstrap Table -->

    <div class="card shadow mt-3">
    <div id="model" data-name="wishes"></div>


    <div style="display: flex;justify-content: space-between;" class="mb-0 d-flex justify-content-around">
      
      <h5 class="card-header showingBy">My Wishes</h5>
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
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Actions</th>
                    <th>Date</th>
                    </tr>
                </thead>
                </table>
            </div>
        
    </div>

  </div>



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
            <div class="col-sm-12 mb-3">
              <label for="nameLarge" class="form-label">Title</label>
              <input type="text" name="title" id="" class="form-control"/>
            </div>
         
            <div class="col-sm-6 mb-3">
              <label for="nameLarge" class="form-label">Category</label>
              
              <select name="category" id="wish_cats" class="wide">
                
              </select>

            </div>

            <div class="col-sm-6 mb-3">Image</label>
                <input type="file" name="image" id="" class="form-control"/>
              </div>

            <div class="col-sm-6 mb-3">Contact Number</label>
                <input type="text" name="phone" id="" class="form-control"/>
              </div>

              <div class="col-sm-6 mb-3">
                <textarea name="address" class="form-control"></textarea>
                <small>Address to deliver the gifts / wishes </small>
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
            <div class="col-sm-12 mb-3">
              <label for="nameLarge" class="form-label">Title</label>
              <input type="text" name="title" id="title" class="form-control"/>
            </div>
         
            <div class="col-sm-6 mb-3">
              <label for="nameLarge" class="form-label">Category</label>
              
              <select name="category" id="edit-wish-cats" class="wide">
                <option>Asjs</option>
                
              </select>

            </div>

            <div class="col-sm-6 mb-3">Image Preview</label>
              <div id="img_preview"></div>
            </div>

            <div class="col-sm-6 mb-3">Image</label>
                <input type="file" name="image" id="" class="form-control"/>
              </div>

            <div class="col-sm-6 mb-3">Contact Number</label>
                <input type="text" name="phone" id="phone" class="form-control"/>
              </div>

              <div class="col-sm-12 mb-3">
                <textarea name="address" id="address" class="form-control"></textarea>
                <small>Address to deliver the gifts / wishes </small>
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




@endsection