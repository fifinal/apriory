<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">

</div>
<div class="container-fluid mt--8 ">
	<div class="card" id="card-rule">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table align-items-center table-flush" id="rule">
					<thead class="thead-light">
						<tr>
							<th scope="col">#</th>
							<th scope="col">If</th>
							<th scope="col">Then</th>
							<th scope="col">Support</th>
							<th scope="col">Confident</th>
							<!-- <th scope="col">Action</th> -->
						</tr>
					</thead>
					<tbody>
						<?php $i = 1;
						foreach ($rules as $rule) : ?>
							<tr>
								<td><?= $i ?></td>
								<td> <span class="badge badge-dot mr-3">
										<i class="bg-warning"></i>
										<?php
										$ifArray = explode(",", $rule["if"]);
										echo implode("</span><span class='badge badge-dot mr-3'>
										<i class='bg-warning'></i>", $ifArray);
										?>
									</span>
								</td>
								<td>
									<span class="badge badge-dot mr-3">
										<i class="bg-info"></i><?= $rule["then"] ?>
									</span>
								</td>
								<td><?= $rule["support"] ?></td>
								<td>
									<div class="d-flex align-items-center">
										<span class="mr-2"> <?= $rule["confident"] ?>%</span>
										<div>
											<div class="progress">
												<div class="progress-bar bg-gradient-info" role="progressbar" aria-valuenow="<?= $rule["confident"] ?>" aria-valuemin="0" aria-valuemax="100" style="width:  <?= $rule["confident"]; ?>%"></div>
											</div>
										</div>
									</div>
								</td>
							</tr>
						<?php $i++;
						endforeach; ?>

					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="card mt-3">
		<div class="card-header">
			<h3>Rule </h3>
		</div>
		<div class="card-body">
			<ol class="list-group">
				<?php $i = 0;
				foreach ($ruleNames as $ruleName) : ?>
					<li class="list-group-item-text">
						<p>Jika membeli
							<span class="text-warning">
								<?= implode("</span> dan  <span class='text-warning'>", $ruleName['jika']); ?>
							</span>
						</p>
						<p>
							Maka <span class="text-success"><?= $ruleName["maka"]; ?></span>
						</p>
						<p>
							Dengan tingkat kepercayaan <span class="text-info"><?= $rules[$i]["confident"] ?> %</span>
						</p>
					</li>
				<?php $i++;
				endforeach ?>
			</ol>

		</div>
	</div>
</div>
<script>
	$(document).ready(function() {

		$('#rule').DataTable({
			dom: 'Bfrtip',
			buttons: [
				'excel', 'pdf',
				{
					extend: "pdfHtml5",
					title: "My title",
					customize: doc => {
						doc.styles.title = {
							fontSize: '40',
							alignment: 'center'
						}
						doc.styles.tableHeader = {
							alignment: 'center'
						}
						doc.styles.tableBodyEven = {
							alignment: 'center'
						}
						doc.styles.tableBodyOdd = {
							alignment: 'center'
						}
					}
				}
			]
		});
		const pdf = document.querySelector(".buttons-pdf")
		const excel = document.querySelector(".buttons-excel")
		pdf.classList = "btn btn-danger"
		pdf.innerHTML = "Download PDF"
		excel.classList = "btn btn-success"
		excel.innerHTML = "Download Excel"
	})
</script>