@extends('layouts.blackbox.main')
@section('content')

<div class="container">
  
  <div class="container-header">
    <div class="row">
      <div class="col-lg-6 col-sm-12">
        <div class="title">
          ประกาศรับสมัครพนักงาน
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

    <div class="title">
      ข้อมูลตำแหน่งงาน
    </div>

    <div class="form-section-inner">

      <div class="form-row">
        <?php 
          echo Form::label('name', 'ชื่อตำแหน่องงาน', array(
            'class' => 'required'
          ));
          echo Form::text('name', null, array(
            'placeholder' => 'ชื่อตำแหน่องงาน',
            'autocomplete' => 'off'
          ));
        ?>
        <p class="notice info">ชื่อจะมีผลโดยตรงต่อการค้นหา</p>
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
        <p class="notice info">สามารถกรอกเป็นประโยคได้ เช่น 10000 - 20000 บาท หรือ สามารถต่อรองได้</p>
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
                echo Form::label('nationality', 'สัญชาติ', array(
                  'class' => 'required'
                ));
                echo Form::text('nationality', null, array(
                  'placeholder' => 'สัญชาติ',
                  'autocomplete' => 'off'
                ));
              ?>
            </div>

            <div class="form-row">
              <?php
                echo Form::label('age', 'อายุ', array(
                  'class' => 'required'
                ));
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
                echo Form::label('educational_level', 'ระดับการศึกษา', array(
                  'class' => 'required'
                ));
                echo Form::text('educational_level', null, array(
                  'placeholder' => 'ระดับการศึกษา',
                  'autocomplete' => 'off'
                ));
              ?>
            </div>

            <div class="form-row">
              <?php
                echo Form::label('experience', 'ประสบการณ์การทำงาน', array(
                  'class' => 'required'
                ));
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
        <?php echo Form::label('', 'รูปภาพสถานที่ทำงาน'); ?>
        <p class="error-message">* รองรับไฟล์ jpg jpeg png</p>
        <p class="error-message">* รองรับรูปภาพขนาดไม่เกิน 3MB</p>
        <div id="_image_group"></div>
      </div>

    </div>

  </div>

  <div class="form-section">

    <div class="title">
      แท๊ก
    </div>

    <div class="form-section-inner">

      <div class="form-row">
        <?php 
          echo Form::label('_tags', 'แท๊กที่เกี่ยวข้องกับงานนี้');
        ?>
        <div id="_tags" class="tag"></div>
        <p class="notice info">แท็กจะช่วยให้การค้นหาประกาศงานของคุณง่ายขึ้น</p>
      </div>

    </div>

  </div>

  <div class="form-section">

    <div class="title">
      ข้อมูลสถานประกอบการ
    </div>

    <div class="form-section-inner">

      <div class="form-row">
        <?php 
          echo Form::label('Company[name]', 'ชื่อสถานประกอบการ', array(
            'class' => 'required'
          ));
          echo Form::text('Company[name]', null, array(
            'placeholder' => 'ชื่อสถานประกอบการ',
            'autocomplete' => 'off'
          ));
        ?>
      </div>

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

    const images = new Images('_image_group',6,'default');
    const tagging = new Tagging();
    const form = new Form();

    images.load();
    tagging.load();
    form.load();
    
  });    
</script>

@stop