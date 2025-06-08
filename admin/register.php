<?php
session_start();

include('includes/header.php');
include('includes/navbar.php');
?>


<?php
$connection = mysqli_connect("localhost", "root", "", "coffee_shop");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$sweetAlertConfig = "";

if (isset($_POST['add_admin_btn'])) {
    $Admin_Name = $_POST['Admin_Name'];
    $Admin_email = $_POST['Admin_email'];
    $Admin_password = $_POST['Admin_password'];
    $confirm_password = $_POST['confirm_password'];
    $Admin_role = $_POST['Admin_role'];
    $Status = $_POST['Status'];
    $Created_at = date('Y-m-d H:i:s');
    $Updated_at = date('Y-m-d H:i:s');

    if ($Admin_password === $confirm_password) {
        $hashed_password = password_hash($Admin_password, PASSWORD_DEFAULT);

        $query = "INSERT INTO admin (Admin_Name, Admin_password, Admin_email, Admin_role, Status, Created_at, Updated_at) 
                  VALUES ('$Admin_Name', '$hashed_password', '$Admin_email', '$Admin_role', '$Status', '$Created_at', '$Updated_at')";
        if (mysqli_query($connection, $query)) {
            $sweetAlertConfig = "
            <script>
            Swal.fire({
                icon: 'success',
                title: 'Admin added successfully!',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                window.location.href = 'register.php';
            });
            </script>
            ";
        } else {
            $sweetAlertConfig = "
            <script>
            Swal.fire({
                icon: 'error',
                title: 'Database error',
                text: 'Error: " . addslashes(mysqli_error($connection)) . "'
            });
            </script>
            ";
        }
    } else {
        $sweetAlertConfig = "
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Passwords do not match!',
            showConfirmButton: false,
            timer: 2000
        });
        </script>
        ";
    }
}
?>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
    ?>
    <script>
        Swal.fire({
            icon: '<?php echo $_SESSION['status_code']; ?>',
            title: '<?php echo $_SESSION['status']; ?>',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
    <?php
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);
}
?>

<style>
  .modal-body {
    max-height: 60vh;
    overflow-y: auto;
  }
</style>

