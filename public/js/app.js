$(document).ready(function() {

  // Load table initially
  function loadTable() {
    $.ajax({
      url: "operations/fetch.php",
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
        $("#operationArea").html(res); // show form
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
      loadTable();             // update table in-place
    });
  });

});
