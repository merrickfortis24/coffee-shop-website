<?php
// filepath: c:\xampp\htdocs\NaiTsa\admin_panel\adminView\editAdminForm.php
include_once "../config/dbconnect.php";
$admin_id = $_POST['record'];
$sql = "SELECT * FROM admin WHERE Admin_ID='$admin_id'";
$result = $conn->query($sql);
if ($row = $result->fetch_assoc()) {
?>
<div class="modal fade" id="editAdminModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Admin</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="editAdminForm">
          <input type="hidden" id="edit_admin_id" value="<?= $row['Admin_ID'] ?>">
          <div class="form-group">
            <label>Name</label>
            <input type="text" id="edit_admin_name" class="form-control" value="<?= htmlspecialchars($row['Admin_Name']) ?>" required>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" id="edit_admin_email" class="form-control" value="<?= htmlspecialchars($row['Admin_email']) ?>" required>
          </div>
          <div class="form-group">
            <label>Role</label>
            <select id="edit_admin_role" class="form-control" required>
              <option value="Super Admin" <?= $row['Admin_role']=='Super Admin'?'selected':'' ?>>Super Admin</option>
              <option value="Manager" <?= $row['Admin_role']=='Manager'?'selected':'' ?>>Manager</option>
              <option value="Staff" <?= $row['Admin_role']=='Staff'?'selected':'' ?>>Staff</option>
            </select>
          </div>
          <div class="form-group">
            <label>Status</label>
            <select id="edit_admin_status" class="form-control" required>
              <option value="Active" <?= $row['Status']=='Active'?'selected':'' ?>>Active</option>
              <option value="Inactive" <?= $row['Status']=='Inactive'?'selected':'' ?>>Inactive</option>
            </select>
          </div>
          <div class="form-group">
            <button type="button" class="btn btn-primary" onclick="updateAdmin()">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
$('#editAdminModal').modal('show');
</script>
<?php } ?>