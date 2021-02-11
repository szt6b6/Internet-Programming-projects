/********************************************************************************************************/
// this block of code is for DFSandBFS.html page
// you can find similar code in CSDN, which is writen by me: https://blog.csdn.net/qq_41061370/article/details/109835097

// color used for map grid, it can also express path with different weights, this DFS&BFS will not show, nut DIJKstra and A*
const colors = ["black", "gray", "green", "yellow", "red", "purple"];
const lineWidth = 3;
const timeStep = 200;
// 0 - obstacle; 1 - blank; 2 - start; 3 - goal
const start = 2,
    goal = 4,
    obstacle = 0,
    blank = 1;
//map display in the html page
const map = [
    [2, 0, 1, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1],
    [1, 0, 1, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1],
    [1, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0],
    [1, 0, 0, 1, 0, 0, 0, 1, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0],
    [1, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 1, 1, 1, 1, 1, 0, 1, 0],
    [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 0, 1, 0, 1, 0, 1, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 1, 0, 1, 0],
    [0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 0, 1, 0],
    [0, 0, 1, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 1, 1, 1],
    [0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0],
    [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0],
    [0, 0, 1, 1, 1, 0, 1, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1],
    [0, 0, 1, 1, 1, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0, 0, 0, 1],
    [0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 1],
    [0, 0, 1, 1, 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 4]
];
const row = map.length;
const col = map[0].length;
var pxSize = 0;
if (document.getElementById("myCanvas") != null) {
    pxSize = Math.floor(window.innerWidth * 0.5 / col);
    document.getElementById("myCanvas").width = pxSize * col;
    document.getElementById("myCanvas").height = pxSize * row;
    document.getElementById("myCanvasForFinalPath").width = pxSize * col;
    document.getElementById("myCanvasForFinalPath").height = pxSize * row;
    document.getElementById("panel").style.gridTemplateColumns = (pxSize + "px ").repeat(col);
    document.getElementById("panel").style.gridTemplateRows = (pxSize + "px ").repeat(row);

    var addGridStringText = "";
    for (i = 0; i < row; i++) {
        for (j = 0; j < col; j++)
            addGridStringText += "<div row='" + i + "' col='" + j + "' id='" + i + "_" + j + "' style=\"border:1px solid white; background-color:" + colors[map[i][j]] + "\"></div>";
    }
    document.getElementById("panel").innerHTML = addGridStringText;
}


function drawLine(from, to) {
    var c = document.getElementById("myCanvas");
    var ctx = c.getContext("2d");
    ctx.strokeStyle = "yellow";
    ctx.lineWidth = lineWidth;
    ctx.moveTo(pxSize * (from.colAt + 0.5), pxSize * (from.rowAt + 0.5));
    ctx.lineTo(pxSize * (to.colAt + 0.5), pxSize * (to.rowAt + 0.5));
    ctx.stroke();
}

function drawFinalPathLine(from, to) {
    var c = document.getElementById("myCanvasForFinalPath");
    var ctx = c.getContext("2d");
    ctx.strokeStyle = '#cc0000';
    ctx.lineWidth = lineWidth;
    ctx.moveTo(pxSize * (from.colAt + 0.5), pxSize * (from.rowAt + 0.5));
    ctx.lineTo(pxSize * (to.colAt + 0.5), pxSize * (to.rowAt + 0.5));
    ctx.stroke();
}

