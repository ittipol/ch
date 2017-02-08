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
        echo Form::label('company', 'สถานศึกษา', array(
          'class' => 'required'
        ));
        echo Form::text('company', null, array(
          'placeholder' => 'สถานศึกษา',
          'autocomplete' => 'off'
        ));
      ?>
    </div>

    <div class="form-row">
      <label class="box">
        <?php
          echo Form::checkbox('graduated', 1);
        ?>
        <div class="inner">จบการศึกษา</div>
      </label>
    </div>

    <div class="form-row">

      <?php 
        echo Form::label('item_category_id', 'ระยะเวลา');
      ?>

      <div class="period-panel" id="period_date">
        <div class="period-controller">
          <span id="start_year">
            <a href="javascript:void(0);">เพิ่มปี</a>
          </span>
          <span id="start_month"></span>
          <span id="start_day"></span>
          <span>ถึง</span>
          <span id="current">ปัจจุบัน</span>
          <span id="end_year">
            <a href="javascript:void(0);">เพิ่มปี</a>
          </span>
          <span id="end_month"></span>
          <span id="end_day"></span>
        </div>
      </div>

    </div>


    <div class="form-row">
      <?php 
        echo Form::label('description', 'รายละเอียดเกี่ยวกับการทำงาน');
        echo Form::textarea('description', null, array(
          'class' => 'ckeditor'
        ));
      ?>
    </div>

  </div>

  <?php
    echo Form::submit('บันทึก' , array(
      'class' => 'button'
    ));
  ?>

  <?php
    echo Form::close();
  ?>

</div>

