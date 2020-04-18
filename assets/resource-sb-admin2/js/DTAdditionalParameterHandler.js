/**
 * Created by Jair on 20/10/2017.
 */

function DTAdditionalParameterHandler(objectContent, table) {

    var id = Date.now();
    var parameterList = [];
    var content = $(objectContent);
    var jsonAdditionalRequest = {};
    var selectorButtonFilter = {};
    var selectorButtonRest = {};
    var clearAdditionalParameters = false;
    var tableSelector = table;

    this.addParameterObject = function(name, type)
    {
        //let's fill out parameter list
        parameterList.push({name:name,type:type});
    };

    this.setValuesToParameters = function()
    {
        var $content = content;
        jsonAdditionalRequest  = {};
        if(!clearAdditionalParameters)
        {
            $.each(parameterList,function(index,parameter){
                var value = "";
                switch(parameter.type)
                {
                    case "text":
                        value = $content.find("input[name="+parameter.name+"]").val();
                        break;
                    case "radio":
                        value = $content.find("input[name="+parameter.name+"]:checked").val();
                        break;
                    case "checkbox":
                        value = $content.find("input[name="+parameter.name+"]").is(":checked");
                        value = value?"1":"";
                        break;
                    case "select":
                        value = $content.find("select[name="+parameter.name+"] option:selected").val();
                        break;
                }
                parameter.value = value;
                if(parameter.value != "")
                    jsonAdditionalRequest[parameter.name] = parameter.value;
            });
        }
    };

    this.setButtonFilter = function(selector)
    {
        selectorButtonFilter = selector;
    };

    this.setButtonRest = function(selector)
    {
        selectorButtonRest = selector;
    };

    this.getList = function()
    {
        this.setValuesToParameters();
        return jsonAdditionalRequest;
    };

    this.loadEventHandlers = function()
    {
        var $content = content;

        $content.on("click",selectorButtonFilter,function(){
            clearAdditionalParameters = false;
            if($(tableSelector).length > 0)
                $(tableSelector).DataTable().ajax.reload();

            if($('#pagination-content').length > 0)
                $('#pagination-content').pagination('go', 1);
        });

        $content.on("click",selectorButtonRest,function(){
            clearAdditionalParameters = true;
            if($(tableSelector).length > 0)
                $(tableSelector).DataTable().ajax.reload();
            if($('#pagination-content').length > 0)
                $('#pagination-content').pagination('go', 1);
            $("#extra-request-data")[0].reset();
        });
    };
}