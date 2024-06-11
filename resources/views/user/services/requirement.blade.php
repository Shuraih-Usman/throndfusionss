@extends('user.app')

@section('title')
    Service Requirement
@endsection

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><a href="/user/dashboard" class="text-muted fw-light">Dashboard /</a><a href="/user/services" class="text-muted fw-light">Service /</a>Requirements</h4>

    <div class="card">
        <div class="row">
            <div class="col-12">
                <h5 class="card-header">Pls Input your requirement for the services</h5>

                <form id="service_requirement" class="row m-5" method="POST">
                    @csrf
                    <div class="col-12 mb-2">
                        <textarea name="requirement" id="" class="form-control"></textarea>
                    </div>
                    <div class="col-12 mb-2">
                        <input type="hidden" name="id" value="{{$id}}">
                        <input type="hidden" name="action" value="service_requirement">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                    
                </form>
            </div>
        </div>

@endsection