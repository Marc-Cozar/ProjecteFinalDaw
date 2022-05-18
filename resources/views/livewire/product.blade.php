<div class="row d-flex justify-content-center">
    <div wire:ignore>
        <div class="col-md-12">
            <div class="card p-4 mt-3">
                <h3 class="heading mt-5 text-center">Hi! How can we help You?</h3>
                <select id="select2" class="form-select">
                    <option value="">Cercar un producte...</option>
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
            // console.log(value);

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
                    // console.log(typeof(response));
                    response = JSON.parse(response);
                    // console.log(typeof(response));


                    Object.keys(response).forEach(function(key) {

                        $('#loadProducts').append(
                            '<div class="col-md-8 mx-auto mt-3">' +
                            '<div class="card">' +
                            '<div class="card-header">' +
                            response[key].product + '</div>' +
                            '<div class="card-body">' +
                            '<blockquote class="blockquote mb-0">' +
                            '<p>A well-known quote, contained in a blockquote element.</p>' +
                            '<footer class="blockquote-footer">' + response[key]
                            .webName + '</footer >' +
                            '</blockquote>' +
                            '</div>' +
                            '</div>' +
                            '</div>'
                        ); <
                        div class = "container" >
                            <
                            div class = "row" >
                            <
                            div class = "col" > Column < /div> <
                            div class = "col" > Column < /div> <
                            div class = "w-100" > < /div> <
                            div class = "col" > Column < /div> <
                            div class = "col" > Column < /div> <
                            /div> <
                            /div>

                    });


                    // data.forEach(obj => {
                    //     Object.entries(obj).forEach(([key, value]) => {
                    //         console.log(`${key} ${value}`);
                    //     });
                    //     console.log('-------------------');
                    // });

                    // $.each(response, function(key, value) {
                    //     console.log(key + ": " + value);
                    // });


                    // Object.entries(response).forEach(entry => {
                    //     console.log(entry);
                    //     const [key, value] = entry;
                    //     // console.log(key, value);
                    // });













                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr);
                }
            });
            // @this.set('selected', text)
            // console.log(text)
        })




    })



    // var xhttp = new XMLHttpRequest();
    // var textOptions = "";
    // var arrayOpenData;

    // xhttp.open("GET", 'https://opendata.reus.cat/api/3/action/datastore_search_sql?sql=SELECT * from "79b0c5e2-d62c-4dd1-80cf-dd52ad543350"', true);
    // xhttp.send();

    // xhttp.onreadystatechange = function() {
    //     if (this.readyState == 4 && this.status == 200) {
    //     	arrayOpenData = JSON.parse(this.responseText);

    //     	for (var i = 0; i < Object.keys(arrayOpenData["result"]["records"]).length; i++) {
    //     		textOptions += "<option id=" + i + ">" + arrayOpenData["result"]["records"][i]["NOM CARRER"] + " (" + arrayOpenData["result"]["records"][i]["TIPUS VIA"] + ")" +"<br></option>";
    //     	}
    //     	 document.getElementById("select").innerHTML = textOptions ;
    //     }
    // };

    // function getPostalCode(){
    // 		var codeName = document.getElementById("select").value;
    // 		for (var i = 0; i < Object.keys(arrayOpenData["result"]["records"]).length; i++) {
    //     		if(arrayOpenData["result"]["records"][i]["NOM CARRER"]+ " (" + arrayOpenData["result"]["records"][i]["TIPUS VIA"] + ")" == codeName) {
    //     			document.getElementById("divGetTxt").innerHTML = arrayOpenData["result"]["records"][i]["CODI POSTAL"];
    //     		}
    //     	}
    // }
</script>
