<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">

</div>
<div class="container-fluid mt--8 ">
	<div class="row">
		<div class="col-xl-6 col-lg-6">
			<div class="card shadow mb-3">
				<div class="card-body" id="import">
					<div class="spinner-border text-primary" role="status">
						<span class="sr-only">Loading...</span>
					</div>
					<form method="post" id="import_form" enctype="multipart/form-data">
						<div class="row">
							<div class="col-lg-6 form-group">
								<label for="file" class="placeholder">Select CSV File</label>
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
		<div class="col-xl-6 col-lg-6">
			<div class="card shadow mb-3">
				<div class="card-body" id="import">
					<div class="spinner-border text-primary" role="status">
						<span class="sr-only">Loading...</span>
					</div>
					<form method="post">
						<div class="row">
							<div class="col-lg-6 form-group ">
								<select class="form-control js-data-example-ajax" id="">
								</select>
							</div>
							<div class="col-lg-5">
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<button class="btn btn-danger" type="button" id="button-addon1">
											<i class="fa fa-minus"></i>
										</button>
									</div>
									<input type="number" class="form-control" placeholder="" style="padding-left:5px; ">
									<div class="input-group-append">
										<button class="btn btn-danger" type="button" id="button-addon2">
											<i class="fa fa-plus"></i>
										</button>
									</div>
								</div>
							</div>
						</div>
						<button class="btn btn-info">
							import
						</button>
					</form>

				</div>
			</div>
		</div>
	</div>
	<div class="card" id="card">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table align-items-center table-flush" id="table-transaksi">
					<thead class="thead-light">
						<tr>
							<th scope="col">Kode Transaksi</th>
							<th scope="col">Hari</th>
							<th scope="col">Tanggal</th>
							<th scope="col">Bulan</th>
							<th scope="col">Tahun</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	// ============ Init DataTable ============
	$('#table-transaksi').DataTable({
		serverSide: true, //Feature control DataTables' server-side processing mode.
		order: [], //Initial no order.
		sAjaxSource: "<?php echo base_url(); ?>transaksi/json",
		sServerMethod: "POST"
	});

	// ============ Event ============
	$('#import_form').on('submit', (event) => {
		event.preventDefault();
		$("#overlay").show();
		getImportData(event.target);
	});

	$("#table-produk").click((e) => {
		if (e.target.classList.contains("edit"))
			edit(e.target.dataset.id);
		if (e.target.classList.contains("hapus"))
			hapus(e.target.dataset.id);
	});

	$('.js-data-example-ajax').select2({
		ajax: {
			url: "<?php echo base_url(); ?>produk/ajax",
			processResults: function(data) {
				// Transforms the top-level key of the response object from 'items' to 'results'
				console.log(data);

				data = JSON.parse(data);

				return {
					results: data.map((d) => {
						return {
							id: d.kode_produk,
							text: d.nama_produk
						};
					})
				};
			}
		}
	});

	// ============ End Event ============


	// ============ Function ============
	function hapus(id) {
		$.ajax({
			url: "<?php echo base_url(); ?>produk/hapus/" + id,
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

	function reset() {
		$("#kode_produk").prop('disabled', false);
		$("#kode_produk").val("")
		$("#nama_produk").val("")
		$("#harga").val("")
		$("#stok").val("")
	}

	function getImportData(data) {
		$.ajax({
			url: "<?php echo base_url(); ?>transaksi/import",
			method: "POST",
			data: new FormData(data),
			contentType: false,
			cache: false,
			processData: false,
			success: function(data) {
				$('#file').val('');
				$("#overlay").hide();
				console.log(data)
			},
			error: function(e) {
				$("#overlay").hide();

				console.log(e.responseText);
			}
		})
	}
	// ============ End Event ============
</script>