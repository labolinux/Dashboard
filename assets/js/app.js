var $ = require('jquery');

$(document).ready(function() {
    window.setInterval(initElements, 1000);

});

function initElements() {
    initTime();
}

function initTime() {
    var $el = $(".time");
    var time = new Date();
    var minutes = (time.getMinutes() < 10) ? "0" + time.getMinutes() : time.getMinutes();
    var hours = (time.getHours() < 10) ? "0" + time.getHours() : time.getHours();
    var timeDisplay = hours + ":" + minutes;
    $el.text(timeDisplay);
}