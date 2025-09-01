$(document).ready(function(){
	$(".numerico").numeric();

	$(".bt_plus").each(function(el){$(this).bind("click",addField);
	});
	
	$("#frm_curso").change(function(){
		$.post("carga_select2.php",{ id:$(this).val() },function(data){$("#frm_modulo").html(data);})
	});
	
	 $(".datepicker").datepicker();
	
	});
	function addField(){
		var clickID=parseInt($(this).parent('div').attr('id').replace('div_',''));
		var newID=(clickID+1);
		$newClone=$('#div_'+clickID).clone(true);
		$newClone.attr("id",'div_'+newID);
		$newClone.children("input").eq(0).attr("id",'respuesta'+newID).val('');
		$newClone.children("input").eq(0).attr("name",'respuesta'+newID);
		$newClone.children("input").eq(1).removeAttr("checked");
		$newClone.children("input").eq(1).attr("name",'correcta'+newID);
		$newClone.children("input").eq(2).attr("id",newID);
		
		$newClone.children("input").eq(3).attr("name",'laid'+newID).val('');
		
		
$newClone.insertAfter($('#div_'+clickID));


$('#cant').attr("value",newID);

$("#"+clickID).val('-').unbind("click",addField);
$("#"+clickID).bind("click",delRow);}

function delRow(){$(this).parent('div').remove();}
