if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
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
        if (openDropdown.classList.contains("post__content__dropdown--show") && openDropdown.id !== `dropdown-${idPost}`) {
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
