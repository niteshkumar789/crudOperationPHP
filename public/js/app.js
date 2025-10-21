$(document).ready(function() {

  // Tracks current operation to control table rendering (e.g., delete mode)
  let currentOperation = null;

  // Load table initially
  function loadTable() {
    $.ajax({
      url: "operations/fetch.php" + (currentOperation === 'delete' ? '?mode=delete' : ''),
      type: "GET",
      success: function(data) {
        $("#tableArea").html(data);
      }
    });
  }

  loadTable(); // initial table load

  // Show form when Go is clicked
  $("#goBtn").on("click", function() {
    const operation = $("#operation").val();
    $.ajax({
      url: `operations/${operation}.php`,
      type: "GET",
      success: function(res) {
        $("#operationArea").html(res); // show form or controls
        // Set current operation and refresh table to reflect mode (e.g., show checkboxes in delete)
        currentOperation = operation;
        loadTable();
      }
    });
  });

  // Show success message (non-blocking)
  function showMessage(msg) {
    const messageDiv = $('<div class="message">'+msg+'</div>');
    $("#operationArea").prepend(messageDiv);
    setTimeout(() => { messageDiv.fadeOut(500, () => messageDiv.remove()); }, 3000);
  }

  // Handle form submissions dynamically
  $(document).on("submit", "#insertForm, #updateForm, #deleteForm", function(e) {
    e.preventDefault();
    const form = $(this);
    $.post(form.attr("action") || `operations/${form.attr("id").replace("Form","")}.php`, form.serialize(), function(res) {
      showMessage(res);        // show message
      $("#operationArea").html(''); // remove form
      currentOperation = null; // reset mode after operation
      loadTable();             // update table in-place
    });
  });

  // Bulk delete: handle click on Delete Selected button (available in delete mode UI)
  $(document).on('click', '#bulkDeleteBtn', function() {
    const ids = $("#tableArea input.rowCheckbox:checked").map(function(){
      return $(this).data('id');
    }).get();

    if (ids.length === 0) {
      showMessage('Please select at least one record to delete.');
      return;
    }

    const btn = $(this);
    btn.prop('disabled', true).text('Deleting...');
    $.post('operations/delete.php', { IDS: ids }, function(res) {
      showMessage(res);
      $("#operationArea").html('');
      currentOperation = null; // exit delete mode after action
      loadTable();
    }).always(function(){
      btn.prop('disabled', false).text('Delete Selected');
    });
  });

  // Select/Deselect all checkboxes in delete mode
  $(document).on('change', '#selectAll', function() {
    const checked = $(this).is(':checked');
    $("#tableArea input.rowCheckbox").prop('checked', checked);
  });

  // Keep selectAll in sync when individual checkboxes change
  $(document).on('change', '#tableArea input.rowCheckbox', function() {
    const total = $("#tableArea input.rowCheckbox").length;
    const checked = $("#tableArea input.rowCheckbox:checked").length;
    $("#selectAll").prop('checked', total > 0 && checked === total);
    if (!$(this).is(':checked')) {
      $("#selectAll").prop('indeterminate', checked > 0 && checked < total);
    } else {
      $("#selectAll").prop('indeterminate', checked > 0 && checked < total);
    }
  });

});
