
/********************************************************************************************************/
// this block of codes used for you_calculate.html page

var trueResult = new Array();
var numberOfFormulartion = 10;
//initialize the calculated formulars randomly
function randomFormulation() {
    let operator = ["+", "-", "*"];
    var htmlText = "";
    var htmlElement = document.getElementById("container");

    //generate random math formulation, use type='number' to limite user's input is number
    for (i = 0; i < numberOfFormulartion; i++) {
        num1 = Math.round(Math.random() * 100);
        num2 = Math.round(Math.random() * 100);
        oper = operator[Math.round(Math.random() * 2)];
        switch (oper) {
            case "+":
                htmlText += "<p>" + num1 + " + " + num2 + "= <input id='formular" + i + "' type='number' required></p>";
                trueResult.push(num1 + num2);
                break;
            case "-":
                htmlText += "<p>" + num1 + " - " + num2 + "= <input id='formular" + i + "' type='number' required></p>";
                trueResult.push(num1 - num2);
                break;
            case "*":
                htmlText += "<p>" + num1 + " * " + num2 + "= <input id='formular" + i + "' type='number' required></p>";
                trueResult.push(num1 * num2);
                break;
            default:
                break;
        }
    }
    htmlText += "<input type='submit' value='submit' onclick='checkValue()'/>";
    htmlElement.innerHTML = htmlText;
}
// check the user's answers to the result and validate
function checkValue() {
    var trueNum = 0;
    for (let index = 0; index < numberOfFormulartion; index++) {
        element = document.getElementById("formular" + index);
        //check the input form, is null or other problem
        if(element.validity.valid == false) {
            alert(element.validationMessage);
            return;
        }
        //display the true answers and wrong answers with different color
        value = parseInt(element.value);
        if (value != trueResult[index]) {
            element.className = "falseValueClass";
        } else {
            element.className = "trueValueClass";
            trueNum++;
        }
    }
    //display the number of correct answer of user's
    alert("YOU GOT " + trueNum + " TRUE CALCULATION.")
}

/********************************************************************************************************/

