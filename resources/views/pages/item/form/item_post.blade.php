@extends('layouts.blackbox.main')
@section('content')

<div class="container">

  <div class="container-header">
    <div class="row">
      <div class="col-lg-6 col-sm-12">
        <div class="title">
          ลงประกาศ ซื้อ ขาย สินค้า
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
  ?>

  <div class="form-section">

    <div class="form-row">
      <?php 
        echo Form::label('announcement_type_id', 'ประเภทของการประกาศ', array(
          'class' => 'required'
        ));
      ?>
      <div class="btn-group">
        <?php 
          foreach ($fieldData['announcementTypes'] as $id => $type):
        ?>
          <label class="btn">
            <input type="radio" name="announcement_type_id" value="<?php echo $id; ?>" <?php if($defaultAnnouncementType == $id) echo 'checked'; ?> >  
            <div class="inner"><?php echo $type; ?></div>
          </label>
        <?php
          endforeach;
        ?>
      </div>
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('name', 'ชื่อสินค้าที่ต้องการประกาศ', array(
          'class' => 'required'
        ));
        echo Form::text('name', null, array(
          'placeholder' => 'ชื่อสินค้าที่ต้องการขาย',
          'autocomplete' => 'off'
        ));
      ?>
      <p class="notice info">ชื่อจะมีผลโดยตรงต่อการค้นหา</p>
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('item_category_id', 'หมวดหมู่หลักสินค้า', array(
          'class' => 'required'
        ));
      ?>
      <div class="form-item-group">
        <div class="row">
          <?php 
            foreach ($fieldData['itemCategories'] as $id => $category):
          ?>
            <div class="col-lg-4 col-md-6 col-sm-6 col-sm-12">
              <label class="box">
                <input type="radio" name="ItemToCategory[item_category_id]" value="<?php echo $id; ?>" >  
                <div class="inner"><?php echo $category; ?></div>
              </label>
            </div>
          <?php
            endforeach;
          ?>
        </div>
      </div>
    </div>

<!--     <div class="form-row">
      <?php 
        echo Form::label('announcement_detail', 'รายละเอียดของประกาศนี้');
        echo Form::textarea('announcement_detail', null, array(
          'class' => 'ckeditor'
        ));
      ?>
    </div> -->

    <div class="form-row">
      <?php 
        echo Form::label('item_detail', 'รายละเอียดของสินค้า');
        echo Form::textarea('item_detail', null, array(
          'class' => 'ckeditor'
        ));
      ?>
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('used', 'สภาพสินค้า');
      ?>
      <div class="btn-group">
        <label class="btn">
          <input type="radio" name="used" value="0" >  
          <div class="inner">สินค้าใหม่</div>
        </label>
        <label class="btn">
          <input type="radio" name="used" value="1" checked >  
          <div class="inner">สินค้ามือสอง</div>
        </label>
      </div>
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('tagging', 'แท็กที่เกี่ยวของกับสินค้าและการประกาศนี้');
      ?>
      <div id="_tags" class="tag"></div>
      <p class="notice info">แท็กมีผลต่อการค้นหา</p>

    </div>

    <div class="form-row">
      <?php 
        echo Form::label('price', 'ราคาสินค้า', array(
          'class' => 'required'
        ));
        echo Form::text('price', null, array(
          'placeholder' => 'ราคาสินค้า',
          'autocomplete' => 'off'
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
        echo Form::label('Contact[phone_number]', 'เบอร์โทรศัพท์', array(
        'class' => 'required'
        ));
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

      <div class="form-row">
      <?php
        echo Form::label('Contact[email]', 'Line');
        echo Form::text('Contact[email]', null, array(
          'placeholder' => 'อีเมล',
          'autocomplete' => 'off'
        ));
      ?>
      </div>

      <div class="form-row">
      <?php
        echo Form::label('Contact[email]', 'Line');
        echo Form::text('Contact[email]', null, array(
          'placeholder' => 'อีเมล',
          'autocomplete' => 'off'
        ));
      ?>
      </div>

    </div>

    <div class="form-section">

      <div class="title">
        ตำแหน่งสินค้า
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

    </div>

  </div>

  <?php
    echo Form::submit('ลงประกาศ' , array(
      'class' => 'button'
    ));
  ?>

  <?php
    echo Form::close();
  ?>

</div>

<script type="text/javascript">

  $(document).ready(function(){
    const images = new Images('_image_group',8);
    const district = new District();
    const tagging = new Tagging();
    const form = new Form();

    images.load();
    district.load();
    tagging.load();
    form.load();

  });

</script>

@stop