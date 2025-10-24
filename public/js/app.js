$(document).ready(function () {
  // 🔹 Utility: show animated message (success or error)
  function showToast(message, type = "success") {
    const color = type === "success" ? "#4CAF50" : "#f44336";
    const toast = $(`
      <div class="toast-message" 
           style="position:fixed; top:20px; right:20px; background:${color};
                  color:white; padding:12px 20px; border-radius:8px;
                  box-shadow:0 3px 6px rgba(0,0,0,0.2); z-index:9999;
                  opacity:0; transform:translateY(-10px); transition:all 0.3s;">
        ${message}
      </div>
    `);
    $("body").append(toast);
    setTimeout(() => toast.css({ opacity: 1, transform: "translateY(0)" }), 10);
    setTimeout(() => {
      toast.css({ opacity: 0, transform: "translateY(-10px)" });
      setTimeout(() => toast.remove(), 500);
    }, 3000);
  }

  // 🔹 Load employee table
  function loadTable() {
    $.ajax({
      url: "operations/fetch.php",
      type: "GET",
      cache: false,
      success: function (data) {
        $("#tableArea").html(data);
      },
      error: function () {
        showToast("Failed to load employee table.", "error");
      },
    });
  }

  loadTable(); // Initial load

  // 🔹 Load insert/update form dynamically
  $("#goBtn").on("click", function () {
    const operation = $("#operation").val();
    $.ajax({
      url: `operations/${operation}.php`,
      type: "GET",
      success: function (res) {
        $("#operationArea").html(res);
      },
      error: function () {
        showToast("Error loading form.", "error");
      },
    });
  });

  // Handle insert & update
  $(document).on("submit", "#insertForm, #updateForm", function (e) {
      e.preventDefault();
      const form = $(this);
      const formData = new FormData(this);

      $.ajax({
          url: form.attr("action") || `operations/${form.attr("id").replace("Form", "")}.php`,
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          success: function (res) {
              showToast(res, "success");
              $("#operationArea").html("");
              loadTable();
          },
          error: function () {
              showToast("Operation failed.", "error");
          },
      });
  });

  // Preview for insert photo
  $(document).on("change", "#insertPhoto", function () {
      const file = this.files[0];
      if (file) {
          const reader = new FileReader();
          reader.onload = function (e) {
              $("#insertPreview").attr("src", e.target.result).show();
          };
          reader.readAsDataURL(file);
      }
  });

  // Preview for update photo
  $(document).on("change", "#updatePhoto", function () {
      const file = this.files[0];
      if (file) {
          const reader = new FileReader();
          reader.onload = function (e) {
              $("#updatePreview").attr("src", e.target.result).show();
          };
          reader.readAsDataURL(file);
      }
  });

  // Row-level Edit button
  $(document).on("click", ".editBtn", function () {
      const id = $(this).data("id");

      $.ajax({
          url: "operations/fetch_single.php",
          type: "GET",
          data: { id: id },
          success: function (res) {
              $("#operationArea").html(res);
          },
          error: function () {
              showToast("Failed to load employee data.", "error");
          }
      });
  });


  // Handle multiple delete
  $(document).on("submit", "#multiDeleteForm", function (e) {
    e.preventDefault();

    const selected = $(".recordCheckbox:checked");
    if (selected.length === 0) {
      showToast("Please select at least one record.", "error");
      return;
    }

    if (!confirm("Are you sure you want to delete selected records?")) return;

    const ids = selected
      .map(function () {
        return $(this).val();
      })
      .get();

    $.ajax({ 
      url: "operations/delete_multiple.php",
      type: "POST",
      data: { ids: ids },
      traditional: true,
      success: function (response) {
        showToast(response, "success");
        loadTable();
      },
      error: function () {
        showToast("Error deleting records.", "error");
      },
    });
  });

  // 🔹 Handle Select All checkbox
  $(document).on("click", "#selectAll", function () {
    $(".recordCheckbox").prop("checked", this.checked);
  });
});
