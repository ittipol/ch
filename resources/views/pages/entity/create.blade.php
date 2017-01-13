@extends('layouts.blackbox.main')
@section('content')

  <div class="container">

    <div class="container-header">
      <div class="row">
        <div class="col-lg-6 col-sm-12">
          <div class="title">
            เพิ่มธุรกิจของคุณ หรือ สถานที่
          </div>
          <div>เพิ่มธุรกิจของคุณ และให้เราทำหน้าที่เชื่อมต่อธุรกิจกับผู้คนในขลบุรี</div>
        </div>
      </div>
    </div>

    <div class="line space-top-bottom-30"></div>

    <div class="row">
      <div class="col-lg-4 col-sm-12">
        <div class="box">
          <div class="inner">
            <h4>บริษัท องค์กร หรือ ธุรกิจชุมชน</h4>
            <p>เพิ่มธุรกิจของคุณ โฆษณาธุรกิจของคุณ สร้างหน้าร้านและนำผลิตภัณฑ์มาขาย เพิ่มโปรโมชั่นและติดโปรโมชั่นให้กับผลิตภัณฑ์นั้นๆได้ โฆษณาผลิตภัณฑ์ใหม่ รวมถึงการประกาศรับสมัครพนักงานของธุรกิจของคุณได้</p>
            <a href="{{URL::to('entity/add?type=business')}}" class="button">เพิ่มบริษัท องค์กร หรือ ธุรกิจชุมชน</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-sm-12">
        <div class="box">
          <div class="inner">
            <h4>สถานที่</h4>
            <p>เพิ่มสถานที่ต่างๆ ในชลบุรี ไม่ว่าจะเป็น สถานที่ราชการ ห้างสรรพสินค้า หรีอ สถานที่ต้องเที่ยวต่างๆ เพื่อเป็นการบอกตำแหน่งหรือเส้นทางให้กับนักท่องเที่ยวหรือผู้คนในชลบุรีเองที่ต้องการค้าหาสถานที่นั้นๆ</p>
            <a href="{{URL::to('entity/add?type=place')}}" class="button">เพิ่มสถานที่</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-sm-12">
        <div class="box">
          <div class="inner">
            <h4>ร้านค้าออนไลน์</h4>
            <p>สร้างร้านค้าออนไลน์ของคุณ สร้างหน้าร้านและนำผลิตภัณฑ์ของคุณที่ต้องการขายมาขายบนนี้ได้หรือแค่เพียงต้องการโฆษณาผลิตภัณฑ์ได้</p>
            <a href="{{URL::to('entity/add?type=online-shop')}}" class="button">เพิ่มร้านค้าออนไลน์</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop;