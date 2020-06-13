<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">

</div>
<div class="container-fluid mt--8 ">
    <div class="row">
        <div class="col-xl-6 col-lg-6">

            <div class="card shadow mb-3">
                <div class="card-header">
                    <h3>Import Excel Data</h3>
                </div>
                <div class="card-body" id="import">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <form method="post" id="import_form" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <input type="file" id="file" name="file" class="form-control input-border-bottom" required accept=".xls, .xlsx, .csv" />
                            </div>

                        </div>
                        <button type="submit" name="import" value="Import" class="btn btn-info">
                            import
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
    <div class="card" id="card-produk">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-items-center table-flush display" id="table-produk">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Kode Produk</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Stok</th>
                            <th scope="col">Action</th>
                        </tr>
                        <tr>
                            <th scope="col form-group">
                                <input type="text" id="kode_produk" name="kode_produk" class="form-control input-border-bottom" placeholder="kode produk..." />
                            </th>
                            <th scope="col form-group">
                                <input type="text" id="nama_produk" name="nama_produk" class="form-control input-border-bottom" placeholder="nama produk..." />
                            </th>
                            <th scope="col form-group">
                                <input type="number" id="harga" name="harga" class="form-control input-border-bottom" placeholder="harga..." />
                            </th>
                            <th scope="col form-group">
                                <input type="number" id="stok" name="stok" class="form-control input-border-bottom" placeholder="stok..." />
                            </th>
                            <th scope="col form-group">
                                <button class="btn btn-success" id="simpan">Simpan</button>
                            </th>

                        </tr>

                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    let status = "simpan";

    // ============ Init DataTable ============
    $('#table-produk').DataTable({
        serverSide: true, //Feature control DataTables' server-side processing mode.
        order: [], //Initial no order.
        sAjaxSource: "<?php echo base_url(); ?>produk/json",
        sServerMethod: "POST"
    });

    // ============ Event ============
    $('#import_form').on('submit', (event) => {
        event.preventDefault();
        $("#overlay").show();
        getImportData(event.target);
    });

    $("#kode_produk").on("keyup", (e) => {
        console.log(e.target.value);
    })
    $("#nama_produk").on("keyup", (e) => {
        console.log(e.target.value);
    })
    $("#harga").on("keyup", (e) => {
        console.log(e.target.value);
    })
    $("#stok").on("keyup", (e) => {
        console.log(e.target.value);
    })

    $("#simpan").click((e) => simpan())

    $("#table-produk").click((e) => {
        if (e.target.classList.contains("edit"))
            edit(e.target.dataset.id);
        if (e.target.classList.contains("hapus"))
            hapus(e.target.dataset.id);
    });
    // ============ End Event ============


    // ============ Function ============

    function edit(id) {
        status = "edit";
        $.ajax({
            url: "<?php echo base_url(); ?>produk/edit/" + id,
            method: "GET",
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                let produk = JSON.parse(data);
                $("#kode_produk").prop('disabled', true);
                $("#kode_produk").val(produk.kode_produk)
                $("#nama_produk").val(produk.nama_produk)
                $("#harga").val(produk.harga)
                $("#stok").val(produk.stok)
            }
        })
    }

    function hapus(id) {
        $("#overlay").show();
        $.ajax({
            url: "<?php echo base_url(); ?>produk/hapus/" + id,
            method: "GET",
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {

                if (confirm("yakin"))
                    console.log("berhasil dihapus");
                $("#overlay").hide();
            }
        })
    }

    function reset() {
        $("#kode_produk").prop('disabled', false);
        $("#kode_produk").val("")
        $("#nama_produk").val("")
        $("#harga").val("")
        $("#stok").val("")
    }

    function simpan() {
        $("#overlay").show();
        let data = {
            kode_produk: $("#kode_produk").val(),
            nama_produk: $("#nama_produk").val(),
            harga: $("#harga").val(),
            stok: $("#stok").val()
        };
        let url = "<?php echo base_url(); ?>produk/simpan";
        if (status === "simpan") {
            url = "<?php echo base_url(); ?>produk/simpan";
        } else if (status === "edit") {
            url = "<?php echo base_url(); ?>produk/update";
            status = "simpan"
        }
        $.ajax({
            url: url,
            type: "POST",
            data: JSON.stringify(data),
            dataType: "text",
            cache: false,
            processData: false,
            success: function(data) {
                let a = JSON.parse(data);
                console.log(a);
                reset();
                $("#overlay").hide();
            }
        })
    }

    function getImportData(data) {
        $.ajax({
            url: "<?php echo base_url(); ?>produk/import",
            method: "POST",
            data: new FormData(data),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#file').val('');
                console.log(data)
                $("#overlay").hide();
            },
            error: function(e) {
                $("#overlay").hide();
                console.log(e.responseText);
            }
        })
    }
    // ============ End Event ============
</script>