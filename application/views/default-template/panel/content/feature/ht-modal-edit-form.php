<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 6/5/2018
 * Time: 21:06
 */
?>
<script id="ht-modal-edit-form" type="text/x-handlebars-template">
    <form role="form" name="modal-feature-edit-form" method="post" data-parsley-validate>
        <input type="hidden" name="feature-id" value="{{feature.id_fes}}">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Name</label>
                    <input class="form-control" name="feature-name" value="{{feature.featurename_fes}}" placeholder="Name" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Security string</label>
                    <input class="form-control" name="feature-security-string" value="{{feature.securitystring_fes}}" placeholder="Enter text" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Icon</label>
                    <input class="form-control" name="feature-icon" value="{{feature.featureicon_fes}}" placeholder="Enter text">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Link</label>
                    <input class="form-control" name="feature-link" value="{{feature.link_fes}}" placeholder="Enter text" required>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Description</label>
                    <input class="form-control" name="feature-description" value="{{feature.description_fes}}" placeholder="Enter text">
                </div>
            </div>
        </div>
    </form>
</script>
