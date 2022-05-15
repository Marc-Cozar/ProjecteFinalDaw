@extends('layouts.app')

@section('content')
    {{-- <h1>{{Auth::guard('customer')->user()}}</h1> --}}

    <div class="container">
        <hr class="mt-0 mb-4">
        <div class="row">
            <div class="col-xl-4">
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Profile Picture</div>
                    <div class="card-body text-center"> <img class="img-account-profile rounded-circle mb-2"
                            src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="">
                        <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div> <button
                            class="btn btn-primary" type="button">Upload new image</button>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">Account Details</div>
                    <div class="card-body">
                        <form>
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1">First name</label>
                                    <p class="form-control">{{ auth()->user()->name }}</p>
                                    {{-- <p class="form-control">{{Auth::guard('customer')->user()->name}}</p> --}}
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1">Last name</label>
                                    <p class="form-control">{{ auth()->user()->surname }}</p>
                                    {{-- <p class="form-control">{{Auth::guard('customer')->user()->surname}}</p> --}}
                                </div>
                            </div>
                            <div class="row gx-3 mb-3">
                                <div class="mb-3 col-md-6">
                                    <label class="small mb-1">Email address</label>
                                    <p class="form-control">{{ auth()->user()->email }}</p>
                                    {{-- <p class="form-control">{{Auth::guard('customer')->user()->email}}</p> --}}
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="small mb-1">Password</label>
                                    <input type="password" readonly class="form-control" placeholder="Password" value="********">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="small mb-1 invisible">button</label>
                                    <button class="btn btn-primary float-right" type="button">Change password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection