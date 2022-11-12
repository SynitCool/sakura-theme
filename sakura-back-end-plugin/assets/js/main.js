function setDatabaseState(database_name) {
  setState("selected_database", database_name);
}

function setTableState(table_name) {
  setState("selected_table", table_name);
}

function activateEditMode(edit_mode) {
  if (edit_mode == "on") {
    setState("edit_mode", "off");
  }

  if (edit_mode == "off") {
    setState("edit_mode", "on");
  }
}

function setTempDatabaseState(database_name) {
  setTempState("temp_database", database_name);
}

function setTempTableState(table_name) {
  setTempState("temp_table", table_name);
}

function setState(key, value) {
  const date = new Date();
  date.setTime(date.getTime() + 86400 * 30);
  let expires = "expires=" + date.toUTCString();
  document.cookie = key + "=" + value + ";" + expires + ";path=/";

  location.reload();
}

function setTempState(key, value) {
  const date = new Date();
  date.setTime(date.getTime() + 86400);
  let expires = "expires=" + date.toUTCString();
  document.cookie = key + "=" + value + ";" + expires + ";path=/";

  location.reload();
}

function backButton() {
  let current_state = currentState();

  if (current_state == "database") {
    setState("selected_database", "no-selected");
  }

  if (current_state == "table") {
    setState("selected_database", "no-selected");
  }

  if (current_state == "column-row") {
    setState("selected_table", "no-selected");
  }
}

function refreshButton() {
  setState("selected_database", "no-selected");
  setState("selected_table", "no-selected");
}

function currentState() {
  let adminCookie = getAdminCookie();

  selected_database_value = adminCookie["selected_database"];
  selected_table_value = adminCookie["selected_table"];

  if (selected_database_value == "no-selected") {
    return "database";
  }

  if (
    selected_database_value != "no-selected" &&
    selected_table_value == "no-selected"
  ) {
    return "table";
  }

  if (
    selected_database_value != "no-selected" &&
    selected_table_value != "no-selected"
  ) {
    return "column-row";
  }
}

function getAdminCookie() {
  let adminCookie = {};

  let cookie = document.cookie;
  let decodedCookie = decodeURIComponent(cookie);
  let splitCookie = decodedCookie.split(";");

  for (let i = 0; i < splitCookie.length; i++) {
    let currentCookie = splitCookie[i];
    let splitCurrentCookie = currentCookie.split("=");

    let cookieKey = splitCurrentCookie[0].trim();
    let cookieValue = splitCurrentCookie[1].trim();

    if (cookieKey == "selected_database" || cookieKey == "selected_table") {
      adminCookie[cookieKey] = cookieValue;
    }
  }

  return adminCookie;
}

function deleteDatabaseButton(database_name) {
  setTempDatabaseState(database_name);
}

function deleteTableButton(table_name) {
  setTempTableState(table_name);
}
