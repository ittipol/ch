@extends('layouts.blackbox.main')
@section('content')

  <div class="container list">

    <div class="row">

      @foreach($pagination['data'] as $list)

      <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <div class="card">
          <div class="image">
            <a href="{{$detailUrl}}">
              <img src="{{$list['_imageUrl']}}">
            </a>
          </div>
          <div class="product-detail">
            <a href="">
              <div class="product-title">{{$list['_name_short']}}</div>
            </a>
            <div class="price">
              {{$list['_price']}}
            </div>
          </div>
          <div>
            <a href="{{$list['_imageUrl']}}"><div class="button wide-button">แสดงสินค้านี้</div></a>
          </div>
        </div>
      </div>

      @endforeach

    </div>

    <div class="row">
      <div class="col-xs-12 pagination clearfix">
        <div class="pagination-inner clearfix">
          @foreach($pagination['paging'] as $paging)

            @if(!empty($paging['url']))

              <a href="{{$paging['url']}}" class="paging @if(!empty($paging['selected'])) selected @endif">
                {{$paging['pageNumber']}}
              </a>

            @else

              <span class="paging @if(!empty($paging['selected'])) selected @endif">
                {{$paging['pageNumber']}}
              </span>

            @endif

            
          @endforeach
        </div>
      </div>
    </div>

  </div>

@stop