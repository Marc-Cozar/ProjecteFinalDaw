@extends('layouts.app')
@section('content')
    {{-- <h1>{{Auth::guard('customer')->user()}}</h1> --}}
    <div class="container">
        <p class="mt-0 mb-4"></p>
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
                    <div id="ajax_message">
                    </div>
                    @if (Session::has('retCode'))
                        @if (Session::get('retCode') == 1)
                            <div class="alert alert-danger">
                                {{ Session::get('msj') }}
                            </div>
                        @else
                            <div class="alert alert-success">
                                {{ Session::get('msj') }}
                            </div>
                        @endif
                    @endif
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
                                    <input type="password" readonly class="form-control" placeholder="Password"
                                        value="********">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="small mb-1" style="visibility:hidden">Password</label>
                                    <a href=""><button class="btn btn-primary float-right" type="button">Change
                                            password</button></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- {{ dd($suscriptions) }} --}}
                @foreach ($suscriptions as $suscription)
                    {{-- {{ $suscription->product}}
                    {{ 'entra' }}
                    {{ dd($suscription->web->products_prices->where('id', $suscription->product->id)) }} --}}
                    <div class="card">
                        <div class="card-header">
                            <button type="button" id="{{ $suscription->product_id }}_{{ $suscription->web->id }}"
                                class="btn btn-danger btn-sm unsuscribe ">Unsubscribe</button>
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <blockquote class="blockquote mb-0">
                                                <p>{{ $suscription->product->name }}</p>
                                                <footer class="blockquote-footer">{{ $suscription->web->name }}</footer>
                                            </blockquote>
                                        </div>
                                        <div class="col">
                                            <blockquote class="blockquote mb-0 text-end">
                                                {{-- <p>{{ dd($suscription->web) }}</p> --}}
                                                <footer><a
                                                        href="{{ $suscription->web->url }}{{ $suscription->product->name }}"
                                                        target="_blank"><button type="button"
                                                            class="btn btn-primary btn-sm">BUY
                                                            PRODUCT</button></a></footer>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach



            </div>
        </div>

        <script>
            $(document).ready(function() {

                document.querySelectorAll('.unsuscribe').forEach(item => {
                    item.addEventListener('click', function(e) {

                        console.log($(this).attr("id"))
                        id = $(this).attr("id");
                        productWebId = $(this).attr("id").split("_");

                        routeUrl = '{{ route('select2.product.unsuscribe') }}';
                        console.log(routeUrl);
                        $.ajax({
                            url: routeUrl,
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "productId": productWebId[0],
                                "webId": productWebId[1],
                            },
                            type: "post",
                            cache: false,
                            success: function(response) {
                                if (response[1] ==
                                    'danger') {
                                    $('#ajax_message')
                                        .addClass(
                                            "alert alert-danger"
                                        ).text(response[
                                            0]);
                                    setTimeout(function() {
                                        $('#ajax_message')
                                            .removeClass(
                                                "alert alert-danger"
                                            )
                                            .empty();
                                    }, 2000);
                                } else {
                                    $('#ajax_message')
                                        .addClass(
                                            "alert alert-success"
                                        ).text(response[
                                            0]);

                                    setTimeout(function() {
                                        $('#ajax_message')
                                            .delay(
                                                800)
                                            .removeClass(
                                                "alert alert-success"
                                            )
                                            .empty();
                                        location.reload();
                                    }, 2000);
                                }

                                console.log(response);
                            },
                            error: function(xhr, ajaxOptions,
                                thrownError) {
                                console.log(xhr);
                            }
                        });
                    })
                })
            })
        </script>
    @endsection
