<div >
  <h2>All Customers</h2>
  <table class="table ">
    <thead>
      <tr>
        <th class="text-center">S.N.</th>
        <th class="text-center">Name</th>
        <th class="text-center">Username</th>
        <th class="text-center">Email</th>
        <th class="text-center">Joining Date</th>
      </tr>
    </thead>
    <?php
      include_once "../config/dbconnect.php";
      $sql = "SELECT * FROM users";
      $result = $conn->query($sql);
      $count = 1;
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
    ?>
    <tr>
      <td><?= $count ?></td>
      <td><?= htmlspecialchars($row["name"]) ?></td>
      <td><?= htmlspecialchars($row["username"]) ?></td>
      <td><?= htmlspecialchars($row["email"]) ?></td>
      <td><?= htmlspecialchars($row["create_datetime"]) ?></td>
    </tr>
    <?php
            $count = $count + 1;
        }
      }
    ?>
  </table>