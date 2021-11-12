<div class="container-fluid box-shadow-2">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Cargar lista inicial</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="col-md-12">
        <?php
        $this->load->view("default-template/flash-data-basic-messages");
		?>
    </div>
	<div class="row">
        <div class="col-md-12">
            <form name="form" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Materiales</label>
                    <input type="file" name="materials-file">
                </div>
                <div class="form-group">
                    <label>Codigo de Proyecto</label><br>
                    <input type="text" name="project-code">
                </div>
                <button type="submit" class="btn btn-primary mb-3">Procesar</button>
            </form>
        </div>
	</div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
