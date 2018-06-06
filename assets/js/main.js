
function drawText(){
    var text = document.getElementById('saisie').value;
    text = text.toUpperCase();
    document.getElementById('text').innerHTML = text;
    smallLetter(text);
}

// function smallLetter(text){
//     var frame = document.getElementById('text').innerText;
//     var measure = text.length;

//     console.log(text.length);
//     if (text.length > 9) {
//         document.getElementById('text').style.fontSize = "3em";
//         document.getElementById('textoverimage').style.marginTop = "-120px";
//     }if(text.length > 12){
//         document.getElementById('text').style.fontSize = "2.2em";
//         document.getElementById('textoverimage').style.marginTop = "-130px";
//     }
  
// }

document.getElementById("changeColor").addEventListener("click", function(){
    var text = document.getElementById('text');
    if (text.style.color == "white") {
        text.style.color = "black";
    }else{
        text.style.color = "white";
    }

});