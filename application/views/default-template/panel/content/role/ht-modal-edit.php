<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 6/5/2018
 * Time: 21:06
 */
?>
<script id="ht-modal-edit-form" type="text/x-handlebars-template">
    <form role="form" name="modal-role-edit-form" method="post" data-parsley-validate>
        <input type="hidden" name="role-id" value="{{role.roleId}}">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Role name</label>
                    <input class="form-control" name="role-name" value="{{role.roleName}}" placeholder="Enter role name" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Role keyword</label>
                    <p class="form-control-static">{{role.keyword}}</p>
                </div>
            </div>
        </div>
    </form>
</script>
