<?php
$title = "Edit Unit Election | Chapter Election Portal | Occoneechee Lodge - Order of the Arrow, BSA";
$userrole = "Admin"; // Allow only logged in users
include "../login/misc/pagehead.php";

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include '../unitelections-info.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta http-equiv=X-UA-Compatible content="IE=Edge,chrome=1" />
    <meta name=viewport content="width=device-width,initial-scale=1.0,maximum-scale=1.0" />

    <title>Edit Unit Election | Occoneechee Lodge - Order of the Arrow, BSA</title>
	
	<link rel="stylesheet" href="../libraries/fontawesome-free-5.12.0/css/all.min.css">

</head>

<body id="dashboard">
	<?php require '../login/misc/pullnav.php'; ?>
  <div class="wrapper">

    <main class="container-fluid">

      <?php
      if (isset($_GET['accessKey'])) {
        if (preg_match("/^([a-z\d]){8}-([a-z\d]){4}-([a-z\d]){4}-([a-z\d]){4}-([a-z\d]){12}$/", $_GET['accessKey'])) {
          $accessKey = $_POST['accessKey'] = $_GET['accessKey'];
          ?>
          <section class="row">
              <div class="col-12">
                  <h2>Unit Election Administration</h2>
              </div>
          </section>
          <?php
          $getUnitElectionsQuery = $conn->prepare("SELECT * from unitElections where accessKey = ?");
          $getUnitElectionsQuery->bind_param("s", $accessKey);
          $getUnitElectionsQuery->execute();
          $getUnitElectionsQ = $getUnitElectionsQuery->get_result();
          if ($getUnitElectionsQ->num_rows > 0) {
            //print election info
            ?>
            <div class="card mb-3">
              <div class="card-body">
                <h3 class="card-title d-inline-flex">Edit Unit Election Information</h3>
                <?php $getUnitElections = $getUnitElectionsQ->fetch_assoc(); ?>
				  
				  <?php
								  if(isset($_POST['button1'])) { 
								  
                    require '../vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
                    include '../unitelections-info.php';
									  $mail = new PHPMailer;
									  $mail->IsSMTP();        //Sets Mailer to send message using SMTP
									  $mail->Host = $host;  //Sets the SMTP hosts
									  $mail->Port = $port;        //Sets the default SMTP server port
									  $mail->SMTPAuth = true;       //Sets SMTP authentication. Utilizes the Username and Password variables
									  $mail->Username = $musername;     //Sets SMTP username
									  $mail->Password = $mpassword;     //Sets SMTP password
									  $mail->SMTPSecure = 'tls';       //Sets connection prefix. Options are "", "ssl" or "tls"
									  $mail->From = $mfrom;     //Sets the From email address for the message
									  $mail->FromName = $mfromname;    //Sets the From name of the message
									  $mail->AddAddress($getUnitElections['sm_email']);//Adds a "To" address
									  $mail->WordWrap = 50;       //Sets word wrapping on the body of the message to a given number of characters
									  $mail->IsHTML(true);       //Sets message type to HTML    
									  $mail->Subject = 'Time to Submit Adult Nominations for the Order of the Arrow';    //Sets the Subject of the message
									  $mail->Body = '<table cellspacing="0" cellpadding="0" border="0" width="600px" style="margin:auto">
									  <tbody>
										<tr>
										  <td style="text-align:center;padding:10px 0 20px 0"><a href="%%7Brecipient.ticket_link%7D" target="_blank"> <img src="https://lodge104.net/wp-content/uploads/2018/09/Horizontal-Brand-Color.png" alt="Occonechee Lodge Support" width="419" height="69" data-image="xoo68adcoon5"></a></td>
										</tr>
										<tr>
										  <td><table cellspacing="0" cellpadding="0" border="0" width="100%">
											  <tbody>
												<tr>
												  <td style="text-align:center;color:#ffffff;background-color:#2d3e4f;padding:8px 0;font-size:13px"> Occoneechee Lodge Unit Elections </td>
												</tr>
												<tr>
												  <td style="text-align:left;border:1px solid #2d3e4f;padding:10px 30px;background-color:#fefefe;line-height:18px;color:#2d3e4f;font-size:13px"> 
													<table width="100%" cellpadding="0" cellspacing="0" border="0">
													  <tbody>
														<tr>
														  <td style="padding:15px 0; width:100%"><table width="100%" cellpadding="0" cellspacing="0" border="0" style="table-layout:fixed">
															  <tbody>
																<tr>
																  <td style="width:100%" valign="top">
																	<br>
																	Dear ' . $getUnitElections['sm_name'] . ',<br>
																	<br>
																	Thank you for recently completing a unit election. The results of your unit election have now been processed by Occoneechee Lodge and the new candidates can now register for their inductions. As part of the election process, your unit may now submit adult nominations for membership in the Order of the Arrow. Please click the link below to access the Unit Leader dashboard for your unit and begin working on your adult nominations.<br>
																	</td>
																</tr>
															  </tbody>
															  <tbody>
																<tr>
																  <td style="width:100%;text-align:center">
																  <a href="https://nominate.lodge104.net/unitleader/?accessKey=' . $getUnitElections['accessKey'] . '" target="_blank">
																  <p>https://nominate.lodge104.net/unitleader/?accessKey=' . $getUnitElections['accessKey'] . '</p>
																  </a>
																  </td>
																</tr>
															  </tbody>
															</table></td>
														</tr>
													  </tbody>
													</table></td>
												</tr>
											  </tbody>
											</table></td>
										</tr>
									  </tbody>
									</table>';   //An HTML or plain text message body
									  if($mail->Send())        //Send an Email. Return true on success or false on error

									echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
        <div class='alert alert-success' role='alert'>
            <strong>Sent!</strong> Your email has been sent! Thanks!
            <button type='button' class='close' data-dismiss='alert'><i class='fas fa-times'></i></button>
        </div>";}								  
								  ?> 
				  <form method="post"> 
					<input type="submit" name="button1" value="Email Unit Leader" class="btn btn-primary" role="button"/>
				  </form>
				  <br>
				   
                <form action="edit-election-process.php" method="post">
                  <input type="hidden" id="unitId" name="unitId" value="<?php echo $getUnitElections['id']; ?>">
                  <input type="hidden" id="accessKey" name="accessKey" value="<?php echo $getUnitElections['accessKey']; ?>">
                  <div class="form-row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="unitNumber" class="required">Unit Number</label>
                        <input id="unitNumber" name="unitNumber" type="number" class="form-control" value="<?php echo $getUnitElections['unitNumber']; ?>" required>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="unitCommunity" class="required">Unit Type</label>
                        <select id="unitCommunity" name="unitCommunity" class="custom-select" required>
							<option></option>
							<option value="Test Unit" <?php echo ($getUnitElections['unitCommunity'] == 'Test Unit' ? 'selected' : ''); ?> >Test Unit</option>
							<option value="Boy Troop" <?php echo ($getUnitElections['unitCommunity'] == 'Boy Troop' ? 'selected' : ''); ?> >Boy Troop</option>
							<option value="Girl Troop" <?php echo ($getUnitElections['unitCommunity'] == 'Girl Troop' ? 'selected' : ''); ?> >Girl Troop</option>
							<option value="Team" <?php echo ($getUnitElections['unitCommunity'] == 'Team' ? 'selected' : ''); ?> >Team</option>
							<option value="Crew" <?php echo ($getUnitElections['unitCommunity'] == 'Crew' ? 'selected' : ''); ?> >Crew</option>
							<option value="Ship" <?php echo ($getUnitElections['unitCommunity'] == 'Ship' ? 'selected' : ''); ?> >Ship</option>
						</select>
                      </div>
                    </div>
					  <div class="col-md-3">
                      <div class="form-group">
                        <label for="exported" class="required">Imported into LodgeMaster?</label>
                        <select id="exported" name="exported" class="custom-select" disabled>
                          <option value="No" <?php echo ($getUnitElections['exported'] == 'No' ? 'selected' : ''); ?> >No</option>
                          <option value="Yes" <?php echo ($getUnitElections['exported'] == 'Yes' ? 'selected' : ''); ?> >Yes</option>
						  </select>
					  </div>
                    </div>
					  <div class="col-md-3">
                      <div class="form-group">
                        <label for="onlinevote" class="required">Unit Election Type</label>
                        <select id="onlinevote" name="onlinevote" class="custom-select" required>
                          <option value="Yes" <?php echo ($getUnitElections['onlinevote'] == 'Yes' ? 'selected' : ''); ?> >Voting Online</option>
						  <option value="No" <?php echo ($getUnitElections['onlinevote'] == 'No' ? 'selected' : ''); ?> >Voting In-Person</option>
						  </select>
					  </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="numRegisteredYouth"># of Registered Youth</label>
                        <input id="numRegisteredYouth" name="numRegisteredYouth" type="number" class="form-control" value="<?php echo $getUnitElections['numRegisteredYouth']; ?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="dateOfElection" class="required">Date of Unit Election</label>
                        <input id="dateOfElection" name="dateOfElection" type="date" class="form-control" value="<?php echo $getUnitElections['dateOfElection']; ?>" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="chapter" class="required">Chapter</label>
                        <select id="chapter" name="chapter" class="custom-select" required>
                          <option></option>
                          <option value="eluwak" <?php echo ($getUnitElections['chapter'] == 'Eluwak' ? 'selected' : ''); ?> >Eluwak</option>
                          <option value="ilaumachque" <?php echo ($getUnitElections['chapter'] == 'Ilau Machque' ? 'selected' : ''); ?> >Ilau Machque</option>
                          <option value="kiowa" <?php echo ($getUnitElections['chapter'] == 'Kiowa' ? 'selected' : ''); ?> >Kiowa</option>
                          <option value="lauchsoheen" <?php echo ($getUnitElections['chapter'] == 'Lauchsoheen' ? 'selected' : ''); ?> >Lauchsoheen</option>
                          <option value="mimahuk" <?php echo ($getUnitElections['chapter'] == 'Mimahuk' ? 'selected' : ''); ?> >Mimahuk</option>
						  <option value="netami" <?php echo ($getUnitElections['chapter'] == 'Netami' ? 'selected' : ''); ?> >Netami</option>
						  <option value="netopalis" <?php echo ($getUnitElections['chapter'] == 'Netopalis' ? 'selected' : ''); ?> >Netopalis</option>
						  <option value="neusiok" <?php echo ($getUnitElections['chapter'] == 'Neusiok' ? 'selected' : ''); ?> >Neusiok</option>
						  <option value="saponi" <?php echo ($getUnitElections['chapter'] == 'Saponi' ? 'selected' : ''); ?> >Saponi</option>
						  <option value="temakwe" <?php echo ($getUnitElections['chapter'] == 'Temakwe' ? 'selected' : ''); ?> >Temakwe</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <hr></hr>
                  <h4 class="card-title">Unit Leader Information</h4>
                  <div class="form-row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <input id="sm_name" name="sm_name" type="text" class="form-control" placeholder="Name" value="<?php echo $getUnitElections['sm_name']; ?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <input id="sm_address_line1" name="sm_address_line1" type="text" class="form-control" placeholder="Address" value="<?php echo $getUnitElections['sm_address_line1']; ?>">
                      </div>
                      <div class="form-group">
                        <input id="sm_address_line2" name="sm_address_line2" type="text" class="form-control" placeholder="Address Line 2 (optional)" value="<?php echo $getUnitElections['sm_address_line2']; ?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <input id="sm_city" name="sm_city" type="text" class="form-control" placeholder="City" value="<?php echo $getUnitElections['sm_city']; ?>">
                      </div>
                      <div class="form-row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <input id="sm_state" name="sm_state" type="text" class="form-control" placeholder="State" value="<?php echo $getUnitElections['sm_state']; ?>">
                          </div>
                        </div>
                        <div class="col-md-8">
                          <div class="form-group">
                            <input id="sm_zip" name="sm_zip" type="text" class="form-control" placeholder="Zip" value="<?php echo $getUnitElections['sm_zip']; ?>">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <input id="sm_email" name="sm_email" type="email" class="form-control" placeholder="Email" value="<?php echo $getUnitElections['sm_email']; ?>">
                      </div>
                      <div class="form-group">
                        <input id="sm_phone" name="sm_phone" type="text" class="form-control" placeholder="Phone" value="<?php echo $getUnitElections['sm_phone']; ?>" >
                      </div>
                    </div>
				  </div>
				  <?php if (($getUnitElections['onlinevote'] == 'Yes')) { ?>
				  <hr></hr>
				  <div class="form-row">
					 <div class="col-md-4">
                      <div class="form-group">
                        <label for="open" class="required">Voting Open?</label>
                        <select id="open" name="open" class="custom-select" required>
                          <option value="No" <?php echo ($getUnitElections['open'] == 'No' ? 'selected' : ''); ?> >No</option>
                          <option value="Yes" <?php echo ($getUnitElections['open'] == 'Yes' ? 'selected' : ''); ?> >Yes</option>
						  </select>
					  </div>
                    </div>
				  </div>
				  <?php } else { ?>
					<div></div>
					<?php } ?>
                  <a href="elections.php" class="btn btn-secondary">Cancel</a>
                  <input type="submit" class="btn btn-primary" value="Save">
                </form>
              </div>
            </div>
            <?php
          } else {
            ?>
            <div class="alert alert-danger" role="alert">
              There are no elections in the database.
            </div>
            <?php
          }
        } else {
          //accesskey bad
          ?>
          <div class="alert alert-danger" role="alert">
            <h5 class="alert-heading">Invalid Access Key</h5>
            You have an invalid access key. Please use the personalized link provided in your email, or enter your access key below.
          </div>
          <div class="card col-md-6 mx-auto">
            <div class="card-body">
              <h5 class="card-title">Access Key </h5>
              <form action='' method="get">
                <div class="form-group">
                  <label for="accessKey">Access Key</label>
                  <input type="text" id="accessKey" name="accessKey" class="form-control" >
                </div>
                <input type="submit" class="btn btn-primary" value="Submit">
              </form>
            </div>
          </div>
          <?php
        }
      } else {
        //no accessKey
        ?>
        <div class="card col-md-6 mx-auto">
          <div class="card-body">
            <h5 class="card-title">Access Key </h5>
            <form action='' method="get">
              <div class="form-group">
                <label for="accessKey">Access Key</label>
                <input type="text" id="accessKey" name="accessKey" class="form-control" >
              </div>
              <input type="submit" class="btn btn-primary" value="Submit">
            </form>
          </div>
        </div>
        <?php
      }
    ?>
    </main>
  </div>
    <?php include "../footer.php"; ?>

    <script src="../libraries/jquery-3.4.1.min.js"></script>
    <script src="../libraries/popper-1.16.0.min.js"></script>
    <script src="../libraries/bootstrap-4.4.1/js/bootstrap.min.js"></script>

</body>

</html>