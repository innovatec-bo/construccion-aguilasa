<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 23/10/2018
 * Time: 9:31
 */
?>
<script id="ht-report-executive-summary-and-current-status-summary" type="text/x-handlebars-template">
    <div class="col-md-6" id="current-status-summary-report">
        {{> ht-report-current-status-summary statusSummary = report.currentStatusSummary.data}}
    </div>
    <div class="col-md-6" id="executive-summary-report">
        {{> ht-report-executive-summary executiveSummary = report.executiveSummary}}
    </div>
</script>