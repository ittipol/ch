@extends('layouts.blackbox.main')
@section('content')

  <div class="container">

    <div class="container-header">
      <div class="row">
        <div class="col-md-8 col-xs-12">
          <div class="title">
            โปรไฟล์
          </div>
          <p>โปรไฟล์ของประวัติการทำงานและโปรไฟล์ของบัญชีนี้ไม่ใช่โปรไฟล์เดียวกัน เมื่อคุณแก้ไขโปรไฟล์ของประวัติการทำงาน จะไม่มีผลกับโปรไฟล์ของบัญชีนี้</p>
        </div>
      </div>
    </div>

    <div class="line"></div>

    @include('components.form_error') 

    <?php 
      echo Form::model($_formData, [
        'id' => 'main_form',
        'method' => 'PATCH',
        'enctype' => 'multipart/form-data'
      ]);
    ?>

    <?php
      echo Form::hidden('model', $_formModel['modelName']);
    ?>

    <div class="form-section">

      <div class="form-row">
        <?php
          echo Form::label('name', 'รูปภาพโปรไฟล์');
        ?>
        <div id="_profile_image">
        </div>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('name', 'ชื่อ นามสกุล', array(
            'class' => 'required'
          ));
          echo Form::text('name', null, array(
            'placeholder' => 'ชื่อ นามสกุล',
            'autocomplete' => 'off'
          ));
        ?>
      </div>

      <div class="form-row">

        <?php
          echo Form::label('name', 'เพศ');
        ?>

        <label class="box">
          <?php
            echo Form::radio('gender', 'm', true);
          ?>
          <div class="inner">ชาย</div>
        </label>

        <label class="box">
          <?php
            echo Form::radio('gender', 'f');
          ?>
          <div class="inner">หญิง</div>
        </label>

        <label class="box">
          <?php
            echo Form::radio('gender', '0');
          ?>
          <div class="inner">ไม่ระบุ</div>
        </label>

      </div>

      <div class="form-row">
        <?php 
          echo Form::label('website', 'เว็บไซต์ส่วนตัว');
          echo Form::text('website', null, array(
            'placeholder' => 'เว็บไซต์ส่วนตัว',
            'autocomplete' => 'off'
          ));
        ?>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('blog', 'บล็อก');
          echo Form::text('blog', null, array(
            'placeholder' => 'บล็อก',
            'autocomplete' => 'off'
          ));
        ?>
      </div>

      <div class="form-row">
        <div class="select-group">
          <?php 
            echo Form::label('', 'วันเกิด');
            echo Form::select('birth_day', $day, null, array(
              'id' => 'birth_day'
            ));
            echo Form::select('birth_month', $month, null, array(
              'id' => 'birth_month'
            ));
            echo Form::select('birth_year', $year, null, array(
              'id' => 'birth_year'
            ));
          ?>
        </div>
      </div>

    </div>

    <div class="form-section">

      <div class="title">
        ข้อมูลการติดต่อ
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('Contact[phone_number]', 'หมายเลขโทรศัพท์');
          echo Form::text('Contact[phone_number]', null, array(
            'placeholder' => 'หมายเลขโทรศัพท์',
            'autocomplete' => 'off'
          ));
        ?>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('Contact[email]', 'อีเมล');
          echo Form::text('Contact[email]', null, array(
            'placeholder' => 'อีเมล',
            'autocomplete' => 'off'
          ));
        ?>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('Contact[line]', 'Line ID');
          echo Form::text('Contact[line]', null, array(
            'placeholder' => 'Line ID',
            'autocomplete' => 'off'
          ));
        ?>
      </div>

    </div>

    <div class="form-section">

      <div class="title">
        ที่อยู่ปัจจุบัน
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('website', 'ที่อยู่');
          echo Form::text('website', null, array(
            'placeholder' => 'ที่อยู่',
            'autocomplete' => 'off'
          ));
        ?>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('Address[province_id]', 'จังหวัด');
          echo Form::select('Address[province_id]', $_fieldData['provinces'] ,null, array(
            'id' => 'province'
          ));
        ?>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('Address[district_id]', 'อำเภอ');
          echo Form::select('Address[district_id]', array() ,null, array(
            'id' => 'district'
          ));
        ?>
      </div>

<!--       <div class="form-row">
        <?php 
          echo Form::label('Address[sub_district_id]', 'ตำบล', array(
            'class' => 'required'
          ));
          echo Form::select('Address[sub_district_id]', array('0' => '-') , null, array(
            'id' => 'sub_district'
          ));
        ?>
      </div> -->

    </div>

    <?php
      echo Form::submit('บันทึก', array(
        'class' => 'button'
      ));
    ?>

    <?php
      echo Form::close();
    ?>

  </div>

  <script type="text/javascript">

    $(document).ready(function(){

      const province = new Province();
      province.load();

      // const district = new District();
      // district.load();

      const images = new Images('_profile_image',1);
      images.load();

    });

  </script>

@stop