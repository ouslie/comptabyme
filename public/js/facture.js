/**
   updateCellValue calls the PHP script that will update the database. 
 */
function updateCellValue(editableGrid, rowIndex, columnIndex, oldValue, newValue, row, onResponse) {
	$.ajax({
		url: 'index.php?module=facture&action=update',
		type: 'POST',
		dataType: "html",
		data: {
			tablename: editableGrid.name,
			id: editableGrid.getRowId(rowIndex),
			newvalue: editableGrid.getColumnType(columnIndex) == "boolean" ? (newValue ? 1 : 0) : newValue,
			colname: editableGrid.getColumnName(columnIndex),
			coltype: editableGrid.getColumnType(columnIndex)
		},
		success: function (response) {
			// reset old value if failed then highlight row
			var success = onResponse ? onResponse(response) : (response == "ok" || !isNaN(parseInt(response))); // by default, a sucessfull reponse can be "ok" or a database id 
			if (!success) editableGrid.setValueAt(rowIndex, columnIndex, oldValue);
			highlight(row.id, success ? "ok" : "error");
		},
		error: function (XMLHttpRequest, textStatus, exception) {
			alert("Ajax failure\n" + errortext);
		},
		async: true
	});

}



function DatabaseGrid() {
	this.editableGrid = new EditableGrid("facture", {
		enableSort: true,


		/* Comment this line if you set serverSide to true */
		// define the number of row visible by page
		/*pageSize: 50,*/

		/* This property enables the serverSide part */
		serverSide: true,

		// Once the table is displayed, we update the paginator state
		tableRendered: function () {
			updatePaginator(this);
		},
		tableLoaded: function () {
			datagrid.initializeGrid(this);
		},
		modelChanged: function (rowIndex, columnIndex, oldValue, newValue, row) {
			updateCellValue(this, rowIndex, columnIndex, oldValue, newValue, row);
		}
	});
	this.fetchGrid();



	$("#filter").val(this.editableGrid.currentFilter != null ? this.editableGrid.currentFilter : "");
	if (this.editableGrid.currentFilter != null && this.editableGrid.currentFilter.length > 0)
		$("#filter").addClass('filterdefined');
	else
		$("#filter").removeClass('filterdefined');

}

DatabaseGrid.prototype.fetchGrid = function () {
	// call a PHP script to get the data
	this.editableGrid.loadJSON("module/facture/loaddata.php?db_tablename=facture");
};



DatabaseGrid.prototype.deleteRow = function (id) {

	var self = this;

	if (confirm('Voulez vous bien suprimer la transaction ' + id)) {

		$.ajax({
			url: 'index.php?module=facture&action=delete',
			type: 'POST',
			dataType: "html",
			data: {
				tablenamed: self.editableGrid.name,
				id: id
			},
			success: function (response) {
				if (response == "ok") {
					message("success", "Transaction supprimé");
					self.fetchGrid();
				}
			},
			error: function (XMLHttpRequest, textStatus, exception) {
				alert("Ajax failure\n" + errortext);
			},
			async: true
		});


	}

};


DatabaseGrid.prototype.addRow = function (id) {

	var self = this;

	$.ajax({
		url: 'index.php?module=facture&action=add',
		type: 'POST',
		dataType: "html",
		data: {
			tablename: self.editableGrid.name,
			name: $("#name").val(),
			solde: $("#solde").val()

		},
		success: function (response) {
			if (response == "ok") {
				message("success", "Transaction ajouté");
				self.fetchGrid();
			} else
				message("error", "Error occured");
		},
		error: function (XMLHttpRequest, textStatus, exception) {
			alert("Ajax failure\n" + errortext);
		},
		async: true
	});
};