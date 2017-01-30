@extends('layouts.blackbox.main')
@section('content')

  <div class="container">

    <div class="container-header">
      <div class="row">
        <div class="col-lg-6 col-sm-12">
          <div class="title">
            ประสบการณ์การทำงาน
          </div>
        </div>
      </div>
    </div>

    <div class="line"></div>

    @if($exist)

      <div class="tile-nav-group space-top-bottom-20 clearfix">

        <div class="tile-nav">
          <div class="tile-nav-image">
            <a href="job_add">
              <img src="/images/common/job.png">
            </a>
          </div>
          <div class="tile-nav-info">
            <a href="job_add">
              <h4 class="tile-nav-title">เพิ่มประวัติทั่วไป</h4>
            </a>
          </div>
        </div>

        <div class="tile-nav">
          <div class="tile-nav-image">
            <a href="job_add">
              <img src="/images/common/job.png">
            </a>
          </div>
          <div class="tile-nav-info">
            <a href="job_add">
              <h4 class="tile-nav-title">เพิ่มประสบการณ์การทำงาน</h4>
            </a>
          </div>
        </div>


        <div class="tile-nav">
          <div class="tile-nav-image">
            <a href="job_add">
              <img src="/images/common/job.png">
            </a>
          </div>
          <div class="tile-nav-info">
            <a href="job_add">
              <h4 class="tile-nav-title">เพิ่มโปรเจคที่คุณเคยทำหรือมีส่วนร่วม</h4>
            </a>
          </div>
        </div>

        <div class="tile-nav">
          <div class="tile-nav-image">
              <a href="branch_add">
                <img src="/images/common/plus.png">
              </a>
          </div>
          <div class="tile-nav-info">
            <a href="branch_add">
              <h4 class="tile-nav-title">เพิ่มทักษะ</h4>
            </a>
          </div>
        </div>

        <div class="tile-nav">
          <div class="tile-nav-image">
              <a href="department_add">
                <img src="/images/common/plus.png">
              </a>
          </div>
          <div class="tile-nav-info">
            <a href="department_add">
              <h4 class="tile-nav-title">เพิ่มภาษาที่สามารถสื่อสารได้</h4>
            </a>
          </div>
        </div>

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