<div class="container-fluid box-shadow-2">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Resumen de materiales</h1>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>

        <div class="col-md-12">
            <form class="form-group" id="extra-request-data" method="POST" name="download-material-summary" action="<?=base_url('panel/MaterialSummary/downloadExcelMaterialSummary')?>">
                <fieldset class="custom-border">
                    <legend class="custom-border">Filtros</legend>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Proyecto</label>
                            <select class="form-control input-sm project" name="project-id">
                                <option></option>
                                <?php
                                $options = "";
                                /** @var Model_project $project */
                                foreach ($projects as $project)
                                {
                                    $options .= "<option value='{$project->getId()}'>{$project->getCode()}</option>";
                                }
                                echo $options;
                                ?>

                            </select>
                        </div>
                    </div>

                    <!-- <div class="col-md-2 hide">
                        <div class="form-group">
                            <label>Mat. Pendientes</label>
                            <select class="form-control input-sm" name="show-material-pending-in-cre">
                                <option value="">Todos</option>
                                <option value="1">Si</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div> -->

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Fiscal</label>
                            <select class="form-control" name="fiscal-responsible-id">
                                <option value="">
                                    Todos</option>
                                <?php
                                    $list = "";
                                    foreach ($fiscalList as $fiscal) 
                                    {
                                        $list .= "<option value='".$fiscal->getId()."'>".$fiscal->getFullName()."</option>";
                                    }
                                    echo $list;
                                ?>
                            </select>
                        </div>
                    </div>
					
                    <div class="col-md-12">
                        <div class="form-group mb-0">
                            <button class="btn btn-primary input-sm" type="submit">Descargar reporte</button>
                            <!-- <button class="btn btn-primary input-sm" id="send-filters" type="button" data-content-data="chart-property-offers-based-on-property-types">Filtrar</button>
                            <button class="btn btn-danger input-sm" id="remove-additional-parameters" type="button" data-content-data="chart-property-offers-based-on-property-types">Remove filtros</button> -->
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="material-summary-index">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>CODIGO</th>
                        <th>DESCRIPCION</th>
                        <th>PROYECTO</th>
                        <th>CANTIDAD<BR>COMPROMETIDA</th>
                        <th>RETIRADO<br>DE CRE</th>
                        <th>PENDIENTE POR<BR>RETIRAR DE CRE</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
