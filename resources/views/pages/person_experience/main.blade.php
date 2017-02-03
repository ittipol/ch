@extends('layouts.blackbox.main')
@section('content')

  <div class="container">

    <div class="container-header">
      <div class="row">
        <div class="col-xs-12">
          <div class="title">
            ประสบการณ์และทักษะ
          </div>
        </div>
      </div>
    </div>

    <div class="line"></div>

    @if($exist)

      <h4>ประวัติการทำงาน</h4>
      <div class="clearfix">
        <div class="tile-nav xs pull-left">
          <div class="tile-nav-image">
            <a href="job_add">
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
            <a href="job_add">
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
            <a href="job_add">
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
            <a href="job_add">
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
            <a href="job_add">
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
            <a href="job_add">
              <img src="/images/common/plus.png">
            </a>
          </div>
        </div>
        <h4 class="tile-nav-title pull-left">เพิ่ม</h4>
      </div>

      <div class="line grey space-top-bottom-20"></div>

      <h4>ทักษะ</h4>
      <div class="clearfix">
        <div class="tile-nav xs pull-left">
          <div class="tile-nav-image">
            <a href="job_add">
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
            <a href="job_add">
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