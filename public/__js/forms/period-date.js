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
      $('#start_year select option:first-child').css('display','none');
    });

    $(document).on('click','#start_day > a',function(){
      let year = $('#start_year select').val();
      let month = $('#start_month select').val();
      _this.createStartDay(_this.getDaysInMonth(month,year));
      $('#start_month select option:first-child').css('display','none');
    });

    // ===============================================================

    $(document).on('change','#start_year select',function(){
      if(this.value == '-') {
        _this.createAddBtn('start_year','เพิ่มปี');
        _this.startYearEnabled = false;
      }
    });

    $(document).on('change','#start_month select',function(){

      if(this.value == '-') {
        _this.createAddBtn('start_month','เพิ่มเดือน');
        $('#start_year select option:first-child').css('display','block');
        _this.startMonthEnabled = false;
      }else if(_this.startDayEnabled) {
        let year = $('#start_year select').val();
        let month = $('#start_month select').val();
        _this.createStartDay(_this.getDaysInMonth(month,year));
      }
    });

    $(document).on('change','#start_day select',function(){
      if(this.value == '-') {
        _this.createAddBtn('start_day','เพิ่มวัน');
        $('#start_month select option:first-child').css('display','block');
        _this.startDayEnabled = false;
      }
    });

    // ===============================================================

    $(document).on('click','#end_year > a',function(){
      _this.createEndYear();
    });

    $(document).on('click','#end_month > a',function(){
      _this.createEndMonth();
      $('#end_year select option:first-child').css('display','none');
    });

    $(document).on('click','#end_day > a',function(){
      let year = $('#end_year select').val();
      let month = $('#end_month select').val();
      _this.createEndDay(_this.getDaysInMonth(month,year));
      $('#end_month select option:first-child').css('display','none');
    });

    // ===============================================================

    $(document).on('change','#end_year select',function(){
      if(this.value == '-') {
        _this.createAddBtn('end_year','เพิ่มปี');
        _this.endYearEnabled = false;
      }
    });

    $(document).on('change','#end_month select',function(){
      if(this.value == '-') {
        _this.createAddBtn('end_month','เพิ่มเดือน');
        $('#end_year select option:first-child').css('display','block');
        _this.endMonthEnabled = false;
      }else if(_this.endDayEnabled) {
        let year = $('#end_year select').val();
        let month = $('#end_month select').val();
        _this.createEndDay(_this.getDaysInMonth(month,year));
      }
    });

    $(document).on('change','#end_day select',function(){
      if(this.value == '-') {
        _this.createAddBtn('end_day','เพิ่มวัน');
        $('#end_month select option:first-child').css('display','block');
        _this.endDayEnabled = false;
      }
    });

    // ===============================================================

    $('#chk_current').on('click',function(){
      _this.checkIsCurrent();
    });

  }

  createStartYear() {

    let html = '';
    html += '<select name="date_start[year]">';
    html += '<option value="-">ลบ</option>';
    for (var i = this.lastestYear; i >= 1982 ; i--) {
      if(i == this.lastestYear) {
        html += '<option value="'+i+'" selected>'+(i+543)+'</option>';
      }else{
        html += '<option value="'+i+'">'+(i+543)+'</option>';
      }
    };
    html += '</select>';

    $('#'+this.panel+' #start_year').html(html);

    this.createAddBtn('start_month','เพิ่มเดือน');

    this.startYearEnabled = true;

  }

  createStartMonth() {

    let html = '';
    html += '<select name="date_start[month]">';
    html += '<option value="-">ลบ</option>';
    for (var i = 1; i <= 12; i++) {
      if(i == 1) {
        html += '<option value="'+i+'" selected>'+this.months[i]+'</option>';
      }else{
        html += '<option value="'+i+'">'+this.months[i]+'</option>';
      }
    };
    html += '</select>';

    $('#'+this.panel+' #start_month').html(html);

    this.createAddBtn('start_day','เพิ่มวัน');

    this.startYearEnabled = true;
  }

  createStartDay(lastestNumberOfDay) {

    let create = true;
    let selectedValue = 1;

    if(this.startDayEnabled && (this.lastestNumberOfStartDay == lastestNumberOfDay)) {
      create = false;
    }else if(typeof $('#start_day select').val() != 'undefined'){
      selectedValue = $('#start_day select').val();
    }

    if(selectedValue > lastestNumberOfDay) {
      selectedValue = lastestNumberOfDay;
    }

    if(create) {
      let html = '';
      html += '<select name="date_start[day]">';
      html += '<option value="-">ลบ</option>';
      for (var i = 1; i <= lastestNumberOfDay; i++) {
        if(i == selectedValue) {
          html += '<option value="'+i+'" selected>'+i+'</option>';
        }else{
          html += '<option value="'+i+'">'+i+'</option>';
        }
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
    html += '<option value="-">ลบ</option>';
    for (var i = this.lastestYear; i >= 1982 ; i--) {
      if(i == this.lastestYear) {
        html += '<option value="'+i+'" selected>'+(i+543)+'</option>';
      }else{
        html += '<option value="'+i+'">'+(i+543)+'</option>';
      }
    };
    html += '</select>';

    $('#'+this.panel+' #end_year').html(html);

    this.createAddBtn('end_month','เพิ่มเดือน');

    this.endYearEnabled = true;

  }

  createEndMonth() {

    let html = '';
    html += '<select name="date_end[month]">';
    html += '<option value="-">ลบ</option>';
    for (var i = 1; i <= 12; i++) {
      if(i == 1) {
        html += '<option value="'+i+'" selected>'+this.months[i]+'</option>';
      }else{
        html += '<option value="'+i+'">'+this.months[i]+'</option>';
      }
    };
    html += '</select>';

    $('#'+this.panel+' #end_month').html(html);

    this.createAddBtn('end_day','เพิ่มวัน');

    this.endMonthEnabled = true;
  }

  createEndDay(lastestNumberOfDay) {

    let create = true;
    let selectedValue = 1;

    if(this.startDayEnabled && (this.lastestNumberOfStartDay == lastestNumberOfDay)) {
      create = false;
    }else if(typeof $('#start_day select').val() != 'undefined'){
      selectedValue = $('#start_day select').val();
    }

    if(selectedValue > lastestNumberOfDay) {
      selectedValue = lastestNumberOfDay;
    }

    if(create) {
      let html = '';
      html += '<select name="date_end[day]">';
      html += '<option value="-">ลบ</option>';
      for (var i = 1; i <= lastestNumberOfDay; i++) {
        if(i == selectedValue) {
          html += '<option value="'+i+'" selected>'+i+'</option>';
        }else{
          html += '<option value="'+i+'">'+i+'</option>';
        }
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