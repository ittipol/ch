class Address {
	constructor() {
		this.subDistrictId = null;
		this.districtId = null;
	}

	load(districtId,subDistrictId) {
		console.log(districtId);
		console.log(subDistrictId);

		// this.getSubDistrict($('#district').val());
		// this.getDistrict($('#province').val());
	}

	bind(){

	  let _this = this;

	  $('#province').on('change',function(){
	    _this.getDistrict($(this).val());
	  });

	  $('#district').on('change',function(){
	    _this.getSubDistrict($(this).val());
	  });

	} 

	getDistrict(districtId){

	  let _this = this;

	  let CSRF_TOKEN = $('input[name="_token"]').val();        

	  let request = $.ajax({
	    url: "/api/v1/get_district/"+districtId,
	    type: "get",
	    dataType:'json'
	  });

	  // Callback handler that will be called on success
	  request.done(function (response, textStatus, jqXHR){
	    $('#district').empty();
	    $.each(response, function(key,value) {
	      
	      let option = $("<option></option>");

	      // if(key == _this.districtId){
	      //   option.prop('selected',true);
	      // }

	      $('#district').append(option.attr("value", key).text(value));

	    });

	    // _this.districtId = null;
	    
	  });

	  request.fail(function (jqXHR, textStatus, errorThrown){
	    console.error(
	        "The following error occurred: "+
	        textStatus, errorThrown
	    );
	  });

	  // request.always(function () {});
	}

	getSubDistrict(districtId){

	  let _this = this;

	  let CSRF_TOKEN = $('input[name="_token"]').val();        

	  let request = $.ajax({
	    url: "/api/v1/get_sub_district/"+districtId,
	    type: "get",
	    dataType:'json'
	  });

	  request.done(function (response, textStatus, jqXHR){
	    $('#sub_district').empty();
	    $.each(response, function(key,value) {
	      
	      let option = $("<option></option>");

	      // if(key == _this.subDistrictId){
	      //   option.prop('selected',true);
	      // }

	      $('#sub_district').append(option.attr("value", key).text(value));

	    });

	    // _this.subDistrictId = null;
	    
	  });

	  request.fail(function (jqXHR, textStatus, errorThrown){
	    console.error(
	        "The following error occurred: "+
	        textStatus, errorThrown
	    );
	  });

	  // request.always(function () {});
	}

}