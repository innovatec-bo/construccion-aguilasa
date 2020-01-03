<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 06/06/2018
 * Time: 10:23 AM
 */
?>
<div class="container-fluid box-shadow-2">
    <div class="row" id="status-management-content">

    </div>
    <!-- /.row -->
</div>
<script id="ht-image-slide" type="text/x-handlebars-template">    
    <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
        <a href="{{base_url}}{{fileUrl}}" itemprop="contentUrl" data-size="1000x1000"  title="{{fileName}}">
            <img src="{{base_url}}{{fileUrl}}" itemprop="thumbnail" alt="{{fileName}}" />
        </a>
        <figcaption itemprop="caption description">{{fileName}}</figcaption>
    </figure>
</script>
<script id="ht-document-slide" type="text/x-handlebars-template">    
    <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
        <a href="{{base_url}}{{fileUrl}}" target="_blank" title="{{fileName}}">
            <img src="{{base_url}}assets/images/pdf-icon.png" itemprop="thumbnail" alt="{{fileName}}" />
        </a>
        <figcaption itemprop="caption description">{{fileName}}</figcaption>
    </figure>
</script>
<!-- /.container-fluid -->
<?php
	$this->load->view("default-template/panel/content/project-status/ht-modal-modify-log");
?>