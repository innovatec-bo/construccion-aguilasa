<div class="container-fluid box-shadow-2">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Solicitudes de materiales</h1>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>

        <div class="col-md-12">
            <form class="form-group" id="extra-request-data" method="POST" name="download-material-summary">
                <fieldset class="custom-border">
                    <legend class="custom-border">Filtros</legend>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>ID de solicitud</label>
                            <input type="text" class="form-control" name='request-id'>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fiscal</label>
                            <select class="form-control" name="fiscal-responsible">
                                <option value="">Todos</option>
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

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Constructor</label>
                            <select class="form-control" name="builder-responsible">
                                <option value="">Todos</option>
                                <?php
                                    $list = "";
                                    foreach ($builderList as $builder) 
                                    {
                                        $list .= "<option value='".$builder->getId()."'>".$builder->getFullName()."</option>";
                                    }
                                    echo $list;
                                ?>
                            </select>
                        </div>
                    </div>
					
                    <div class="col-md-12">
                        <div class="form-group mb-0">
                            <button class="btn btn-primary input-sm" type="submit">Filtrar</button>
                            <!-- <button class="btn btn-primary input-sm" id="send-filters" type="button" data-content-data="chart-property-offers-based-on-property-types">Filtrar</button>
                            <button class="btn btn-danger input-sm" id="remove-additional-parameters" type="button" data-content-data="chart-property-offers-based-on-property-types">Remove filtros</button> -->
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="material-summary-requests-list">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>ESTADO</th>
                        <th>FISCAL</th>
                        <th>CONSTRUCTOR</th>
                        <th>FECHA DE<BR>ENTRADA MANUAL</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $tr = "";
                        $statusList = [
                            Model_material_summary::STATUS_PENDING => 'Pendiente',
                            Model_material_summary::STATUS_CANCELED_BY_FISCAL => 'Cancelado por el fiscal',
                            Model_material_summary::STATUS_CANCELED_BY_SYSTEM => 'Cancelado por el sistema',
                            Model_material_summary::STATUS_WITHDRAWN => 'Retirado'
                        ];
                        foreach($requestList as $row)
                        {
                            $status = $statusList[$row['status_id_msu']]??"";
                            $manualEntryDate = new DateTime($row['entry_date_msu']);
                            $tr .= "
                            <tr>
                                <td>{$row['id_msu']}</td>
                                <td>{$status}</td>
                                <td>{$row['fiscal_full_name']}</td>
                                <td>{$row['builder_full_name']}</td>
                                <td>{$manualEntryDate->format('d-m-Y H:i:s')}</td>
                            </tr>    
                            ";
                        }
                        echo $tr;
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
