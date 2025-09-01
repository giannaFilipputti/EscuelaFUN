$('#table-6').tableDnD({
        onDrop: function(table, row) {
            //alert($('#table-6').tableDnDSerialize());
			//$('#AjaxResult').load("ordentest.php?"+$.tableDnD.serialize());
			$('#AjaxResult').load("<?php echo $baseURLcontrol;?>orden_cont.php?id=<?=$id?>&"+$.tableDnD.serialize());
        },
        dragHandle: "dragHandle"
    });

    $("#table-6 tr").hover(function() {
          $(this.cells[0]).addClass('showDragHandle');
    }, function() {
          $(this.cells[0]).removeClass('showDragHandle');
    });