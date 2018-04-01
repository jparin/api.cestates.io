<html>
	<head><title>Forgot Password Activation Link!</title></head>
	<body>
		<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;">Forgot Password Activation Link!</h2>
		You recently requested a new password.<br>
		Please click the button below to complete your new password request:<br />
		<br />
		<big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b><a href="<?php echo site_url('/auth/user/activate/'.$user_id.'/'.$password_key); ?>" style="color: #3366cc;">Forgot Password</a></b></big><br />
		<br />
		Link doesn't work? Copy the following link to your browser address bar:<br />
		<nobr><a href="<?php echo site_url('/auth/user/activate/'.$user_id.'/'.$password_key); ?>" style="color: #3366cc;"><?php echo site_url('/auth/user/activate/'.$user_id.'/'.$password_key); ?></a></nobr><br />
		<br />
		<br />
		Please note that this email has been sent to your account. <br/>
		If you did not request a new password, someone may have been trying to access your account without your permission. As long as you do not not click the link contained in the email, 
no action will be taken and your account will remain secure. Thank you.
		<br />
		<br />
		Best Regards,<br />
		Project Everest, AIM
	</body>
</html>