@extends('layouts.blackbox.main')
@section('content')

<script src="https://maps.googleapis.com/maps/api/js?libraries=places"></script>

<div class="container">
  
  <div class="container-header">
    <div class="row">
      <div class="col-lg-6 col-sm-12">
        <div class="title">
          เพิ่มบริษัท องค์กร หรือ ธุรกิจชุมชน
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
        echo Form::label('name', 'ชื่อบริษัท องค์กร หรือ ธุรกิจชุมชน', array(
          'class' => 'required'
        ));
        echo Form::text('name', null, array(
          'placeholder' => 'ชื่อบริษัท องค์กร หรือ ธุรกิจชุมชน',
          'autocomplete' => 'off'
        ));
      ?>
      <p class="notice info">ชื่อจะมีผลโดยตรงต่อการค้นหา</p>
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('business_type', 'ประเภทของธุรกิจ');
        echo Form::select('business_type', array() ,null, array(
          'id' => 'business_type'
        ));
      ?>
      <p class="notice info">เช่น โรงเรียน การศึกษา</p>
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

    <div class="form-section">

      <div class="title">
        ที่อยู่
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('Address[address]', 'ที่อยู่');
          echo Form::text('Address[address]', null, array(
          'placeholder' => 'ที่อยู่',
          'autocomplete' => 'off'
        ));
        ?>
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
        <?php echo Form::label('', 'ระบุตำแหน่งบริษัท องค์กร หรือ ธุรกิจชุมชนบนแผนที่'); ?>
        <input id="pac-input" class="controls" type="text" placeholder="Search Box">
        <div id="map"></div>
        <p class="notice info">คลิกบนแผนที่เพื่อระบุตำแหน่ง</p>
      </div>

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

    const district = new District();
    district.load();

    const map = new Map();
    map.load();

    const form = new Form();
    form.load();

  });
  
</script>

@stop