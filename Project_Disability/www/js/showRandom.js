//Global to store previous random int
_oldInt = null;

var textarray = [
    "How are you?",
    "Nice to see you here!",
    "Many parking places are ready for you!",
    "Have a nice day!" // No comma after last entry
];

function RndText() {
    //random index of textarray
    var rannum = Math.floor(Math.random() * textarray.length);
    //ensure random integer isn't the same as last
    if (rannum == _oldInt)
        rannum = new rannum;
    else
        _oldInt = rannum;
    //fade in & out animation
    $('#randomText').fadeOut('fast', function () {
        $(this).text(textarray[rannum]).fadeIn('fast');
    });
}
onload = function () { RndText(); }
var inter = setInterval(function () { RndText(); }, 1000);

