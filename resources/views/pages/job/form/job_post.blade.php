@extends('layouts.blackbox.main')
@section('content')

<div class="container">
  
  <div class="container-header">
    <div class="row">
      <div class="col-md-8 col-xs-12">
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
    echo Form::hidden('model', $_formModel['modelName']);
  ?>

  <div class="form-section">

    <div class="form-row">
      <?php 
        echo Form::label('item_category_id', 'กำหนดสาขาที่เปิดรับสมัคร (สามารถเว้นว่างได้)');
      ?>
      @if(!empty($_fieldData['branches']))
      <div class="form-item-group">
        <div class="row">
          <?php 
            foreach ($_fieldData['branches'] as $id => $branch):
          ?>
            <div class="col-lg-4 col-md-6 col-sm-6 col-sm-12">
              <label class="box">
                <?php
                  echo Form::checkbox('JobToBranch[branch_id][]', $id);
                ?>
                <div class="inner"><?php echo $branch; ?></div>
              </label>
            </div>
          <?php
            endforeach;
          ?>
        </div>
      </div>
      @else
      <p class="notice info">ยังไม่มีสาขาลงในร้านค้านี้</p>
      @endif
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('name', 'ชื่อตำแหน่งงาน', array(
          'class' => 'required'
        ));
        echo Form::text('name', null, array(
          'placeholder' => 'ชื่อตำแหน่งงาน',
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
      <p class="notice info">สามารถกรอกเป็นประโยคได้ เช่น 10000 - 20000 บาท, ตามประสบการณ์ หรือ สามารถต่อรองได้</p>
    </div>

    <div class="form-row">
      
      <?php 
        echo Form::label('employment_type_id', 'รูปแบบงาน');
        echo Form::select('employment_type_id', $_fieldData['employmentTypes'] , null);
      ?>

    </div>

    <div class="form-row">
      <?php 
        echo Form::label('qualification', 'คุณสมบัติผู้สมัคร');
        echo Form::textarea('qualification', null, array(
          'class' => 'ckeditor'
        ));
      ?>
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('description', 'รายละเอียดงาน');
        echo Form::textarea('description', null, array(
          'class' => 'ckeditor'
        ));
      ?>
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('benefit', 'สวัสดิการ');
        echo Form::textarea('benefit', null, array(
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

  <div class="form-section">

    <div class="title">
      วิธีการสมัครงาน
    </div>

    <div class="form-row">

      <label class="box">
        <input type="checkbox" checked disabled >
        <div class="inner">รับสมัครผ่านชุมชน CHONBURI SQUARE</div>
      </label>
      <br>
      <label class="box">
        <?php
          echo Form::checkbox('recruitment_custom', 1, null, array(
            'id' => 'recruitment_custom'
          ));
        ?>
        <div class="inner">เพิ่มวิธีการสมัครงานนี้</div>
      </label>

      <?php 
        echo Form::label('recruitment_custom_detail', 'รายละเอียดการสมัครงานนี้');
        echo Form::textarea('recruitment_custom_detail', null, array(
          'class' => 'ckeditor'
        ));
      ?>
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

  class Job {

    constructor() {
      this.txtRecruitmentDetail = $('textarea[name="recruitment_custom_detail"]');
    }

    load() {
      this.bind();
      
      if($('#recruitment_custom').is(':checked')) {
        $('textarea[name="recruitment_custom_detail"]').prop('disabled',false);
      }else{
        $('textarea[name="recruitment_custom_detail"]').prop('disabled',true);
      }

    }

    bind() {
      $('#recruitment_custom').on('click',function(){
        if($(this).is(':checked')) {
          CKEDITOR.instances['recruitment_custom_detail'].setReadOnly(false);
        }else{
          CKEDITOR.instances['recruitment_custom_detail'].setReadOnly(true);
          CKEDITOR.instances['recruitment_custom_detail'].setData('');
        }
      });
    }

  }

  $(document).ready(function(){

    const images = new Images('_image_group','photo',5,'description');
    const tagging = new Tagging();
    const job = new Job();
    const form = new Form();

    images.load();
    tagging.load();
    @if(!empty($_oldInput['Tagging']))
      tagging.setTags('{!!$_oldInput['Tagging']!!}');
    @endif
    job.load();
    form.load();
    
  });    
</script>

@stop