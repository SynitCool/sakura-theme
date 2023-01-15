// panel
let addProfile = document.getElementById("addProfilePanel");
let editProfile = document.getElementById("editProfilePanel");

// button
let addProfileButton = document.getElementById("addProfile");
let editProfileButton = document.getElementById("editProfile");

// start
addProfile.style.display = "none";
editProfile.style.display = "display";

addProfileButton.onclick = (event) => {
  editProfile.style.display = "none";
  addProfile.style.display = "block";
};

editProfileButton.onclick = (event) => {
  editProfile.style.display = "block";
  addProfile.style.display = "none";
};
