
function drawTextup(){
    var text = document.getElementById('top-text').value;
    text = text.toUpperCase();
    document.getElementById('text').innerHTML = text;
    var x = document.getElementById('image').naturalWidth;
    var y = document.getElementById('image').naturalHeight;
    var down = -(y+22)+ "px";
    console.log(down);
    document.getElementById('textoverimageUp').style.marginTop = down;

}

function drawTextbottom(){
    var text = document.getElementById('bottom-text').value;
    text = text.toUpperCase();
    document.getElementById('text2').innerHTML = text;
    var y = document.getElementById('image').naturalHeight;
    console.log(y);
    var up = -(y-348);
    console.log(up);
    document.getElementById('textoverimageUp').style.marginTop = up;

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