@extends('layouts.default.main')
@section('content')
  
  <?php 
    echo Form::open(['id' => 'main_form','method' => 'post', 'enctype' => 'multipart/form-data']);
  ?>

  <?php 
    echo Form::label('pid', 'Parent ID', array(
      'class' => 'required'
    ));
    echo Form::text('pid', null, array(
      'placeholder' => 'Parent ID',
      'autocomplete' => 'off'
    ));
  ?>

  <?php 
    echo Form::label('description');
    echo Form::textarea('description', null);
  ?>

  <br/>

  <?php
    echo Form::submit('ลงประกาศ' , array(
      'class' => 'button'
    ));
  ?>

  <?php
    echo Form::close();
  ?>

@stop