@extends('layouts.blackbox.main')
@section('content')

<div class="detail container">

  <div class="detail-title">
    <h4 class="sub-title">ราละเอียดการสมัครงาน</h4>
    <h2 class="title">{{$jobName}}</h2>
    <div class="tag-group">
    </div>
  </div>

  <div>{!!$jobApply['message']!!}</div>

  <div class="line space-top-bottom-30"></div>

  <h4>จุดมุ่งหมายในอาชีพ</h4>
  <div>{!!$careerObjective!!}</div>

  <div class="line space-top-bottom-30"></div>

  <h3>ข้อมูลผู้สมัครงาน</h3>
  <div>โปรไฟล์</div>

  <div class="space-top-bottom-20">

    <div class="clearfix">
      <div class="profile-image pull-left">
        @if(!empty($profileImageUrl))
        <img src="{{$profileImageUrl}}">
        @endif
      </div>

      <div class="profile-info pull-left">
        <h3>{{$profile['name']}}</h3>
        <dl>
          <dt>เพศ</dt>
          <dd>{{$profile['gender']}}</dd>
        </dl>

        <dl>
          <dt>วันเกิด</dt>
          <dd>{{$profile['birthDate']}}</dd>
        </dl>
      </div>

    </div>

    <div class="space-top-bottom-20">
      <dl>
        <dt>ที่อยู่ปัจจุบัน</dt>
        <dd>{{$profile['Address']['_long_address']}}</dd>
      </dl>

    </div>

    <div class="space-top-50"></div>
    <h4>ประสบการณ์การทำงาน</h4>
    <div class="line"></div>
    <div class="list">
      @foreach($PersonWorkingExperience as $detail)
        <div class="list-row row">
          <div class="col-xs-9">
            <h4>{{$detail['message']}}</h4>
            <h5>{{$detail['peroid']}}</h5>
          </div>
        </div>
      @endforeach
    </div>

    <div class="space-top-50"></div>
    <h4>ประสบการณ์การฝึกงาน</h4>
    <div class="line"></div>
    <div class="list">
      @foreach($PersonInternship as $detail)
        <div class="list-row row">
          <div class="col-xs-9">
            <h4>{{$detail['company']}}</h4>
            <h5>{{$detail['peroid']}}</h5>
          </div>
        </div>
      @endforeach
    </div>

    <div class="space-top-50"></div>
    <h4>ประวัติการศึกษา</h4>
    <div class="line"></div>
    <div class="list">
      @foreach($PersonEducation as $detail)
        <div class="list-row row">
          <div class="col-xs-9">
            <h4>{{$detail['message']}}</h4>
            <h5>{{$detail['peroid']}}</h5>
          </div>
        </div>
      @endforeach
    </div>

    <div class="space-top-50"></div>
    <h4>โปรเจค</h4>
    <div class="line"></div>
    <div class="list">
      @foreach($PersonProject as $detail)
        <div class="list-row row">
          <div class="col-xs-9">
            <h4>{{$detail['name']}}</h4>
            <h5>{{$detail['peroid']}}</h5>
          </div>
        </div>
      @endforeach
    </div>

    <div class="space-top-50"></div>
    <h4>ประกาศนียบัตรและการฝึกอบรม</h4>
    <div class="line"></div>
    <div class="list">
      @foreach($PersonCertificate as $detail)
        <div class="list-row row">
          <div class="col-xs-9">
            <h4>{{$detail['name']}}</h4>
            <h5>{{$detail['peroid']}}</h5>
          </div>
        </div>
      @endforeach
    </div>

    <div class="space-top-50"></div>
    <h4>ทักษะและความสามารถ</h4>
    <div class="line"></div>
    <div class="list">
      @foreach($skills as $skill)
        <div class="list-row row">
          <div class="col-xs-9">
            <h4>{{$skill['skill']}}</h4>
          </div>
        </div>
      @endforeach
    </div>

    <div class="space-top-50"></div>
    <h4>ภาษาที่สามารถสื่อสารได้</h4>
    <div class="line"></div>
    <div class="list">
      @foreach($languageSkills as $languageSkill)
        <div class="list-row row">
          <div class="col-xs-9">
            <h4>{{$languageSkill['name']}}</h4>
            <h5>{{$languageSkill['level']}}</h5>
          </div>
        </div>
      @endforeach
    </div>

  </div>

</div>

@stop