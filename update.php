<?php
    require 'database.php';
 
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: index.php");
    }
     
    if ( !empty($_POST)) {
        // keep track validation errors
        $titelError = null;
        $inhaltError = null;
        $proError = null;
        $contraError = null;
         
        // keep track post values
        $titel = $_POST['titel'];
        $inhalt = $_POST['inhalt'];
        $pro = $_POST['pro'];
        $contra = $_POST['contra'];
         
        // validate input
        $valid = true;
        if (empty($titel)) {
            $titelError = 'Please enter Titel';
            $valid = false;
        }
         
        if (empty($inhalt)) {
            $inhaltError = 'Please enter Inhalt';
            $valid = false;
        }
        
        if (empty($pro)) {
            $proError = 'Please enter Pro-Inhalt';
            $valid = false;
        }
        
        if (empty($contra)) {
            $contraError = 'Please enter Contra-Inhalt';
            $valid = false;
        }
        
         
        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE fragen SET titel = ?, inhalt = ?, pro = ?, contra = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($titel,$inhalt,$pro,$contra,$id));
            Database::disconnect();
            header("Location: index.php");
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM fragen where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $titel = $data['titel'];
        $inhalt = $data['inhalt'];
        $pro = $data['pro'];
        $contra = $data['contra'];
        Database::disconnect();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Update a Question</h3>
                    </div>
             
                    <form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
                      <div class="control-group <?php echo !empty($titelError)?'error':'';?>">
                        <label class="control-label">Titel</label>
                        <div class="controls">
                            <input name="titel" type="text"  placeholder="Titel" value="<?php echo !empty($titel)?$titel:'';?>">
                            <?php if (!empty($titelError)): ?>
                                <span class="help-inline"><?php echo $titelError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($inhaltError)?'error':'';?>">
                        <label class="control-label">Inhalt</label>
                        <div class="controls">
                            <input name="inhalt" type="text"  placeholder="Inhalt" value="<?php echo !empty($inhalt)?$inhalt:'';?>">
                            <?php if (!empty($inhaltError)): ?>
                                <span class="help-inline"><?php echo $inhaltError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($proError)?'error':'';?>">
                        <label class="control-label">Pro</label>
                        <div class="controls">
                            <input name="pro" type="text"  placeholder="Pro" value="<?php echo !empty($pro)?$pro:'';?>">
                            <?php if (!empty($proError)): ?>
                                <span class="help-inline"><?php echo $proError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($contraError)?'error':'';?>">
                        <label class="control-label">Contra</label>
                        <div class="controls">
                            <input name="contra" type="text"  placeholder="Contra" value="<?php echo !empty($contra)?$contra:'';?>">
                            <?php if (!empty($contraError)): ?>
                                <span class="help-inline"><?php echo $contraError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn" href="index.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>