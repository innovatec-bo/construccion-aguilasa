$(document).ready(function() {
    startSelect2Materials('select.select2-materials','');

    $('.iw-add-row').on('click',function(){
        _addRow();
    });
    $(document).on('click','.iw-quit-row',function(){
       _quitRow(this);
    });
});

function _addRow()
{
    let rowData = $('.select2-materials').select2('data')[0];
    console.log(rowData);
    //Search summary from next array by code added to table
    
    let htmlSource   = $('#table-row').html();
    let template = Handlebars.compile(htmlSource);
    let data = {data:rowData, rowId: Date.now()};
    let html = template(data);

    //Add new row: let's get the last row to append the new row after it
    $('#table-body').append(html);
    $(".input-masked").inputmask();

}

function _quitRow(btn)
{
    $(btn).closest('tr').remove();
}