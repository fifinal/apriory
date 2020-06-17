<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">

</div>
<div class="container-fluid mt--8 ">
    <div class="card" id="card-rule">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-items-center table-flush" id="rule">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Nama</th>
                            <th scope="col">Bulan</th>
                            <th scope="col">Tahun</th>
                            <th scope="col">Min Support</th>
                            <th scope="col">Min Confident</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rules as $rule) : ?>
                            <tr>
                                <td><?= $rule["nama"] ?></td>
                                <td><?= $rule["bulan"] ?></td>
                                <td><?= $rule["tahun"] ?></td>
                                <td><?= $rule["min_support"] ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="mr-2"> <?= $rule["min_confident"] ?>%</span>
                                        <div>
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-primary" role="progressbar" aria-valuenow="<?= $rule["min_confident"] ?>" aria-valuemin="0" aria-valuemax="100" style="width:  <?= $rule["min_confident"]; ?>%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><a href="<?= base_url() ?>rule/detail/<?= $rule["id"] ?>" class=" btn btn-sm btn-warning"> <i class="fa fa-eye"></i> detail</a></td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>