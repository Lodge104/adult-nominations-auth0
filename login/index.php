<?php
$userrole = 'loginpage';
$title = 'Login';
include 'misc/pagehead.php';
?>
<body>	
  <?php require 'misc/pullnav.php'; ?>
	<div class="container logindiv wrapper">
		    <div class="card col-sm">		
              <div class="card-body">
		<div class="col-sm-4"></div>
        <div class="col-sm-4">
            <form class="text-center" name="loginform" method="post" action="ajax/checklogin.php">
                <h3 class="form-signin-heading"><?php echo $title;?></h3>
                <br>
				<div class="alert alert-danger" role="alert">
                <h5 class="alert-heading">Lodge Adminstrators Only</h5>
                This login is for administrators only. Chapters can access nomination data at lodge104.net/adult-nominations
              </div>
				<br>
                <div class="form-group">
                    <input name="myusername" id="myusername" type="text" class="form-control input-lg" placeholder="Email" autofocus>
                    <input name="mypassword" id="mypassword" type="password" class="form-control input-lg" placeholder="Password"> </div>
                <div class="form-group">
                    <button name="Submit" id="submit" class="btn btn-lg btn-primary btn-block" type="submit">Log In</button>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <input id="remember"  type="checkbox"> Remember Me</input>
                    </div>
                </div>
            </form>
            <div id="message"></div>
            <p class="text-center"><a href="forgotpassword.php">Forgot Password?</a></p>
        </div>
        <div class="col-sm-4"></div>
    </div>
	</div>
	</div>
    <!-- The AJAX login script -->
    <script src="js/login.js"></script>

<?php include "../footer.php"; ?>
</body>
</html>
