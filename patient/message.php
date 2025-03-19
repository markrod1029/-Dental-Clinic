
<?php include('include/session.php');?>

<?php 
  include '../timezone.php'; 
  $today = date('Y-m-d');
  $year = date('Y');
  if(isset($_GET['year'])){
    $year = $_GET['year'];
  }
?>


                <?php include('include/header.php');?>
                <?php include('include/sidebar.php');?>
                <?php include('include/menubar.php'); ?>

          
  <div class="content-wrapper wrapper">



  <section class="users">
      <header>
        <div class="content">
          
          <img src="../images/<?php echo $user['patient_photo']; ?>" alt="">
          <div class="details">
              <span><?php echo $user['patient_first_name'].' '. $user['patient_last_name'];?></span>
            <p><?php echo $user['chat_status']; ?></p>
          </div>
        </div>
      </header>
      <div class="search">
        <span class="text">Select an Doctor to start chat</span>
        <input type="text" placeholder="Enter name to search...">
        <button><i class="fas fa-search"></i></button>
      </div>
      <div class="users-list">
  
      </div>
    </section>
  </div>

  <script src="javascript/users.js"></script>

<?php include 'include/footer.php'; ?>


</body>
</html>
