@extends('layouts.blackbox.main')
@section('content')

<script src="https://maps.googleapis.com/maps/api/js?libraries=places"></script>

<div class="container">

  <div class="container-header">
    <div class="row">
      <div class="col-lg-12">
        <div class="title">
          ลงประกาศ ซื้อ ขาย ให้เช่าอสังหาริมทรัพย์
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
        echo Form::label('name', 'ชื่อสังหาริมทรัพย์ที่ต้องการประกาศ', array(
          'class' => 'required'
        ));
        echo Form::text('name', null, array(
          'placeholder' => 'ชื่อสังหาริมทรัพย์ที่ต้องการประกาศ',
          'autocomplete' => 'off'
        ));
      ?>
      <p class="notice info">ชื่อจะมีผลโดยตรงต่อการค้นหา</p>
    </div>

    <div class="form-row">
      <?php 
        echo Form::label('real_estate_type_id', 'ประเภทอสังหาริมทรัพย์', array(
          'class' => 'required'
        ));
      ?>
      <div class="form-item-group">
        <div class="row">
          <?php 
            foreach ($fieldData['realEstateTypes'] as $id => $category):
          ?>
            <div class="col-lg-4 col-md-6 col-sm-6 col-sm-12">
              <label class="box">
                <input type="radio" name="real_estate_type_id" value="<?php echo $id; ?>" >  
                <div class="inner"><?php echo $category; ?></div>
              </label>
            </div>
          <?php
            endforeach;
          ?>
        </div>
      </div>
    </div>

    <div class="form-row">

      <div class="sub-title">รายละเอียดอสังหาริมทรัพย์</div>

      <div class="sub-form">

        <div class="sub-form-inner">

          <div class="form-row">
            <?php 
              echo Form::label('name', 'พื้นที่ใช้สอย');
            ?>
            <span class="input-addon">
              <input class="home-area" type="text" name="home_area[sqm]" placeholder="พื้นที่ใช้สอย" autocomplete="off">
              <span>ตารางเมตร</span>
            </span>
          </div>

          <div class="form-row">
            <?php 
              echo Form::label('name', 'พื้นที่ที่ดิน');
            ?>

            <span class="input-addon">
              <input id="rai" class="land-area" type="text" name="land_area[rai]" placeholder="ไร่" autocomplete="off">
              <span>ไร่</span>
            </span>

            <span class="input-addon">
              <input id="ngan" class="land-area" type="text" name="land_area[ngan]" placeholder="งาน" autocomplete="off">
              <span>งาน</span>
            </span>

            <span class="input-addon">
              <input id="wa" class="land-area" type="text" name="land_area[wa]" placeholder="ตารางวา" autocomplete="off">
              <span>ตารางวา</span>
            </span>

            <div class="line space-top-bottom-10"></div>

            <span class="input-addon">
              <input id="sqm" class="land-area" type="text" name="land_area[sqm]" placeholder="ตารางเมตร" autocomplete="off">
              <span>ตารางเมตร</span>
            </span>
            

          </div>

          <div class="form-row">
            <?php 
              echo Form::label('name', 'คุณสมบัติ');
            ?>

            <div class="input-addon-group">
              <span class="input-addon">
                <span>ห้องนอน</span>
                <input type="text" name="indoor[bedroom]" placeholder="ห้องนอน" autocomplete="off" value="0">
              </span>

              <span class="input-addon">
                <span>ห้องน้ำ</span>
                <input type="text" name="indoor[bathroom]" placeholder="ห้องน้ำ" autocomplete="off" value="0">
              </span>

              <span class="input-addon">
                <span>ห้องนั่งเล่น</span>
                <input type="text" name="indoor[living_room]" placeholder="ห้องนั่งเล่น" autocomplete="off" value="0">
              </span>
            </div>

            <div class="input-addon-group">
              <span class="input-addon">
                <span>ห้องทำงาน</span>
                <input type="text" name="indoor[home_office]" placeholder="ห้องทำงาน" autocomplete="off" value="0">
              </span>

              <span class="input-addon">
                <span>จำนวนชั้น</span>
                <input type="text" name="indoor[floors]" placeholder="จำนวนชั้น" autocomplete="off" value="0">
              </span>

              <span class="input-addon">
                <span>ที่จอดรถ</span>
                <input type="text" name="indoor[carpark]" placeholder="ที่จอดรถ" autocomplete="off" value="0">
              </span>
            </div>

          </div>

          <div class="form-row">

            <?php 
              echo Form::label('name', 'เฟอร์นิเจอร์');
            ?>

            <div class="btn-group">
              <label class="btn">
                <input type="radio" name="furniture" value="e">  
                <div class="inner">ไม่มี</div>
              </label>
              <label class="btn">
                <input type="radio" name="furniture" value="s" checked>  
                <div class="inner">มีบางส่วน</div>
              </label>
              <label class="btn">
                <input type="radio" name="furniture" value="f">  
                <div class="inner">ตกแต่งครบ</div>
              </label>
            </div>

          </div>

          <div class="form-row">
            <?php 
              echo Form::label('feature', 'จุดเด่น (เลือกได้มากกว่า 1 ตัวเลือก)');
            ?>
            
            <div class="form-item-group">
              <div class="row">
                <?php 
                  foreach ($fieldData['feature'] as $id => $feature):
                ?>
                  <div class="col-lg-4 col-md-6 col-sm-6 col-sm-12">
                    <label class="box">
                      <input type="checkbox" name="feature[]" value="<?php echo $id; ?>" >  
                      <div class="inner"><?php echo $feature; ?></div>
                    </label>
                  </div>
                <?php
                  endforeach;
                ?>
              </div>
            </div>

          </div>

          <div class="form-row">
            <?php 
              echo Form::label('facility', 'สิ่งอำนวยความสะดวก (เลือกได้มากกว่า 1 ตัวเลือก)');
            ?>
            <div class="form-item-group">
              <div class="row">
                <?php 
                  foreach ($fieldData['facility'] as $id => $facility):
                ?>
                  <div class="col-lg-4 col-md-6 col-sm-6 col-sm-12">
                    <label class="box">
                      <input type="checkbox" name="facility[]" value="<?php echo $id; ?>" >  
                      <div class="inner"><?php echo $facility; ?></div>
                    </label>
                  </div>
                <?php
                  endforeach;
                ?>
              </div>
            </div>

          </div>

          <div class="form-row">
            <?php 
              echo Form::label('description', 'รายละเอียดอสังหาริมทรัพย์');
              echo Form::textarea('description', null, array(
                'class' => 'ckeditor'
              ));
            ?>
          </div>

          <div class="form-row">
            <?php 
              echo Form::label('tagging', 'แท็กที่เกี่ยวของกับอสังหาริมทรัพย์นี้');
            ?>
            <div id="_tags" class="tag"></div>
            <p class="notice info">แท็กมีผลต่อการค้นหา</p>
          </div>

          <div class="form-row">
            <?php 
              echo Form::label('price', 'ราคาอสังหาริมทรัพย์', array(
                'class' => 'required'
              ));
              echo Form::text('price', null, array(
                'placeholder' => 'ราคาอสังหาริมทรัพย์',
                'autocomplete' => 'off'
              ));
            ?>
          </div>

          <div class="form-row">
            <?php 
              echo Form::label('broker', 'ตัวแทนขาย');
            ?>
            <div class="btn-group">
              <label class="btn">
                <input type="radio" name="need_broker" value="1" >  
                <div class="inner">ต้องการ</div>
              </label>
              <label class="btn">
                <input type="radio" name="need_broker" value="0" checked >  
                <div class="inner">ไม่ต้องการ</div>
              </label>
            </div>
          </div>

        </div>

      </div>

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
          echo Form::label('Contact[line]', 'Line');
          echo Form::text('Contact[line]', null, array(
            'placeholder' => 'อีเมล',
            'autocomplete' => 'off'
          ));
        ?>
      </div>

    </div>

    <div class="form-section">

      <div class="title">
        ตำแหน่งอสังหาริมทรัพย์
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
        <?php echo Form::label('', 'ระบุตำแหน่บนแผนที่'); ?>
        <input id="pac-input" class="controls" type="text" placeholder="Search Box">
        <div id="map"></div>
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

  class RealEstate {
    constructor() {}

    load() {
      this.bind();
    }

    bind() {

      let _this = this;

      $('.home-area').on('keydown',function(e){

        if(((e.keyCode < 96) || (e.keyCode > 105)) && ((e.keyCode < 48) || (e.keyCode > 57)) && (e.keyCode != 8)) {
          e.preventDefault();
          return false;
        }

      });

      $('.land-area').on('keydown',function(e){

        if(((e.keyCode < 96) || (e.keyCode > 105)) && ((e.keyCode < 48) || (e.keyCode > 57)) && (e.keyCode != 8)) {
          e.preventDefault();
          return false;
        }
        
        let obj = this;

        clearTimeout(_this.handle);
        _this.handle = setTimeout(function(){
          _this.calSqm($(obj).attr('id'));
        },500);
      });

    }

    calSqm(unit) {

      if(unit == 'sqm') {
        $('#rai').val('');
        $('#ngan').val('');
        $('#wa').val('');
      }else{
        let rai = $('#rai').val() * 1600;
        let ngan = $('#ngan').val() * 400;
        let wa = $('#wa').val() * 4;

        $('#sqm').val(rai+ngan+wa);
      }

    }

  }

  // class HomeArea {

  //   constructor() {}

  //   load() {
  //     this.bind();
  //   }

  //   bind() {

  //     let _this = this;

  //     $('.home-area').on('keydown',function(e){

  //       if(((e.keyCode < 96) || (e.keyCode > 105)) && ((e.keyCode < 48) || (e.keyCode > 57)) && (e.keyCode != 8)) {
  //         e.preventDefault();
  //         return false;
  //       }

  //     });

  //   }

  // }

  // class LandArea {

  //   constructor() {
  //     this.handle;
  //   }

  //   load() {
  //     this.bind();
  //   }

  //   bind() {

  //     let _this = this;

  //     $('.land-area').on('keydown',function(e){

  //       if(((e.keyCode < 96) || (e.keyCode > 105)) && ((e.keyCode < 48) || (e.keyCode > 57)) && (e.keyCode != 8)) {
  //         e.preventDefault();
  //         return false;
  //       }
        
  //       let obj = this;

  //       clearTimeout(_this.handle);
  //       _this.handle = setTimeout(function(){
  //         _this.calSqm($(obj).attr('id'));
  //       },500);
  //     });

  //   }

  //   calSqm(unit) {

  //     if(unit == 'sqm') {
  //       $('#rai').val('');
  //       $('#ngan').val('');
  //       $('#wa').val('');
  //     }else{
  //       let rai = $('#rai').val() * 1600;
  //       let ngan = $('#ngan').val() * 400;
  //       let wa = $('#wa').val() * 4;

  //       $('#sqm').val(rai+ngan+wa);
  //     }

  //   }

  // }

  $(document).ready(function(){
    const images = new Images('_image_group',8,'description');
    const district = new District();
    const map = new Map();
    const tagging = new Tagging();
    const form = new Form();
    const realEstate = new RealEstate();

    images.load();
    district.load();
    map.load();
    tagging.load();
    form.load();
    realEstate.load();

  });

</script>

@stop