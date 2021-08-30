<?php
include 'header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-9">
            <h1 class="text-center text-primary">Spisak planina u ponudi</h1>
        </div>
        <div class="col-3">
            <a href="kreirajPlaninu.php" target="_blank">
                <button class='btn btn-primary btn-block'>Kreiraj novu planinu</button>
            </a>
        </div>
    </div>
    <div id='planine' class='mt-5'>

    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        ucitajPlanine();
    })
    function ucitajPlanine() {
        $.getJSON('servis/planina/vratiSve.php', function (response) {
            console.log(response);
            if (!response.status) {
                $('#planine').html('desila se greska');
                return;
            }
            $('#planine').html('');
            for (let planina of response.podaci) {
                $('#planine').append(`
                    <div class='row mt-5 mb-3 d-flex justify-content-center'>
                        <div class='col-9'>
                            <img class="img-fluid" src='assets/${planina.slika}' />
                            <h4 class='text-center text-primary'> ${planina.naziv}</h4>
                         <div class='row mt-2'>
                            <div class='col-6'>
                          <a  target="_blank" href='planina.php?id=${planina.id}'>
                            <button class='btn btn-success btn-block'>Izmeni</button>  
                          </a>
                          </div>
                          <div class='col-6'>
                             <button onClick="obrisiPlaninu(${planina.id})" class='btn btn-danger btn-block'>Obrisi</button>
                          </div>
                         </div>
                        </div>
                    </div>
                
                `)
            }
        })
    }
    function obrisiPlaninu(id) {
        $.post('servis/planina/obrisi.php', { id }, function (res) {
            const response = JSON.parse(res);
            if (!response.status) {
                alert(response.greska);
            } else {
                ucitajPlanine();
            }
        })
    }
</script>

<?php
include 'footer.php';
?>