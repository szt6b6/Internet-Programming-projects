var firstName = null;
var lastName = null;
var school = null;
var checkSubmitFlg = false;

//Check if the user fill in all information or not
function checkValue() {
    element1 = document.getElementById("fName");
    element2 = document.getElementById("lName");
    if (element1.value == "" || element2.value == "") {
        alert("please fill your name!");
        return;
    } else {
        if (checkSubmit() == true) {
            jump();
        } else {
            alert("please do not submit twice!")
        }
    }
}



function checkSubmit() {

    if (checkSubmitFlg == true) {
        return false; //当表单被提交过一次后checkSubmitFlg将变为true,根据判断将无法进行提交。

    }

    checkSubmitFlg == true;

    return true;

}

//Get the chosen school from information.html
function getRadioButtonCheckedValue() {
    var radio_tag = document.getElementsByName("school");
    for (var i = 0; i < radio_tag.length; i++) {
        if (radio_tag[i].checked) {
            var checkvalue = radio_tag[i].value;
            return checkvalue;
        }
    }
}

//open the visa.html to show the result
function jump() {

    firstName = document.getElementById("fName").value;
    lastName = document.getElementById("lName").value;

    //store data
    sessionStorage["fName"] = firstName;
    sessionStorage["lName"] = lastName;
    sessionStorage["school"] = getRadioButtonCheckedValue();
    window.open("visa.html", "win", "width=400,height=500,toolbar=no, menubar=no, scrollbars=no, resizable=no");
    sessionStorage.clear();
}