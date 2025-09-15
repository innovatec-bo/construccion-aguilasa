/**
 * Created by Jair on 10/01/2018.
 */

$(document).ready(function() {

    var buttonAdd = {
        text: "Add",
        action: function ( e, dt, node, config ) {
            window.location.href = base_url + "panel/Contract/add";
        }
    };
    //Horizontal Icons dataTable
    var oTable = $('#contract-index').dataTable({
        "processing" : true,
        "serverSide" : true,
        "ajax" : {
            url : base_url + 'panel/AjaxContract/ajaxDtAllContracts',
            type : 'POST'
        },
        "language": {
                processing: '<h1><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></h1>'
        },
        "dom": "<'row'<'col-sm-6'Bl><'col-sm-6 text-right'f>>rt<'row'<'col-sm-6'i><'col-sm-6 text-right'p>>",
        "lengthMenu": [ [10, 25, 50, 100, 100000], [10, 25, 50,100, 100000] ],
        columnDefs: [
            { className: 'text-right', targets: [2,5] },
            { className: 'text-center', targets: [1,3,4] }
        ],
        "columns" : [{
            "data" : "id_con"
        }, {
            "data" : "contract_number_con"
        }, {
            "data" : "amount_con",
            "render":function(data, type, row, meta){
                return row.amount_con.replace(/\d(?=(\d{3})+\.)/g, '$&,');
            }
        }, {
            "data" : "active",
            "render":function(data, type, row, meta){
                return row.active==1?'Si':'No';
            }
        }, {
            "data" : "expiration_date_con",
            "render" : function(data, type, row, meta) {
                var result = "";
                if(row.expiration_date_con !== "" && row.expiration_date_con !== null)
                {
                    var dateObject = new Date(row.expiration_date_con);
                    var date = dateObject.getDate() < 10? "0"+dateObject.getDate():dateObject.getDate();
                    var month = (dateObject.getMonth()+1) < 10? "0"+(dateObject.getMonth()+1):(dateObject.getMonth()+1);
                    var year = dateObject.getFullYear();
                    result = date+"-"+month+"-"+year;
                }
                return result;
            }
        }, {
            "data" : "umbo"
        }, {
            "defaultContent" : " ",
            "searchable" : false,
            "orderable" : false,
            "render" : function(data, type, row, meta) {
                var html = ' <a target="_blank" href="'+base_url+'panel/Contract/edit/'+row.id_con+'" class="btn btn-primary btn-xs" data-role-id="'+row.id_con+'" title="" data-original-title="EDIT"  data-toggle="tooltip" data-placement="top"><i class="fa fa-pencil"></i></a> ';
                    // html += ' <a class="btn btn-danger btn-xs datatable-delete-button" data-object-id="'+row.id_con+'" data-url= "'+base_url+'panel/Role/delete/'+row.id_rol+'" title="" data-original-title="DELETE"  data-toggle="tooltip" data-placement="top"><i class="fa fa-times"></i></a> ';
                return html;
            }
        }],
        "drawCallback" : function(object) {
            $('[data-toggle="tooltip"]').tooltip();
            this.api().column(0).visible(false);
        },
        "buttons": ['excel', 'csv','pdf','print',buttonAdd]
    });
    $('.dataTables_filter input').addClass('form-control').attr('placeholder', 'Search');
    $('.dataTables_length select').addClass('form-control');
    oTable.fnSetFilteringDelay(1000);
});