

// When the user clicks on the button, open the modal 
function show(username) {
    var modal = document.getElementById('myModal'+username);
	modal.style.display = "block";
}

// When the user clicks on function hide(), close the modal
function hide(username) {
    var modal = document.getElementById('myModal'+username);
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    var modal = document.getElementsByClassName("modal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}