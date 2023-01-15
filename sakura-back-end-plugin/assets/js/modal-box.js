// Get the modal
var addModal = document.getElementById("addModal");
var editTableModal = document.getElementById("editTableModal");

// Get the button that opens the modal
var addButton = document.getElementById("addButton");
var editTableButton = document.getElementById("editTableButton");

if (addButton != null) {
  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];

  // When the user clicks on the button, open the modal
  addButton.onclick = function () {
    addModal.style.display = "block";
  };

  // When the user clicks on <span> (x), close the modal
  span.onclick = function () {
    addModal.style.display = "none";
  };

  // When the user clicks anywhere outside of the modal, close it
  // window.onclick = function (event) {
  //   if (event.target == addModal) {
  //     addModal.style.display = "none";
  //   }
  // };
}

if (editTableButton != null) {
  var editTableSpan = document.getElementsByClassName("close")[0];

  editTableButton.onclick = function () {
    editTableModal.style.display = "block";
  };

  editTableSpan.onclick = function () {
    editTableModal.style.display = "none";
  };

  // window.onclick = function (event) {
  //   if (event.target == editTableModal) {
  //     editTableModal.style.display = "none";
  //   }
  // };
}
