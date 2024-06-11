@extends('user.app')

@section('title')
    Wallet
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><a href="/user/dashboard" class="text-muted fw-light">Dashboard /</a>Wallet</h4>


    <div id="model" data-name="wallets"></div>
    <div class="row">
        
    <div class="col-12 mb-4">
            <div class="card h-100">
              <div class="card-body  text-center">

                <h4 class="mb-2 pb-1">{{CUR.Admin('balance')}}</h4>
                <p class="small">Wallet Balance</p>
                <div class="row mb-3 g-3">
                  <div class="col-6">
                    <div class="d-flex">
                      <div class="avatar flex-shrink-0 me-2">
                        <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-money bx-sm"></i></span>
                      </div>
                      <div>
                        <h6 class="mb-0 text-nowrap">{{CUR.Admin('balance')}}</h6>
                        <small>Wallet Balance</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="d-flex">
                      <div class="avatar flex-shrink-0 me-2">
                        <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-bitcoin bx-sm"></i></span>
                      </div>
                      <div>
                        <h6 class="mb-0 text-nowrap">{{Admin('coins')}}</h6>
                        <small>Throne Fusion Coin</small>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                <div class="col-sm-6 col-md-6 text-center mb-3">
                  <a href="javascript:void(0);" id="user_add_funds" class="btn btn-primary w-100 d-grid ">Add Funds to wallet</a>
                </div>
                <div class="col-sm-6 col-md-6 text-center mb-3">
                    <a href="javascript:void(0);" id="user_add_coins" class="btn btn-primary w-100 d-grid">Buy TF coins</a>
                  </div>

                  <div class="col-12 text-center mb-3">
                    <a href="javascript:void(0);" id="user_withdraw" class="btn btn-primary w-100 d-grid">Withdraw</a>
                  </div>
                </div>
              </div>
            </div>
          </div>


    </div>

    <div class="col-12 mb-5 mt-3">
        <div class="card">
            <div class="card-header">History</div>

            <div class="table-responsive text-nowrap m-3">
                <table id="dataTable" class="table" data-filter="ALL">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Amount</th>
                      <th>Type</th>
                      <th>Transaction ID </th>
                      <th>Status</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                </table>
              </div>
        </div>
    </div>

  </div>

  <input type="hidden" id="user_id" value="{{Admin('id')}}">
  <input type="hidden" id="user_email" value="{{Admin('email')}}">
  <input type="hidden" id="fullname" value="{{Admin('fullname')}}">



@endsection