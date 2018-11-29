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

    Handlebars.registerHelper('numberFormat', function (value, options) {
        // Helper parameters
        var dl = options.hash['decimalLength'] || 2;
        var ts = options.hash['thousandsSep'] || ',';
        var ds = options.hash['decimalSep'] || '.';

        // Parse to float
        var value = parseFloat(value);

        // The regex
        var re = '\\d(?=(\\d{3})+' + (dl > 0 ? '\\D' : '$') + ')';

        // Formats the number with the decimals
        var num = value.toFixed(Math.max(0, ~~dl));

        // Returns the formatted number
        return (ds ? num.replace('.', ds) : num).replace(new RegExp(re, 'g'), '$&' + ts);
    });

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

    Handlebars.registerHelper('time_ago',function(dateParam, context){
        if (!dateParam) {
            return null;
        }

        const date = typeof dateParam === 'object' ? dateParam : new Date(dateParam);
        const DAY_IN_MS = 86400000; // 24 * 60 * 60 * 1000
        const today = new Date();
        const yesterday = new Date(today - DAY_IN_MS);
        const seconds = Math.round((today - date) / 1000);
        const minutes = Math.round(seconds / 60);
        const isToday = today.toDateString() === date.toDateString();
        const isYesterday = yesterday.toDateString() === date.toDateString();
        const isThisYear = today.getFullYear() === date.getFullYear();


        if (seconds < 5) {
            return 'now';
        } else if (seconds < 60) {
            return `${ seconds } seconds ago`;
        } else if (seconds < 90) {
            return 'about a minute ago';
        } else if (minutes < 60) {
            return `${ minutes } minutes ago`;
        } else if (isToday) {
            return getFormattedDate(date, 'Today'); // Today at 10:20
        } else if (isYesterday) {
            return getFormattedDate(date, 'Yesterday'); // Yesterday at 10:20
        } else if (isThisYear) {
            return getFormattedDate(date, false, true); // 10. January at 10:20
        }

        return getFormattedDate(date); // 10. January 2017. at 10:20
    });

    //Additional functions
    const MONTH_NAMES = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];
    function getFormattedDate(date, prefomattedDate = false, hideYear = false) {
        const day = date.getDate();
        const month = MONTH_NAMES[date.getMonth()];
        const year = date.getFullYear();
        const hours = date.getHours();
        let minutes = date.getMinutes();

        if (minutes < 10) {
            // Adding leading zero to minutes
            minutes = `0${ minutes }`;
        }

        if (prefomattedDate) {
            // Today at 10:20
            // Yesterday at 10:20
            return `${ prefomattedDate } at ${ hours }:${ minutes }`;
        }

        if (hideYear) {
            // 10. January at 10:20
            return `${ day }. ${ month } at ${ hours }:${ minutes }`;
        }

        // 10. January 2017. at 10:20
        return `${ day }. ${ month } ${ year }. at ${ hours }:${ minutes }`;
    }

    Handlebars.registerHelper('netBuildingListener', function (value, options) {
        // Helper parameters
        var dl = options.hash['rowKey'] || "";

        var response = '<th>{{criteria}}</th>\n' +
        '<td class="text-center"><a href="#" class="find-th">{{january}}</a></td>\n' +
        '<td class="text-center"><a href="#" class="find-th">{{february}}</a></td>\n' +
        '<td class="text-center"><a href="#" class="find-th">{{march}}</a></td>\n' +
        '<td class="text-center"><a href="#" class="find-th">{{april}}</a></td>\n' +
        '<td class="text-center"><a href="#" class="find-th">{{may}}</a></td>\n' +
        '<td class="text-center"><a href="#" class="find-th">{{june}}</a></td>\n' +
        '<td class="text-center"><a href="#" class="find-th">{{july}}</a></td>\n' +
        '<td class="text-center"><a href="#" class="find-th">{{august}}</a></td>\n' +
        '<td class="text-center"><a href="#" class="find-th">{{september}}</a></td>\n' +
        '<td class="text-center"><a href="#" class="find-th">{{october}}</a></td>\n' +
        '<td class="text-center"><a href="#" class="find-th">{{november}}</a></td>\n' +
        '<td class="text-center"><a href="#" class="find-th">{{december}}</a></td>\n' +
        '<td class="text-center">{{total}}</td>';

        return response;
    });