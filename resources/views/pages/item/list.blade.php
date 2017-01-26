@extends('layouts.blackbox.main')
@section('content')

  <div class="container">

    <div class="row">

      @foreach($lists as $list)

      <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
        <div class="card">
          <div class="image">
            <a href="">
              <!-- <div class="image" style="background-image: url({{$list['_imageUrl']}});"> -->
              <img src="{{$list['_imageUrl']}}">
            </a>
          </div>
          <div class="product-detail">
            <a href="">
              <div class="product-title">{{$list['name']}}</div>
            </a>
            <div class="price">
              {{$list['_price']}}
            </div>
          </div>
        </div>
      </div>

      @endforeach

    </div>

    <div class="row">
      <div class="pagination">

      </div>
    </div>

  </div>

@stop