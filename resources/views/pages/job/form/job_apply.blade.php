@extends('layouts.blackbox.main')
@section('content')

<div class="container">
  
  <div class="container-header">
    <div class="row">
      <div class="col-md-8 col-xs-12">
        <div class="title">
          สมัครงาน
        </div>
      </div>
    </div>
  </div>

  <?php 
    echo Form::open(['id' => 'main_form','method' => 'post', 'enctype' => 'multipart/form-data']);
  ?>

  <?php
    echo Form::hidden('model', $_formModel['modelName']);
  ?>

  <div class="form-section">

    <div class="form-row">
      <h4>ชื่อบริษัท หรือสถานประกอบการ</h4>
      <div>{{$shopName}}</div>
    </div>

    <div class="form-row">
      <h4>งาน</h4>
      <div>{{$jobName}}</div>
    </div>

    @if(!empty($branches))
    <div class="form-row">
      <?php 
        echo Form::label('item_category_id', 'เลือกสาขาที่สามารถทำงานได้ (เลือกได้มากกว่า 1 ตัวเลือก)');
      ?>
      <div class="form-item-group">
        <div class="row">
          <?php 
            foreach ($branches as $id => $branch):
          ?>
            <div class="col-lg-4 col-md-6 col-sm-6 col-sm-12">
              <label class="box">
                <?php
                  echo Form::checkbox('JobApplyToBranch[branch_id][]', $id);
                ?>
                <div class="inner"><?php echo $branch; ?></div>
              </label>
            </div>
          <?php
            endforeach;
          ?>
        </div>
      </div>
    </div>
    @endif

    <div class="form-row">
      <?php 
        echo Form::label('message', 'ข้อความถึงผู้รับสมัครงานนี้');
        echo Form::textarea('message', null, array(
          'class' => 'ckeditor'
        ));
      ?>
    </div>

  </div>

  <?php
    echo Form::submit('สมัครงาน', array(
      'class' => 'button'
    ));
  ?>

  <?php
    echo Form::close();
  ?>

</div>

@stop