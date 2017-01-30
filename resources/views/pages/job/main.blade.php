@extends('layouts.blackbox.main')
@section('content')

  <div class="container">

    <div class="container-header">
      <div class="row">
        <div class="col-lg-6 col-sm-12">
          <div class="title">
            งาน
          </div>
        </div>
      </div>
    </div>

    <div class="line"></div>

    @if(!empty($pagination['data']))

      <div class="list">

        <div class="row">

          @foreach($pagination['data'] as $data)

          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="card">
              <div class="image">
                <a href="{{$detailUrl}}{{$data['id']}}">
                  <div class="product-image" style="background-image:url({{$data['_imageUrl']}});"></div>
                </a>
              </div>
              <div class="product-detail">
                <a href="{{$detailUrl}}{{$data['id']}}">
                  <div class="product-title">{{$data['_name_short']}}</div>
                </a>
              </div>
              <div>
                <a href="{{$detailUrl}}{{$data['id']}}"><div class="button wide-button">แก้ไข</div></a>
              </div>
            </div>
          </div>

          @endforeach

        </div>

        @include('components.pagination') 

      </div>

    @else

      <div class="shop-notice text-center">
        <img src="/images/common/job.png">
        <div>
          <h3>ลงประกาศงานของคุณ</h3>
          <p>ยังไม่มีประกาศงานของคุณ เพิ่มประกาศงานของคุณเพื่อค้นหาพนักงานใหม่</p>
          <a href="{{$shopUrl}}job_add" class="button">ลงประกาศงาน</a>
        </div>
      </div>

    @endif

  </div>

@stop