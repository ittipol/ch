@extends('layouts.blackbox.main')
@section('content')

<div class="top-header-wrapper">
  <h2 class="top-header">โฆษณา</h2>
</div>

<div class="container">

  <div class="tile-nav-group space-top-bottom-20 clearfix">

    <div class="tile-nav small">
      <div class="tile-nav-image">
        <a href="{{$advertisingPostUrl}}">
          <img src="/images/common/megaphone.png">
        </a>
      </div>
      <div class="tile-nav-info">
        <a href="{{$advertisingPostUrl}}">
          <h4 class="tile-nav-title">ลงโฆษณา</h4>
        </a>
      </div>
    </div>

  </div>

  <div class="line"></div>

  @if(!empty($_pagination['data']))

    <div class="grid-card">

      <div class="row">

        @foreach($_pagination['data'] as $data)

        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <div class="card">

            <div class="overlay-top-info text-center">ประเภทโฆษณา: {{$data['_advertisingType']}}</div>

            <div class="image">
              <a href="{{$data['detailUrl']}}">
                <div class="product-image" style="background-image:url({{$data['_imageUrl']}});"></div>
              </a>
            </div>
            <div class="product-detail">
              <a href="{{$data['detailUrl']}}">
                <div class="product-title">{{$data['_name_short']}}</div>
              </a>
              <div>
                <div>ประเภทโฆษณา</div>
                {{$data['_advertisingType']}}
              </div>
            </div>
            <div>
    
              <a href="{{$data['editUrl']}}">
                <div class="button half-button">แก้ไข</div>
              </a>
 
              <a href="{{$data['detailUrl']}}">
                <div class="button half-button">แสดง</div>
              </a>
      
            </div>
          </div>
        </div>

        @endforeach

      </div>

      @include('components.pagination') 

    </div>

  @else

    <div class="shop-notice text-center space-top-20">
      <img class="space-bottom-20" src="/images/common/megaphone.png">
      <div>
        <h3>โฆษณา</h3>
        <p>ยังไม่มีประกาศงานของคุณ เพิ่มประกาศงานของคุณเพื่อค้นหาพนักงานใหม่</p>
        <a href="{{$advertisingPostUrl}}" class="button">ลงโฆษณา</a>
      </div>
    </div>

  @endif

</div>

@stop