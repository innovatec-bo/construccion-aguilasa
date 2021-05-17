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
            <h1 class="page-header">Workflow</h1>
        </div>
        <div class="col-md-12">
            <?php
            $this->load->view("default-template/flash-data-basic-messages");
            ?>
        </div>
        <div class="col-md-12">
			<script>
				var columns = <?=json_encode($columns)?>;
			</script>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="workflow-index">
                    <thead>
                    <tr>
						<?php
						$th = "";
						foreach ($columns as $key => $title)
						{
							$th .= "<th>{$title}</th>";
						}
						echo $th;
						?>
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
