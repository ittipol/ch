class TextInputStack {

  constructor(panel = '_text_input_panel',textInputName = '_text_input_data',placeholder = '',options = []) {
    this.panel = panel;
    this.textInputName = textInputName;
    this.placeholder = placeholder;
    this.options = options;
    this.index = 1;
    this.runningNumber = 0;
    this.checkEmpty = true;
  }

  load(data = []) {

    if((data.length > 0) && (data != '[]')) {
      data = JSON.parse(data);

      for (var i = 0; i < data.length; i++) {
        this.createTextInput(data[i]['name'],data[i]['type']);
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
      --_this.index;
      $(this).parent().remove();
    });

    $('#main_form').on('submit',function(){

      if(_this.checkEmpty) {

        let hasError = false;

        $('#'+_this.panel+' input[type="text"]').each(function(index) {
            if(this.value == '') {

              hasError = true;

              $(this).addClass('input-error');
            }
        });

        if(hasError) {
          return false;
        }

      }
      
    });

  }

  createTextInput(value = '',type='') {

    let html = '';
    html += '<div class="text-input-wrapper">';

    if(this.options.length > 0) {
      html += '<select name="'+this.textInputName+'['+this.runningNumber+'][type]">';
      for (var i = 0; i < this.options.length; i++) {
        if(type == this.options[i][0]) {
          html += '<option value="'+this.options[i][0]+'" selected>'+this.options[i][1]+'</option>';
        }else{
          html += '<option value="'+this.options[i][0]+'">'+this.options[i][1]+'</option>';
        }
      };
       html += '</select>';
    }
   
    html += '<input type="text" name="'+this.textInputName+'['+this.runningNumber+'][name]" placeholder="'+this.placeholder+'" autocomplete="off" value="'+value+'">';
    if((this.index > 1) || (value != '')){
      html += '<span class="button-clear-text" style="visibility: visible;">×</span>';
    }
    html += '</div>';

    this.runningNumber++;
    this.index++;
    $('#'+this.panel+' .text-group-panel').append(html);

  }

  disbleCheckingEmpty() {
    this.checkEmpty = false;
  }

}