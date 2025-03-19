<?php 
  session_start();
  if(isset($_SESSION['doctor'])){
    $_SESSION['id'];
    header("location: users.php");
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

      <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
      
        <div class="mt-12 flex flex-col items-center">
          <h1 class="text-2xl xl:text-3xl font-extrabold">
            Sign In 
          </h1>
          <form action="php/login.php" method="POST">
          <div class="w-full flex-1 mt-8">
       
            <div class="mx-auto max-w-xs">
              <input
                class="w-full px-8 py-4 rounded-lg "
                style="color:black; border:solid 1px black;"
                name="email" placeholder="input Username"

              />
              <input
                class="w-full px-8 py-4 rounded-lg mt-5"
                type="password"
                placeholder="Password"
                name="password"
                style="color:black; border:solid 1px black;"
              />
              <button
                class="mt-5 tracking-wide font-semibold bg-indigo-500 text-gray-100 w-full py-4 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none"
              
                name="login"
                  >

                <span class="ml-3">
                  Sign In
                </span>
              </button>
              <p class="mt-6 text-xs text-gray-600 text-center">
              Don't have an account? <a href="register.php" class="link-info">Register here</a>
              </p>
            </div>
            </form>
     
            <?php
  		if(isset($_SESSION['error'])){
  			echo "
  				<div class='callout callout-danger text-center '>
			  		<p>".$_SESSION['error']."</p> 
			  	</div>
  			";
  			unset($_SESSION['error']);
  		}
  	?>
          </div>
        </div>
      </div>
      <div class="flex-1 bg-indigo-100 text-center hidden lg:flex">
        <div
          class="m-12 xl:m-16 w-full bg-contain bg-center bg-no-repeat"
          style="background-image: url('https://storage.googleapis.com/devitary-image-host.appspot.com/15848031292911696601-undraw_designer_life_w96d.svg');"
        >
        <h1 class="h1 text-bold">Ekonsulta Mo:<br> Jesus Hand Healing Hospital</h1>
      
      </div>
      </div>
    </div>
    
  </body>
</html>
