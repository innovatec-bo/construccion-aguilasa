<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 24/04/2018
 * Time: 4:12 PM
 */
?>
<script id="ht-error-message" type="text/x-handlebars-template">
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{message}}
    </div>
</script>
<script id="ht-success-message" type="text/x-handlebars-template">
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{message}}
    </div>
</script>
<script id="ht-alert-message" type="text/x-handlebars-template">
    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{message}}
    </div>
</script>
<script id="ht-info-message" type="text/x-handlebars-template">
    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{message}}
    </div>
</script>