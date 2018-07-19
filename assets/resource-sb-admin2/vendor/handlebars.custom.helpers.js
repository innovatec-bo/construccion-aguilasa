    Handlebars.registerHelper('ifCond', function (v1, operator, v2, options) {

        switch (operator) {
            case '==':
                return (v1 == v2) ? options.fn(this) : options.inverse(this);
            case '===':
                return (v1 === v2) ? options.fn(this) : options.inverse(this);
            case '!=':
                return (v1 != v2) ? options.fn(this) : options.inverse(this);
            case '!==':
                return (v1 !== v2) ? options.fn(this) : options.inverse(this);
            case '<':
                return (v1 < v2) ? options.fn(this) : options.inverse(this);
            case '<=':
                return (v1 <= v2) ? options.fn(this) : options.inverse(this);
            case '>':
                return (v1 > v2) ? options.fn(this) : options.inverse(this);
            case '>=':
                return (v1 >= v2) ? options.fn(this) : options.inverse(this);
            case '&&':
                return (v1 && v2) ? options.fn(this) : options.inverse(this);
            case '||':
                return (v1 || v2) ? options.fn(this) : options.inverse(this);
            default:
                return options.inverse(this);
        }
    });
    Handlebars.registerHelper('each', function(context, options) {
        var out = "", data;

        if (options.data) {
            data = Handlebars.createFrame(options.data);
        }

        for (var i=0; i<context.length; i++) {
            if (data) {
                data.index = i;
            }

            out += options.fn(context[i], { data: data });
        }
        return out;
    });
    Handlebars.registerHelper('toLowerCase', function (str) {
        if(str && typeof str === "string") {
            return str.toLowerCase();
        }
        return '';
    });
    Handlebars.registerHelper('var',function(name, value, context){
        this[name] = value;
    });
    Handlebars.registerHelper('listSelectOptions', function(items, defaultValue) {
        var out = "";
        var selected = '';
        for(var i=0, l=items.length; i<l; i++) {
            selected = defaultValue != undefined && defaultValue.toLowerCase() == items[i].toLowerCase()?' selected ': '';
            out = out + "<option "+selected+" >" + items[i] + "</option>";
        }

        return out;
    });
    // Handlebars.registerHelper("switch", function(value, options) {
    //     this._switch_value_ = value;
    //     var html = options.fn(this); // Process the body of the switch block
    //     delete this._switch_value_;
    //     return html;
    // });
    // Handlebars.registerHelper("case", function(value, options) {
    //     if (value == this._switch_value_) {
    //         return options.fn(this);
    //     }
    // });
    Handlebars.registerHelper("switch", function(value, options) {
        this._switch_value_ = value;
        var html = options.fn(this); // Process the body of the switch block
        delete this._switch_value_;
        return html;
    });

    Handlebars.registerHelper("case", function() {
        // Convert "arguments" to a real array - stackoverflow.com/a/4775938
        var args = Array.prototype.slice.call(arguments);

        var options    = args.pop();
        var caseValues = args;

        if (caseValues.indexOf(this._switch_value_) === -1) {
            return '';
        } else {
            return options.fn(this);
        }
    });

    Handlebars.registerHelper("striptags", function( input ){
        var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
            commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;

        return input.replace(commentsAndPhpTags, "").replace(tags, "").replace("&nbsp;","");
    });
    Handlebars.registerHelper('var',function(name, value, context){
        this[name] = value;
    });
    Handlebars.registerHelper('formatDate', function (datetime, format) {
        var DateFormats = {
            short: "DD-MM-YYYY",
            long: "dddd DD.MM.YYYY HH:mm"
        };
        if (moment) {
            // can use other formats like 'lll' too
            format = DateFormats[format] || format;
            return moment(datetime).format(format);
        }
        else {
            return datetime;
        }
    });