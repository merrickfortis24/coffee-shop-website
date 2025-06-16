<?php
include("auth_session.php");
require_once("db.php"); // this sets $con

// Fetch current user info
$username = $_SESSION['username'];
$query = $con->prepare("SELECT user_id, name, username FROM users WHERE username = ?");
$query->bind_param("s", $username);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = $_POST['name'];
    $new_username = $_POST['username'];
    $update = $con->prepare("UPDATE users SET name=?, username=? WHERE user_id=?");
    $update->bind_param("ssi", $new_name, $new_username, $user['user_id']);
    $update->execute();
    $_SESSION['username'] = $new_username;
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Bootstrap Modal -->
    <div class="modal fade show" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-modal="true" style="display:block; background:rgba(0,0,0,0.5);">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <form method="post">
            <div class="modal-header">
              <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                  <label class="form-label">Full Name</label>
                  <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
              </div>
              <div class="mb-3">
                  <label class="form-label">Username</label>
                  <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
              </div>
            </div>
            <div class="modal-footer">
              <a href="index.php" class="btn btn-secondary">Cancel</a>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Optional: Prevent background scroll when modal is open -->
    <script>
      document.body.classList.add('modal-open');
    </script>
    <style>
      body.modal-open {
        overflow: hidden;
      }
    </style>
</body>
</html>