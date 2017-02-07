@extends('layouts.blackbox.main')
@section('content')

<div class="container">

  <div class="container-header">
    <div class="row">
      <div class="col-lg-12">
        <div class="title">
          เพิ่มประสบการณ์การทำงาน
        </div>
      </div>
    </div>
  </div>

  @include('components.form_error') 

  <?php 
    echo Form::open(['id' => 'main_form','method' => 'post', 'enctype' => 'multipart/form-data']);
  ?>

  <?php
    echo Form::hidden('model', $_formModel['modelName']);
  ?>

  <div class="form-section">

    <div class="form-row">
      <?php 
        echo Form::label('item_category_id', 'ประเภทของหัวข้อที่ต้องการเพิ่ม', array(
          'class' => 'required'
        ));
      ?>

      <div class="row">
        <?php 
          foreach ($_fieldData['workingExperienceDetailTypes'] as $id => $type):
        ?>
          <div class="col-sm-12">
            <label class="box">
              <?php
                echo Form::radio('working_experiences_detail_type_id', $id);
              ?> 
              <div class="inner"><?php echo $type; ?></div>
            </label>
          </div>
        <?php
          endforeach;
        ?>
      </div>
 
    </div>

    <div class="form-row">

      <?php 
        echo Form::label('item_category_id', 'ช่วงเวลา', array(
          'class' => 'required'
        ));
      ?>

    </div>

    <div class="form-row">
      <?php 
        echo Form::label('item_category_id', 'ซื่อบริษัท', array(
          'class' => 'required'
        ));
      ?>
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('item_category_id', 'ชื่อโรงเรียน/มหาวิทยาลัย', array(
          'class' => 'required'
        ));
      ?>
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('description', 'รายละเอียดหรือเนื้อหาตามหัวข้อที่เลือกข้างต้น');
        echo Form::textarea('description', null, array(
          'class' => 'ckeditor'
        ));
      ?>
    </div>


    เว็บไซต์ส่วนตัว
    บล็อก

    ภาษา
    Thai
    เป็นเจ้าของภาษาหรือเป็นภาษาที่สอง
    English
    สามารถใช้ทำงานได้แบบมืออาชีพ
    Dutch
    ความสามารถระดับพื้นฐาน
    French
    ความสามารถระดับพื้นฐาน

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

    // CKEDITOR.config.height = '900px';
    CKEDITOR.instances['description'].config.height = '600px';

    // const images = new Images('_image_group',8);
    // const district = new District();
    // const tagging = new Tagging();
    const form = new Form();

    // images.load();
    // district.load();
    // tagging.load();
    // @if(!empty($_oldData['Tagging']))
    //   tagging.setTags('{!!$_oldData['Tagging']!!}');
    // @endif
    form.load();

  });

</script>

@stop