<div class="container-fluid box-shadow-2">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">LISTADO DE <?=$tabTitle?></h1>
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
                            <input type="text" class="form-control" name='summary-id'>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fiscal</label>
                            <select class="form-control" name="fiscal-responsible">
                                <?php
                                    $list = "";
                                    if(count($fiscalList) > 1)
                                    {
                                        $list .= "<option value=''>Todos</option>";
                                    }
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
                            <!-- <button class="btn btn-primary input-sm" type="submit">Filtrar</button> -->
                            <button class="btn btn-primary input-sm" id="send-filters" type="button" data-content-data="chart-property-offers-based-on-property-types">Filtrar</button>
                            <button class="btn btn-danger input-sm" id="remove-additional-parameters" type="button" data-content-data="chart-property-offers-based-on-property-types">Remove filtros</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="material-summary-type">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>ESTADO</th>
                        <th>FISCAL</th>
                        <th>CONSTRUCTOR</th>
                        <th>FECHA DE<BR>ENTRADA MANUAL</th>
                        <th>PROYECTO</th>
                        <th>OPTIONS</th>
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
