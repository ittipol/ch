@extends('layouts.blackbox.main')
@section('content')

  <div class="container">

    <div class="container-header">
      <div class="row">
        <div class="col-lg-6 col-sm-12">
          <div class="title">
            ชุมชน
          </div>
          <p>สร้างร้านค้าในชุมชน เชื่อมต่อร้านค้าของคุณกับชุมชนและผู้คนในชลบุรี เพื่อสะดวกต่อการค้นหาร้านค้า สินค้า งานบริการ ตำแหน่งงาน และอื่นๆ อีกมากมาย</p>
        </div>
      </div>
    </div>

    <div class="line space-top-bottom-30"></div>
      
    <div class="row">

      <div class="col-xs-12">
        <h3 class="no-margin">คุณสมบัติ</h3>
      </div>

      <div class="col-lg-6 col-xs-12">
        <h3>เชื่อมต่อธุรกิจของคุณกับผู้คนในขลบุรี</h3>
        <p>เพิ่มธุรกิจของคุณ และให้เราทำหน้าที่เชื่อมต่อธุรกิจของคุณกับผู้คนในขลบุรี</p>
      </div>
      <div class="col-lg-6 col-xs-12">
        <h3>ขายสินค้า</h3>
        <p>ขายสินค้าและจัดการสินค้าของคุณ รวมถึงสร้งโปรโมชั่นเพื่อเพิ่มยอดขายของคุณ</p>
      </div>
      <div class="col-lg-6 col-xs-12">
        <h3>ลงประกาศงาน</h3>
        <p>ลงประกาศงานเพื่อหาพนักงานใหม่ๆ หรือ ค้นหาโดยตรงจากประวัติการทำของบุคคลนั้นๆ<br/>รวมถึงการจัดการและตรวจสอบรายชื่อผู้ที่สนใจงานของคุณ</p>
      </div>
      <div class="col-lg-6 col-xs-12">
        <h3>โฆษณาธุรกิจและงานบริการ</h3>
        <p>โฆษณางานบริการของคุณ เพื่อให้ลูกทราบถึงธุรกิจงานบริการต่างๆ ของคุณ</p>
      </div>
    </div>

    <div class="line space-top-bottom-30"></div>

    <div class="container-header">
      <div class="row">
        <div class="col-lg-6 col-sm-12">
          <div class="title">
            สร้างร้านค้าลงในชุมชน
          </div>
          <p>สร้างร้านค้าของคุณเพื่อนำสินค้าของคุณมาขาย ค้นหาพนักงานให้กับธุรกิจของคุณ และรวมถึงการโฆษณาแบรนด์ ธุรกิจ หรืองานบริการของคุณ</p>
        </div>
      </div>
    </div>

    @include('components.form_error') 

    <?php 
      echo Form::open(['id' => 'main_form','method' => 'post', 'enctype' => 'multipart/form-data']);
    ?>

    <?php
      echo Form::hidden('model', $formModel['modelName']);
    ?>

    <div class="form-section">

      <div class="form-row">
        <?php 
          echo Form::label('name', 'ชื่อแบรนด์ ร้านค้าหรือธุรกิจ', array(
            'class' => 'required'
          ));
          echo Form::text('name', null, array(
            'placeholder' => 'ชื่อแบรนด์ ร้านค้าหรือธุรกิจ',
            'autocomplete' => 'off'
          ));
        ?>
      </div>

      <div class="form-row">
      <?php 
        echo Form::label('Contact[phone_number]', 'หมายเลขโทรศัพท์', array(
            'class' => 'required'
        ));
        echo Form::text('Contact[phone_number]', null, array(
          'placeholder' => 'หมายเลขโทรศัพท์',
          'autocomplete' => 'off'
        ));
      ?>
      </div>

    </div>

    <?php
      echo Form::submit('เริ่มต้นใช้งาน' , array(
        'class' => 'button'
      ));
    ?>

    <?php
      echo Form::close();
    ?>

  </div>

@stop