class ImageGallery {
  constructor(displayDescription = false) {
    this.images = null;
    this.noImg = '/images/common/no-img.png';
    this.displayDescription = displayDescription;
  }

  load(images = null) {

    if ((images != '[]') && (typeof images[0] != 'undefined')) {

      this.setImage(images[0]['_url']);
      this.setImageDescription(images[0]['description']);
      this.makeGalleryList(images);

      this.images = images;

      this.init();
      this.bind();

    }else{
      $('#image_display').attr('src',this.noImg);
    }

  }

  init() {
    this.alignCenter();
    this.enableImageDesription();
  }

  bind() {

    let _this = this;

    $('.preview-image').on('click',function(){

      _this.setImage(_this.images[$(this).data('id')]['_url']);
      _this.setImageDescription(_this.images[$(this).data('id')]['description']);
      _this.alignCenter();

      // let image = new Image();
      // image.src = $(this).data('url');

      // image.onload = function() {
      //   $('#image_display').css('display','none');
      //   _this.setImage(image.src);
      //   _this.alignCenter();
      //   $('#image_display').css('display','inline-block');
      // }

      // <div id="item_detail" class="tab-content"></div>

    });

    $('.display-image-description-icon').on('click',function(){
      $(this).css('display','none');
      $('.image-description').css('top','0');
    });

    $('.close-image-description-icon').on('click',function(){
      $('.image-description').css('top','100%');
      $('.display-image-description-icon').css('display','block');
    });

    $(window).resize(function() {
      _this.alignCenter();
    });

  }

  makeGalleryList(images) {

    let len = images.length;

    for (var i = 0; i < len; i++) {
      let div = document.createElement('div');

      $(div).addClass('preview-image');
      $(div).data('id',i);
      $(div).css('background-image','url('+images[i]['_url']+')');

      $('#image_gallery_list').append(div);
    };

  }

  setImage(url) {
    $('#image_display').attr('src',url);
  }

  setImageDescription(description) {

    if(description == null) {
      description = '-'
    }

    $('#image_description').text(description);
  }

  alignCenter() {

    let imgWidth = $('#image_display').width();
    let frameWidth = $('.image-gallary-display-inner').width();

    if(imgWidth > frameWidth) {
      $('#image_display').css('left',(frameWidth - imgWidth) / 2);
    }else{
      $('#image_display').css('left',0);
    }
  }

  enableImageDesription() {

    $('.display-image-description-icon').css('display','block');

    $('.image-description').css({
      'display':'block',
      'top':'100%'
    });
  }

}