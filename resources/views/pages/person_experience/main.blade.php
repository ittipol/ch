@extends('layouts.blackbox.main')
@section('content')

  <div class="container">

    @if($exist)

      <div class="container-header">
        <div class="row">
          <div class="col-xs-12">
            <div class="title">
              โปรไฟล์
            </div>
          </div>
        </div>
      </div>

      <div class="line"></div>

<!--       <div class="clearfix">
        <div class="tile-nav xs pull-left">
          <div class="tile-nav-image">
            <a href="{{URL::to('experience/profile')}}">
              <img src="/images/common/plus.png">
            </a>
          </div>
        </div>
        <h4 class="tile-nav-title pull-left">เพิ่ม</h4>

      </div> -->

      <div class="space-top-bottom-20">

        <div class="clearfix">
          <div class="profile-image pull-left">
            <img src="">
          </div>

          <div class="profile-info pull-left">
            <h3>{{$profile['name']}}</h3>
  <!-- 
            <div>
              <dl>
                <dt>เพศ</dt>
                <dd>{{$profile['gender']}}</dd>
              </dl>

              <dl>
                <dt>วันเกิด</dt>
                <dd>{{$profile['birthDate']}}</dd>
              </dl>
            </div> -->

          </div>

        </div>

        <div class="space-top-bottom-20">
          <dl>
            <dt>เพศ</dt>
            <dd>{{$profile['gender']}}</dd>
          </dl>

          <dl>
            <dt>วันเกิด</dt>
            <dd>{{$profile['birthDate']}}</dd>
          </dl>
        </div>

        <a href="{{URL::to('experience/profile')}}" class="button">แก้ไขโปรไฟล์</a>

      </div>

      <div class="line grey space-top-bottom-20"></div>

      <h4>ประวัติการทำงาน</h4>
      <div class="clearfix">
        <div class="tile-nav xs pull-left">
          <div class="tile-nav-image">
            <a href="{{URL::to('experience/working')}}">
              <img src="/images/common/plus.png">
            </a>
          </div>
        </div>
        <h4 class="tile-nav-title pull-left">เพิ่ม</h4>
      </div>

      <div class="line grey space-top-bottom-20"></div>

      <h4>ประวัติการศึกษา</h4>
      <div class="clearfix">
        <div class="tile-nav xs pull-left">
          <div class="tile-nav-image">
            <a href="{{URL::to('experience/education')}}">
              <img src="/images/common/plus.png">
            </a>
          </div>
        </div>
        <h4 class="tile-nav-title pull-left">เพิ่ม</h4>
      </div>

      <div class="line grey space-top-bottom-20"></div>

      <h4>โปรเจค</h4>
      <div class="clearfix">
        <div class="tile-nav xs pull-left">
          <div class="tile-nav-image">
            <a href="{{URL::to('experience/project')}}">
              <img src="/images/common/plus.png">
            </a>
          </div>
        </div>
        <h4 class="tile-nav-title pull-left">เพิ่ม</h4>
      </div>

      <div class="line grey grey space-top-bottom-20"></div>

      <h4>บทความ</h4>
      <div class="clearfix">
        <div class="tile-nav xs pull-left">
          <div class="tile-nav-image">
            <a href="{{URL::to('experience/article')}}">
              <img src="/images/common/plus.png">
            </a>
          </div>
        </div>
        <h4 class="tile-nav-title pull-left">เพิ่ม</h4>
      </div>

      <div class="line grey space-top-bottom-20"></div>
      <h4>กิจกรรมและอาสาสมัคร</h4>
      <div class="clearfix">
        <div class="tile-nav xs pull-left">
          <div class="tile-nav-image">
            <a href="{{URL::to('experience/volunteer')}}">
              <img src="/images/common/plus.png">
            </a>
          </div>
        </div>
        <h4 class="tile-nav-title pull-left">เพิ่ม</h4>
      </div>

      <div class="line grey space-top-bottom-20"></div>

      <h4>ฝึกอบรม</h4>
      <div class="clearfix">
        <div class="tile-nav xs pull-left">
          <div class="tile-nav-image">
            <a href="{{URL::to('experience/training')}}">
              <img src="/images/common/plus.png">
            </a>
          </div>
        </div>
        <h4 class="tile-nav-title pull-left">เพิ่ม</h4>
      </div>

      <div class="line grey space-top-bottom-20"></div>

      <h4>ทักษะและความสามารถ</h4>
      <div class="clearfix">
        <div class="tile-nav xs pull-left">
          <div class="tile-nav-image">
            <a href="{{URL::to('experience/skill')}}">
              <img src="/images/common/plus.png">
            </a>
          </div>
        </div>
        <h4 class="tile-nav-title pull-left">เพิ่ม</h4>
      </div>

      <div class="line grey space-top-bottom-20"></div>

      <h4>ภาษาที่สามารถสื่อสารได้</h4>
      <div class="clearfix">
        <div class="tile-nav xs pull-left">
          <div class="tile-nav-image">
            <a href="{{URL::to('experience/language')}}">
              <img src="/images/common/plus.png">
            </a>
          </div>
        </div>
        <h4 class="tile-nav-title pull-left">เพิ่ม</h4>
      </div>

    @else

      <div class="shop-notice text-center">
        <img src="/images/common/job.png">
        <div>
          <h3>ประสบการณ์การทำงานของคุณ</h3>
          <p>ยังไม่มีประสบการณ์การทำงาน เพิ่มประสบการณ์การทำงานเพื่อเพิ่มโอกาสในการทำงานและประสบความสำเร็จในสายอาชีพของคุณ</p>
          <?php
            echo Form::open(['method' => 'post', 'enctype' => 'multipart/form-data']);

            echo Form::submit('เพิ่มประสบการณ์การทำงาน' , array(
              'class' => 'button'
            ));

            echo Form::close();
          ?>
        </div>
      </div>

    @endif

  </div>

@stop