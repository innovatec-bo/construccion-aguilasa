$(document).ready(function() {
    var additionalParameter = new DTAdditionalParameterHandler("#extra-request-data","#material-summary-type");
    additionalParameter.addParameterObject('summary-id','text');
    additionalParameter.addParameterObject('fiscal-responsible','select');
    additionalParameter.addParameterObject('builder-responsible','select');
    additionalParameter.setButtonFilter('#send-filters');
    additionalParameter.setButtonRest('#remove-additional-parameters');
    additionalParameter.loadEventHandlers();
    
    //Horizontal Icons dataTable
    let type = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
    var oTable = $('#material-summary-type').dataTable({
        "processing" : true,
        "serverSide" : true,
        "ajax" : {
            url : base_url + 'panel/AjaxSummary/ajaxDtAllSummaries/'+type,
            type : 'POST',
            data:function ( data ) {
                data.additionalParameters = additionalParameter.getList();
            }
        },
        "language": {
                processing: '<h1><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></h1>'
        },
        "dom": "<'row'<'col-sm-6'Bl><'col-sm-6 text-right'f>>rt<'row'<'col-sm-6'i><'col-sm-6 text-right'p>>",
        "lengthMenu": [ [10, 25, 50, 100, 100000], [10, 25, 50,100, 100000] ],
        "columns" : [{
            "data" : "id_msu"
        }, {
            "data" : "material_summary_status"
        }, {
            "data" : "fiscal_full_name"
        }, {
            "data" : "builder_full_name"
        }, {
            "data" : "entry_date_msu",
            "render": function(data, type, row, meta){
                let date = moment(row.entry_date_msu,'YYYY-MM-DD HH:mm:ss');
                let result = "";
                if(date.isValid())
                {
                    result = date.format('DD-MM-YYYY HH:mm:ss');
                }
                return result;
            }
        }, {
            "defaultContent" : " ",
            "searchable" : false,
            "orderable" : false,
            "render" : function(data, type, row, meta) {
                var html = ' <a class="btn btn-primary btn-xs" href="'+base_url + 'panel/MaterialSummary/show/' +row.id_msu+'" target="_blank" title="" data-original-title="Ver"  data-toggle="tooltip" data-placement="top"><i class="fa fa-eye"></i></a>';
                return html;
            }
        }],
        "drawCallback" : function(object) {
            $('[data-toggle="tooltip"]').tooltip();
        },
        "buttons": [{
            extend: 'excel',
            title: $(".page-header").text(),
            footer: true,
            exportOptions: {
                 columns: [1,2,3,4,5]
             }
        }]
    });
    $('.dataTables_filter input').addClass('form-control').attr('placeholder', 'Search');
    $('.dataTables_length select').addClass('form-control');
    oTable.fnSetFilteringDelay(1000);
});
