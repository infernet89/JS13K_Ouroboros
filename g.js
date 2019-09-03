// < >
var DEBUG=0;
//costant
var TO_RADIANS = Math.PI/180; 
var borderSize=5;
var defaultWidth=1200;
var defaultHeight=800;

//global variables
var canvas;
var canvasW;
var canvasH;
var ctx;
var activeTask;
var Kpressed=[];

//game variables
var snakeHead;
var snakeSize=20;
var snakeSpeed=5;
var snakeColor="#0F0";
var tailColor="#0A0";


//setup
canvas = document.getElementById("g");
ctx = canvas.getContext("2d");
canvasW=canvas.width  = defaultWidth;//window.innerWidth;
canvasH=canvas.height = defaultHeight;//window.innerHeight;

//controls
window.addEventListener('keydown',keyDown,false);
window.addEventListener('keyup',keyUp,false);

generateLevel();
activeTask=setInterval(run, 33);

function generateLevel()
{
    snakeHead=new Object();
    snakeHead.x=canvasW/2;
    snakeHead.y=canvasH/2;
    snakeHead.z=0;
    snakeHead.meat=180;
    snakeHead.direction=6;
    snakeHead.next=null;
}

function run()
{
    ctx.clearRect(0, 0, canvasW, canvasH);
    ctx.fillStyle="#000";
    ctx.fillRect(0,0,canvasW,canvasH);

    ctx.fillStyle="#00F";
    ctx.fillRect(0,0,canvasW,borderSize);
    ctx.fillRect(0,canvasH-borderSize,canvasW,borderSize);
    ctx.fillRect(0,0,borderSize,canvasH);
    ctx.fillRect(canvasW-borderSize,0,borderSize,canvasH);

    drawSnake(snakeHead);
    moveSnake(snakeHead,snakeSpeed);
    changeDirection();
    checkCollisions(snakeHead);
}
//controlla in Kpressed se cambiare direction
function changeDirection()
{
    newDirection=-1;
    if(Kpressed[38] || Kpressed[87])
    {
        newDirection=8;
    }
    else if(Kpressed[40] || Kpressed[83])
    {
        newDirection=2;
    }
    else if(Kpressed[37] || Kpressed[65])
    {
        newDirection=4;
    }
    else if(Kpressed[39] || Kpressed[68])
    {
        newDirection=6;
    }

    //he changed direction
    if(newDirection!=-1)
    {
        oldHead=snakeHead;
        snakeHead=new Object();
        snakeHead.x=oldHead.x;
        snakeHead.y=oldHead.y;
        snakeHead.z=oldHead.z;
        snakeHead.direction=newDirection;
        snakeHead.meat=0;
        snakeHead.next=oldHead;

    }
}
function drawSnake(piece)
{
    //ricorsivamente, per disegnare la testa per ultima
    if(piece.next!=null)
        drawSnake(piece.next);

    //la testa del serpente
    if(piece==snakeHead)
        ctx.fillStyle=snakeColor;
    else
        ctx.fillStyle=tailColor;
    ctx.fillRect(piece.x-snakeSize/2,piece.y-snakeSize/2,snakeSize,snakeSize);
    //il resto del pezzo, in base alla direzione
    if(piece.meat>0)
    {
        ctx.fillStyle=tailColor;
        if(piece.direction==8)//top
        {
            ctx.fillRect(piece.x-snakeSize/2,piece.y+snakeSize/2,snakeSize,piece.meat);
        }
        else if(piece.direction==2)//bottom
        {
            ctx.fillRect(piece.x-snakeSize/2,piece.y-snakeSize/2,snakeSize,-piece.meat);
        }
        else if(piece.direction==4)//left
        {
            ctx.fillRect(piece.x+snakeSize/2,piece.y-snakeSize/2,piece.meat,snakeSize);
        }
        else if(piece.direction==6)//right
        {
            ctx.fillRect(piece.x-snakeSize/2,piece.y-snakeSize/2,-piece.meat,snakeSize);
        }
    }  
}
function moveSnake(piece,speed)
{
    if(piece.direction==8)//top
    {
        piece.y-=speed;
    }
    else if(piece.direction==2)//bottom
    {
        piece.y+=speed;
    }
    else if(piece.direction==4)//left
    {
        piece.x-=speed;
    }
    else if(piece.direction==6)//right
    {
        piece.x+=speed;
    }    
    //il resto del serpente
    if(piece.next!=null)
    {
        piece.meat+=snakeSpeed;
        
        if(piece.next.meat>0)
        {
            piece.next.meat-=snakeSpeed;
            moveSnake(piece.next,0);
        }
        else piece.next=null;
    }
        
}
function checkCollisions(piece)
{
    var res=false;
    if(piece.x-snakeSize<0)
        res=true;
    else if(piece.x+snakeSize>canvasW)
        res=true;
    else if(piece.y+snakeSize>canvasH)
        res=true;
    else if(piece.y-snakeSize<0)
        res=true;

    if(res)
        document.title="YES";
    else
        document.title="NO";
    return res;
}
//CONTROLS
function keyDown(e) {
    Kpressed[e.keyCode]=true;
}
function keyUp(e) {
    Kpressed[e.keyCode]=false;
}
/*#############
    Funzioni Utili
##############*/
function rand(da, a)
{
    if(da>a) return rand(a,da);
    a=a+1;
    return Math.floor(Math.random()*(a-da)+da);
}
function distanceFrom(a,b)
{
    return Math.sqrt((a.x-b.x)*(a.x-b.x)+(a.y-b.y)*(a.y-b.y)+(a.z-b.z)*(a.z-b.z));
}
window.AutoScaler = function(element, initialWidth, initialHeight, skewAllowance){
    var self = this;
    
    this.viewportWidth  = 0;
    this.viewportHeight = 0;
    
    if (typeof element === "string")
        element = document.getElementById(element);
    
    this.element = element;
    this.gameAspect = initialWidth/initialHeight;
    this.skewAllowance = skewAllowance || 0;
    
    this.checkRescale = function() {
        if (window.innerWidth == self.viewportWidth && 
            window.innerHeight == self.viewportHeight) return;
        
        var w = window.innerWidth;
        var h = window.innerHeight;
        
        var windowAspect = w/h;
        var targetW = 0;
        var targetH = 0;
        
        targetW = w;
        targetH = h;
        
        if (Math.abs(windowAspect - self.gameAspect) > self.skewAllowance) {
            if (windowAspect < self.gameAspect)
                targetH = w / self.gameAspect;
            else
                targetW = h * self.gameAspect;
        }
        
        self.element.style.width  = targetW + "px";
        self.element.style.height = targetH + "px";
    
        self.element.style.marginLeft = ((w - targetW)/2) + "px";
        self.element.style.marginTop  = ((h - targetH)/2) + "px";
    
        self.viewportWidth  = w;
        self.viewportHeight = h;
        
    }
    
    // Ensure our element is going to behave:
    self.element.style.display = 'block';
    self.element.style.margin  = '0';
    self.element.style.padding = '0';
    
    // Add event listeners and timer based rescale checks:
    window.addEventListener('resize', this.checkRescale);
    rescalercheck=setInterval(this.checkRescale, 1500);
};
