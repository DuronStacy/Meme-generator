
function drawTextup(){
  var text = document.getElementById('top-text').value;
  text = text.toUpperCase();
  document.getElementById('haut').innerHTML = text;

}

function drawTextbottom(){
  var text = document.getElementById('bottom-text').value;
  text = text.toUpperCase();
  document.getElementById('bas').innerHTML = text;
}

console.log(document.querySelector("#colorWell").value);

window.addEventListener("load", startup, false);
function startup() {
  var defaultColor = "#FFFFFF";
  var colorWell = document.querySelector("#colorWell");
  colorWell.value = defaultColor;
  colorWell.addEventListener("input", updateFirst, false);
  colorWell.addEventListener("change", updateAll, false);
  colorWell.select();
}

function updateFirst(event) {
  var p = document.getElementById("haut");

  if (p) {
    p.style.color = event.target.value;
  }
}
function updateAll(event) {
  document.querySelectorAll("p").forEach(function(p) {
    p.style.color = event.target.value;
  });
}


