<?php
require_once("../bootstrap.php");
require_once("./classes/Opinion.php");


$opinionRepository = $entityManager->getRepository('Opinion');
$opinions = $opinionRepository->findBy(array());
$sorting  = "rate";
$order  = "ASC";

if (isset($_GET['sorting'])){
    $sortingFromUrl = $_GET['sorting'];
    $orderFromUrl = $_GET['order'];

    if($sortingFromUrl == "rate" || $sortingFromUrl == "createdAt"){
        $sorting = $sortingFromUrl;
    }
    if($orderFromUrl == "ASC" ||  $orderFromUrl == "DESC"){
        $order = $orderFromUrl;
    }

    $opinions = $opinionRepository->findBy(array() , orderBy: array($sorting => $order)  );
}




function showStars($rate){
 for($i = 0; $i < $rate; $i+=1) {  ?>
        <img src="https://cdn-icons-png.flaticon.com/512/1828/1828884.png" height="20" width="20" alt="">
    <?php }
}


function showRates($opinions){
    foreach ($opinions as $opinion) {
        ?>

    <tr>
      <th scope="row"><?= $opinion->getId() ?></th>
      <td><?= $opinion->getName() ?></td>
      <td><?= $opinion->getEmail() ?></td>
      <td> <?= $opinion->getDescription() ?> </td>
      <td>  <?= $opinion->getRate()   ?>  <?= showStars($opinion->getRate())   ?>  </td>
      <td>  <?= date_format($opinion->getCreatedAt() , "yy-m-d")  ?>  </td>
    </tr>

    <?php
    }
}



?>


<?php include_once("./partials/_header.php") ?>
<?php include_once("./partials/_navbar.php") ?>

      
 
<div class="container">

    <h3 class="">Liste des avis publiés</h3>

    <form action="">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="sorting" id="exampleRadios1" value="rate" checked>
            <label class="form-check-label" for="exampleRadios1">
                Trier par notes
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="sorting" id="exampleRadios2" value="createdAt">
            <label class="form-check-label" for="exampleRadios2">
                Trier par date de publication
            </label>
        </div>

        <div style="max-width: 400px;" class="form-group">
            <label for="">Choisissez Ascendant ou descendant</label>
            <select name="order" class="form-control" id="">
            <option value="ASC">Ascendant</option>
            <option value="DESC">Descendant</option>
            </select>
        </div>

        <button type="submit" class="btn btn-info mb-4">Trier</button>

        </form>


<h3>Tableau trié avec php</h3>
    <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Email</th>
            <th scope="col">Description</th>
            <th scope="col">Note</th>
            <th scope="col">Date de publication</th>
            </tr>
        </thead>
        <tbody>
            <div class="row"> <?php showRates($opinions); ?> </div>
        </tbody>
    </table>



<h3>Tableau trié avec DATATABLE javascript</h3>
    <table id="table_id" class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Email</th>
            <th scope="col">Description</th>
            <th scope="col">Note</th>
            <th scope="col">Date de publication</th>
            </tr>
        </thead>
        <tbody>
            <div class="row"> <?php showRates($opinions); ?> </div>
        </tbody>
    </table>


</div>



<?php include_once("./partials/_footer.php") ?>

<script>

$(document).ready( function () {
     $('#table_id').DataTable( {
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/fr_fr.json'
        }
    } );
 } );


</script>
