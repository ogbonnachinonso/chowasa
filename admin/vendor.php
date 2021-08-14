
<?php
$title = " Dashboard";
  require_once "../partials/header.php";
  if(isset($_GET['type']) && $_GET['type']!=''){
  
    if($type=='delete'){
      $id = get_safe_value($link, $_GET['id']);
      $delete_sql = "DELETE FROM vendors  where id='$id' ";
      
      mysqli_query($link, $delete_sql );
    }
  }
  
  
   $query = "SELECT * FROM `vendors` WHERE 1  ";
     $res = mysqli_query($link, $query);
  
 
  ?>
<div class="main-content">
   <h1 class="text-center pt-5">Dashboard</h1>

<div class="container">
<div class="manage_product">
  <a href="add_product.php" class="btn btn-add" >Add Product</a>     
</div>

<?php
     if(isset($_SESSION['add'])){
       echo $_SESSION['add'];
       unset($_SESSION['add']);
    }
     if(isset($_SESSION['delete'])){
       echo $_SESSION['delete'];
       unset($_SESSION['delete']);
    }

    if(isset($_SESSION['update'])){
      echo $_SESSION['update'];
       unset($_SESSION['update']);
    }
    ?>
  <div class="row">
    <div class="col-12 col-m-12 col-sm-12">
      <div class="car">
        <div class="car-header  ">
          <h3 class="text-center">
            Vendor Dashboard
          </h3>
          <a href="add_product.php" ><i class="fas fa-ellipsis-"></i></a>
          
        </div>
    
        <div class="card-content table-responsive">
        <table class="table">
        <thead class="table-darke">
              <tr>
              <th>ID</th>
			       <th>USERNAME</th>
             <th>EMAIL</th>
             
                <th><a href="add_product.php"
                      class="btn btn-add mt-0">Add_product</a>
                    </th>
                    <th><button type="button" class="btn btn-outline-white btn-rounded btn-sm px-2"><a href=""
                      class="fas fa-pencil-alt mt-0"></a>
                    <i></i> </button></th>
              </tr>
            </thead>
            <tbody>
            <?php
            $i=1;
             while ($row = mysqli_fetch_assoc($res)){ ?> 
             
           <?php if( $_SESSION["id"] ==$row['id']){ 
            ?>
           
            <tr>
           
           
            <td><?php echo $row['id']; ?> </td>
            <td><?php echo $row['username']; ?> </td>
            <td><?php echo $row['email']; ?> </td>
            
          <td>
                  <i class='btn-success'></i>
                  <a href="update_vendor.php?id=<?php echo $row['id'] ?>" class="btn btn-primary">Edit</a>
                  </td>
                  <td>
                  <a href="?type=delete&id=<?php echo $row['id'] ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            
            <?php }
      
            
      ?>


 <?php   }; ?>
            </tbody>
          </table>

        </div>
      </div>
    </div>

  </div>
</div>
</div>
<?php
 require_once "../partials/footer.php";
  ?>