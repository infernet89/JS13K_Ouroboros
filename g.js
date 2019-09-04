// < >
var DEBUG=1;
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
var snakeSpeed=1;
var snakeColor="#0F0";
var tailColor="#0A0";
var borderColor="#00F";
var snakeGrowing=0;


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
    snakeHead.meat=40;
    snakeHead.direction=6;
    snakeHead.next=null;
    //DEBUG
    snakeGrowing=1000;
    //DEBUG
}

function run()
{
    ctx.clearRect(0, 0, canvasW, canvasH);
    ctx.fillStyle="#000";
    ctx.fillRect(0,0,canvasW,canvasH);

    ctx.fillStyle=borderColor;
    ctx.fillRect(0,0,canvasW,borderSize);
    ctx.fillRect(0,canvasH-borderSize,canvasW,borderSize);
    ctx.fillRect(0,0,borderSize,canvasH);
    ctx.fillRect(canvasW-borderSize,0,borderSize,canvasH);

    drawSnake(snakeHead);
    moveSnake(snakeHead);
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
    //change direction cooldown
    if(snakeHead.meat<snakeSize)
        newDirection=-1;

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
        var rect=getSnakePieceRect(piece);
        ctx.fillRect(rect.x,rect.y,rect.width,rect.height);
    }  
}
function getSnakePieceRect(piece)
{
    var res=new Object();
    if(piece.direction==8)//top
    {
        res.x=piece.x-snakeSize/2;
        res.y=piece.y+snakeSize/2;
        res.width=snakeSize;
        res.height=piece.meat;
    }
    else if(piece.direction==2)//bottom
    {
        res.x=piece.x-snakeSize/2;
        res.y=piece.y-snakeSize/2-piece.meat;
        res.width=snakeSize;
        res.height=piece.meat;
    }
    else if(piece.direction==4)//left
    {
        res.x=piece.x+snakeSize/2;
        res.y=piece.y-snakeSize/2;
        res.width=piece.meat;
        res.height=snakeSize;
    }
    else if(piece.direction==6)//right
    {
        res.x=piece.x-snakeSize/2-piece.meat;
        res.y=piece.y-snakeSize/2;
        res.width=piece.meat;
        res.height=snakeSize;
    }
    return res;
}
function moveSnake(piece)
{
    if(piece.direction==8)//top
    {
        piece.y-=snakeSpeed;
    }
    else if(piece.direction==2)//bottom
    {
        piece.y+=snakeSpeed;
    }
    else if(piece.direction==4)//left
    {
        piece.x-=snakeSpeed;
    }
    else if(piece.direction==6)//right
    {
        piece.x+=snakeSpeed;
    }    

    //se ho altri pezzi attaccati
    if(piece.next!=null)
    {
        piece.meat+=snakeSpeed;
        while(piece.next!=null)
        {
            if(piece.next.meat<=0)
                piece.next=null;
            else piece=piece.next;
        }
            
        //l'ultimo della coda, cresce o si sposta
        if(snakeGrowing>snakeSpeed)
            snakeGrowing-=snakeSpeed;
        else piece.meat-=snakeSpeed;
        //sarebbe dovuto crescere di un pochino
        if(snakeGrowing<0)
        {
            piece.meat+=snakeGrowing;
            snakeGrowing=0;
        }
    }
        
}
function checkCollisions(piece)
{
    var res=false;
    if(piece.x-snakeSize/2<0)
        res=true;
    else if(piece.x+snakeSize/2>canvasW)
        res=true;
    else if(piece.y+snakeSize/2>canvasH)
        res=true;
    else if(piece.y-snakeSize/2<0)
        res=true;
    var tmp=piece.next;
    var r=null;
    while(tmp!=null)// && !res)
    {
        r=getSnakePieceRect(tmp);
        //console.log("DEBUG: ",r.x,"<",piece.x,"<",r.x+r.width," __ ",piece.y,">",r.y," && ",piece.y,"<",r.y+r.height);
        if(piece.x+snakeSize/2>r.x && piece.x-snakeSize/2<r.x+r.width && piece.y+snakeSize/2>r.y && piece.y-snakeSize/2<r.y+r.height)
        {
            res=true;
            if(DEBUG)
            {
                ctx.fillStyle="#F00";
                ctx.fillRect(r.x,r.y,r.width,r.height);
            }
        }
        tmp=tmp.next;
    }
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
