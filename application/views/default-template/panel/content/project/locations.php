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
            <h1 class="page-header">Mapa de proyectos
                <em class="subtext"></em>
            </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="col-md-12">
        <?php
        $this->load->view("default-template/flash-data-basic-messages");
        ?>
    </div>
    <div class="col-md-12">
            <input type="hidden" name="status-set" value="none">
            <form class="form-group" id="extra-request-data">
                <input type="hidden" name="status" value="">
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

    <div class="col-md-6">
        <div id="pagination-content" class="py-1"></div>
    </div>
    <div class="col-md-6">
        <form class="form-inline py-1" style="float:right">
          <div class="form-group">
            <input type="text" name="code" class="form-control" id="exampleInputEmail3" placeholder="">
          </div>
          <button type="button" class="btn btn-default search-project-in-map">Buscar</button>
        </form>
    </div>
    <div class="col-md-12">
        <div class="map-fancy-framework">
            <div id="maps" style="height: 500px;width: auto;position: relative;">
            </div>
            <em class="map-search-message"></em>
        </div>
        <br><br>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
<?php
$this->load->view('default-template/panel/content/project/ProjectsLocationHandler'); 
?>