
<?php include 'include/header.php'; ?>
<?php
  session_start();
  if(isset($_SESSION['admin'])){
    header('location:admin/home.php');
        $_SESSION['type'] = 'Admin';

  }
  if(isset($_SESSION['doctor'])){
    header('location:doctor/home.php');
	$_SESSION['admin_id'];
	$_SESSION['type'] = 'Doctor';
  }

    if(isset($_SESSION['patient'])){
		$_SESSION["patient_id"];
    header('location:patient/home.php');
  }


?>


      <head>
    <link
      href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap"
      rel="stylesheet"
    />
    <meta
      name="viewport"
      content="width=device-width,initial-scale=1,maximum-scale=1"
    />
    <style>
      body {
        font-family: "Inter", sans-serif;
      }
    </style>
    <script
      src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js"
      defer
    ></script>
  </head>

  <body class="min-h-screen bg-gray-100 text-gray-900 flex justify-center">

      <div class="lg:w-1/2  p-6 sm:p-12">
      <h1 class="text-2xl xl:text-3xl font-extrabold">
           Register 
          </h1><br>
        <div class="card">
				
                <div class="card-body" >

                    <form  method="POST" action="register_action.php" enctype="multipart/form-data" >

                        <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Patient Email Address<span class="text-danger">*</span></label>
                                <input type="text" name="patient_email_address" id="patient_email_address" class="form-control" required autofocus data-parsley-type="email" data-parsley-trigger="keyup" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Patient Password<span class="text-danger">*</span></label>
                                <input type="password" name="patient_password" id="patient_password" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Patient First Name<span class="text-danger">*</span></label>
                                <input type="text" name="patient_first_name" id="patient_first_name" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Patient Last Name<span class="text-danger">*</span></label>
                                <input type="text" name="patient_last_name" id="patient_last_name" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Patient Date of Birth<span class="text-danger">*</span></label>
                                <input type="date" name="patient_date_of_birth" id="patient_date_of_birth" class="form-control" required  data-parsley-trigger="keyup"  />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Patient Gender<span class="text-danger">*</span></label>
                                <select name="patient_gender" id="patient_gender" class="form-control">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Patient Contact No.<span class="text-danger">*</span></label>
                                <input type="text" name="patient_phone_no" id="patient_phone_no" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Patient Maritial Status<span class="text-danger">*</span></label>
                                <select name="patient_maritial_status" id="patient_maritial_status" class="form-control">
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Patient Complete Address<span class="text-danger">*</span></label>
                        <textarea name="patient_address" id="patient_address" class="form-control" required data-parsley-trigger="keyup"></textarea>
                    </div>

                    <div class="form-group">
                    <label>Patient Image <span class="text-danger">*</span></label>
                    <br />
                    <input type="file" name="patient_photo" id="doctor_profile_image" />
                    <div id="uploaded_image"></div>
                    </div>


                        
                    <button
                class="mt-5 tracking-wide font-semibold bg-indigo-500 text-gray-100 w-full py-4 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none"
              
                name="submit"
                  >

                <span class="ml-3">
                  Sign In
                </span>
              </button>
              <p class="mt-6 text-xs text-gray-600 text-center">
              DYou have Account? <a href="index.php" class="link-info">Login here</a>
              </p>
            </div>

                  


</form>


    </div>
        </div>
      </div>
      <div class="flex-1 bg-indigo-100 text-center hidden lg:flex" >
        <div
          class="m-12 xl:m-18 w-full bg-contain bg-center bg-no-repeat"
          style="background-image: url('https://storage.googleapis.com/devitary-image-host.appspot.com/15848031292911696601-undraw_designer_life_w96d.svg');"
        ></div>
      </div>
    </div>
    
  </body>
</html>
