/********************************************************************************************************/
//this block of code is for draw clicking animation for index.html
if (document.getElementById("mainCanvas") != null) {
    document.getElementById("mainCanvas").width = window.innerWidth;
    document.getElementById("mainCanvas").height = window.innerHeight;
}

//e->element, r->radius, this function draw circle on canvas with id "mainCanvas"
function draw(e, r) {
    var c = document.getElementById("mainCanvas");
    var ctx = c.getContext("2d");
    ctx.clearRect(0, 0, window.innerWidth, window.innerHeight);
    ctx.lineWidth = 5;
    ctx.beginPath();
    ctx.strokeStyle = "blue";
    ctx.arc(e.pageX - document.getElementById("mainCanvas").offsetLeft, e.pageY - document.getElementById("mainCanvas").offsetTop, Math.pow(r, 2), 0, Math.PI * 2);
    ctx.stroke();
    //increase r and set stop limitation
    r += 2;
    if (Math.pow(r, 2) > 2 * window.innerWidth) return;
    setTimeout(() => { draw(e, r); }, 50);
}

//window size changing action listener, set canvas size to the window size
window.addEventListener("resize", resizeCanvas);

function resizeCanvas() {
    location.reload();
    document.getElementById("mainCanvas").width = window.innerWidth;
    document.getElementById("mainCanvas").height = window.innerHeight;
}

//vector class
Vector = function(x, y) {
    this.x = x;
    this.y = y;

    this.add = function(vec) {
        return new Vector(this.x + vec.x, this.y + vec.y);
    }

    this.mult = function(scalar) {
        return new Vector(this.x * scalar, this.y * scalar);
    }
}

//iteration unction, timestep for changing position
function iterate(node) {
    if (node.mouseAt == true) {
        node.mouseAt = false;
        setTimeout(() => { iterate(node); }, 2000);
        return;
    }
    node.move(node);
    setTimeout(() => { iterate(node); }, 10);
}

//add mouse over the element action listener
function setMouseOverListener(node) {
    node.element.onmouseover = function() {
        node.mouseAt = true;
    }
}

//node class
div_node = function(id, ini_v, ini_pos) {
    this.v = ini_v;
    this.pos = ini_pos;
    this.element = document.getElementById(id);
    this.mouseAt = false;

    this.move = function(node) {
        var offsetTop = node.element.offsetTop;
        var offsetLeft = node.element.offsetLeft;

        if (offsetLeft >= window.innerWidth - node.element.offsetWidth - 10 || offsetLeft <= 0) {
            node.v.x = -node.v.x;
        }
        if (offsetTop >= window.innerHeight - node.element.offsetHeight - 10 || offsetTop <= 0) {
            node.v.y = -node.v.y;
        }
        //1 -> T timeStep， S = V * T
        node.pos = node.pos.add(node.v.mult(2));
        node.element.style.top = node.pos.y + "px";
        node.element.style.left = node.pos.x + "px";
    }
}

var dfs_bfs = new div_node("dfs_bfs", new Vector(Math.random() * 4, Math.random() * 4), new Vector(Math.random() * window.innerWidth * 0.8, Math.random() * window.innerHeight * 0.8));
setMouseOverListener(dfs_bfs);
iterate(dfs_bfs);

var calu = new div_node("calu", new Vector(Math.random() * 4, Math.random() * 4), new Vector(Math.random() * window.innerWidth * 0.8, Math.random() * window.innerHeight * 0.8));
setMouseOverListener(calu);
iterate(calu);

var info = new div_node("info", new Vector(Math.random() * 4, Math.random() * 4), new Vector(Math.random() * window.innerWidth * 0.8, Math.random() * window.innerHeight * 0.8));
setMouseOverListener(info);
iterate(info);

var hello = new div_node("hello", new Vector(Math.random() * 4, Math.random() * 4), new Vector(Math.random() * window.innerWidth * 0.8, Math.random() * window.innerHeight * 0.8));
setMouseOverListener(hello);
iterate(hello);
/********************************************************************************************************/