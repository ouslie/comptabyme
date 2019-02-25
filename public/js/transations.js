function updateCellValue(editableGrid, rowIndex, columnIndex, oldValue, newValue, row, onResponse) {
	$.ajax({
		url: 'index.php?module=transactions&action=update',
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
	this.editableGrid = new EditableGrid("transactions", {
		enableSort: true,
		serverSide: true,
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
	this.editableGrid.loadJSON('index.php?module=transactions&action=loaddata');
};

DatabaseGrid.prototype.deleteRow = function (id) {

	var self = this;

	if (confirm('Voulez vous bien suprimer la transaction ' + id)) {

		$.ajax({
			url: 'index.php?module=transactions&action=delete',
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
		url: 'index.php?module=transactions&action=add',
		type: 'POST',
		dataType: "html",
		data: {
			tablename: self.editableGrid.name,
			third: $("#third").val(),
			comment: $("#comment").val(),
			id_category: $("#id_category").val(),
			id_bank: $("#id_bank").val(),
			id_type: $("#id_type").val(),
			amount: $("#amount").val(),
			date: $("#date").val(),
			id_contrat: $("#id_contrat").val(),
			tally: $("#tally").is(':checked') ? 1 : 0
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


DatabaseGrid.prototype.addRowInternal = function (id) {

	var self = this;

	$.ajax({
		url: 'index.php?module=transactions&action=add&category=internal',
		type: 'POST',
		dataType: "html",
		data: {
			tablename: self.editableGrid.name,
			id_bank_recette: $("#id_bank_recette").val(),
			id_bank_depense: $("#id_bank_depense").val(),
			amountinternal: $("#amountinternal").val(),
			dateinternal: $("#dateinternal").val(),
			tallyinternal: $("#tallyinternal").is(':checked') ? 1 : 0
		},
		success: function (response) {
			if (response == "ok") {
				message("success", "Transaction interne ajouté");
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