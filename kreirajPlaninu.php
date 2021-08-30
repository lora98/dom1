<?php
include 'header.php';
?>

<div class="container mt-5">
    <h1 class="text-center text-primary">
        Forma za kreiranje nove planine
    </h1>
    <div class="row mt-2 d-flex justify-content-center">
        <div class='col-8'>
            <form id='forma' enctype="multipart/form-data" size='200'>
                <label>Naziv</label>
                <input required class="form-control" type="text" id='naziv'>
                <label>Slika</label>
                <input required class="form-control" type="file" id='slika'>
                <label>Opis</label>
                <textarea required class="form-control" type="text" id='opis'></textarea>
                <button class="mt-2 btn btn-primary form-control">Sacuvaj</button>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#forma').submit(function (e) {
            e.preventDefault();
            const naziv = $('#naziv').val();
            const opis = $('#opis').val();
            const fd = new FormData();
            const slika = $("#slika")[0].files[0];
            fd.append("slika", slika);
            fd.append("naziv", naziv);
            fd.append("opis", opis);

            $.ajax(
                {
                    url: "./servis/planina/kreiraj.php",
                    type: 'post',
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        data = JSON.parse(data);
                        if (!data.status) {
                            alert(data.greska);
                        } else {
                            alert('Uspesno kreirana planina');
                        }

                    },

                }
            )
        })
    })
</script>

<?php
include 'footer.php';
?>