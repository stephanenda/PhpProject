<?php

require_once "./action.php";
$name = $email = $description = $note = "";
$ELEMENT_SAVED = false;

function test_input($data , $type = "text") {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return array($data , validateInput($data , $type));
  }


function validateInput($input , $type="text"){
   $inputErrors =  array();
  if( empty($input)) $inputErrors["empty"] = true;
  if($type == "email" && filter_var($input, FILTER_VALIDATE_EMAIL) ==  false)
          $inputErrors["badEmail"] = true ;

  return $inputErrors;
}


  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $nameResult = test_input($_POST["name"]);
      $emailResult = test_input($_POST["email"] , "email");
      $descriptionResult = test_input($_POST["description"]);
      $rateResult = test_input($_POST["rate"]);


      $name = $nameResult[0];
      $email = $emailResult[0];
      $description =$descriptionResult[0];
      $rate =$rateResult[0];


      $table =  array( $nameResult[1] ,$emailResult[1] , $descriptionResult[1] ,$rateResult[1]);
      $foundError = false;
      foreach ($table as $item) {
         if (!empty($item)) $foundError=true;
      }


      if(!$foundError){

        saveOptionToDB($name , $email , $description , $rate);
        $ELEMENT_SAVED = true;
      }

}


function showFieldValue($field){
    return $field;
}



function showRateOptions(){
    global $rate;
    for ($i = 0; $i <= 5; $i++) {
    ?>
        <option   <?php if($rate == $i) echo "selected"  ?>   > <?= $i ?> </option>
    <?php
    }
}


function showNewErrors($variable , $type="text"){
    if ($_SERVER["REQUEST_METHOD"] != "POST") return "";
    $result = validateInput($variable , $type);
    if(empty($result)) return "";

    ?>
    <div class="alert alert-warning" role="alert">
      <?php 
        if($result["empty"]) {
            echo "Le champ ne doit pas être vide"."</br>";
        }

        if($result["badEmail"]) {
            echo "L'email est incorrect"."</br>";
        }
       
    ?>
    </div>

    <?php 
}
?>


<?php include_once("./partials/_header.php") ?>
<?php include_once("./partials/_navbar.php") ?>




<div class="container">

    <?php if ($ELEMENT_SAVED) { ?>
        <div class="alert alert-success" role="alert">
        Votre avis a bien été créé
        </div>
    <?php } ?>


   <h1>Donnez un avis !</h1>
   <form action="" method="post">
      <div class="form-group">
         <label>Name</label>
         <input type="text" class="form-control" name="name" value="<?= showFieldValue($name) ?>" placeholder="Entrer le nom">
         <?php showNewErrors($name) ?>
      </div>
      <div class="form-group">
         <label for="exampleFormControlInput1">Email</label>
         <input value="<?= showFieldValue($email) ?>" type="text" name="email" class="form-control" id="exampleFormControlInput1" placeholder="Entrer le mail">
         <?php showNewErrors($email , $type="email") ?>
      </div>
      <div class="form-group">
         <label for="exampleFormControlSelect1">Note</label>
         <select class="form-control" name="rate" id="exampleFormControlSelect1">
            <?=  showRateOptions() ?>
         </select>
                  <?php showNewErrors($rate) ?>

      </div>
      <div class="form-group">
         <label>Description</label>
         <textarea name="description" class="form-control" rows="3">
           <?= showFieldValue($description) ?>
         </textarea>
                  <?php showNewErrors($description) ?>

      </div>
      <button class="btn btn-success" type="submit">SOUMETTRE</button>
   </form>
</div>

<?php include_once("./partials/_footer.php") ?>