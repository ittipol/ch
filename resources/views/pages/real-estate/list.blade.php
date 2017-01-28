@extends('layouts.blackbox.main')
@section('content')

  <div class="container list">

    <div class="row">

      @foreach($pagination['data'] as $data)

      <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <div class="card">
          <div class="image">
            <a href="{{$detailUrl}}{{$data['id']}}">
              <img src="{{$data['_imageUrl']}}">
            </a>
          </div>
          <div class="product-detail">
            <a href="{{$detailUrl}}{{$data['id']}}">
              <div class="product-title">{{$data['_name_short']}}</div>
            </a>
            <div class="price">
              {{$data['_price']}}
            </div>
          </div>
          <div>
            <a href="{{$detailUrl}}{{$data['id']}}"><div class="button wide-button">แสดงสินค้านี้</div></a>
          </div>
        </div>
      </div>

      @endforeach

    </div>

    <div class="row">
      <div class="col-xs-12 pagination clearfix">
        <div class="pagination-inner clearfix">

          @if(!empty($pagination['prev']['url'])) 
            <a href="{{$pagination['prev']['url']}}" class="paging icon icon-prev"></a>
          @endif

          @foreach($pagination['paging'] as $paging)

            @if(!empty($paging['url']))
              <a href="{{$paging['url']}}" class="paging @if($paging['pageNumber'] == $pagination['page']) selected @endif">
                {{$paging['pageNumber']}}
              </a>
            @else
              <span class="paging">
                {{$paging['pageNumber']}}
              </span>
            @endif

            
          @endforeach

          @if(!empty($pagination['next']['url'])) 
            <a href="{{$pagination['next']['url']}}" class="paging icon icon-next"></a>
          @endif
        
        </div>
      </div>
    </div>

  </div>

@stop