
<div class="modal fade" id="editModal<?=$u[0]?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit this form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="ResponsiblesPage.php?id=<?=$u[0]?>&password=<?=$u[3]?>" method="POST">
      <div class="user-box">
        <input type="text" name="name" value="<?=$editName?>" required>
        <label>Name</label>
      </div>
      <div class="user-box">
        <input type="text" name="email" value="<?=$u[2]?>" required>
        <label>Email Address</Address></label>
      </div>
     
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="confirmBtn">Confirm</button>
        </form>
      </div>
    </div>
  </div>
</div>