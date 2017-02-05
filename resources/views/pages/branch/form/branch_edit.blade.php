@extends('layouts.blackbox.main')
@section('content')

<script src="https://maps.googleapis.com/maps/api/js?libraries=places"></script>

<div class="container">

  <div class="container-header">
    <div class="row">
      <div class="col-lg-12">
        <div class="title">
          เพิ่มสาขา
        </div>
      </div>
    </div>
  </div>

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
        echo Form::label('name', 'ชื่อสาขา', array(
          'class' => 'required'
        ));
        echo Form::text('name', null, array(
          'placeholder' => 'ชื่อสาขา',
          'autocomplete' => 'off'
        ));
      ?>
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('description', 'รายละเอียดของสาขา');
        echo Form::textarea('description', null, array(
          'class' => 'ckeditor'
        ));
      ?>
    </div>

    <div class="form-row">

      <div class="sub-title">รูปภาพ</div>

      <div class="form-row">
        <div id="_image_group">
        </div>
      </div>

    </div>

    <div class="form-section">

      <div class="title">
        ข้อมูลการติดต่อ
      </div>

      <div class="form-row">
      <?php 
        echo Form::label('Contact[phone_number]', 'เบอร์โทรศัพท์');
        echo Form::text('Contact[phone_number]', null, array(
          'placeholder' => 'เบอร์โทรศัพท์',
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

    </div>

    <div class="form-section">

      <div class="title">
       ที่อยู่สาขา
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('province', 'จังหวัด');
          echo Form::text('province', 'ชลบุรี', array(
            'placeholder' => 'จังหวัด',
            'autocomplete' => 'off',
            'disabled' => 'disabled'
          ));
        ?>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('Address[district_id]', 'อำเภอ', array(
            'class' => 'required'
          ));
          echo Form::select('Address[district_id]', $_fieldData['districts'] ,null, array(
            'id' => 'district'
          ));
        ?>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('Address[sub_district_id]', 'ตำบล', array(
            'class' => 'required'
          ));
          echo Form::select('Address[sub_district_id]', array('0' => '-') , null, array(
            'id' => 'sub_district'
          ));
        ?>
      </div>

      <div class="form-row">
        <?php echo Form::label('', 'ระบุตำแหน่บนแผนที่'); ?>
        <input id="pac-input" class="controls" type="text" placeholder="Search Box">
        <div id="map"></div>
      </div>

    </div>

  </div>

  <?php
    echo Form::submit('บันทึก' , array(
      'class' => 'button'
    ));
  ?>

  <?php
    echo Form::close();
  ?>

</div>

<script type="text/javascript">

  $(document).ready(function(){

    const images = new Images('_image_group','photo',5);
    const district = new District();
    const map = new Map();
    const form = new Form();

    images.load('<?php echo $_formData['Image']; ?>');
    district.load('<?php echo $_formData['Address']['sub_district_id']; ?>');
    map.initialize();
    map.setLocation('<?php echo $_formData['Address']['_geographic']; ?>');
    form.load();

  });

</script>

@stop