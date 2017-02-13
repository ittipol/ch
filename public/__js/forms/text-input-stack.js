class TextInputStack {

  constructor(panel = '_text_input_panel',textInputName = '_text_input_data',placeholder = '',options = []) {
    this.panel = panel;
    this.textInputName = textInputName;
    this.placeholder = placeholder;
    this.options = options;
    this.index = 1;
    this.runningNumber = 0;
    this.checkEmpty = false;
    this.disableCreating = false;
    // this.singleField = false;
  }

  load(data = []) {

    if((data.length > 0) && (data != '[]')) {

      for (var i = 0; i < data.length; i++) {

        if(typeof data[i]['name'] != 'undefined') {
          this.createTextInput(data[i]['name'],data[i]['type'],true);
        }else{
          this.createTextInput(data[i],'',true);
        }

      };
    }

    this.createTextInput('','');
    this.bind();
  }

  bind() {

    let _this = this;

    $('.text-group > .text-add').on('click',function(){
      _this.createTextInput();
    });

    $(document).on('click','.button-clear-text',function(){
      
      $(this).parent().remove();

      if(--_this.index == 1) {
        _this.createTextInput('','',true);
      }

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

  setData(data = []) {

  }

  createTextInput(value = '',type='',forceCreate = false) {

    // if((this.disableCreating || (this.singleField && (this.runningNumber > 0))) && !forceCreate) {
    //   return ;
    // }

    if((this.disableCreating && (this.runningNumber > 0)) && !forceCreate) {
      return ;
    }

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
   
    html += '<input type="text" name="'+this.textInputName+'['+this.runningNumber+'][value]" placeholder="'+this.placeholder+'" autocomplete="off" value="'+value+'">';
    // if(((this.index > 1) || (value != '')) && !this.singleField){
    if(((this.index > 1) || (value != '')) && !this.disableCreating){
      html += '<span class="button-clear-text" style="visibility: visible;">×</span>';
    }
    html += '</div>';

    this.runningNumber++;
    this.index++;
    $('#'+this.panel+' .text-group-panel').append(html);

  }

  // createSingleField() {
  //   this.singleField = true;
  // }

  disableCreatingInput() {
    this.disableCreating = true;
  }

  enableCheckingEmpty() {
    this.checkEmpty = true;
  }

}