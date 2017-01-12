@extends('layouts.blackbox.main')
@section('content')

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCk5a17EumB5aINUjjRhWCvC1AgfxqrDQk&libraries=places"></script>

<div class="container">
  
  <div class="container-header">
    <div class="row">
      <div class="col-lg-6 col-sm-12">
        <div class="title">
          เพิ่มสถานที่
        </div>
      </div>
    </div>
  </div>

  @include('components.form_error') 

  <?php 
    echo Form::open(['id' => 'main_form','method' => 'post', 'enctype' => 'multipart/form-data']);
  ?>

  <?php
    echo Form::hidden('model', $modelName);
    echo Form::hidden('entity_type', $entityType);
  ?>

  <div class="form-section">

    <div class="form-row">
      <?php 
        echo Form::label('name', 'ชื่อสถานที่', array(
          'class' => 'required'
        ));
        echo Form::text('name', null, array(
          'placeholder' => 'ชื่อสถานที่',
          'autocomplete' => 'off'
        ));
      ?>
      <p class="notice info">ชื่อจะมีผลโดยตรงต่อการค้นหา</p>
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
        echo Form::select('Address[district_id]', $fieldData['districts'] ,null, array(
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
      <?php echo Form::label('', 'ระบุตำแหน่งสถานที่บนแผนที่'); ?>
      <input id="pac-input" class="controls" type="text" placeholder="Search Box">
      <div id="map"></div>
    </div>

  </div>

  <?php
    echo Form::submit('เพิ่ม' , array(
      'class' => 'button'
    ));
  ?>

  <?php
    echo Form::close();
  ?>

</div>

<script type="text/javascript">
  const district = new District();
  district.load();

  const map = new Map();
  map.load();

  const form = new Form();
  form.load();
</script>

@stop