// When the user clicks on the button, open the modal 
function show(username) {
    var modal = document.getElementById('myModal');
    var text = document.getElementById('popuptext');
    text.innerHTML = 'Weet u zeker dat u ' + username + ' wilt verwijderen?';
    modal.style.display = "block";
}

// When the user clicks on <span>, close the modal
function hide() {
    var modal = document.getElementById('myModal');
    var span = document.getElementsByClassName("close")[0];
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    var modal = document.getElementById('myModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}