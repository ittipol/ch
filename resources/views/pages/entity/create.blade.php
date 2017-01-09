@extends('layouts.blackbox.main')
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-sm-12">
        <div class="box">
          <div class="inner">
            <h4>บริษัท องค์กร หรือ ธุรกิจชุมชน</h4>
            <p>เพิ่มบริษัท องค์กร หรือ ธุรกิจชุมชนของคุณ เพิ่มสินค้าลงในร้านค้าของคุณ โฆษณาสินค้าใหม่ๆ หรือ ลงประกาศงาน </p>
            <a href="{{URL::to('entity/add?type=business')}}" class="button">เพิ่มบริษัท องค์กร หรือ ธุรกิจชุมชน</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-sm-12">
        <div class="box">
          <div class="inner">
            <h4>สถานที่</h4>
            <p>เพิ่มสถานที่ต่างๆ ในชลบุรี</p>
            <a href="{{URL::to('entity/add?type=place')}}" class="button">เพิ่มสถานที่</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-sm-12">
        <div class="box">
          <div class="inner">
            <h4>ร้านค้าออนไลน์</h4>
            <p>สร้างร้านค้าออนไลน์ของคุณ และนำสินค้าของคุณมาขายบนนี้</p>
            <a href="{{URL::to('entity/add?type=online-shop')}}" class="button">เพิ่มร้านค้าออนไลน์</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop;