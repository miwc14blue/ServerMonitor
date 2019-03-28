// When the user clicks on the button, open the modal 
function show(username) {
   var modal = document.getElementById('myModal'+username)
   modal.style.display = "block";
}

// When the user clicks on X or grey area, close the modal
function hide(username) {
    var modal = document.getElementById('myModal'+username);
    modal.style.display = "none";
}

