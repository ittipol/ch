@extends('layouts.blackbox.main')
@section('content')

<div class="container">
  
  <div class="container-header">
    <div class="row">
      <div class="col-lg-6 col-sm-12">
        <div class="title">
          ลงประกาศงาน
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
        echo Form::label('item_category_id', 'ลงประกาศงานนี้ให้กับสาขา');
      ?>
      @if(!empty($fieldData['branchs']))
      <p class="error-message">* สามารถเว้นว่างได้</p>
      <div class="form-item-group">
        <div class="row">
          <?php 
            foreach ($fieldData['branchs'] as $id => $branch):
          ?>
            <div class="col-lg-4 col-md-6 col-sm-6 col-sm-12">
              <label class="box">
                <input type="checkbox" name="JobToBranch[branch_id] " value="<?php echo $id; ?>" >  
                <div class="inner"><?php echo $branch; ?></div>
              </label>
            </div>
          <?php
            endforeach;
          ?>
        </div>
      </div>
      @else
      <p class="notice info">ยังไม่ได้เพิ่มสาขาลงในร้านค้านี้</p>
      @endif
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('name', 'ชื่อตำแหน่งงาน', array(
          'class' => 'required'
        ));
        echo Form::text('name', null, array(
          'placeholder' => 'ชื่อตำแหน่องงาน',
          'autocomplete' => 'off'
        ));
      ?>
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('salary', 'เงินเดือน (บาท)', array(
          'class' => 'required'
        ));
        echo Form::text('salary', null, array(
          'placeholder' => 'เงินเดือน',
          'autocomplete' => 'off'
        ));
      ?>
    </div>

    <div class="form-row">
      
      <?php 
        echo Form::label('employment_type_id', 'ประเภทของการทำงาน');
        echo Form::select('employment_type_id', $fieldData['employmentTypes'] , null);
      ?>

    </div>

    <div class="form-row">

      <div class="sub-title">คุณสมบัติผู้สมัคร</div>

      <div class="sub-form">

        <div class="sub-form-inner">

          <div class="form-row">
            <?php 
              echo Form::label('nationality', 'สัญชาติ');
              echo Form::text('nationality', null, array(
                'placeholder' => 'สัญชาติ',
                'autocomplete' => 'off'
              ));
            ?>
          </div>

          <div class="form-row">
            <?php
              echo Form::label('age', 'อายุ');
              echo Form::text('age', null, array(
                'placeholder' => 'อายุ',
                'autocomplete' => 'off'
              ));
              echo '<p class="notice info">สามารถกรอกเป็นประโยคได้ เช่น ไม่จำกัดอายุ, มากกว่า 25 ปี หรือ 25 - 30 ปี</p>';
            ?>
          </div>

          <div class="form-row">
            <?php
              echo Form::label('gender', 'เพศ');
              echo Form::select('gender', array(
              'm' => 'ชาย',
              'f' => 'หญิง',
              'n' => 'ไม่จำกัดเพศ'
              ) , null);
            ?>
          </div>

          <div class="form-row">
            <?php
              echo Form::label('educational_level', 'ระดับการศึกษา');
              echo Form::text('educational_level', null, array(
                'placeholder' => 'ระดับการศึกษา',
                'autocomplete' => 'off'
              ));
            ?>
          </div>

          <div class="form-row">
            <?php
              echo Form::label('experience', 'ประสบการณ์การทำงาน');
              echo Form::text('experience', null, array(
                'placeholder' => 'ประสบการณ์การทำงาน',
                'autocomplete' => 'off'
              ));
              echo '<p class="notice info">สามารถกรอกเป็นประโยคได้ เช่น 3 ปีขึ้นไป หรือ 0 - 3 ปี</p>';
            ?>
          </div>

          <div class="form-row">
            <?php
              echo Form::label('number_of_position', 'จำนวนที่รับ');
              echo Form::text('number_of_position', null, array(
                'placeholder' => 'จำนวนที่รับ',
                'autocomplete' => 'off'
              ));
              echo '<p class="notice info">สามารถกรอกเป็นประโยคได้</p>';
            ?>
          </div>

        </div>
      
      </div>

    </div>

    <div class="form-row">
      <?php 
        echo Form::label('description', 'รายละเอียดงาน', array(
          'class' => 'required'
        ));
        echo Form::textarea('description', null, array(
          'class' => 'ckeditor'
        ));
      ?>
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('welfare', 'สวัสดิการ');
        echo Form::textarea('welfare', null, array(
          'class' => 'ckeditor'
        ));
      ?>
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('_tags', 'แท๊กที่เกี่ยวข้องกับงานนี้');
      ?>
      <div id="_tags" class="tag"></div>
    </div>

  </div>

  <div class="form-section">

    <div class="title">
      รูปภาพ
    </div>

    <div class="form-row">
      <div id="_image_group"></div>
    </div>

  </div>

  <?php
    echo Form::submit('ลงประกาศงาน', array(
      'class' => 'button'
    ));
  ?>

  <?php
    echo Form::close();
  ?>

</div>

<script type="text/javascript">
  $(document).ready(function(){

    const images = new Images('_image_group',8,'default');
    const tagging = new Tagging();
    const form = new Form();

    images.load();
    tagging.load();
    form.load();
    
  });    
</script>

@stop