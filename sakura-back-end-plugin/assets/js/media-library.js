function openMediaLibrary(selectedType, mediaFor) {
  document.getElementById("mediaLibrary").style.display = "block";

  let images = document.getElementsByName("image-library[]");
  let counter = document.getElementById("selectedImageCount");

  let count = 0;

  console.log(images);

  let selectedImages = {};
  images.forEach((element) => {
    if (selectedType == "single") {
      element.onclick = (event) => {
        console.log(selectedImages);
        if (element.checked) {
          images.forEach((e) => {
            e.checked = false;
            selectedImages = {};
          });

          selectedImages[element.getAttribute("id")] = element;
          element.checked = true;
        }
      };
      return;
    }

    element.onclick = (event) => {
      console.log(selectedImages);
      if (element.checked) {
        selectedImages[element.getAttribute("id")] = element;
        count += 1;

        counter.innerText = count + " images has selected.";
        return;
      }

      delete selectedImages[element.getAttribute("id")];
      count -= 1;
      counter.innerText = count + " images has selected.";
    };
  });

  const date = new Date();
  date.setTime(date.getTime() + 86400 * 30);
  let expires = "expires=" + date.toUTCString();
  document.cookie =
    "media-library" + "=" + mediaFor + ";" + expires + ";path=/";
}

function closeMediaLibrary() {
  document.getElementById("mediaLibrary").style.display = "none";
}
