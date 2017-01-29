@extends('layouts.blackbox.main')
@section('content')
  <div class="shop-wrapper">

    <div class="shop-header shop-default-cover">
      <div class="shop-cover" style="background-image: url('<?php echo $modelData['_cover'] ?>');"></div>
      <div class="contain-fluid">
        <div class="shop-header-overlay clearfix">
          <div class="row">
            <div class="col-md-12 col-lg-9">
              <div class="shop-header-info clearfix">
                <div class="shop-logo">
                  <div class="logo" style="background-image: url('<?php echo $modelData['_logo'] ?>');"></div>
                </div>
                <section class="shop-description">
                  <h2><?php echo $modelData['name']; ?></h2>
                  <p><?php echo $modelData['_short_description']; ?></p>
                </section>
              </div>
            </div>
            <div class="col-md-12 col-lg-3">
              <div class="shop-header-secondary-info">

                @if(!empty($entity['OfficeHour']))
                <div class="additional-option triangle working-time-status <?php echo $entity['OfficeHour']['status']['name']; ?>">
                  <?php echo $entity['OfficeHour']['status']['text']; ?>
                  <div class="additional-option-content">
                    <?php foreach ($entity['OfficeHour']['workingTime'] as $workingTime): ?>
                    <span><?php echo $workingTime['day'].' '.$workingTime['workingTime']; ?></span>
                    <?php endforeach; ?>
                  </div>
                </div>
                <div class="line space-top-bottom-20"></div>
                @endif

                @if(!empty($modelData['Address']['fullAddress']))
                <div class="shop-info">
                  <h4>ที่อยู่</h4>
                  <div>
                    {{$modelData['Address']['fullAddress']}}
                  </div>
                </div>
                @endif

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="shop-main-bar">
      <div class="row">
        <div class="col-xs-12">
          <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-secondary">แก้ไขร้านค้า</button>
          </div>
        </div>
      </div>
    </div>

    
    <div class="container">

      <div class="shop-content">
        
        <div class="shop-notice">
          
          <div class="shop-notice-header">
            <h3>ยินดีต้อนรับเข้าสู่ชุมชน</h3>
            <p>กรุณาเพิ่มข้อมูลต่างๆของร้านค้าของคุณ ก่อนการใช้งาน</p>
          </div>

          <div class="shop-notice-content">
            <div class="shop-notice-row">
              <a href="{{$shopUrl}}setting"><h4 class="text-center">เพิ่มข้อมูลของร้านค้า</h4></a>
            </div>
          </div>

        </div>

        <div class="line space-top-bottom-20"></div>

        <h3>จัดการ</h3>

        <div class="shop-nav-group clearfix">

          <div class="shop-nav">
            <div class="shop-nav-image">
              <a href="{{$shopUrl}}job">
                <img src="/images/common/tag.png">
              </a>
            </div>
            <div class="shop-nav-info">
              <a href="{{$shopUrl}}product">
                <h4 class="shop-nav-title">สินค้า</h4>
              </a>
            </div>
          </div>

          <div class="shop-nav">
            <div class="shop-nav-image">
                <a href="{{$shopUrl}}job">
                  <img src="/images/common/job.png">
                </a>
            </div>
            <div class="shop-nav-info">
              <a href="{{$shopUrl}}job">
                <h4 class="shop-nav-title">งาน</h4>
              </a>
            </div>
          </div>

          <div class="shop-nav">
            <div class="shop-nav-image">
                <a href="{{$shopUrl}}advertisement">
                  <img src="/images/common/megaphone.png">
                </a>
            </div>
            <div class="shop-nav-info">
              <a href="{{$shopUrl}}advertisement">
                <h4 class="shop-nav-title">โฆษณา</h4>
              </a>
            </div>
          </div>

        </div>

      </div>

    </div>

  </div>
@stop