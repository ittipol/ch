@extends('layouts.blackbox.main')
@section('content')
  <div class="detail container">

    <div class="detail-title">
      <h4 class="sub-title">ประกาศ{{$modelData['announcementType']['name']}}</h4>
      <h2 class="title">{{$modelData['name']}}</h2>
      <div class="title-box-group">
        <a class="title-box">@if($modelData['used'] == 1) สินค้าใหม่ @else สินค้ามือสอง @endif</a>
        <a class="title-box">{{$modelData['categoryName']}}</a>
        @foreach ($modelData['Tagging'] as $tagging)
          <a class="title-box">{{$tagging['name']}}</a>
        @endforeach
      </div>
    </div>

    <div class="image-gallery">

      <div class="row">

          <div class="col-lg-7 col-md-7 col-sm-12">

            <div class="image-gallary-display">
              <div class="image-gallary-display-inner">
                @if(!empty($modelData['Image'][0]))
                <img id="image_display" src="{{$modelData['Image'][0]['url']}}">
                @else
                <img id="image_display" src="/images/common/no-img.png">
                @endif
              </div>
            </div>

          </div>

          <div class="col-lg-5 col-md-5 col-sm-12">

            @if(!empty($modelData['Image']))
            <div class="image-gallery-preview clearfix">
              @foreach ($modelData['Image'] as $image)
                <div class="preview-image" style="background-image:url('{{$image['url']}}')" data-url="{{$image['url']}}"></div>
              @endforeach
            </div>

            <div class="line"></div>
            @endif

            <div class="item-info">

              <div class="item-info-row">
                <p>ราคา{{$modelData['announcementType']['name']}}</p>
                <h4>{{$modelData['price']}} บาท</h4>
              </div>

            </div>
              
            <div class="line"></div>

            <div class="item-info">

              <div class="item-info-row">
                <!-- <p>เบอร์โทรศัพท์</p> -->
                @if(!empty($modelData['Contact']['phone_number']))
                <h4 class="title-with-icon phone">{{$modelData['Contact']['phone_number']}}</h4>
                @else
                <h4 class="title-with-icon phone">-</h4>
                @endif
              </div>

              <div class="item-info-row">
                <!-- <p>อีเมล</p> -->
                @if(!empty($modelData['Contact']['email']))
                <h4 class="title-with-icon email">{{$modelData['Contact']['email']}}</h4>
                @else
                <h4 class="title-with-icon email">-</h4>
                @endif
              </div>

              <div class="item-info-row">
                <h4 class="title-with-icon location-pin">ต.{{$modelData['Address']['sub_district_name']}} อ.{{$modelData['Address']['district_name']}} จ.{{$modelData['Address']['province_name']}}</h4>
              </div>
            </div>
            
          </div>

      </div>

    </div>

    <div class="line space-top-bottom-20"></div>

    <h4>รายละเอียดสินค้า</h4>   
    <div>
      @if(strlen($modelData['item_detail']) > 0)
      {!!$modelData['item_detail']!!}
      @else
      -
      @endif
    </div>

    <div class="line space-top-bottom-20"></div>

    <h4>ตำแหน่งบนแผนที่</h4>
    <p>

    </p>

    <h4>สินค้าที่คล้ายคลึงกัน</h4>

  </div>

  <script type="text/javascript">

    class ImageGallery {
      constructor() {

      }

      init() {
        this.alignCenter();
        this.bind();
      }

      bind() {

        let _this = this;

        $('.preview-image').on('click',function(){
          _this.setImage($(this).data('url'));
        });

        $(window).resize(function() {
          _this.alignCenter();
        });

      }

      setImage(url) {
        $('#image_display').attr('src',url);
        this.alignCenter();
      }

      alignCenter() {

        let imgWidth = $('#image_display').width();
        let frameWidth = $('.image-gallary-display-inner').width();

        if(imgWidth > frameWidth) {
          $('#image_display').css('left',(frameWidth - imgWidth) / 2);
        }else{
          $('#image_display').css('left',0);
        }
      }

    }

    $(document).ready(function(){
      imageGallery = new ImageGallery();
      imageGallery.init();
    });
  </script>
@stop