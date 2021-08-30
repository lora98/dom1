<?php
include 'header.php';
?>

<div class=' mt-2'>
    <h1 class='text-center text-primary'>Hoteli</h1>
    <div class="row m-2">
        <div class="col-8">
            <input required class="form-control" type="text" id='pretraga' placeholder="Pretrazi...">
        </div>
    </div>
    <div class='row mt-4'>
        <div class='ml-2 mr-2 col-8'>
            <table class='table '>
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Naziv</th>
                        <th>Broj zvezdica</th>
                        <th>Planina</th>
                        <th colspan="2">Opis</th>
                        <th>Obrisi</th>
                    </tr>
                </thead>
                <tbody id='hoteli'>

                </tbody>
            </table>
        </div>
        <div class='col-3'>
            <h2 class='text-center text-primary'>
                Kreiraj hotel
            </h2>
            <form id='forma'>
                <label>Naziv</label>
                <input required class="form-control" type="text" id='naziv'>
                <label>Broj zvezdica</label>
                <input required class="form-control" type="number" id='zvezdice' min="1" max="5">
                <label>Planina</label>
                <select id="planina" class="form-control">
                    
                </select>
                <label>Opis</label>
                <textarea required class="form-control" type="text" id='opis'></textarea>
                <button class="mt-2 btn btn-primary form-control">Sacuvaj</button>
            </form>

        </div>
    </div>

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    let hoteli = [];
    $(document).ready(function () {
        ucitajPlanine();
        ucitajHotele();
        $('#pretraga').change(function (e) {
            const value = e.currentTarget.value;
            iscrtajTabelu(hoteli.filter(filtriraj(value)));
        })
        $('#forma').submit(function (e) {
            e.preventDefault();
            const naziv = $('#naziv').val();
            const zvezdice = $('#zvezdice').val();
            const opis = $('#opis').val();
            const planina = $('#planina').val();
            $.post('servis/hotel/kreiraj.php', { naziv, zvezdice, opis, planina }, function (res) {
                const response = JSON.parse(res);
                if (!response.status) {
                    alert(response.greska);
                } else {
                    ucitajHotele();
                }

            })
        })
    })


    function filtriraj(vrednost) {
        return function unutrasnja(hotel) {
            return vrednost === '' || hotel.id == vrednost || hotel.naziv.includes(vrednost) || hotel.opis.includes(vrednost) || hotel.naziv_planine.includes(vrednost);
        }
    }

    function ucitajPlanine() {
        $.getJSON('servis/planina/vratiSve.php', function (response) {
            console.log(response);
            if (!response.status) {
                $('#planina').html('desila se greska');
                return;
            }
            $('#planina').html('');
            for (let planina of response.podaci) {
                $('#planina').append(`
                   <option value='${planina.id}'>${planina.naziv} </option>
                `)
            }
        })
    }
    function ucitajHotele() {
        $.getJSON('servis/hotel/vratiSve.php', function (response) {
            console.log(response);
            if (!response.status) {
                alert(response.greska);
                return;
            }
            hoteli = response.podaci;
            iscrtajTabelu(hoteli);
        })
    }
    function iscrtajTabelu(podaci) {
        $('#hoteli').html('');
        for (let hotel of podaci) {
            $('#hoteli').append(`
                <tr>
                    <td>${hotel.id}</td>
                    <td>${hotel.naziv}</td>
                    <td>${hotel.zvezdice}</td>
                    <td>${hotel.naziv_planine}</td>
                    <td colspan="2">${hotel.opis}</td>
                    <td>
                        <button onClick="obrisiHotel(${hotel.id})" class='btn btn-danger btn-block'>Obrisi</button>
                    </td>
                </tr>
                `)
        }
    }
    function obrisiHotel(id) {
        $.post('servis/hotel/obrisi.php', { id }, function (res) {
            const response = JSON.parse(res);
            if (!response.status) {
                alert(response.greska);
            } else {
                ucitajHotele();
            }
        })
    }
</script>
<?php
include 'footer.php';
?>