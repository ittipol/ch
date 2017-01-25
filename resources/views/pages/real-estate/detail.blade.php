@extends('layouts.blackbox.main')
@section('content')

  <script src="https://maps.googleapis.com/maps/api/js?libraries=places"></script>

  <div class="detail container">

    <div class="detail-title">
      <h4 class="sub-title">ประกาศ{{$modelData['_announcementTypeName']}}</h4>
      <h2 class="title">{{$modelData['name']}}</h2>
      <div class="tag-group">
        <a class="tag-box">{{$modelData['_realEstateTypeName']}}</a>
        @if($modelData['need_broker'])
        <a class="tag-box">{{$modelData['_need_broker']}}</a>
        @endif
        @foreach ($modelData['Tagging'] as $tagging)
          <a class="tag-box">{{$tagging['_word']}}</a>
        @endforeach
      </div>
    </div>

    <h4 class="title-with-icon location-pin">{{$modelData['Address']['_full_address']}}</h4>

    <div class="image-gallery">

      <div class="container-fuild">

      <div class="row">

        <div class="col-sm-12 image-gallary-display">
          <div class="image-gallary-display-inner">

            <div class="image-gallary-panel">
              <img id="image_display">
            </div>

            <div class="image-description">
             <div id="image_description" class="image-description-inner"></div>
             <div class="close-image-description-icon"></div>
            </div>

            <div class="display-image-description-icon"></div>

          </div>
        </div>

      </div>

      </div>

      @if(!empty($modelData['Image']))
      <div class="row">
        <div class="col-sm-12">
          <div id="image_gallery_list" class="image-gallery-list clearfix"></div>
        </div>
      </div>
      <div class="line space-top-bottom-20"></div>
      @endif

    </div>

    <div class="row">

      <div class="col-md-6 col-sm-12">
        <div class="item-info">

          <div class="item-info-row">
            <p>ราคา{{$modelData['_announcementTypeName']}}</p>
            <h4 class="price">{{$modelData['_price']}}</h4>
          </div>

        </div>
      </div> 

    </div>

    <div class="line space-top-bottom-20"></div>

    <div class="row">

      <div class="col-sm-12">

        <div class="item-info">

          <p>ติดต่อผู้{{$modelData['_announcementTypeName']}}</p>

          <div class="row">
            <div class="col-md-3">
              <div class="item-info-row">
                @if(!empty($modelData['Contact']['phone_number']))
                <h4 class="title-with-icon phone">{{$modelData['Contact']['phone_number']}}</h4>
                @else
                <h4 class="title-with-icon phone">-</h4>
                @endif
              </div>
            </div>
            <div class="col-md-3">
              <div class="item-info-row">
                @if(!empty($modelData['Contact']['email']))
                <h4 class="title-with-icon email">{{$modelData['Contact']['email']}}</h4>
                @else
                <h4 class="title-with-icon email">-</h4>
                @endif
              </div>
            </div>
            <div class="col-md-3">
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

    </div>

    <div class="line space-top-bottom-20"></div>

    <div class="row">
      <div class="col-md-6 col-sm-12">
        <dl class="row">
          <dt class="col-sm-3">ประเภท</dt>
          <dd class="col-sm-9">{{$modelData['_realEstateTypeName']}}</dd>
        </dl>

        <dl class="row">
          <dt class="col-sm-3">พื้นที่ใช้สอย</dt>
          <dd class="col-sm-9">{{$modelData['_homeArea']}}</dd>
        </dl>

        <dl class="row">
          <dt class="col-sm-3">พื้นที่ที่ดิน</dt>
          <dd class="col-sm-9">{{$modelData['_landArea']}}</dd>
        </dl>
      </div>

      <div class="col-md-6 col-sm-12">
        <dl class="row">
          <dt class="col-sm-3">เฟอร์นิเจอร์</dt>
          <dd class="col-sm-9">{{$modelData['_furniture']}}</dd>
        </dl>
      </div>
    </div>

    <div class="line space-top-bottom-20"></div>

    <div class="row">
      <dt class="col-sm-3">คุณสมบัติ</dt>
      <dd class="col-sm-9">
      @foreach($modelData['_indoors'] as $indoor)
        <div class="col-lg-4 col-md-4 col-sm-6">
          <div class="title-with-icon space {{$indoor['room']}}"><b>{{$indoor['value']}}</b> {{$indoor['name']}}</div>
        </div>
      @endforeach
      </dd>
    </div>

    <div class="line space-top-bottom-20"></div>

    <div class="row">
      <dt class="col-sm-3">จุดเด่น</dt>
      <dd class="col-sm-9">
      @if(!empty($modelData['_features']))
        @foreach($modelData['_features'] as $feature)

        <div class="col-lg-4 col-md-4 col-sm-6">
          <div class="title-with-icon space tick-green">{{$feature['name']}}</div>
        </div>

        @endforeach
      @else
        <div class="col-lg-4 col-md-4 col-sm-6">
          <div class="">-</div>
        </div>
      @endif
      </dd>
    </div>

    <div class="line space-top-bottom-20"></div>

    <div class="row">
      <dt class="col-sm-3">สิ่งอำนวยความสะดวก</dt>
      <dd class="col-sm-9">
      @if(!empty($modelData['_facilities']))
        @foreach($modelData['_facilities'] as $facility)

        <div class="col-lg-4 col-md-4 col-sm-6">
          <div class="title-with-icon space tick-green">{{$facility['name']}}</div>
        </div>

        @endforeach
      @else
        <div class="col-lg-4 col-md-4 col-sm-6">
          <div class="">-</div>
        </div>
      @endif
      </dd>
    </div>

    <div class="line space-top-bottom-20"></div>

    <h4>รายละเอียดอสังหาริมทรัพย์</h4>   
    <div>
      @if(strlen($modelData['description']) > 0)
      {!!$modelData['description']!!}
      @else
      -
      @endif
    </div>

    <div class="line space-top-bottom-20"></div>

    <h4>ตำแหน่งบนแผนที่</h4>
    <div id="map"></div>

  </div>

  <script type="text/javascript">

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
      imageGallery = new ImageGallery(true);
      imageGallery.load(<?php echo $modelData['Image']; ?>);

      let tabs = new Tabs('item_detail');
      tabs.load();

      const map = new Map(false,false,false);
      map.load('<?php echo $modelData["Address"]["_geographic"]; ?>');
    });
  </script>
@stop