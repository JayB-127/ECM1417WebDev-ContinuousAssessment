//the functions below are used to display the user's choice of avatar components during registration


function displaySkin(type) {
    document.getElementById("skinImg").src = "../assets/skin/".concat(type, ".png");
}

function displayEyes(type) {
    document.getElementById("eyesImg").src = "../assets/eyes/".concat(type, ".png");
}

function displayMouth(type) {
    document.getElementById("mouthImg").src = "../assets/mouth/".concat(type, ".png")
}