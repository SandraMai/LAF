window.onload = function(){
    let deleteButton = document.getElementById("delete");
    deleteButton.addEventListener('click', hideButton);
}


function hideButton(){
    $('.text').css('visibility', 'hidden');
    document.getElementById("deleteForm").style.visibility = "visible";
    document.getElementById("delete").style.visibility = "hidden";
}