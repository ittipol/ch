@extends('layouts.default.default')
@section('content')
	<div class="register-wrapper">
		<div class="header-container">
			<h3><a class="logo" href="{{URL::to('/')}}">CHONBURI SQUARE</a></h3>
			<p>สมัครสามชิก</p>
		</div>

		<div class="register-form">
			
			<div class="register-form-inner">
			
				<div class="form-row">
					<input type="text" name="email" placeholder="ชื่อ" autocomplete="off">
				</div>
				<div class="form-row">
					<input type="text" name="email" placeholder="อีเมล" autocomplete="off">
				</div>
				<div class="form-row">
					<input type="password" name="email" placeholder="รหัสผ่าน (อย่างน้อย 4 อักขระ)" autocomplete="off">
				</div>
				<div class="form-row">
					<input type="password" name="email" placeholder="ป้อนรหัสผ่านอีกครั้ง" autocomplete="off">
				</div>

				<?php
					echo Form::submit('สมัครสมาชิก', array(
						'class' => 'button wide-btn'
					));
				?>

				<h4 class="text-center">เป็นสมาชิกแล้ว <a href="{{URL::to('register')}}">ลงชื่อเข้าใช้</a></h4>

			</div>
		</div>
	</div>

		<script type="text/javascript">

	    class RegisterPage {
	      constructor() {}

	      init() {

	        let w = window.innerWidth;

	        if(w <= 1200) {

	        	$('.register-wrapper').addClass('mobile');

	        	// $('.login-form').css({
	        	// 	'height':window.innerHeight,
	        	// });

	        }

	      }

	    }

	    $(document).ready(function(){
	      registerPage = new RegisterPage();
	      registerPage.init();
	    });
	  </script>
@stop