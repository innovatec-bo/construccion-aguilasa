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
            <h1 class="page-header">Plan de trabajo</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="col-md-12">
        <?php
        $this->load->view("default-template/flash-data-basic-messages");
        ?>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>Fiscal</label>
                <select class="form-control">
                    <option></option>
                    <?php 
                    $html = "";
                    foreach ($fiscalList as $row) 
                    {
                        // $row = $row->toArray();
                        $html .= "<option value=".$row->getId().">".$row->getFullName()."</option>";
                    }
                    echo $html;
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Constructor</label>
                <select class="form-control">
                    <option></option>
                    <?php 
                    $html = "";
                    foreach ($builderList as $row) 
                    {
                        // $row = $row->toArray();
                        $html .= "<option value=".$row->getId().">".$row->getFullName()."</option>";
                    }
                    echo $html;
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-11"> 
            <button type="button" class="btn btn-info btn-xs" data-toogle='tooltip' data-placement='top' data-original-title="Nueva fila"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th rowspan="3" class="text-center vertical-align">PROYECTO</th>
                            <th rowspan="3" class="text-center vertical-align">LUGAR</th>
                            <th class="change-week previous-week" data-toggle='tooltip' data-placement='top' data-original-title="SEMANA ANTERIOR" data-container="body"><<</th>
                            <th colspan="5" class="table-month vertical-align">FEBRERO</th>
                            <th class="change-week next-week" data-original-title='SIGUIENTE SEMANA' data-placement='top' data-container="body" data-toggle='tooltip'>>></th>
                            <th rowspan="3" class="text-center vertical-align">TRABAJO</th>
                            <th rowspan="3" class="text-center vertical-align">OBSERVACION</th>
                            <th rowspan="3" class="text-center vertical-align">X</th>
                        </tr>
                        <tr>
                            <th class="width-30 text-center table-days">L</th>
                            <th class="width-30 text-center table-days">M</th>
                            <th class="width-30 text-center table-days">M</th>
                            <th class="width-30 text-center table-days">J</th>
                            <th class="width-30 text-center table-days">V</th>
                            <th class="width-30 text-center table-days">S</th>
                            <th class="width-30 text-center table-days">D</th>
                        </tr>
                        <tr>
                            <th class="width-30 text-center table-dates">10</th>
                            <th class="width-30 text-center table-dates">11</th>
                            <th class="width-30 text-center table-dates">12</th>
                            <th class="width-30 text-center table-dates">13</th>
                            <th class="width-30 text-center table-dates">14</th>
                            <th class="width-30 text-center table-dates">15</th>
                            <th class="width-30 text-center table-dates">16</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>RD.02.2222</td>
                            <td>VIADUCTO COTOCA</td>
                            <td class="date-to-work"></td>
                            <td class="date-to-work"></td>
                            <td class="date-to-work"></td>
                            <td class="date-to-work"></td>
                            <td class="date-to-work"></td>
                            <td class="date-to-work"></td>
                            <td class="date-to-work"></td>
                            <td><input class="table-input-work-plan" placeholder="Especifique el trabajo" type="text" name="work"></td>
                            <td><input class="table-input-work-plan" placeholder="Observacion" type="text" name="observation"></td>
                            <td class="text-center delete-row"><i class="fa fa-times"></i></td>
                        </tr>
                        <tr>
                            <td>RD.02.2222</td>
                            <td>VIADUCTO COTOCA</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Maniobra para recableo de linea MT.</td>
                            <td>Coordinacion con Paul Rojas y Dario Flores</td>
                            <td class="text-center">x</td>
                        </tr>
                        <tr>
                            <td>RD.02.2222</td>
                            <td>VIADUCTO COTOCA</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Maniobra para recableo de linea MT.</td>
                            <td>Coordinacion con Paul Rojas y Dario Flores</td>
                            <td class="text-center">x</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>    
    </div>
    <div class="row">
        <div class="col-lg-12">
            <button type="button" class="btn btn-primary">Guardar</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <label>Elija un mes para filtrar los proyectos</label>
        </div>    
        <div class="col-md-offset-2 col-md-2">
            <div class="form-group">
                <input name="report-year" readonly="" class="form-control input-lg date-time text-center" size="1" required="">
            </div>
        </div>
        <div class="col-md-offset-2 col-md-8">
            <p class="help-block">Los proyectos que figuran en la tabla estan en etapa de construccion.</p>
        </div>    
    </div>
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="table-content">
              
            </div>
        </div>    
    </div>
</div>
<!-- /.container-fluid -->
<?php
    $this->load->view("default-template/panel/content/event-calendar/WorkPlanHandler");
?>