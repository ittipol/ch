@extends('layouts.blackbox.main')
@section('content')

  <div class="shop-wrapper">

    @include('pages.shop.layouts.header') 

    <div class="shop-main-bar">
      <div class="row">
        <div class="col-xs-12">
          <div class="btn-group" role="group">
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

        <div class="tile-nav-group clearfix">

          <div class="tile-nav">
            <div class="tile-nav-image">
              <a href="{{$shopUrl}}job">
                <img src="/images/common/tag.png">
              </a>
            </div>
            <div class="tile-nav-info">
              <a href="{{$shopUrl}}product">
                <h4 class="tile-nav-title">สินค้า</h4>
              </a>
            </div>
          </div>

          <div class="tile-nav">
            <div class="tile-nav-image">
                <a href="{{$shopUrl}}job">
                  <img src="/images/common/career.png">
                </a>
            </div>
            <div class="tile-nav-info">
              <a href="{{$shopUrl}}job">
                <h4 class="tile-nav-title">ลงประกาศงานงาน</h4>
              </a>
            </div>
          </div>

          <div class="tile-nav">
            <div class="tile-nav-image">
                <a href="{{$shopUrl}}advertisement">
                  <img src="/images/common/megaphone.png">
                </a>
            </div>
            <div class="tile-nav-info">
              <a href="{{$shopUrl}}advertisement">
                <h4 class="tile-nav-title">โฆษณา</h4>
              </a>
            </div>
          </div>

          <div class="tile-nav">
            <div class="tile-nav-image">
                <a href="{{$shopUrl}}advertisement">
                  <img src="/images/common/additional.png">
                </a>
            </div>
            <div class="tile-nav-info">
              <a href="{{$shopUrl}}advertisement">
                <h4 class="tile-nav-title">แสดงทั้งหมด</h4>
              </a>
            </div>
          </div>

        </div>

      </div>

    </div>

  </div>
@stop