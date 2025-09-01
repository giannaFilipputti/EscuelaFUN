$('#table-6').tableDnD({
        onDrop: function(table, row) {
            //alert($('#table-6').tableDnDSerialize());
			//$('#AjaxResult').load("ordentest.php?"+$.tableDnD.serialize());
			$('#AjaxResult').load("<?php echo $baseURLcontrol;?>orden_preg.php?ref=<?=$ref?>&id=<?=$id?>&"+$.tableDnD.serialize());
        },
        dragHandle: "dragHandle"
    });

    $("#table-6 tr").hover(function() {
          $(this.cells[0]).addClass('showDragHandle');
    }, function() {
          $(this.cells[0]).removeClass('showDragHandle');
    });