<script type="text/javascript">

  class PeriodDate {

    constructor(panel,lastestYear,months) {
      this.panel = panel;
      this.startYearEnabled = false;
      this.startMonthEnabled = false;
      this.startDayEnabled = false;
      this.endYearEnabled = false;
      this.endMonthEnabled = false;
      this.EndDayEnabled = false;
      this.lastestYear = lastestYear;
      this.lastestNumberOfStartDay = 31;
      this.lastestNumberOfEndDay = 31;
      this.months = months;
    }

    load() {
      this.init();
      this.bind();
      // this.createStartYear();
    }

    init() {
      this.checkIsCurrent();
    }

    bind() {

      let _this = this;

      $(document).on('click','#start_year > a',function(){
        _this.createStartYear();
      });

      $(document).on('click','#start_month > a',function(){
        _this.createStartMonth();
      });

      $(document).on('click','#start_day > a',function(){
        let year = $('#start_year select').val();
        let month = $('#start_month select').val();
        _this.createStartDay(_this.getDaysInMonth(month,year));
      });

      $(document).on('change','#start_Day select',function(){
        if(_this.startDayEnabled) {
          let year = $('#start_year select').val();
          let month = $('#start_month select').val();
          _this.createStartDay(_this.getDaysInMonth(month,year));
        }
      });

      $(document).on('change','#start_month select',function(){
        if(_this.startDayEnabled) {
          let year = $('#start_year select').val();
          let month = $('#start_month select').val();
          _this.createStartDay(_this.getDaysInMonth(month,year));
        }
      });

      $(document).on('click','#end_year > a',function(){
        _this.createEndYear();
      });

      $(document).on('click','#end_month > a',function(){
        _this.createEndMonth();
      });

      $(document).on('click','#end_day > a',function(){
        let year = $('#end_year select').val();
        let month = $('#end_month select').val();
        _this.createEndDay(_this.getDaysInMonth(month,year));
      });

      $(document).on('change','#end_Day select',function(){
        if(_this.endDayEnabled) {
          let year = $('#end_year select').val();
          let month = $('#end_month select').val();
          _this.createEndDay(_this.getDaysInMonth(month,year));
        }
      });

      $(document).on('change','#end_month select',function(){
        if(_this.endDayEnabled) {
          let year = $('#end_year select').val();
          let month = $('#end_month select').val();
          _this.createEndDay(_this.getDaysInMonth(month,year));
        }
      });

      $('#chk_current').on('click',function(){
        _this.checkIsCurrent();
      });

    }

    createStartYear() {

      let html = '';
      html += '<select name="date_start[year]">';
      for (var i = this.lastestYear; i >= 1957 ; i--) {
        html += '<option value="'+i+'">'+(i+543)+'</option>';
      };
      html += '</select>';

      $('#'+this.panel+' #start_year').html(html);

      this.createAddBtn('start_month','เพิ่มเดือน');

      this.startYearEnabled = true;

    }

    createStartMonth() {

      let html = '';
      html += '<select name="date_start[month]">';
      for (var i = 1; i <= 12; i++) {
        html += '<option value="'+i+'">'+this.months[i]+'</option>';
      };
      html += '</select>';

      $('#'+this.panel+' #start_month').html(html);

      this.createAddBtn('start_day','เพิ่มวัน');

      this.startYearEnabled = true;
    }

    createStartDay(lastestNumberOfDay) {

      let create = true;
      if(this.startDayEnabled && (this.lastestNumberOfStartDay <= lastestNumberOfDay)) {
        create = false;
      }

      if(create) {
        let html = '';
        html += '<select name="date_start[day]">';
        for (var i = 1; i <= lastestNumberOfDay; i++) {
          html += '<option value="'+i+'">'+i+'</option>';
        };
        html += '</select>';

        $('#'+this.panel+' #start_day').html(html); 
      }

      this.lastestNumberOfStartDay = lastestNumberOfDay;

      this.startDayEnabled = true;
    }

    createEndYear() {

      let html = '';
      html += '<select name="date_end[year]">';
      for (var i = this.lastestYear; i >= 1957 ; i--) {
        html += '<option value="'+i+'">'+(i+543)+'</option>';
      };
      html += '</select>';

      $('#'+this.panel+' #end_year').html(html);

      this.createAddBtn('end_month','เพิ่มเดือน');

      this.endYearEnabled = true;

    }

    createEndMonth() {

      let html = '';
      html += '<select name="date_end[month]">';
      for (var i = 1; i <= 12; i++) {
        html += '<option value="'+i+'">'+this.months[i]+'</option>';
      };
      html += '</select>';

      $('#'+this.panel+' #end_month').html(html);

      this.createAddBtn('end_day','เพิ่มวัน');

      this.endMonthEnabled = true;
    }

    createEndDay(lastestNumberOfDay) {

      let create = true;
      if(this.endDayEnabled && (this.lastestNumberOfEndDay <= lastestNumberOfDay)) {
        create = false;
      }

      if(create) {
        let html = '';
        html += '<select name="date_end[day]">';
        for (var i = 1; i <= lastestNumberOfDay; i++) {
          html += '<option value="'+i+'">'+i+'</option>';
        };
        html += '</select>';

        $('#'+this.panel+' #end_day').html(html);
      }

      this.lastestNumberOfEndDay = lastestNumberOfDay;

      this.endDayEnabled = true;
    }

    createAddBtn(panel,text) {
      let html = '<a href="javascript:void(0);">'+text+'</a>';
      $('#'+panel).html(html);
    }

    getDaysInMonth(month,year) {  
     return new Date(year, month, 0).getDate();  
    }  

    checkLeapYear(year) {
      return (year % 100 === 0) ? (year % 400 === 0) : (year % 4 === 0); 
    }

    checkIsCurrent() {
      if($('#chk_current').is(':checked')) {

        $('#current').css('display','inline-block');

        $('#end_year').css('display','none');
        $('#end_month').css('display','none');
        $('#end_day').css('display','none');

      }else{

        $('#current').css('display','none');

        $('#end_year').css('display','inline-block');
        $('#end_month').css('display','inline-block');
        $('#end_day').css('display','inline-block');
      }
    }

  }

  $(document).ready(function(){

    CKEDITOR.instances['description'].config.height = '600px';

    const periodDate = new PeriodDate('period_date',{{$latestYear}},{!!$month!!});
    periodDate.load();

    const form = new Form();
    form.load();

  });

</script>

@stop