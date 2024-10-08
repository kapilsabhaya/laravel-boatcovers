
// var snow = new Quill("#snow", {
//   theme: "snow",
// })
// var bubble = new Quill("#bubble", {
//   theme: "bubble",
// })
// new Quill("#full", {
//   bounds: "#full-container .editor",
//   modules: {
//     toolbar: [
//       [{ font: [] }, { size: [] }],
//       ["bold", "italic", "underline", "strike"],
//       [{ color: [] }, { background: [] }],
//       [{ script: "super" }, { script: "sub" }],
//       [
//         { list: "ordered" },
//         { list: "bullet" },
//         { indent: "-1" },
//         { indent: "+1" },
//       ],
//       ["direction", { align: [] }],
//       ["link", "image", "video"],
//       ["clean"],
//     ],
//   },
//   theme: "snow",
// })
document.addEventListener("DOMContentLoaded", function() {
  var quill = new Quill("#full", {
      bounds: "#full-container .editor",
      modules: {
          toolbar: [
              [{ font: [] }, { size: [] }],
              ["bold", "italic", "underline", "strike"],
              [{ color: [] }, { background: [] }],
              [{ script: "super" }, { script: "sub" }],
              [
                  { list: "ordered" },
                  { list: "bullet" },
                  { indent: "-1" },
                  { indent: "+1" },
              ],
              ["direction", { align: [] }],
              ["link", "image", "video"],
              ["clean"],
          ],
      },
      theme: "snow",
  });

  // On form submit, set the hidden input value to the Quill content
  const addProductForm =  document.getElementById("addPro");
  if(addProductForm) {
      document.getElementById("addPro").onsubmit = function() {
          document.getElementById("hiddenDesc").value = quill.root.innerHTML;
      };
  }

  const updateProductForm = document.getElementById("updateProductForm");
  if(updateProductForm) {
      document.getElementById("updateProductForm").onsubmit = function() {
          document.getElementById("hiddenDesc").value = quill.root.innerHTML;
      };
  }
});
