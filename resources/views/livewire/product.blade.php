<div class="row d-flex justify-content-center">
    <div wire:ignore>
        <div class="col-md-12">
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
            <div class="card p-4 mt-3">
                <h3 class="heading mt-5 text-center">PRODUCT PRICE ALERT</h3>
                <select id="select2" class="form-select">
                    <option value="">Search product...</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>

                {{-- <div id="select2" class="d-flex justify-content-center px-5">
                    <div class="search"> <input type="text" class="search-input" placeholder="Search..."
                            name=""> <a href="#" class="search-icon"> <i class="fa fa-search"></i> </a> </div>
                </div> --}}
            </div>
        </div>
        <div id="loadProducts">
        </div>
    </div>
</div>

@push('styles')
    <link href="{{ asset('css/search.css') }}" rel="stylesheet">
@endpush
{{-- <div class="flex justify-center">
    <div wire:ignore>

        <select id="select2" class="form-select">
            <option value="">Cercar un producte</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
            @endforeach
        </select>
    </div>
    <label>Has seleccionat: <b>{{ $selected }}</b></label>
</div> --}}


<script>
    $(document).ready(function() {
        $('#select2').select2();
        $('#select2').on('change', function(e) {
            let value = $('#select2').select2('val');
            let text = $('#select2 option:selected').text();

            console.log('onchange');

            $('#loadProducts').empty();
            //send request to get products
            $.ajax({
                url: '{{ route('select2.product.prices') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "productId": value,
                },
                type: "post",
                cache: false,
                success: function(response) {

                    suscribed = JSON.parse(response[0]);
                    response = JSON.parse(response[1]);
                    Object.keys(response).forEach(function(key) {
                        $('#loadProducts').append(
                            '<div class="col-md-8 mx-auto mt-3">' +
                            '<div class="card">' +
                            '<div class="card-header">' +
                            '<div class="form-check form-switch">' +
                            '<input class="form-check-input" type="checkbox" id="' +
                            response[key].id + '_' + response[key].webId +
                            '">' + //checked
                            '<label class="form-check-label" for="switch_' +
                            response[key].id + '">Suscribe</label>' +
                            '</div>' +
                            '</div>' +
                            '<div class="card-body">' +
                            '<div class = "container" >' + //
                            '<div class = "row" >' + //
                            '<div class = "col" >' + //
                            '<blockquote class="blockquote mb-0">' +
                            '<p>' + response[key].product + '</p>' +
                            '<footer class="blockquote-footer">' + response[key]
                            .webName + '</footer >' +
                            '</blockquote>' +
                            '</div>' +
                            '<div class = "col" >' + //
                            '<blockquote class="blockquote mb-0 text-end">' +
                            '<p>' + response[key].price + ' €</p>' +
                            '<footer><a href="' + response[key].webUrl +
                            response[
                                key].product +
                            '"target="_blank"><button type="button" class="btn btn-primary btn-sm">BUY PRODUCT</button></a></footer >' +
                            '</blockquote>' +
                            '</div>' + //
                            '</div>' + //
                            '</div>' + //
                            '</div>' + //
                            '</div>' +
                            '</div>'
                        );
                    });

                    // $("#1_1");
                    if (suscribed.length > 0) {
                        Object.keys(suscribed).forEach(function(key) {

                            // console.log(suscribed[key].product_id + '_' + suscribed[
                            //     key].web_id);
                            // $('#' + suscribed[key].product_id + '_' + suscribed[key]
                            //     .web_id).bootstrapSwitch('state', true);
                            // console.log('atribute work');
                        });
                    }


                    document.querySelectorAll('.form-check-input').forEach(item => {
                        item.addEventListener('change', function(e) {

                            id = $(this).attr("id");
                            productWebId = $(this).attr("id").split("_");

                            routeUrl = this.checked ?
                                '{{ route('select2.product.suscribe') }}' :
                                '{{ route('select2.product.unsuscribe') }}'

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


                    // $("input.form-check-input").on('change', function(e) {
                    //     console.log($(this).attr("id"));
                    // });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr);
                }
            });
            // @this.set('selected', text)
            // console.log(text)
        });
        console.log('working');

    })
</script>
