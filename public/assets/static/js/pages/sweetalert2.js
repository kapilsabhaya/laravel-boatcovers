const Swal2 = Swal.mixin({
  customClass: {
    input: 'form-control'
  }
})

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

function addEventListenerIfExists(elementId, event, callback) {
  const element = document.getElementById(elementId);
  if (element) {
    element.addEventListener(event, callback);
  }
}

// Define all your event listeners using the helper function
addEventListenerIfExists("basic", "click", (e) => {
  Swal2.fire("Any fool can use a computer");
});

addEventListenerIfExists("footer", "click", (e) => {
  Swal2.fire({
    icon: "error",
    title: "Oops...",
    text: "Something went wrong!",
    footer: "<a href>Why do I have this issue?</a>",
  });
});

addEventListenerIfExists("title", "click", (e) => {
  Swal2.fire("The Internet?", "That thing is still around?", "question");
});

addEventListenerIfExists("success", "click", (e) => {
  Swal2.fire({
    icon: "success",
    title: "Success",
  });
});

addEventListenerIfExists("error", "click", (e) => {
  Swal2.fire({
    icon: "error",
    title: "Error",
  });
});

addEventListenerIfExists("warning", "click", (e) => {
  Swal2.fire({
    icon: "warning",
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    confirmButtonText: "Yes, delete it!"
  }).then((result) => {
    if (result.isConfirmed) {
      deleteItem();
      Swal2.fire({
        title: "Deleted!",
        text: "Your file has been deleted.",
        icon: "success"
      });
    }
  });
});

addEventListenerIfExists("info", "click", (e) => {
  Swal2.fire({
    icon: "warning",
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    confirmButtonText: "Yes, delete it!"
  }).then((result) => {
    if (result.isConfirmed) {
      Swal2.fire({
        title: "Deleted!",
        text: "Your file has been deleted.",
        icon: "success"
      });
    }
  });
});

addEventListenerIfExists("question", "click", (e) => {
  Swal2.fire({
    icon: "warning",
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    confirmButtonText: "Yes, delete it!"
  }).then((result) => {
    if (result.isConfirmed) {
      Swal2.fire({
        title: "Deleted!",
        text: "Your file has been deleted.",
        icon: "success"
      });
    }
  });
});

addEventListenerIfExists("text", "click", (e) => {
  Swal2.fire({
    title: "Enter your IP address",
    input: "text",
    inputLabel: "Your IP address",
    showCancelButton: true,
  });
});

addEventListenerIfExists("email", "click", async (e) => {
  const { value: email } = await Swal2.fire({
    title: "Input email address",
    input: "email",
    inputLabel: "Your email address",
    inputPlaceholder: "Enter your email address",
  });

  if (email) {
    Swal2.fire(`Entered email: ${email}`);
  }
});

addEventListenerIfExists("url", "click", async (e) => {
  const { value: url } = await Swal2.fire({
    input: "url",
    inputLabel: "URL address",
    inputPlaceholder: "Enter the URL",
  });

  if (url) {
    Swal2.fire(`Entered URL: ${url}`);
  }
});

addEventListenerIfExists("password", "click", async (e) => {
  const { value: password } = await Swal2.fire({
    title: "Enter your password",
    input: "password",
    inputLabel: "Password",
    inputPlaceholder: "Enter your password",
    inputAttributes: {
      maxlength: 10,
      autocapitalize: "off",
      autocorrect: "off",
    },
  });

  if (password) {
    Swal2.fire(`Entered password: ${password}`);
  }
});

addEventListenerIfExists("textarea", "click", async (e) => {
  const { value: text } = await Swal2.fire({
    input: "textarea",
    inputLabel: "Message",
    inputPlaceholder: "Type your message here...",
    inputAttributes: {
      "aria-label": "Type your message here",
    },
    showCancelButton: true,
  });

  if (text) {
    Swal2.fire(text);
  }
});

addEventListenerIfExists("select", "click", async (e) => {
  const { value: fruit } = await Swal2.fire({
    title: "Select field validation",
    input: "select",
    inputOptions: {
      Fruits: {
        apples: "Apples",
        bananas: "Bananas",
        grapes: "Grapes",
        oranges: "Oranges",
      },
      Vegetables: {
        potato: "Potato",
        broccoli: "Broccoli",
        carrot: "Carrot",
      },
      icecream: "Ice cream",
    },
    inputPlaceholder: "Select a fruit",
    showCancelButton: true,
    inputValidator: (value) => {
      return new Promise((resolve) => {
        if (value === "oranges") {
          resolve();
        } else {
          resolve("You need to select oranges :)");
        }
      });
    },
  });

  if (fruit) {
    Swal2.fire(`You selected: ${fruit}`);
  }
});

// Toasts
addEventListenerIfExists("toast-success", "click", () => {
  Toast.fire({
    icon: "success",
    title: "Signed in successfully",
  });
});

addEventListenerIfExists("toast-warning", "click", () => {
  Toast.fire({
    icon: "warning",
    title: "Please input your email",
  });
});

addEventListenerIfExists("toast-failed", "click", () => {
  Toast.fire({
    icon: "error",
    title: "Transaction error. Please try again later",
  });
});

