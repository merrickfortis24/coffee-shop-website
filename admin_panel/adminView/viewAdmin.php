<div>
  <h2>All Admins</h2>
  <table class="table">
    <thead>
      <tr>
        <th class="text-center">S.N.</th>
        <th class="text-center">Name</th>
        <th class="text-center">Email</th>
        <th class="text-center">Role</th>
        <th class="text-center">Status</th>
        <th class="text-center">Created At</th>
        <th class="text-center" colspan="2">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
        include_once "../config/dbconnect.php";
        $sql = "SELECT * FROM admin";
        $result = $conn->query($sql);
        $count = 1;
        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
      ?>
      <tr>
        <td class="text-center"><?= $count ?></td>
        <td class="text-center"><?= htmlspecialchars($row["Admin_Name"]) ?></td>
        <td class="text-center"><?= htmlspecialchars($row["Admin_email"]) ?></td>
        <td class="text-center"><?= htmlspecialchars($row["Admin_role"]) ?></td>
        <td class="text-center"><?= htmlspecialchars($row["Status"]) ?></td>
        <td class="text-center"><?= htmlspecialchars($row["Created_at"]) ?></td>
        <td>
          <button class="btn btn-primary" style="height:40px" onclick="editAdmin('<?= $row['Admin_ID'] ?>')">Edit</button>
        </td>
        <td>
          <button class="btn btn-danger" style="height:40px" onclick="adminDelete('<?= $row['Admin_ID'] ?>')">Delete</button>
        </td>
      </tr>
      <?php
              $count++;
          }
        } else {
          echo '<tr><td colspan="8" class="text-center">No admins found.</td></tr>';
        }
      ?>
    </tbody>
  </table>

  <!-- Add Admin Button -->
  <button type="button" class="btn btn-secondary" style="height:40px" data-toggle="modal" data-target="#addAdminModal">
    Add Admin
  </button>

  <!-- Add Admin Modal -->
  <div class="modal fade" id="addAdminModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Register New Admin</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="post" id="addAdminForm" autocomplete="off">
            <div class="form-group">
              <label for="admin_name">Name</label>
              <input type="text" name="admin_name" id="admin_name" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="admin_email">Email</label>
              <input type="email" name="admin_email" id="admin_email" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="admin_password">Password</label>
              <input type="password" name="admin_password" id="admin_password" class="form-control" required minlength="6">
            </div>
            <div class="form-group">
              <label for="admin_role">Role</label>
              <select name="admin_role" id="admin_role" class="form-control" required>
                <option value="">Select Role</option>
                <option value="Super Admin">Super Admin</option>
                <option value="Manager">Manager</option>
                <option value="Staff">Staff</option>
              </select>
            </div>
            <div class="form-group">
              <label for="admin_status">Status</label>
              <select name="admin_status" id="admin_status" class="form-control" required>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>
            <div class="form-group">
              <button type="button" class="btn btn-primary" onclick="addAdmin()">Register Admin</button>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