<div class="container-fluid">
  <!-- Add Admin Modal -->
  <div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document"> 
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add Admin Data</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST">
          <div class="modal-body">
            <div class="mb-3">
              <label for="Admin_Name" class="form-label">Username</label>
              <input type="text" class="form-control" id="Admin_Name" name="Admin_Name" required>
            </div>
            <div class="mb-3">
              <label for="Admin_email" class="form-label">Email</label>
              <input type="email" class="form-control" id="Admin_email" name="Admin_email" required>
              <div id="email-warning" class="text-danger small mt-1"></div>
            </div>
            <div class="mb-3">
              <label for="Admin_password" class="form-label">Password</label>
              <input type="password" class="form-control" id="Admin_password" name="Admin_password" required>
            </div>
            <div class="mb-3">
              <label for="confirm_password" class="form-label">Confirm Password</label>
              <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="mb-3">
              <label for="Admin_role" class="form-label">Role</label>
              <select class="form-control" id="Admin_role" name="Admin_role" required>
                <option value="Super Admin">Super Admin</option>
                <option value="Manager">Manager</option>
                <option value="Staff">Staff</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="Status" class="form-label">Status</label>
              <select class="form-control" id="Status" name="Status" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="add_admin_btn" class="btn btn-primary">Add Admin</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit Admin Modal -->
  <div class="modal fade" id="editadminprofile" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="code.php" method="POST">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Admin Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="edit_admin_id" id="edit_admin_id">
            <div class="mb-3">
              <label for="edit_Admin_Name" class="form-label">Username</label>
              <input type="text" class="form-control" id="edit_Admin_Name" name="edit_Admin_Name" required>
            </div>
            <div class="mb-3">
              <label for="edit_Admin_email" class="form-label">Email</label>
              <input type="email" class="form-control" id="edit_Admin_email" name="edit_Admin_email" required>
            </div>
            <div class="mb-3">
              <label for="edit_Admin_password" class="form-label">New Password</label>
              <input type="password" class="form-control" id="edit_Admin_password" name="edit_Admin_password">
            </div>
            <div class="mb-3">
              <label for="edit_confirm_password" class="form-label">Confirm New Password</label>
              <input type="password" class="form-control" id="edit_confirm_password" name="edit_confirm_password">
            </div>
            <div class="mb-3">
              <label for="edit_Admin_role" class="form-label">Role</label>
              <select class="form-control" id="edit_Admin_role" name="edit_Admin_role" required>
                <option value="Super Admin">Super Admin</option>
                <option value="Manager">Manager</option>
                <option value="Staff">Staff</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="edit_Status" class="form-label">Status</label>
              <select class="form-control" id="edit_Status" name="edit_Status" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="update_admin_btn" class="btn btn-primary">Update Admin</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Admin Table Card -->
  <div class="card shadow mb-4 mt-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">
        Admin Profile
      </h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>ID</th>
              <th>Username</th>
              <th>Email</th>
              <th>Role</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Use the same database as above!
            $connection = mysqli_connect("localhost", "root", "", "coffee_shop");
            $query = "SELECT * FROM admin";
            $query_run = mysqli_query($connection, $query);

            if (mysqli_num_rows($query_run) > 0) {
              foreach ($query_run as $admin) {
                ?>
                <tr>
                  <td><?= $admin['Admin_ID']; ?></td>
                  <td><?= $admin['Admin_Name']; ?></td>
                  <td><?= $admin['Admin_email']; ?></td>
                  <td><?= $admin['Admin_role']; ?></td>
                  <td><?= $admin['Status']; ?></td>
                  <td>
                    <button type="button"
                            class="btn btn-success btn-sm editBtn"
                            data-id="<?= $admin['Admin_ID']; ?>"
                            data-name="<?= htmlspecialchars($admin['Admin_Name']); ?>"
                            data-email="<?= htmlspecialchars($admin['Admin_email']); ?>"
                            data-role="<?= $admin['Admin_role']; ?>"
                            data-status="<?= $admin['Status']; ?>">
                      Edit
                    </button>
                    <form action="code.php" method="POST" class="d-inline deleteForm">
                      <input type="hidden" name="delete_admin_btn" value="<?= $admin['Admin_ID']; ?>">
                      <button type="button" class="btn btn-danger btn-sm deleteBtn">Delete</button>
                    </form>
                  </td>
                </tr>
                <?php
              }
            } else {
              echo "<tr><td colspan='6'>No Record Found</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
      <!-- Add Admin Button below the table, left-aligned -->
      <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addadminprofile">
        Add Admin
      </button>
    </div>
  </div>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>

<?php
// Only echo the $sweetAlertConfig for alerts
echo $sweetAlertConfig;
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('Admin_email');
    const warningDiv = document.getElementById('email-warning');
    const submitBtn = document.querySelector('button[name="add_admin_btn"]');

    emailInput.addEventListener('input', function() {
        const email = emailInput.value.trim();
        if (email.length > 0) {
            fetch('ajax/check_email.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'email=' + encodeURIComponent(email)
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    warningDiv.textContent = 'Email is already used!';
                    submitBtn.disabled = true;
                } else {
                    warningDiv.textContent = '';
                    submitBtn.disabled = false;
                }
            });
        } else {
            warningDiv.textContent = '';
            submitBtn.disabled = false;
        }
    });
});

document.querySelectorAll('.editBtn').forEach(function(button) {
  button.addEventListener('click', function() {
    document.getElementById('edit_admin_id').value = this.dataset.id;
    document.getElementById('edit_Admin_Name').value = this.dataset.name;
    document.getElementById('edit_Admin_email').value = this.dataset.email;
    document.getElementById('edit_Admin_role').value = this.dataset.role;
    document.getElementById('edit_Status').value = this.dataset.status;
    var editModal = new bootstrap.Modal(document.getElementById('editadminprofile'));
    editModal.show();
  });
});

document.querySelectorAll('.deleteBtn').forEach(function(btn) {
  btn.addEventListener('click', function(e) {
    e.preventDefault();
    const form = this.closest('form');
    Swal.fire({
      title: 'Are you sure?',
      text: "This action cannot be undone!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      }
    });
  });
});
</script>