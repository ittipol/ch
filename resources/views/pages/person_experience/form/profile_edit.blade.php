@extends('layouts.blackbox.main')
@section('content')

  <div class="container">

    <div class="container-header">
      <div class="row">
        <div class="col-md-8 col-xs-12">
          <div class="title">
            โปรไฟล์
          </div>
          <p>โปรไฟล์ของประวัติการทำงานและโปรไฟล์ของบัญชีนี้ไม่ใช่โปรไฟล์เดียวกัน เมื่อคุณแก้ไขโปรไฟล์ของประวัติการทำงาน จะไม่มีผลกับโปรไฟล์ของบัญชีนี้</p>
        </div>
      </div>
    </div>

    <div class="line"></div>

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
        <?php
          echo Form::label('name', 'รูปภาพโปรไฟล์');
        ?>
        <div id="_profile_image">
        </div>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('name', 'ชื่อ นามสกุล', array(
            'class' => 'required'
          ));
          echo Form::text('name', null, array(
            'placeholder' => 'ชื่อ นามสกุล',
            'autocomplete' => 'off'
          ));
        ?>
      </div>

      <div class="form-row">

        <?php
          echo Form::label('name', 'เพศ');
        ?>

        <label class="box">
          <?php
            echo Form::radio('gender', 'm', true);
          ?>
          <div class="inner">ชาย</div>
        </label>

        <label class="box">
          <?php
            echo Form::radio('gender', 'f');
          ?>
          <div class="inner">หญิง</div>
        </label>

        <label class="box">
          <?php
            echo Form::radio('gender', '0');
          ?>
          <div class="inner">ไม่ระบุ</div>
        </label>

      </div>

      <div class="form-row">
        <?php 
          echo Form::label('websites', 'เว็บไซต์ส่วนตัวหรือบล็อก');
        ?>
        <div id="website_input" class="text-group">
          <div class="text-group-panel">
          </div>
          <a href="javascript:void(0);" class="text-add">เพิ่ม +</a>
        </div>
      </div>

      <div class="form-row">
        <div class="select-group">
          <?php 
            echo Form::label('', 'วันเกิด');
            echo Form::select('birth_day', $day, null, array(
              'id' => 'birth_day'
            ));
            echo Form::select('birth_month', $month, null, array(
              'id' => 'birth_month'
            ));
            echo Form::select('birth_year', $year, null, array(
              'id' => 'birth_year'
            ));
          ?>
        </div>
      </div>

    </div>

    <div class="form-section">

      <div class="title">
        ข้อมูลการติดต่อ
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('Contact[phone_number]', 'หมายเลขโทรศัพท์');
          echo Form::text('Contact[phone_number]', null, array(
            'placeholder' => 'หมายเลขโทรศัพท์',
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
          echo Form::label('Contact[line]', 'Line ID');
          echo Form::text('Contact[line]', null, array(
            'placeholder' => 'Line ID',
            'autocomplete' => 'off'
          ));
        ?>
      </div>

    </div>

    <div class="form-section">

      <div class="title">
        ที่อยู่ปัจจุบัน
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
          echo Form::label('Address[province_id]', 'จังหวัด');
          echo Form::select('Address[province_id]', $_fieldData['provinces'] ,null, array(
            'id' => 'province'
          ));
        ?>
      </div>

      <div class="form-row">
        <?php 
          echo Form::label('Address[district_id]', 'อำเภอ');
          echo Form::select('Address[district_id]', array() ,null, array(
            'id' => 'district'
          ));
        ?>
      </div>

<!--       <div class="form-row">
        <?php 
          echo Form::label('Address[sub_district_id]', 'ตำบล', array(
            'class' => 'required'
          ));
          echo Form::select('Address[sub_district_id]', array('0' => '-') , null, array(
            'id' => 'sub_district'
          ));
        ?>
      </div> -->

    </div>

    <?php
      echo Form::submit('บันทึก', array(
        'class' => 'button'
      ));
    ?>

    <?php
      echo Form::close();
    ?>

  </div>

  <script type="text/javascript">

    class InputTextGroup {

      constructor(panel = '_text_input_panel',textInputName = '_text_input_data',placeholder = '') {
        this.panel = panel;
        this.textInputName = textInputName;
        this.placeholder = placeholder;
        this.count = 1;
      }

      load(data) {

        if((data.length > 0) && (data != '[]')) {
          data = JSON.parse(data);

          for (var i = 0; i < data.length; i++) {
            this.createTextInput(data[i]);
          };
        }

        this.createTextInput();
        this.bind();
      }

      bind() {

        let _this = this;

        $('.text-group > .text-add').on('click',function(){
          _this.createTextInput();
        });

        $(document).on('click','.button-clear-text',function(){
          --_this.count;
          $(this).parent().remove();
        });

      }

      createTextInput(value = '') {
        let html = '';
        
        html += '<div class="text-input-wrapper">';
        html += '<input type="text" name="'+this.textInputName+'[]" placeholder="'+this.placeholder+'" autocomplete="off" value="'+value+'">';
        if((this.count++ > 1) || (value != '')){
          html += '<span class="button-clear-text" style="visibility: visible;">×</span>';
        }
        html += '</div>';

        $('#'+this.panel+' .text-group-panel').append(html);

      }

    } 

    $(document).ready(function(){

      const province = new Province();
      province.load();

      // const district = new District();
      // district.load();

      const images = new Images('_profile_image','profile-image',1);
      images.load('{!!$profileImage!!}');

      const inputTextGroup = new InputTextGroup('website_input','private_websites','เว็บไซต์ส่วนตัวหรือบล็อก');
      inputTextGroup.load('{!!$_formData['private_websites']!!}');

      const form = new Form();
      form.load();

    });

  </script>

@stop