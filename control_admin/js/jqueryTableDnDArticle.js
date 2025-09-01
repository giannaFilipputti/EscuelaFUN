$(document).ready(function() {
	// Initialise the first table (as before)
	
	$('#table-5').tableDnD({
        onDrop: function(table, row) {
            //alert($('#table-5').tableDnDSerialize());
			//$('#AjaxResult').load("ordentest.php?"+$.tableDnD.serialize());
			$('#AjaxResult').load("/control/ordentest.php?"+$.tableDnD.serialize());
        },
        dragHandle: "dragHandle"
    });

    $("#table-5 tr").hover(function() {
          $(this.cells[0]).addClass('showDragHandle');
    }, function() {
          $(this.cells[0]).removeClass('showDragHandle');
    });
    
});
