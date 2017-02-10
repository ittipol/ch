@extends('layouts.blackbox.main')
@section('content')

<div class="container">

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

  <div class="space-top-bottom-20">

    <div class="clearfix">
      <div class="profile-image pull-left">
        <img src="{{$profileImageUrl}}">
      </div>

      <div class="profile-info pull-left">
        <h3>{{$profile['name']}}</h3>
      </div>

    </div>

    <div class="space-top-bottom-20">
      <dl>
        <dt>ที่อยู่ปัจจุบัน</dt>
        <dd>{{$profile['Address']['_long_address']}}</dd>
      </dl>

      <dl>
        <dt>เพศ</dt>
        <dd>{{$profile['gender']}}</dd>
      </dl>

      <dl>
        <dt>วันเกิด</dt>
        <dd>{{$profile['birthDate']}}</dd>
      </dl>
    </div>

    <a href="{{URL::to('experience/profile_edit')}}" class="button">แก้ไขโปรไฟล์</a>

  </div>

  <div class="line grey space-top-bottom-20"></div>

  <h4>ประวัติการทำงาน</h4>
  <div class="clearfix">
    <div class="tile-nav xs pull-left">
      <div class="tile-nav-image">
        <a href="{{URL::to('experience/working_add')}}">
          <img src="/images/common/plus.png">
        </a>
      </div>
    </div>
    <h4 class="tile-nav-title pull-left">เพิ่ม</h4>
  </div>
  <div class="list">
    @foreach($PersonWorkingExperience as $detail)
      <div class="list-row row">
        <div class="col-xs-9">
          <h4>{{$detail['message']}}</h4>
          <h5>{{$detail['peroid']}}</h5>
        </div>
        <div class="col-xs-3">
          <div class="additional-option round pull-right">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="additional-option-content">
              <a href="{{$detail['editUrl']}}">แก้ไข</a>
              <a data-modal="1" href="{{$detail['deleteUrl']}}">ลบ</a>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>


  <div class="line grey space-top-bottom-20"></div>

  <h4>ประวัติการศึกษา</h4>
  <div class="clearfix">
    <div class="tile-nav xs pull-left">
      <div class="tile-nav-image">
        <a href="{{URL::to('experience/education_add')}}">
          <img src="/images/common/plus.png">
        </a>
      </div>
    </div>
    <h4 class="tile-nav-title pull-left">เพิ่ม</h4>
  </div>
  <div class="list">
    @foreach($PersonEducation as $detail)
      <div class="list-row row">
        <div class="col-xs-9">
          <h4>{{$detail['message']}}</h4>
          <h5>{{$detail['peroid']}}</h5>
        </div>
        <div class="col-xs-3">
          <div class="additional-option round pull-right">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="additional-option-content">
              <a href="{{$detail['editUrl']}}">แก้ไข</a>
              <a data-modal="1" href="{{$detail['deleteUrl']}}">ลบ</a>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="line grey space-top-bottom-20"></div>

  <h4>โปรเจค</h4>
  <div class="clearfix">
    <div class="tile-nav xs pull-left">
      <div class="tile-nav-image">
        <a href="{{URL::to('experience/project_add')}}">
          <img src="/images/common/plus.png">
        </a>
      </div>
    </div>
    <h4 class="tile-nav-title pull-left">เพิ่ม</h4>
  </div>
  <div class="list">
    @foreach($PersonProject as $detail)
      <div class="list-row row">
        <div class="col-xs-9">
          <h4>{{$detail['name']}}</h4>
          <h5>{{$detail['peroid']}}</h5>
        </div>
        <div class="col-xs-3">
          <div class="additional-option round pull-right">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="additional-option-content">
              <a href="{{$detail['editUrl']}}">แก้ไข</a>
              <a data-modal="1" href="{{$detail['deleteUrl']}}">ลบ</a>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="line grey space-top-bottom-20"></div>

  <h4>ประกาศนียบัตรและการฝึกอบรม</h4>
  <div class="clearfix">
    <div class="tile-nav xs pull-left">
      <div class="tile-nav-image">
        <a href="{{URL::to('experience/certificate_add')}}">
          <img src="/images/common/plus.png">
        </a>
      </div>
    </div>
    <h4 class="tile-nav-title pull-left">เพิ่ม</h4>
  </div>
  <div class="list">
    @foreach($PersonCertificate as $detail)
      <div class="list-row row">
        <div class="col-xs-9">
          <h4>{{$detail['name']}}</h4>
          <h5>{{$detail['peroid']}}</h5>
        </div>
        <div class="col-xs-3">
          <div class="additional-option round pull-right">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="additional-option-content">
              <a href="{{$detail['editUrl']}}">แก้ไข</a>
              <a data-modal="1" href="{{$detail['deleteUrl']}}">ลบ</a>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="line grey space-top-bottom-20"></div>

  <h4>ทักษะและความสามารถ</h4>
  <div class="clearfix">
    <div class="tile-nav xs pull-left">
      <div class="tile-nav-image">
        <a href="{{URL::to('experience/skill_add')}}">
          <img src="/images/common/plus.png">
        </a>
      </div>
    </div>
    <h4 class="tile-nav-title pull-left">เพิ่ม</h4>
  </div>
  <div class="list">
    @foreach($skills as $skill)
      <div class="list-row row">
        <div class="col-xs-9">
          <h4>{{$skill['skill']}}</h4>
        </div>
        <div class="col-xs-3">
          <div class="additional-option round pull-right">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="additional-option-content">
              <a href="{{$skill['editUrl']}}">แก้ไข</a>
              <a data-modal="1" href="{{$skill['deleteUrl']}}">ลบ</a>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="line grey space-top-bottom-20"></div>

  <h4>ภาษาที่สามารถสื่อสารได้</h4>
  <div class="clearfix">
    <div class="tile-nav xs pull-left">
      <div class="tile-nav-image">
        <a href="{{URL::to('experience/language_skill_add')}}">
          <img src="/images/common/plus.png">
        </a>
      </div>
    </div>
    <h4 class="tile-nav-title pull-left">เพิ่ม</h4>
  </div>
  <div class="list">
    @foreach($languageSkills as $languageSkill)
      <div class="list-row row">
        <div class="col-xs-9">
          <h4>{{$languageSkill['name']}}</h4>
          <h5>{{$languageSkill['level']}}</h5>
        </div>
        <div class="col-xs-3">
          <div class="additional-option round pull-right">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="additional-option-content">
              <a href="{{$languageSkill['editUrl']}}">แก้ไข</a>
              <a data-modal="1" href="{{$languageSkill['deleteUrl']}}">ลบ</a>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

</div>

@stop