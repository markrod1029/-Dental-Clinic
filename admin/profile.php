<?php include('include/session.php'); ?>

<?php
include '../timezone.php';
$today = date('Y-m-d');
$year = date('Y');
if (isset($_GET['year'])) {
    $year = $_GET['year'];
}
?>

<?php include('include/header.php'); ?>
<?php include('include/sidebar.php'); ?>
<?php include('include/menubar.php'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1 class="h3 mb-4 text-gray">Admin Management</h1>
    </section>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="h3 m-0 font-weight-bold text-success">Admin Update</h6>
        </div>

        <div class="card-body">
            <form class="form-horizontal box-show" method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Profile Image</label>
                    <div class="mb-3">
                        <img src="<?php echo (!empty($user['photo']) && file_exists('../images/' . $user['photo'])) ? '../images/' . $user['photo'] : '../images/profile.jpg'; ?>" 
                             class="img-circle elevation-2" style="height: 80px; width: 80px; margin-bottom: 10px;">
                    </div>
                    <input type="file" name="admin_image" class="form-control" accept="image/*">
                </div>

                <div class="form-group">
                    <label>Admin Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="admin_email" class="form-control" required value="<?php echo $user['email']; ?>" />
                </div>

                <div class="form-group">
                    <label>New Password (leave blank if not changing)</label>
                    <input type="password" name="admin_password" class="form-control" placeholder="Enter new password if changing" />
                </div>

                <div class="form-group">
                    <label>Admin Name <span class="text-danger">*</span></label>
                    <input type="text" name="admin_name" class="form-control" required value="<?php echo $user['admin_name']; ?>" />
                </div>

                <div class="form-group">
                    <label>Admin Phone No. <span class="text-danger">*</span></label>
                    <input type="text" name="admin_phone" class="form-control" required value="<?php echo $user['phone']; ?>" />
                </div>

                <div class="form-group">
                    <label>Admin Complete Address<span class="text-danger">*</span></label>
                    <textarea name="admin_address" id="admin_address" class="form-control" required><?php echo $user['address'] ?></textarea>
                </div>

                <div class="modal-footer">
                    <input type="submit" name="submit" class="btn btn-success" value="Update" />
                    <button type="reset" class="btn btn-default">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('include/footer.php'); ?>

<?php
if (isset($_POST['submit'])) {
    $admin_email = $_POST['admin_email'];
    $admin_name = $_POST['admin_name'];
    $admin_address = $_POST['admin_address'];
    $admin_phone = $_POST['admin_phone'];
    $admin_id = $user['id'];

    // Kunin ang kasalukuyang password at profile image
    $sql = "SELECT password, photo FROM admin_table WHERE id = '$admin_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $current_password = $row['password'];
    $current_image = $row['photo'];

    // Check kung may bagong password
    if (!empty($_POST['admin_password'])) {
        $new_password = password_hash($_POST['admin_password'], PASSWORD_BCRYPT);
    } else {
        $new_password = $current_password;
    }

    // File Upload Handling
    if (!empty($_FILES['admin_image']['name'])) {
        $target_dir = "../images/";
        $image_file = basename($_FILES["admin_image"]["name"]);
        $image_file_type = strtolower(pathinfo($image_file, PATHINFO_EXTENSION));
        $valid_extensions = array("jpg", "jpeg", "png");
        
        if (in_array($image_file_type, $valid_extensions)) {
            $new_image_name = "admin_" . time() . "." . $image_file_type;
            $target_file = $target_dir . $new_image_name;

            if (move_uploaded_file($_FILES["admin_image"]["tmp_name"], $target_file)) {
                // Burahin ang lumang image kung mayroon
                if (!empty($current_image) && file_exists($target_dir . $current_image)) {
                    unlink($target_dir . $current_image);
                }
            }
        } else {
            $_SESSION['error'] = "Invalid file type. Only JPG, JPEG, and PNG are allowed.";
            header("Location: profile.php");
            exit();
        }
    } else {
        $new_image_name = $current_image;
    }

    // Update Admin Info
    $sql = "UPDATE admin_table SET 
                email = '$admin_email',
                password = '$new_password',
                admin_name = '$admin_name',
                address = '$admin_address',
                phone = '$admin_phone',
                photo = '$new_image_name'
            WHERE id = '$admin_id'";

    if ($conn->query($sql)) {
        $_SESSION['success'] = 'Admin updated successfully';
        echo '<script>window.location.href = "profile.php";</script>';
    } else {
        $_SESSION['error'] = $conn->error;
    }
}
?>
