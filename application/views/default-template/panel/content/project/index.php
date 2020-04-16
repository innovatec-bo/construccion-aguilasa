<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 * Time: 22:33
 */
?>
<div class="container-fluid box-shadow-2">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?=$viewTitle?></h1>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>

        <div class="col-md-12">
            <input type="hidden" name="status-set" value="<?=$statusSet?>">
            <form class="form-group" id="extra-request-data">
                <input type="hidden" name="status" value="<?=$status?>">
                <fieldset class="custom-border">
                    <legend class="custom-border">Filtros</legend>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Area de trabajo</label>
                            <select class="form-control" name="work-area">
                                <option value="">--Todos--</option>
                                <option value="gir">GIR</option>
                                <option value="gis">GIS</option>
                            </select>    
                        </div>
                    </div>
                    <?php
                    if($isSuperAdmin == 1)
                    {
                    ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fiscales</label>
                            <select class="form-control" name="fiscal-responsible-id">
                                <option value="">--Todos--</option>
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
                    <?php
                    }
                    ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Constructores</label>
                            <select class="form-control" name="builder-responsible-id">
                                <option value="">--Todos--</option>
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Mano de obra</label>
                            <select class="form-control" name="manpower-uploaded">
                                <option value="">--Todos--</option>
                                <option value="1">SI</option>
                                <option value="0">NO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group mb-0">
                            <button class="btn btn-primary input-sm" id="send-filters" type="button" data-content-data="chart-property-offers-based-on-property-types">Filtrar</button>
                            <button class="btn btn-danger input-sm" id="remove-additional-parameters" type="button" data-content-data="chart-property-offers-based-on-property-types">Remove filtros</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        
        <form name="workflow-with-parameters" action="<?=base_url("panel/Project/getProjectWorkFlowReport")?>" method="post">
            <input type="hidden" name="is-super-admin" value="<?=$isSuperAdmin?>">
            <input type="hidden" name="code-list" value="">
            <input type="hidden" name="columns-to-download" value="">
        </form>
        <?php
        if($statusSet == "building") {
            ?>
            <div class="col-md-12">
                <div class="form-group">
                    <button type="button" class="btn btn-warning add-incident" data-status-id="<?=$status?>" data-project-id="all"><i class="fa fa-flag-o fa-fw"></i> Añadir incidencia a todos los proyectos
                    </button>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="project-index" data-project-systems='<?=json_encode($projectSystems)?>' data-project-status='<?=$projectStatusJson?>'>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>ORDEN</th>
                        <th>CODIGO</th>
                        <th>INGRESO EN SISTEMA</th>
                        <th>INGRESO EN ESTADO</th>
                        <th>DIAS ESTATICO</th>
                        <th>ESTADO</th>
                        <th>SISTEMA</th>
                        <th>DISTANCIA Y<br>PUNTOS</th>
                        <th>RESPONSABLE</th>
                        <th>FISCAL</th>
                        <th>CONSTRUCTOR</th>
                        <th>UBICACION</th>
                        <th class="text-center"><i class="fa fa-cogs fa-2x"></i></th>
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
