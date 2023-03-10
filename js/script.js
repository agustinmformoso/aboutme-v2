/* Styles - Likes */

let likes = document.getElementsByClassName("post__likes__icon-wrapper");

for (let i = 0; i < likes.length; i++) {
  likes[i].addEventListener("mouseenter", () => {
    likes[i].parentElement.firstElementChild.classList.add(
      "post__likes__number--hover"
    );
    likes[i].classList.add("post__likes__icon-wrapper--hover");
    likes[i].firstElementChild.firstElementChild.classList.add(
      "fa-heart--hover"
    );
  });

  likes[i].addEventListener("mouseleave", () => {
    likes[i].parentElement.firstElementChild.classList.remove(
      "post__likes__number--hover"
    );
    likes[i].classList.remove("post__likes__icon-wrapper--hover");
    likes[i].firstElementChild.firstElementChild.classList.remove(
      "fa-heart--hover"
    );
  });
}
/* Unauthorized Modal */

const unauthorizedModal = (isAuthorized) => {
  let body = document.getElementsByClassName("body");
  let modalWrapper = document.createElement("div");
  let modal = document.createElement("div");
  let modalContent = `
    <h2>Indica que te gusta un post para demostrar tu interés.</h2>
    <p>Únete ahora mismo.</p>

    <div class="unauthorized-modal__actions">
        <a class="button button--black button--login" href="index.php?s=login">Iniciar Sesión</a>
        <a class="button button--white" href="index.php?s=sign-up">Registrarse</a>
    </div>
    `;

  modalWrapper.className = "unauthorized-modal-wrapper";
  modal.className = "unauthorized-modal";

  modal.innerHTML = modalContent;

  modalWrapper.appendChild(modal);
  body[0].appendChild(modalWrapper);

  modalWrapper.addEventListener("click", (e) => {
    if (e.target.className === "unauthorized-modal-wrapper") {
      document.getElementsByClassName("unauthorized-modal-wrapper")[0].remove();
    }
    return;
  });
};

/* Empty values at new post creation validation */

let newPostButton = document.getElementById("new-post__button");
let newPostTitle = document.getElementById("new-post__title");
let newPostContent = document.getElementById("new-post__content");

newPostButton.disabled = true;

window.addEventListener("keyup", (e) => {
  if (newPostTitle.value !== "" && newPostContent.value !== "") {
    newPostButton.disabled = false;
  } else {
    newPostButton.disabled = true;
  }
});

/* Removes the empty form alert */

if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}

/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function displayDropdown(idPost) {
  var dropdowns = document.getElementsByClassName(
    "post__content__dropdown-content"
  );
  var i;
  for (i = 0; i < dropdowns.length; i++) {
    var openDropdown = dropdowns[i];
    if (
      openDropdown.classList.contains("post__content__dropdown--show") &&
      openDropdown.id !== `dropdown-${idPost}`
    ) {
      openDropdown.classList.remove("post__content__dropdown--show");
    }
  }

  document
    .getElementById(`dropdown-${idPost}`)
    .classList.toggle("post__content__dropdown--show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function (event) {
  if (!event.target.matches(".post__content__dropdown-button")) {
    var dropdowns = document.getElementsByClassName(
      "post__content__dropdown-content"
    );
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains("post__content__dropdown--show")) {
        openDropdown.classList.remove("post__content__dropdown--show");
      }
    }
  }
};
