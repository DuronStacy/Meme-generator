
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

var colorWell
var defaultColor = "#FFFFFF";

window.addEventListener("load", startup, false);
function startup() {
  colorWell = document.querySelector("#colorWell");
  colorWell.value = defaultColor;
  colorWell.addEventListener("input", updateFirst, false);
  colorWell.addEventListener("change", updateAll, false);
  colorWell.select();
}
function updateFirst(event) {
  var p = document.getElementById("textoverimageUp");

  if (p) {
    p.style.color = event.target.value;
  }
}
function updateAll(event) {
  document.querySelectorAll("p").forEach(function(p) {
    p.style.color = event.target.value;
  });
}


