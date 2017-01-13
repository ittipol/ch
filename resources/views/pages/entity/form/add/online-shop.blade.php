@extends('layouts.blackbox.main')
@section('content')

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCk5a17EumB5aINUjjRhWCvC1AgfxqrDQk&libraries=places"></script>

<div class="container">
  
  <div class="container-header">
    <div class="row">
      <div class="col-lg-6 col-sm-12">
        <div class="title">
          เพิ่มร้านค้าออนไลน์
        </div>
      </div>
    </div>
  </div>

  @include('components.form_error') 

  <?php 
    echo Form::open(['id' => 'main_form','method' => 'post', 'enctype' => 'multipart/form-data']);
  ?>

  <?php
    echo Form::hidden('model', $formModel['modelName']);
    echo Form::hidden('entity_type', $fieldData['entityType']);
  ?>

  <div class="form-section">

    <div class="form-row">
      <?php 
        echo Form::label('name', 'ชื่อร้านค้าออนไลน์', array(
          'class' => 'required'
        ));
        echo Form::text('name', null, array(
          'placeholder' => 'ชื่อร้านค้าออนไลน์',
          'autocomplete' => 'off'
        ));
      ?>
      <p class="notice info">ชื่อจะมีผลโดยตรงต่อการค้นหา</p>
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

    <div class="form-row">
    <?php
      echo Form::label('Contact[website]', 'เว็บไซต์');
      echo Form::text('Contact[website]', null, array(
        'placeholder' => 'เว็บไซต์',
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

  $(document).ready(function(){
    const form = new Form();
    form.load();
  });
  
</script>

@stop