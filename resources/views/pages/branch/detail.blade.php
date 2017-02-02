@extends('layouts.blackbox.main')
@section('content')

  <script src="https://maps.googleapis.com/maps/api/js?libraries=places"></script>

  <div class="detail container">

    <div class="detail-title">
      <h4 class="sub-title">งาน</h4>
      <h2 class="title">{{$_modelData['name']}}</h2>
      <div class="tag-group">
        <a class="tag-box">{{$_modelData['_employmentTypeName']}}</a>
        @foreach ($_modelData['Tagging'] as $tagging)
          <a class="tag-box">{{$tagging['_word']}}</a>
        @endforeach
      </div>
    </div>

    @if(!empty($shopAddress))
    <h4 class="title-with-icon location-pin">{{$shopAddress['_full_address']}}</h4>
    @endif

    <h4>สาขาที่เปิดรับสมัครงานนี้</h4>   
    <div class="row">
      <div class="col-xs-12">
        <div class="item-info space-bottom-20">

          <div class="tile-info-group">
            <div class="row">
              @foreach($_modelData['JobToBranch'] as $branch)
              <div class="col-md-4 col-sm-6 col-xs-12">
                <a href="">
                  <div class="tile-info with-icon">
                    <h4 class="title-with-icon location-pin">
                      {{$branch['name']}}
                    </h4>
                  </div>
                </a>
              </div>
              @endforeach
            </div>
          </div>

        </div>
      </div> 
    </div>

    <div class="image-gallery">

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

            <div class="display-image-description-icon">
              คำอธิบายรูปนี้
            </div>

          </div>
        </div>

      </div>

      @if(!empty($_modelData['Image']))
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
            <p>เงินเดือน (บาท)</p>
            <h4 class="price">{{$_modelData['_salary']}}</h4>
          </div>

        </div>
      </div> 
    </div>

    <div class="line space-top-bottom-20"></div>

    <div class="row">
      <div class="col-md-6 col-sm-12">
        <dl class="row">
          <dt class="col-sm-3">รูปแบบงาน</dt>
          <dd class="col-sm-9">{{$_modelData['_employmentTypeName']}}</dd>
        </dl>
      </div>
    </div>

    <div class="line space-top-bottom-20"></div>

    <h4>คุณสมบัติผู้สมัคร</h4>   
    <div>
      {!!$_modelData['qualification']!!}
    </div>

    <div class="line space-top-bottom-20"></div>

    <h4>รายละเอียดงาน</h4>   
    <div>
      {!!$_modelData['description']!!}
    </div>

    <div class="line space-top-bottom-20"></div>

    <h4>สวัสดิการ</h4>   
    <div>
      {!!$_modelData['benefit']!!}
    </div>

    <div class="line space-top-bottom-20"></div>

    <h4>สมัครงานนี้</h4>

    <div class="text-center space-top-bottom-20">
      <a href="{{URL::to('job/apply_job')}}">
        <span class="button">สมัครงานนี้ผ่าน CHONBURI SQUARE</span>
      </a>
    </div>

    @if(!empty($_modelData['_recruitment_custom']))

    <div class="text-strike">
      <span>หรือ</span>
      <div class="line"></div>
    </div>
    
    <div>
      {!!$_modelData['recruitment_custom_detail']!!}
    </div>
    @endif


  </div>

  <script type="text/javascript">
    $(document).ready(function(){
      imageGallery = new ImageGallery(true);
      imageGallery.load(<?php echo $_modelData['Image']; ?>);
    });
  </script>
@stop