@extends('layouts.blackbox.main')
@section('content')
  <div class="detail container">

    <div class="detail-title">
      <h2>{{$formData['name']}}</h2>
      <h4>ประกาศ{{$announcementType['name']}}</h4>
    </div>

    <div class="image-gallery">

      <div class="row">

          <div class="col-lg-7 col-md-7 col-sm-12">

            <div class="image-gallary-display">
              <div class="image-gallary-display-inner">
                <img id="image_display" src="{{$formData['Image'][0]['url']}}">
              </div>
            </div>

          </div>

          <div class="col-lg-5 col-md-5 col-sm-12">

            <!-- <h2 class="detail-title">{{$formData['name']}}</h2> -->
            
            <div class="image-gallery-preview clearfix">
              @foreach ($formData['Image'] as $image)
                <div class="preview-image" style="background-image:url('{{$image['url']}}')" data-url="{{$image['url']}}"></div>
              @endforeach
            </div>
            
          </div>

      </div>

    </div>

    <h2>ราคา{{$announcementType['name']}} {{$formData['price']}} บาท</h2>
    <div class="line space-top-bottom-20"></div>

    <h4>รายละเอียดสินค้า</h4>
    <p>
      {!!$formData['description']!!}
    </p>

    <div class="line space-top-bottom-20"></div>

    <h4>ตำแหน่งของสินค้า</h4>
    <p>

    </p>

  </div>

  <script type="text/javascript">
    $(document).ready(function(){
      $('.preview-image').on('mouseenter',function(){
        console.log($(this).data('url'));
        $('#image_display').attr('src',$(this).data('url'));
      });
    });
  </script>
@stop