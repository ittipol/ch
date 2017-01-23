@extends('layouts.blackbox.main')
@section('content')

  <script src="https://maps.googleapis.com/maps/api/js?libraries=places"></script>

  <div class="detail container">

    <div class="detail-title">
      <h4 class="sub-title">ประกาศ{{$modelData['announcementType']['name']}}</h4>
      <h2 class="title">{{$modelData['name']}}</h2>
      <div class="title-box-group">
        <a class="title-box">{{$modelData['realEstateType']['name']}}</a>
        @foreach ($modelData['Tagging'] as $tagging)
          <a class="title-box">{{$tagging['_word']}}</a>
        @endforeach
      </div>
    </div>

    <div class="image-gallery">

      <div class="row">

          <div class="col-lg-7 col-md-7 col-sm-12">

            <div class="image-gallary-display">
              <div class="image-gallary-display-inner">
                @if(!empty($modelData['Image'][0]))
                <img id="image_display" src="{{$modelData['Image'][0]['_url']}}">
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
                <div class="preview-image" style="background-image:url({{$image['_url']}})" data-url="{{$image['_url']}}"></div>
              @endforeach
            </div>

            <div class="line"></div>
            @endif

            <div class="item-info">

              <div class="item-info-row">
                <p>ราคา{{$modelData['announcementType']['name']}}</p>
                <h4 class="price">{{$modelData['_price']}}</h4>
              </div>

            </div>
              
            <div class="line"></div>

            <div class="item-info">

              <div class="item-info-row">
                @if(!empty($modelData['Contact']['phone_number']))
                <h4 class="title-with-icon phone">{{$modelData['Contact']['phone_number']}}</h4>
                @else
                <h4 class="title-with-icon phone">-</h4>
                @endif
              </div>

              <div class="item-info-row">
                @if(!empty($modelData['Contact']['email']))
                <h4 class="title-with-icon email">{{$modelData['Contact']['email']}}</h4>
                @else
                <h4 class="title-with-icon email">-</h4>
                @endif
              </div>

              <div class="item-info-row">
                <h4 class="title-with-icon location-pin">{{$modelData['Address']['_full_address']}}</h4>
              </div>

              <div class="item-info-row">
                @if(!empty($modelData['Contact']['line']))
                <h4 class="title-with-icon line-app">{{$modelData['Contact']['line']}}</h4>
                @else
                <h4 class="title-with-icon line-app">-</h4>
                @endif
              </div>

            </div>
            
          </div>

      </div>

    </div>

    <div class="line space-top-bottom-20"></div>

    <h4>รายละเอียดสินค้า</h4>   
    <div>
      @if(strlen($modelData['description']) > 0)
      {!!$modelData['description']!!}
      @else
      -
      @endif
    </div>

    <div class="line space-top-bottom-20"></div>

    <h4>ตำแหน่งบนแผนที่</h4>
    <!-- <input id="pac-input" class="controls" type="text" placeholder="Search Box"> -->
    <div id="map"></div>

    <div class="line space-top-bottom-20"></div>
    <h4>สินค้าที่คล้ายกัน</h4>
    <p>ไม่พบสินค้าที่คล้ายกัน</p>

  </div>

  <script type="text/javascript">

    class ImageGallery {
      constructor() {}

      load() {
        this.init();
        this.bind();
      }

      init() {
        this.alignCenter();
      }

      bind() {

        let _this = this;

        $('.preview-image').on('click',function(){

          _this.setImage($(this).data('url'));
          _this.alignCenter();

          // let image = new Image();
          // image.src = $(this).data('url');

          // image.onload = function() {
          //   $('#image_display').css('display','none');
          //   _this.setImage(image.src);
          //   _this.alignCenter();
          //   $('#image_display').css('display','inline-block');
          // }

          // <div id="item_detail" class="tab-content"></div>

        });

        $(window).resize(function() {
          _this.alignCenter();
        });

      }

      setImage(url) {
        $('#image_display').attr('src',url);
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

    class Tabs {
      constructor(tab = '') {
        this.currentTab = tab;
      }

      load() {
        this.init();
        this.bind();
      }

      init() {
        this.showTab(this.currentTab);
      }

      bind() {

        let _this = this;

        $('.tab').on('click',function(){
          if($(this).is(':checked')) {
            _this.showTab($(this).data('tab'));
          }
        });

      }

      showTab(tab) {
        $('.tab-content').css('display','none');
        $('#'+tab).css('display','block');
      }

      // <div class="tabs clearfix">
      //   <label>
      //     <input class="tab" type="radio" name="tabs"  data-tab="item_detail" checked >
      //     <span href="#">รายละเอียดสินค้า</span>
      //   </label>
      //   <label>
      //     <input class="tab" type="radio" name="tabs" data-tab="announcement_detail" >
      //     <span href="#">รายละเอียดเพิ่มเติม</span>
      //   </label>
      // </div>

    }

    $(document).ready(function(){
      imageGallery = new ImageGallery();
      imageGallery.load();

      let tabs = new Tabs('item_detail');
      tabs.load();

      const map = new Map();
      map.load('<?php echo $modelData["Address"]["_geographic"]; ?>');
    });
  </script>
@stop