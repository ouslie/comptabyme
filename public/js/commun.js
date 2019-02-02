/**
 *  highlightRow and highlight are used to show a visual feedback. If the row has been successfully modified, it will be highlighted in green. Otherwise, in red
 */
function highlightRow(rowId, bgColor, after) {
    var rowSelector = $("#" + rowId);
    rowSelector.css("background-color", bgColor);
    rowSelector.fadeTo("normal", 0.5, function () {
        rowSelector.fadeTo("fast", 1, function () {
            rowSelector.css("background-color", '');
        });
    });
}

function highlight(div_id, style) {
    highlightRow(div_id, style == "error" ? "#e5afaf" : style == "warning" ? "#ffcc00" : "#8dc70a");
}



function message(type, message) {
    if (type == "error") {
        type = "danger"
    } else {
        type = "success"
    }
    $('#message').html("<div class=\"alert alert-" + type + "\" role=\"alert\">" + message + "</div>").slideDown('normal').delay(1800).slideToggle('slow');
}

DatabaseGrid.prototype.initializeGrid = function (grid) {

    var self = this;

    // render for the action column
    grid.setCellRenderer("action", new CellRenderer({
        render: function (cell, id) {
            cell.innerHTML += "<i onclick=\"datagrid.deleteRow(" + id + ");\" class='fa fa-trash red' ></i>";
        }
    }));
    grid.setCellRenderer("edit", new CellRenderer({
        render: function (cell, id) {
            cell.innerHTML += "<a style='margin:0px 10px 0px 10px' href=index.php?module=items&action=list&id_fact="+id+" class='fas fa-edit'></i></a>";
            cell.innerHTML += "<a style='margin:0px 10px 0px 10px' href=facture.php?id_fact="+id+" <i class='far fa-file-pdf' ></i></a>";
            cell.innerHTML += "<i style='margin:0px 10px 0px 10px' onclick=\"datagrid.deleteRow(" + id + ");\" class='fa fa-trash red' ></i>";
            cell.innerHTML += "<a style='margin:0px 10px 0px 10px'  href=index.php?module=factures&action=generate&id_fact="+id+ "  class='fas fa-cog red' ></i></a>";

        }
    }));
    grid.setCellRenderer("amount", new CellRenderer({
        render: function (cell, id) {
            if (id >= 0) {
                cell.innerHTML += "<p class='text-success'> " + id + "  </p>";
            } else {
                cell.innerHTML += "<p class='text-danger'> " + id + "  </p>";

            }

        }
    }));

    grid.renderGrid("tablecontent", "table table-hover table-striped table-bordered first");

};

function updatePaginator(grid, divId) {
    divId = divId || "paginator";
    var paginator = $("#" + divId).empty();
    var nbPages = grid.getPageCount();

    // get interval
    var interval = grid.getSlidingPageInterval(20);
    if (interval == null) return;

    // get pages in interval (with links except for the current page)
    var pages = grid.getPagesInInterval(interval, function (pageIndex, isCurrent) {
        if (isCurrent) return "<span id='currentpageindex'>" + (pageIndex + 1) + "</span>";
        return $("<a>").css("cursor", "pointer").html(pageIndex + 1).click(function (event) {
            grid.setPageIndex(parseInt($(this).html()) - 1);
        });
    });

    // "first" link
    var link = $("<a class='nobg'>").html("<i class='fa fa-fast-backward'></i>");
    if (!grid.canGoBack()) link.css({
        opacity: 0.4,
        filter: "alpha(opacity=40)"
    });
    else link.css("cursor", "pointer").click(function (event) {
        grid.firstPage();
    });
    paginator.append(link);

    // "prev" link
    link = $("<a class='nobg'>").html("<i class='fa fa-backward'></i>");
    if (!grid.canGoBack()) link.css({
        opacity: 0.4,
        filter: "alpha(opacity=40)"
    });
    else link.css("cursor", "pointer").click(function (event) {
        grid.prevPage();
    });
    paginator.append(link);

    // pages
    for (p = 0; p < pages.length; p++) paginator.append(pages[p]).append(" ");

    // "next" link
    link = $("<a class='nobg'>").html("<i class='fa fa-forward'>");
    if (!grid.canGoForward()) link.css({
        opacity: 0.4,
        filter: "alpha(opacity=40)"
    });
    else link.css("cursor", "pointer").click(function (event) {
        grid.nextPage();
    });
    paginator.append(link);

    // "last" link
    link = $("<a class='nobg'>").html("<i class='fa fa-fast-forward'>");
    if (!grid.canGoForward()) link.css({
        opacity: 0.4,
        filter: "alpha(opacity=40)"
    });
    else link.css("cursor", "pointer").click(function (event) {
        grid.lastPage();
    });
    paginator.append(link);
};


function showAddForm() {
    if ($("#addform").is(':visible'))
        $("#addform").hide();
    else
        $("#addform").show();
}