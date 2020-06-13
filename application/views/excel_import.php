<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">

</div>
<div class="container-fluid mt--8 ">
	<div class="row">
		<div class="col-xl-6 col-lg-6">

			<div class="card shadow mb-3">
				<div class="card-header">
					<a class="" data-toggle="collapse" href="#import" role="button" aria-expanded="false" aria-controls="import">
						<h3>Import Excel Data</h3>
					</a>
				</div>
				<div class="card-body collapse" id="import">
					<div class="spinner-border text-primary" role="status">
						<span class="sr-only">Loading...</span>
					</div>
					<form method="post" id="import_form" enctype="multipart/form-data">
						<div class="row">
							<div class="col-lg-6 form-group">
								<label for="file" class="placeholder">Select CSV File</label>
								<input type="file" id="file" name="file" class="form-control input-border-bottom" required accept=".xls, .xlsx, .csv" />
							</div>
							<div class="col-lg-6 form-group">
								<label for="nama" class="placeholder">Nama rule</label>
								<input type="text" id="nama" name="nama" class="form-control input-border-bottom" />
							</div>
							<div class="col-lg-6 form-group">
								<label for="support" class="placeholder">Support</label>
								<input type="number" id="support" name="support" class="form-control input-border-bottom" />
							</div>
							<div class="col-lg-6 form-group">
								<label for="confident" class="placeholder">Confident</label>
								<input type="number" id="confident" name="confident" class="form-control input-border-bottom" />
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
				<div class="card-header">
					<a class="" id="btn-log" data-toggle="collapse" href="#log" role="button" aria-expanded="false" aria-controls="log">
						<h3>Log Prosess Apriori</h3>
					</a>
				</div>
				<div class="card-body collapse" id="log">
				</div>
			</div>

		</div>
	</div>
	<div class="card" id="card-rule">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table align-items-center table-flush" id="rule">
					<thead class="thead-light">
						<tr>
							<th scope="col">#</th>
							<th scope="col">if</th>
							<th scope="col">then</th>
							<th scope="col">Support</th>
							<th scope="col">Confident</th>
						</tr>
					</thead>

				</table>
				<button class="btn btn-primary col-2" id="simpanRule">Simpan Rule</button>
			</div>
		</div>
	</div>
</div>

<script src="<?= base_url() ?>assets/js/apriori.js"></script>

<script>
	$(document).ready(function() {

		$("#card-rule").hide()
		$("#overlay").hide()

		let transaksi;
		let apriori = null;

		$('#import_form').on('submit', function(event) {
			event.preventDefault();
			$("#overlay").show()
			$("#btn-log").click()

			getImportData(this);

		});

		$('#simpanRule').on('click', () => simpanRule());

		// function simpanRule(id) {
		// 	$.ajax({
		// 		url: "<?php echo base_url(); ?>home/simpan",
		// 		type: "post",
		// 		data: JSON.stringify({
		// 			id: id,
		// 			data: apriori.getRule()
		// 		}),
		// 		contentType: "application/json",
		// 		dataType: "json",
		// 		cache: false,
		// 		processData: false,
		// 		success: function(data) {
		// 			console.log(data);
		// 		}
		// 	})
		// }

		function simpanRule() {
			let daftarRule = {
				nama: $("#nama").val(),
				bulan: "agustus",
				tahun: "2018",
				min_support: $("#support").val(),
				min_confident: $("#confident").val()
			}
			$.ajax({
				url: "<?php echo base_url(); ?>home/simpanRule",
				type: "post",
				data: JSON.stringify({
					daftarRule,
					rule: apriori.getRule()
				}),
				contentType: "application/json",
				dataType: "json",
				cache: false,
				processData: false,
				success: function(data) {
					// console.log(data);
				},
				error: function(e) {
					console.log(e.responseText);
				}
			})
		}

		function getImportData(data) {
			$("#log").append(`<p>Get data import...</p>`)

			$.ajax({
				url: "<?php echo base_url(); ?>home/tes",
				method: "POST",
				data: new FormData(data),
				contentType: false,
				cache: false,
				processData: false,
				success: function(data) {
					$('#file').val('');
					console.log(data)

					$("#log").append(`<p>Data berhasil diimport...</p>`)
					$("#log").append(`<p>Data parsing...</p>`)
					transaksi = JSON.parse(data);
					$("#log").append(`<p>Menghitung apriori...</p>`)

					// apriori = new Apriori(transaksi, 20);
					// apriori.prosess();

				},
				error: function(e) {
					console.log(e.responseText);
					$("#overlay").hide()
				}
			})
		}

	});
</script>