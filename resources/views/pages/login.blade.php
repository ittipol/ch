@extends('layouts.default.default')
@section('content')

<div class="bg-overlay"></div>

<div class="login-form">
	<div class="login-form-inner">
		<h3><a class="logo" href="{{URL::to('/')}}">CHONBURI SQUARE</a></h3>

		<?php if(!empty($errors->all())): ?>
			<?php foreach ($errors->all() as $message) { ?>
				<h4 class="error-message"><?php echo $message; ?></h4>
			<?php	} ?>
		<?php endif; ?>

		<div class="login-form-main">

			<?php
				echo Form::open(['method' => 'post', 'id' => 'login_form']);
			?>

			<div class="line"></div>

			<div class="form-row">
				<input type="text" name="email" placeholder="อีเมล" autocomplete="off">
			</div>

			<div class="form-row">
				<input type="password" name="password" placeholder="รหัสผ่าน">
			</div>

			<div class="form-row">
				<?php
					echo Form::checkbox('remember', 1);
					echo Form::label('remember', 'จดจำไว้ในระบบ');
				?>
			</div>

			<div>
				<?php
					echo Form::submit('เข้าสู่ระบบ', array(
						'class' => 'button wide-btn'
					));
				?>
			</div>

			<div class="line space-top-bottom-10"></div>

			<a href="#" class="fb-button">
				<img src="/images/common/fb-logo.png">
				เข้าสู่ระบบด้วย Facebook
			</a>

			<h4 class="text-center">ไม่ใช่สมาชิก <a href="{{URL::to('register')}}">สมัครสมาชิก</a></h4>

			<?php
				echo Form::close();
			?>
		</div>
	</div>
</div>

	<script type="text/javascript">

    class LoginPage {
      constructor() {}

      init() {

        let w = window.innerWidth;

        if(w > 1200) {

        	$('body').addClass('login-bg');

        	// $('.login-form').removeClass('mobile');

        	// let loginFormWidth = $('.login-form').width();
        	// let loginFormHeight = $('.login-form').height();

        	// $('.login-form').css({
        	// 	'margin-top':-(loginFormHeight/2),
        	// 	'margin-left':-(loginFormWidth/2)
        	// });

        }else{

        	$('.login-form').addClass('mobile');

        	$('.login-form').css({
        		'height':window.innerHeight,
        	});


        }

      }

    }

    $(document).ready(function(){
      loginPage = new LoginPage();
      loginPage.init();
    });
  </script>
@stop