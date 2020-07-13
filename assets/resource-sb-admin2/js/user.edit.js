/**
 * Created by Jair on 10/01/2018.
 */

$(document).ready(function() {
	$(".input-masked").inputmask('decimal',{min:0, max:999999, groupSeparator: ',', autoGroup: true});
});
