$(document).ready(function() {
	window.print();
	// printView();
});

function printView()
{
	let printContents = $("#invoice-template").html();
	if(printContents !== undefined)
	{
		let originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
	}
}
