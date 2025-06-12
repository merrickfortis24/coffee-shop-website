<div id="ordersBtn" >
  <h2>Order Details</h2>
  <table class="table table-striped">
    <thead>
    <tr>
        <th>O.N.</th>
        <th>Customer</th>
        <th>OrderDate</th>
        <th>Payment Method</th>
        <th>Order Status</th>
        <th>Payment Status</th>
        <th>More Details</th>
    </tr>
</thead>
     <?php
      include_once "../config/dbconnect.php";
      $sql = "SELECT o.*, u.name AS user_name 
        FROM orders o 
        LEFT JOIN users u ON o.user_id = u.user_id";
      $result=$conn-> query($sql);
      
      if ($result-> num_rows > 0){
        while ($row=$result-> fetch_assoc()) {
    ?>
       <tr>
          <td><?= $row["orders_id"] ?></td>
          <td><?= $row["user_name"] ?? '-' ?></td>
          <td><?= $row["date"] ?></td>
          <td><?= $row["pay_method"] ?? '-' ?></td>
          <td>
            <?php if($row["order_status"]==0): ?>
              <button class="btn btn-danger" onclick="ChangeOrderStatus('<?= $row['orders_id'] ?>')">Pending</button>
            <?php else: ?>
              <button class="btn btn-success" onclick="ChangeOrderStatus('<?= $row['orders_id'] ?>')">Delivered</button>
            <?php endif; ?>
          </td>
          <td>
            <?php if($row["pay_status"]==0): ?>
              <button class="btn btn-danger" onclick="ChangePay('<?= $row['orders_id'] ?>')">Unpaid</button>
            <?php else: ?>
              <button class="btn btn-success" onclick="ChangePay('<?= $row['orders_id'] ?>')">Paid</button>
            <?php endif; ?>
          </td>
              
        <td><a class="btn btn-primary openPopup" data-href="./adminView/viewEachOrder.php?orderID=<?= $row['orders_id'] ?>" href="javascript:void(0);">View</a></td>
        </tr>
    <?php
            
        }
      }
    ?>
     
  </table>
   
</div>
<!-- Modal -->
<div class="modal fade" id="viewModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          
          <h4 class="modal-title">Order Details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="order-view-modal modal-body">
        
        </div>
      </div><!--/ Modal content-->
    </div><!-- /Modal dialog-->
  </div>
<script>
     //for view order modal  
    $(document).ready(function(){
      $('.openPopup').on('click',function(){
        var dataURL = $(this).attr('data-href');
    
        $('.order-view-modal').load(dataURL,function(){
          $('#viewModal').modal({show:true});
        });
      });
    });
 </script>