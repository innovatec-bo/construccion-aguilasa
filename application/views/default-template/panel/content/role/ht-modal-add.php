<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 6/5/2018
 * Time: 21:06
 */
?>
<script id="ht-modal-add-form" type="text/x-handlebars-template">
    <form role="form" name="modal-role-add-form" method="post" data-parsley-validate>
        <input type="hidden" name="role-id" value="">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Role name</label>
                    <input class="form-control" name="role-name" value="" placeholder="Enter role name" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Role keyword</label>
                    <input class="form-control" name="role-keyword" value="" placeholder="Enter keyword" required>
                </div>
            </div>
        </div>
    </form>
</script>
