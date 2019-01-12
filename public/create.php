<!DOCTYPE HTML>
<html>
<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
      
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
          
</head>
<body>
  
    <!-- container -->
    <div class="container">
   
        <div class="page-header">
            <h1>Create Espedisi</h1>
        </div>
      
    <?php
if($_POST){
 
    // include database connection
    include 'includes/connect_database.php';
 
    try{
     
        // insert query
        $query = "INSERT INTO tbl_ongkir SET Id=:id, provinsi=:provinsi, berat=:berat, harga=:harga";
 
        // prepare query for execution
        $stmt = $connect->prepare($query);
 
        // posted values
        $Id=htmlspecialchars(strip_tags($_POST['Id']));
        $provinsi=htmlspecialchars(strip_tags($_POST['provinsi']));
        $berat=htmlspecialchars(strip_tags($_POST['berat']));
        $harga=htmlspecialchars(strip_tags($_POST['harga']));
 
        // bind the parameters
        $stmt->bind_result(':Id', $Id);
        $stmt->bind_result(':provinsi', $provinsi);
        $stmt->bind_result(':berat', $berat);
        $stmt->bind_result(':harga', $harga);

         
        // specify when this record was inserted to the database
        
         
        // Execute the query
        if($stmt->execute()){
            echo "<div class='alert alert-success'>Record was saved.</div>";
        }else{
            echo "<div class='alert alert-danger'>Unable to save record.</div>";
        }
         
    }
     
    // show error
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}
?>
 
<!-- html form here where the product information will be entered -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Id</td>
            <td><input type='text' name='Id' class='form-control' /></td>
        </tr>
        <tr>
            <td>Provinsi</td>
            <td><textarea name='provinsi' class='form-control'></textarea></td>
        </tr>
        <tr>
            <td>Berat</td>
            <td><input type='text' name='berat' class='form-control' /></td>
        </tr>
        <tr>
            <td>Harga</td>
            <td><input type='text' name='harga' class='form-control' /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type='submit' value='Save' class='btn btn-primary' />
            </td>
        </tr>
    </table>
</form>
          
    </div> <!-- end .container -->
      
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
   
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
</body>
</html>