@extends('layouts.blackbox.main')
@section('content')

<div class="container">

  <div class="container-header">
    <div class="row">
      <div class="col-lg-7 col-sm-12">
        <div class="title">
          เวลาเปิดทำการ
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
      <label class="box">
        <?php
          echo Form::checkbox('active', 1);
        ?>
        <div class="inner">แสดงเวลาเปิดทำการในหน้าร้านของคุณ</div>
      </label>
    </div>

    <div class="form-row">
      <label class="box">
        <?php
          echo Form::checkbox('same_time', 1);
        ?>
        <div class="inner">กำหนดเวลาทำการเหมือนกันทุกวัน</div>
      </label>
    </div>

    <div class="form-row">
      <span class="office-status active"></span><span>&nbsp;เปิดทำการ</span>
      <span class="office-status"></span><span>&nbsp;หยุดทำการ</span>
    </div>

    <div id="_office_time"></div>

  </div>

  <?php
    echo Form::submit('บันทึก' , array(
      'class' => 'button'
    ));
  ?>

  <?php
    echo Form::close();
  ?>

<div>

<script type="text/javascript">

  $(document).ready(function(){

    const openHour = new OpenHour();
    openHour.load('{!!$openHours!!}',{{$sameTime}});

  });

</script>

@stop