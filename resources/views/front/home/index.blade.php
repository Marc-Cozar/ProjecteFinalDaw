@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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

        <select class="js-example-responsive" style="width: 100%" name="state">
            <option value="AL">Alabama</option><option value="AL">Alabama</option><option value="AL">Alabama</option><option value="AL">Alabama</option><option value="AL">Alabama</option>
              ...
            <option value="WY">Wyoming</option>
          </select>

        </div>
    </div>
</div>


<script>

$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>






@endsection
