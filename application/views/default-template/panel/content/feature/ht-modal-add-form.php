<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 6/5/2018
 * Time: 21:06
 */
?>
<script id="ht-modal-add-form" type="text/x-handlebars-template">
    <form role="form" name="modal-feature-add-form" method="post" data-parsley-validate>
        <input type="hidden" name="feature-id" value="">
        <input type="hidden" name="feature-parent-id" value="{{parentId}}">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Name</label>
                    <input class="form-control" name="feature-name" value="" placeholder="Name" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Security string</label>
                    <input class="form-control" name="feature-security-string" value="" placeholder="Enter text" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Icon</label>
                    <input class="form-control" name="feature-icon" value="" placeholder="Enter text">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Link</label>
                    <input class="form-control" name="feature-link" value="" placeholder="Enter text" required>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Description</label>
                    <input class="form-control" name="feature-description" value="" placeholder="Enter text">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Is visible menu</label>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="is-visible-menu">Yes
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </form>
</script>