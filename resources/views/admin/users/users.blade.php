@extends('admin.app')

@section('title')
    Users
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><a href="/admin/dashboard" class="text-muted fw-light">Dashboard /</a> Users</h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
    
    <div id="model" data-name="users"></div>

    <div style="display: flex;justify-content: space-between;" class="mb-0 d-flex justify-content-around">
      <h5 class="card-header showingBy"> Users</h5>
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
              <th>Name</th>
              <th>Username</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Type</th>
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
@endsection