window.onscroll = function() {
    var currentScrollPos = window.pageYOffset;
    var header = document.getElementById("head");

    if (currentScrollPos > 50) {
        header.classList.add("sticky");
    } else {
        header.classList.remove("sticky");
    }
};
