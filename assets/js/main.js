
function drawTextup(){
    var text = document.getElementById('top-text').value;
    text = text.toUpperCase();
    document.getElementById('text').innerHTML = text;
    var x = document.getElementById('image').naturalWidth;
    var y = document.getElementById('image').naturalHeight;
    var up = -(y)+ "px";
    document.getElementById('textoverimageUp').style.marginTop = up;
    document.getElementById('textoverimageUp').style.width = x + "px";

}

function drawTextbottom(){
    var text = document.getElementById('bottom-text').value;
    text = text.toUpperCase();
    document.getElementById('text2').innerHTML = text;
    var y = document.getElementById('image').naturalHeight;
    var x = document.getElementById('image').naturalWidth;
    document.getElementById('textoverimageDown').style.width = x + "px";
}

document.getElementById("changeColor").addEventListener("click", function(){
    var text = document.getElementById('text');
    var text2 = document.getElementById('text2');

    if (text.style.color == "white") {
        text.style.color = "black";
    }else{
        text.style.color = "white";
    }

    if (text2.style.color == "white") {
        text2.style.color = "black";
    }else{
        text2.style.color = "white";
    }
});