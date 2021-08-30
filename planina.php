<?php
include 'header.php';
include 'baza/broker.php';
$broker=Broker::getBroker();
if(!isset($_GET['id'])){
    header('Location: index.php');
}else{
    $res=$broker->ucitaj('select * from planina where id='.$_GET['id']);
    if(!$res['status'] || count($res['podaci'])==0){
        header('Location: index.php');
    }else{
        $planina=$res['podaci'][0];
        $res=$broker->ucitaj('select * from hotel where planina='.$_GET['id']);
        $hoteli=$res['podaci'];
    }
}

?>

<div class='container mt-2 mb-5'>
    <h1 class='text-center text-primary'>
        <?php echo $planina->naziv; ?>
    </h1>
    <div class="row">
        <img src="assets/<?php echo $planina->slika;?>" alt="Planina nema sliku">
    </div>
    <div class='row mt-2'>
        <div class='col-7'>
            <h2>Izmeni planinu</h2>
            <form id="forma">
                <label>ID</label>
                <input required class="form-control" disabled type="text" id='idPlanine'
                    value="<?php echo $planina->id; ?>">
                <label>Naziv</label>
                <input required class="form-control" type="text" id='naziv' value="<?php echo $planina->naziv; ?>">

                <label>Opis</label>
                <textarea required class="form-control" type="text" id='opis'><?php echo $planina->opis; ?></textarea>
                <button class="mt-2 btn btn-primary form-control">Sacuvaj promene</button>
            </form>
        </div>
        <div class='col-5'>
            <h2 class='text-center text-primary'>Hoteli na planini</h2>
            <table class='table'>
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Naziv</th>
                        <th>Broj zvezdica</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($hoteli as $hotel){
                        ?>
                    <tr>
                        <td>
                            <?php echo $hotel->id;?>
                        </td>
                        <td>
                            <?php echo $hotel->naziv;?>
                        </td>
                        <td>
                            <?php echo $hotel->zvezdice;?>
                        </td>
                    </tr>
                    <?php      
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#forma').submit(function (e) {
            e.preventDefault();
            const id = $("#idPlanine").val();
            const naziv = $("#naziv").val();
            const opis = $("#opis").val();
            $.post('servis/planina/izmeni.php', {
                id, naziv, opis
            }, function (res) {
                const response = JSON.parse(res);
                if (!response.status) {
                    alert(response.greska);
                } else {
                    alert('uspesno izmenjena planina');
                }
            })
        })
    })
</script>
<?php
include 'footer.php';
?>