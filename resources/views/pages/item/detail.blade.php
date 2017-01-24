@extends('layouts.blackbox.main')
@section('content')
  <div class="detail container">

    <div class="detail-title">
      <h4 class="sub-title">ประกาศ{{$modelData['_announcementTypeName']}}</h4>
      <h2 class="title">{{$modelData['name']}}</h2>
      <div class="tag-group">
        <a class="tag-box">{{$modelData['_used']}}</a>
        <a class="tag-box">{{$modelData['_categoryName']}}</a>
        @foreach ($modelData['Tagging'] as $tagging)
          <a class="tag-box">{{$tagging['name']}}</a>
        @endforeach
      </div>
    </div>

    <h4 class="title-with-icon location-pin">{{$modelData['Address']['_full_address']}}</h4>

    <div class="image-gallery">

      <div class="row">

          <div class="col-lg-7 col-sm-12">

            <div class="image-gallary-display">
              <div class="image-gallary-display-inner">
                <img id="image_display">
              </div>
            </div>

          </div>

          <div class="col-lg-5 col-sm-12">

            @if(!empty($modelData['Image']))
            <div class="image-gallery-list clearfix">
              <div id="image_gallery_list" class="image-gallery-list clearfix"></div>
            </div>

            <div class="line"></div>
            @endif

            <div class="item-info">

              <div class="item-info-row">
                <p>ราคา{{$modelData['_announcementTypeName']}}</p>
                <h4>{{$modelData['_price']}}</h4>
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

    <h4>สินค้าที่คล้ายกัน</h4>
    <p>ไม่พบสินค้าที่คล้ายกัน</p>

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
      imageGallery = new ImageGallery();
      imageGallery.load();

      let tabs = new Tabs('item_detail');
      tabs.load();
    });
  </script>
@stop