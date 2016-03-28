/**
 * Site : http:www.smarttutorials.net
 * @author muni
 */
	
//adds extra table rows
var i=$('.tableStatuate tr').length;
$(".addmore").on('click',function(){
	html = '<tr>';
	html += '<td><input class="case" type="checkbox"/></td>';
	html += '<td><input type="text" data-type="statuate" name="statuate[]" id="statuate_'+i+'" class="form-control autocomplete_process" autocomplete="off"></td>';
	html += '<td><input type="text" data-type="subsection" name="subsection[]" id="subsection_'+i+'" class="form-control autocomplete_process" autocomplete="off"></td>';
	html += '<td><input type="text" data-type="concept" name="concept[]" id="concept_'+i+'" class="form-control autocomplete_concept" autocomplete="off"  ondrop="return false;" onpaste="return false;"></td>';
	html += '</tr>';
	$('.tableStatuate').append(html);
	i++;
});


//adds extra table rows  	Type of Citation
var j=$('.tableCitation tr').length;
$(".typeAddmore").on('click',function(){
	html = '<tr>';
	html += '<td><input class="case_citation" type="checkbox"/></td>';
	html += '<td><select  class="form-control"  data-type="courtType" id="courtType_'+j+'" name="courtType[]"></select></td>';
	html += '<td><input type="text" data-type="citationNumber" name="citationNumber[]" id="citationNumber_'+j+'" class="form-control autocomplete_citation" autocomplete="off"></td>';
	html += '</tr>';
	$('.tableCitation').append(html);
	i++;
});

//to check all checkboxes
$(document).on('change','#check_all',function(){
	$('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
});

//deletes the selected table rows
$(".delete").on('click', function() {
	$('.case:checkbox:checked').parents("tr").remove();
	$('#check_all').prop("checked", false); 
});


//deletes the selected table rows
$(".typeDelete").on('click', function() {
	$('.case_citation:checkbox:checked').parents("tr").remove();
	$('#check_all').prop("checked", false); 
});





//It restrict the non-numbers
var specialKeys = new Array();
specialKeys.push(8,46); //Backspace
function IsNumeric(e) {
    var keyCode = e.which ? e.which : e.keyCode;
    console.log( keyCode );
    var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
    return ret;
}

//datepicker
$(function () {
    $('#quotationdate').datepicker({});
});

function frmvalidation()
{
	var name = $('#name').val();
	var contactno = $('#contactno').val();
	var address = $('#address').val();
	var retail_contact = $('#retail_contact').val();
	var mailid = $('#mailid').val();
	var tin = $('#tin').val();
	var cst = $('#cst').val();
	var salesperson = $('#salesperson').val();
	var term = $('#term').val();
	var refnumber = $('#refnumber').val();
	var quotationdate = $('#quotationdate').val();
	var itemName_1 = $('#itemName_1').val();
	var valid=true;
	
	var errorstr = '';
	
	if(name==''){
		valid = false;
		errorstr += "Enter valid name!"+ "<BR/>";
	}
	
	if(contactno==''){
		valid = false;
		errorstr += "Enter valid Customer Contact Number!"+ "<BR/>";
	}
	
	if(address==''){
		valid = false;
		errorstr += "Enter valid address!"+ "<BR/>";
	}
	
	if(retail_contact==''){
		valid = false;
		errorstr += "Enter valid retail contact!"+ "<BR/>";
	}
	
	if(mailid==''){
		valid = false;
		errorstr += "Enter valid mail ID!"+ "<BR/>";
	}
	
	if(tin==''){
		valid = false;
		errorstr += "Enter valid TIN!"+ "<BR/>";
	}
	
	if(cst==''){
		valid = false;
		errorstr += "Enter valid cst!"+ "<BR/>";
	}
	
	if(salesperson==''){
		valid = false;
		errorstr += "Enter valid sale person!"+ "<BR/>";
	}
	
	if(term==''){
		valid = false;
		errorstr += "Enter valid term and condition!"+ "<BR/>";
	}
	
	if(term==''){
		valid = false;
		errorstr += "Enter valid term and condition!"+ "<BR/>";
	}
	
	
	if(refnumber==''){
		valid = false;
		errorstr += "Enter valid reference number!"+ "<BR/>";
	}
	
	
	if(quotationdate==''){
		valid = false;
		errorstr += "Enter valid Quotation Date!"+ "<BR/>";
	}
	
	if(itemName_1==''){
		valid = false;
		errorstr += "Enter valid Description"+ "<BR/>";
	}
	
	if(!valid)
	{
		alert(errorstr);
	}
	
	return valid;
	
}