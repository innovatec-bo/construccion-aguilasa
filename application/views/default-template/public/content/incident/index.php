<div class="container">
    <div class="row">
        <div class="col-md-offset-1 col-md-9">
            <div class="title-system-panel panel panel-default">
                <div class="panel-heading">
                    <h1 class="system-title text-center">Mis Proyectos</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-1 col-md-9">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-1 col-md-9">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Seleccione un proyecto para gestionar las incidencias
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover table-xs" id="project-list">
                                    <thead>
                                        <tr>
                                            <th>CODIGO</th>
                                            <th>DETALLE</th>
                                            <th>ESTADO</th>
                                            <th>DIRECCION</th>
                                            <th>OPCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $html = "";
                                            foreach ($projectList as $row) 
                                            {
                                                $myEncrypt = new MY_Encrypt();
                                                $dataToEncrypt = array("userId" => $row['cre_fiscal_pro'], "projectId" => $row['id_pro']);
                                                $dataToEncrypt = json_encode($dataToEncrypt);
                                                $dataEncrypted = $myEncrypt->encode($dataToEncrypt);
                                                $html .= "
                                                    <tr>
                                                        <td>".$row['code_pro']."</td>
                                                        <td>".$row['detail_pro']."</td>
                                                        <td>".$row['status_name_pst']."</td>
                                                        <td>".$row['address_pro']."</td>
                                                        <td><a target='_self' href='".base_url('Incident/project/'.$dataEncrypted)."' class='btn btn-social-icon btn-info btn-xs'><i class='fa fa-flag'></i></a></td>
                                                    </tr>
                                                ";
                                            }
                                            echo $html;
                                        ?>
                                    </tbody>
                                </table>
                            </div>        
                        </div>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
    </div>
</div>
