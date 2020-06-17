<style>
    .r {
        text-align: right;
    }
</style>
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">

</div>
<div class="container-fluid mt--8 ">
    <div class="card" id="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h3>Kode Transaksi : <?= $transaksi["kode_transaksi"] ?></h3>
                    <p>Tanggal : <?= $transaksi["tanggal"] . "/" . $transaksi["bulan"] . "/" . $transaksi["tahun"] ?></p>
                    <p>Hari : <?= $transaksi["hari"] ?></p>
                </div>
                <div class="col-6 r">
                    <?php
                    $total = 0;
                    foreach ($detail_transaksi as $detail) $total += $detail["harga"];
                    ?>
                    <p>Total harga : Rp <?= $total ?></p>
                    <p>Total item : <?= count($detail_transaksi) ?></p>
                </div>
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-items-center table-flush" id="table-transaksi">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Kode Produk</th>
                            <th scope="col">nama Produk</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detail_transaksi as $detail) : ?>
                            <tr>
                                <td><?= $detail["kode_produk"] ?></td>
                                <td><?= $detail["nama_produk"] ?></td>
                                <td><?= $detail["harga"] ?></td>
                                <td><?= $detail["stok"] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // ============ Init DataTable ============
    // $('#table-transaksi').DataTable({
    //     serverSide: true, //Feature control DataTables' server-side processing mode.
    //     order: [], //Initial no order.
    //     sAjaxSource: "<?php echo base_url('/transaksi/detail'); ?>",
    //     sServerMethod: "POST"
    // });

    // ============ Function ============
    function hapus(id) {
        $.ajax({
            url: "<?php echo base_url(); ?>produk/hapus",
            method: "GET",
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (confirm("yakin"))
                    console.log("berhasil dihapus");
            }
        })
    }
    // ============ End Event ============
</script>