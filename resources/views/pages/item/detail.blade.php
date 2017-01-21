@extends('layouts.blackbox.main')
@section('content')
  <div class="detail container">

    <div class="detail-title">
      <h4 class="sub-title">ประกาศ{{$announcementType['name']}}</h4>
      <h2 class="title">{{$formData['name']}}</h2>
      <div class="title-box-group">
        <a class="title-box">@if($formData['used'] == 1) สินค้าใหม่ @else สินค้ามือสอง @endif</a>
        <a class="title-box">{{$categoryName}}</a>
        @foreach ($formData['Tagging'] as $tagging)
          <a class="title-box">{{$tagging['name']}}</a>
        @endforeach
      </div>
    </div>

    <div class="image-gallery">

      <div class="row">

          <div class="col-lg-7 col-md-7 col-sm-12">

            <div class="image-gallary-display">
              <div class="image-gallary-display-inner">
                <img id="image_display" src="{{$formData['Image'][0]['url']}}">
              </div>
            </div>

          </div>

          <div class="col-lg-5 col-md-5 col-sm-12">

            <div class="image-gallery-preview clearfix">
              @foreach ($formData['Image'] as $image)
                <div class="preview-image" style="background-image:url('{{$image['url']}}')" data-url="{{$image['url']}}"></div>
              @endforeach
            </div>

            <div class="line"></div>

            <div class="item-info">
              <p>ราคา{{$announcementType['name']}}</p>
              <h4>{{$formData['price']}} บาท</h4>

              <p>เบอร์โทรศัพท์ติดต่อ</p>
              <h4>{{$formData['Contact']['phone_number']}}</h4>

              <p>อีเมล</p>
              <h4>{{$formData['Contact']['email']}}</h4>
            </div>
            
          </div>

      </div>

    </div>

    <div class="line space-top-bottom-20"></div>

    <h4>รายละเอียดสินค้า</h4>
    <div>
      @if(strlen($formData['description']) > 0)
      {!!$formData['description']!!}
      @else
      -
      @endif
    </div>

    <div class="line space-top-bottom-20"></div>

    <h4>ตำแหน่งของสินค้า</h4>
    <p>

    </p>

    <h4>สินค้าที่คล้ายคลึงกัน</h4>

  </div>

  <script type="text/javascript">
    $(document).ready(function(){
      $('.preview-image').on('mouseenter',function(){
        console.log($(this).data('url'));
        $('#image_display').attr('src',$(this).data('url'));
      });
    });
  </script>
@stop