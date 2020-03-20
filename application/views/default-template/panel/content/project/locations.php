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
    <script type="text/javascript">
        var projectList = JSON.parse('<?=json_encode($projects)?>');
            
    </script>
    <div class="col-md-12">
        <form class="form-inline">
          <div class="form-group">
            <label class="sr-only" for="exampleInputEmail3">Codigo</label>
            <input type="text" name="code" class="form-control" id="exampleInputEmail3" placeholder="Codigo">
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