//represent each of grid display in the page
function Node(parent, rowat, colat) {
    this.parent = parent;
    this.rowAt = rowat;
    this.colAt = colat;
    //after this nodet is created, draw line from its parent to it
    if (parent != null) drawLine(parent, this);

    this.getMapValue = function() {
        return map[rowAt][colAt];
    }

    //add neighbors of current node's from left top and normal clock order, total 8 neightbors
    this.addNeightBor = function() {
        rowAt = this.rowAt;
        colAt = this.colAt;
        rightTop = [rowAt - 1, colAt + 1];
        if (rightTop[0] >= 0 && rightTop[1] < col && map[rightTop[0]][rightTop[1]] != obstacle && notContain(rightTop)) {
            node = new Node(this, rightTop[0], rightTop[1]);
            openList.push(node);
            createdList.push(node);
        }
        right = [rowAt, colAt + 1];
        if (right[1] < col && map[right[0]][right[1]] != obstacle && notContain(right)) {
            node = new Node(this, right[0], right[1]);
            openList.push(node);
            createdList.push(node);
        }
        rightBott = [rowAt + 1, colAt + 1];
        if (rightBott[0] < row && rightBott[1] < col && map[rightBott[0]][rightBott[1]] != obstacle && notContain(rightBott)) {
            node = new Node(this, rightBott[0], rightBott[1]);
            openList.push(node);
            createdList.push(node);
        }
        bott = [rowAt + 1, colAt];
        if (bott[0] < row && map[bott[0]][bott[1]] != obstacle && notContain(bott)) {
            node = new Node(this, bott[0], bott[1]);
            openList.push(node);
            createdList.push(node);
        }
        leftBott = [rowAt + 1, colAt - 1];
        if (leftBott[0] < row && leftBott[1] >= 0 && map[leftBott[0]][leftBott[1]] != obstacle && notContain(leftBott)) {
            node = new Node(this, leftBott[0], leftBott[1]);
            openList.push(node);
            createdList.push(node);
        }
        left = [rowAt, colAt - 1];
        if (left[1] >= 0 && map[left[0]][left[1]] != obstacle && notContain(left)) {
            node = new Node(this, left[0], left[1]);
            openList.push(node);
            createdList.push(node);
        }
        leftTop = [rowAt - 1, colAt - 1];
        if (leftTop[0] >= 0 && leftTop[1] >= 0 && map[leftTop[0]][leftTop[1]] != obstacle && notContain(leftTop)) {
            node = new Node(this, leftTop[0], leftTop[1]);
            openList.push(node);
            createdList.push(node);
        }
        //can not use top, top is already defined as window class in JS
        topNode = [rowAt - 1, colAt];
        if (topNode[0] >= 0 && map[topNode[0]][topNode[1]] != obstacle && notContain(topNode)) {
            node = new Node(this, topNode[0], topNode[1]);
            openList.push(node);
            createdList.push(node);
        }
    }
}
//check neighbors is created or not
function notContain(testNode) {
    for (i = 0; i < createdList.length; i++) {
        if (createdList[i].rowAt == testNode[0] && createdList[i].colAt == testNode[1]) return false;
    }
    return true;
}

var algorithm = "BFA";
var openList;
var closedList;
var createdList;
var startNode;
var currentNode;
// click start button and searching road starts
function run() {
    startNode = getStartNode();
    openList = [];
    openList.push(startNode);
    createdList = [];
    createdList.push(startNode);
    closedList = [];
    iterationTime = 0;
    //start iteration procedure
    if (openList.length != 0) {
        iteration();
    }
}

function iteration() {
    //after timeStep, remove highlight of currentNode
    if (currentNode != null) document.getElementById(currentNode.rowAt + "_" + currentNode.colAt).style.border = "1px solid white";
    //BFA
    if (algorithm == "BFA") currentNode = openList.shift();
    //DFA
    if (algorithm == "DFA") currentNode = openList.pop();
    //highlight currentNode
    document.getElementById(currentNode.rowAt + "_" + currentNode.colAt).style.border = "1px solid red";
    console.log("currentNode is(" + currentNode.rowAt + "," + currentNode.colAt + ")")
    currentNode.addNeightBor();
    closedList.push(currentNode);
    document.getElementById("iteration").innerText = "iteration:" + ++iterationTime;
    if (currentNode.getMapValue() == goal) {
        //find path through closedList
        var node = closedList[closedList.length - 1]; //goal node
        var path = new Array(node);
        while (node.getMapValue != startNode.getMapValue) {
            node = node.parent;
            path.unshift(node);
        }
        for (i = path.length - 1; i > 0; i--) {
            drawFinalPathLine(path[i], path[i].parent);
        }
        return;
    } else setTimeout(() => {
        iteration();
    }, timeStep);

}


function getStartNode() {
    for (i = 0; i < row; i++) {
        for (j = 0; j < col; j++) {
            if (map[i][j] == start)
                return new Node(null, i, j);
        }
    }
}

//after click BFA button, switch the algorithm
function setAlgorithm(button) {
    if (button.textContent == "BFA") {
        algorithm = "DFA";
        button.textContent = "DFA";
    } else {
        algorithm = "BFA";
        button.textContent = "BFA";
    }
}


//resize window action listener. set responsing display of grid map and canvas
window.addEventListener("resize", resizeCanvas);

function resizeCanvas() {
    pxSize = Math.floor(window.innerWidth * 0.5 / col);
    document.getElementById("myCanvas").width = pxSize * col;
    document.getElementById("myCanvas").height = pxSize * row;
    document.getElementById("myCanvasForFinalPath").width = pxSize * col;
    document.getElementById("myCanvasForFinalPath").height = pxSize * row;
    document.getElementById("panel").style.gridTemplateColumns = (pxSize + "px ").repeat(col);
    document.getElementById("panel").style.gridTemplateRows = (pxSize + "px ").repeat(row);

    var addGridStringText = "";
    for (i = 0; i < row; i++) {
        for (j = 0; j < col; j++)
            addGridStringText += "<div row='" + i + "' col='" + j + "' id='" + i + "_" + j + "' style=\"border:1px solid white; background-color:" + colors[map[i][j]] + "\"></div>";
    }
    document.getElementById("panel").innerHTML = addGridStringText;
}

/********************************************************************************************************/