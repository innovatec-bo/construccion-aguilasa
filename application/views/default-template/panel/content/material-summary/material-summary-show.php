<div class="container-fluid box-shadow-2">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Detalle</h1>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <dl>
                        <dt>ID</dt>
                        <dd><?= $materialSummary['summary_id'] ?></dd>
                        <dt>Fecha</dt>
                        <dd><?= $materialSummary['summary_entry_date'] ?></dd>
                        <dt>Nro. Correlativo</dt>
                        <dd><?= $materialSummary['summary_correlative_counter'] ?></dd>
                        <dt>Tipo de resumen</dt>
                        <dd><?=$materialSummary['summary_type_name']?></dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <dl>
                        <dt>Fiscal</dt>
                        <dd><?= $materialSummary['fiscal_full_name'] ?></dd>
                        <dt>Constructor</dt>
                        <dd><?= $materialSummary['builder_full_name'] ?></dd>
                        <dt>Proyecto</dt>
                        <dd><?= $materialSummary['project_code'] ?></dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="material-summary-type">
                    <thead>
                        <tr>
                            <th>CODIGO</th>
                            <th>DESCRIPCION</th>
                            <th>UNIDAD<BR>DE MEDIDA</th>
                            <th>CANTIDAD</th>
                            <th>STATUS</th>
                            <th>TENSION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $html = "";
                        foreach ($materialList as $material) {
                            $html .= "
                                <tr>
                                    <td>{$material['material_code']}</td>
                                    <td>{$material['material_description']}</td>
                                    <td>{$material['material_unit_of_measurement']}</td>
                                    <td>{$material['material_quantity']}</td>
                                    <td>{$material['material_status_code']}</td>
                                    <td>{$material['material_tension']}</td>
                                </tr>    
                                ";
                        }
                        echo $html;
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->