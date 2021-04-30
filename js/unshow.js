"use strict";

let show = document.getElementById('unshow');
let modal = document.getElementById('dropBasket');

show.addEventListener("click", function() {
    modal.style.cssText = "display: none";
});