<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Ouroboros TEST</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	
	</head>
	<body>
		<script type="module">
		//game variables
		var level;
		var snakeHead;
		var snakeSize=0.1;
		var snakeSpeed=0.005;
		var snakeColor=0x00FF00;
		var tailColor=0x00AA00;
		var snakeGrowing=0;
		var foods=[];
		var newFoodCooldown=0;
		var gameOverCoooldown=0;

		//import * as THREE from 'https://threejs.org/examples/../build/three.module.js';
		import * as THREE from './three.module.js';
		import { BoxLineGeometry } from './BoxLineGeometry.js';
		var camera, scene, renderer;
		var controller1, controller2,lastActiveController;
		var room;
		var count = 0;
		var normal = new THREE.Vector3();
		var relativeVelocity = new THREE.Vector3();
		var clock = new THREE.Clock();
		var geometry = new THREE.BoxGeometry( 1, 1, 1 );

		var font=undefined;
		var text = "SAND ADDER\n\nby Infernet89";
		var textColor=0xffffff;
		var textMesh1=undefined,textMesh2=undefined,textMesh3=undefined,textMesh4=undefined,tutorialMesh1=undefined,tutorialMesh2=undefined;
		var score=0;
		var tutorialEnabled=true;
		var soundLoaded=false;
		var sound=null;
		var appleSound=null;
		var particles=[];
		
		init();
		animate();
		//utility functions
		function loadSound()
		{
			//sounds
			var audioLoader = new THREE.AudioLoader();
			audioLoader.load('Sound/slither2.mp3', function(buffer) {
				sound.setBuffer(buffer);
				sound.setRefDistance(0.05);//più e basso, più la distanza è influente
				sound.setLoop(true);
				sound.play();
			});
			audioLoader.load('Sound/eat.mp3', function(buffer) {
				appleSound.setBuffer(buffer);
				appleSound.setRefDistance(0.05);//più e basso, più la distanza è influente
			});
			soundLoaded=true;
		}
		function vibrate(amount,length,controller=null)
		{
			if(!controller1.haptic)
			{
				var gamepads = navigator.getGamepads();
	        	//console.log("tst: ",gamepads);
	        	if(gamepads && gamepads.length>0 && gamepads[0] && "hapticActuators" in gamepads[0] && gamepads[0].hapticActuators.length > 0)
	        		controller1.haptic=gamepads[0].hapticActuators[0];
	        	if(gamepads && gamepads.length>1 && gamepads[1] && "hapticActuators" in gamepads[1] && gamepads[1].hapticActuators.length > 0)
	        		controller2.haptic=gamepads[1].hapticActuators[0];
			}

			if(controller!=null && controller.haptic)
			{
				controller.haptic.pulse(amount,length);
			}
			else
			{
				if(controller1.haptic)
					controller1.haptic.pulse(amount,length);
				if(controller2.haptic)
					controller2.haptic.pulse(amount,length);
			}
		}
		function refreshText()
		{
			if(font==undefined)
				return;
			//remove what we added
			if(textMesh1!=undefined)
				room.remove(textMesh1);
			if(textMesh2!=undefined)
				room.remove(textMesh2);
			if(textMesh3!=undefined)
				room.remove(textMesh3);
			if(textMesh4!=undefined)
				room.remove(textMesh4);
			if(tutorialMesh1!=undefined)
				controller1.remove(tutorialMesh1);
			if(tutorialMesh2!=undefined)
				controller2.remove(tutorialMesh2);
			//create geometry for new text
			const geo = new THREE.TextBufferGeometry(text,{font:font,size: 0.1,height:0.002});
            geo.center();
	        //create and reposition meshes   
            textMesh1 = new THREE.Mesh(geo,new THREE.MeshBasicMaterial({color:textColor}));
            textMesh1.position.set(0,2,-2);
            room.add(textMesh1);

            textMesh2=textMesh1.clone();
            textMesh2.rotateY(Math.PI);
            textMesh2.position.set(0,2,2);
            room.add(textMesh2);

            textMesh3=textMesh1.clone();
            textMesh3.rotateY(Math.PI/2);
            textMesh3.position.set(-2,2,0);
            room.add(textMesh3);

            textMesh4=textMesh1.clone();
            textMesh4.rotateY(-Math.PI/2);
            textMesh4.position.set(2,2,0);
            room.add(textMesh4);

            if(tutorialEnabled)
            {
            	var geo1=new THREE.TextBufferGeometry("TO MOVE\n  SNAKE",{font:font,size: 0.01,height:0.002});
            	geo1.center();
            	var geo2=new THREE.TextBufferGeometry("  DRAG AND RELEASE IN\nTHE CHOSEN DIRECTION",{font:font,size: 0.01,height:0.002});
            	geo2.center();
            	tutorialMesh1 = new THREE.Mesh(geo1,new THREE.MeshStandardMaterial({color:0xffffff,metalness:0.0,roughness:0.5}));
            	tutorialMesh1.rotateX(-Math.PI/2);
            	tutorialMesh1.position.z=0.07;
            	controller1.add(tutorialMesh1);
            	tutorialMesh2 = new THREE.Mesh(geo2,new THREE.MeshStandardMaterial({color:0xffffff,metalness:0.0,roughness:0.5}));
            	tutorialMesh2.rotateX(-Math.PI/2);
            	tutorialMesh2.position.z=0.07;
            	controller2.add(tutorialMesh2);
            }
		}
		function updateScore(amount)
		{
			score+=amount;
			text="SCORE: "+score;
			textColor=0x333333;
			refreshText();
			vibrate(0.3,200);
		}
		//Snake functions
		function generateLevel()
		{
			level=0;
			snakeSpeed=0.005;

		    snakeHead=new Object();
		    snakeHead.x=0;
		    snakeHead.y=1;
		    snakeHead.z=-1;
		    snakeHead.meat=0.4;
		    do
		    {
		    	snakeHead.direction=rand(2,8);
		    } while(snakeHead.direction==3);
		    snakeHead.next=null;
		    snakeHead.growth=0;
		    snakeGrowing=0;
		    foods=[]
		    newFoodCooldown=0;
		    //3d
		    snakeHead.tdHeadObject=new THREE.Mesh( geometry, new THREE.MeshLambertMaterial( { color: snakeColor } ) );
		    snakeHead.tdHeadObject.position.x=snakeHead.x;
		    snakeHead.tdHeadObject.position.y=snakeHead.y;
		    snakeHead.tdHeadObject.position.z=snakeHead.z;
		    snakeHead.tdHeadObject.scale.x=snakeSize+0.01;
		    snakeHead.tdHeadObject.scale.y=snakeSize+0.01;
		    snakeHead.tdHeadObject.scale.z=snakeSize+0.01;
		    room.add(snakeHead.tdHeadObject);
		    snakeHead.tdObject=new THREE.Mesh( geometry, new THREE.MeshLambertMaterial( { color: tailColor } ) );
		    snakeHead.tdObject.position.x=snakeHead.x;
		    snakeHead.tdObject.position.y=snakeHead.y;
		    snakeHead.tdObject.position.z=snakeHead.z;
		    snakeHead.tdObject.scale.x=snakeSize;
		    snakeHead.tdObject.scale.y=snakeSize;
		    snakeHead.tdObject.scale.z=snakeSize;
		    room.add(snakeHead.tdObject);

		    snakeHead.tdHeadObject.add(sound);
		    snakeHead.tdHeadObject.add(appleSound);
		    score=0;
		    if(text.includes("GAME OVER"))
		    	updateScore(0);
		    vibrate(1.0,400);
		    if(soundLoaded)
		    	sound.play();
		}
		function generateApple()
		{
		    var apple=new Object();
		    apple.nutriment=rand(20,100)*0.01;
		    apple.size=snakeSize;//rand(500,1050)*0.001*snakeSize;
		    apple.color=0xAA0000;
		    apple.growth=0;
		    
		    apple.x=rand(-2000,2000)*0.0009;
		    apple.y=rand(200,3000)*0.0009;
		    apple.z=rand(-2000,2000)*0.0009;

		    apple.tdObject=new THREE.Mesh( geometry, new THREE.MeshLambertMaterial( { color: apple.color } ) );
		    apple.tdObject.position.x=apple.x;
		    apple.tdObject.position.y=apple.y;
		    apple.tdObject.position.z=apple.z;
		    apple.tdObject.scale.x=apple.size*apple.growth;
		    apple.tdObject.scale.y=apple.size*apple.growth;
		    apple.tdObject.scale.z=apple.size*apple.growth;
		    room.add(apple.tdObject);

		    foods.push(apple);
		    	
		}
		function gameOver()
		{
		    level=2;
		    for(var i=0;i<foods.length;i++)
		        foods[i].growth=2;
		    var tmp=snakeHead;
		    while(tmp!=null)
		    {
		        tmp.growth=2;
		        tmp=tmp.next;
		    }
		    gameOverCoooldown=300;
		    room.remove(snakeHead.tdHeadObject);

		    text="GAME OVER\n\n   SCORE: "+score;
			textColor=0xffffff;
			refreshText();
			vibrate(1.0,1000);
			sound.stop();
		}
		function moveSnake()
		{
			var piece=snakeHead;
		    if(piece.direction==8)//top
		    {
		        piece.y+=snakeSpeed;
		        piece.tdObject.position.y=piece.y;
		        piece.tdHeadObject.position.y=piece.y;
		    }
		    else if(piece.direction==2)//bottom
		    {
		        piece.y-=snakeSpeed;
		        piece.tdObject.position.y=piece.y;
		        piece.tdHeadObject.position.y=piece.y;
		    }
		    else if(piece.direction==4)//left
		    {
		        piece.x-=snakeSpeed;
		        piece.tdObject.position.x=piece.x;
		        piece.tdHeadObject.position.x=piece.x;
		    }
		    else if(piece.direction==6)//right
		    {
		        piece.x+=snakeSpeed;
		        piece.tdObject.position.x=piece.x;
		        piece.tdHeadObject.position.x=piece.x;
		    }
		    else if(piece.direction==5)//allontana
		    {
		        piece.z+=snakeSpeed;
		        piece.tdObject.position.z=piece.z;
		        piece.tdHeadObject.position.z=piece.z;
		    }
		    else if(piece.direction==7)//avvicina
		    {
		        piece.z-=snakeSpeed;
		        piece.tdObject.position.z=piece.z;
		        piece.tdHeadObject.position.z=piece.z;
		    }
		    //crescita
		    piece.meat+=snakeSpeed;

		    fixtdObject(piece);

		    //trova l'ultimo elemento
		    while(piece.next!=null)
		    {
		        if(piece.next.meat<=0)
		        {
		            room.remove(piece.next.tdObject);
		            piece.next=null;
		        }
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

		    if(piece!=snakeHead)
		    	fixtdObject(piece);
		    
		}
		function fixtdObject(piece)
		{
			//aggiusta il tdObject in base alla crescita
		    if(piece.direction==8)//top
		    {
		        piece.tdObject.scale.y=snakeSize+piece.meat;
		        piece.tdObject.position.y=piece.y-piece.meat/2;
		    }
		    else if(piece.direction==2)//bottom
		    {
		        piece.tdObject.scale.y=snakeSize+piece.meat;
		        piece.tdObject.position.y=piece.y+piece.meat/2;
		    }
		    else if(piece.direction==4)//left
		    {
		        piece.tdObject.scale.x=snakeSize+piece.meat;
		        piece.tdObject.position.x=piece.x+piece.meat/2;
		    }
		    else if(piece.direction==6)//right
		    {
		        piece.tdObject.scale.x=snakeSize+piece.meat;
		        piece.tdObject.position.x=piece.x-piece.meat/2;
		    }
		    else if(piece.direction==5)//allontana
		    {
		        piece.tdObject.scale.z=snakeSize+piece.meat;
		        piece.tdObject.position.z=piece.z-piece.meat/2;
		    }
		    else if(piece.direction==7)//avvicina
		    {
		        piece.tdObject.scale.z=snakeSize+piece.meat;
		        piece.tdObject.position.z=piece.z+piece.meat/2;
		    }
		}
		function getChosenDirection(dx,dy,dz)
		{
			var res=7;
			if(Math.abs(dx)>Math.abs(dy) && Math.abs(dx)>Math.abs(dz))
			{
				if(dx>0)
					res=4;
				else res=6;
			}				
			else if(Math.abs(dy)>Math.abs(dx) && Math.abs(dy)>Math.abs(dz))
			{
				if(dy>0)
					res=2;
				else res=8;
			}
			else if(Math.abs(dz)>Math.abs(dx) && Math.abs(dz)>Math.abs(dy))
			{
				if(dz>0)
					res=7;
				else res=5;
			}
			return res;
		}
		function changeDirection(newDirection)
		{
		    //change direction cooldown
		    if(snakeHead.meat<snakeSize)
		        newDirection=-1;
		    //not allowed changes
		    if( (snakeHead.direction==2 && newDirection==8) ||
		        (snakeHead.direction==8 && newDirection==2) ||
		        (snakeHead.direction==4 && newDirection==6) ||
		        (snakeHead.direction==6 && newDirection==4) ||
		        (snakeHead.direction==5 && newDirection==7) ||
		        (snakeHead.direction==7 && newDirection==5) )
		        {
		            newDirection=-1;
		        }

		    //he changed direction
		    if(newDirection!=-1 && snakeHead.direction!=newDirection)
		    {
		        var oldHead=snakeHead;
		        snakeHead=new Object();
		        snakeHead.x=oldHead.x;
		        snakeHead.y=oldHead.y;
		        snakeHead.z=oldHead.z;
		        snakeHead.tdObject=new THREE.Mesh( geometry, new THREE.MeshLambertMaterial( { color: tailColor } ) );
			    snakeHead.tdObject.position.x=snakeHead.x;
			    snakeHead.tdObject.position.y=snakeHead.y;
			    snakeHead.tdObject.position.z=snakeHead.z;
			    snakeHead.tdObject.scale.x=snakeSize;
			    snakeHead.tdObject.scale.y=snakeSize;
			    snakeHead.tdObject.scale.z=snakeSize;
			    setTimeout(function() { room.add(snakeHead.tdObject); }, 5);//delayed add

		        snakeHead.direction=newDirection;
		        snakeHead.meat=0;
		        snakeHead.growth=1;
		        snakeHead.next=oldHead;
		        snakeHead.tdHeadObject=oldHead.tdHeadObject;

		        vibrate(0.9,50,lastActiveController);
		        tutorialEnabled=false;
		    }
		}
		function checkCollisions()
		{
			var piece=snakeHead;
		    var res=false;
		    //borderds
		    if(piece.x-snakeSize/2<-2)
		        res=true;
		    else if(piece.x+snakeSize/2>2)
		        res=true;
		    else if(piece.y+snakeSize/2>4)
		        res=true;
		    else if(piece.y-snakeSize/2<0)
		        res=true;
	        else if(piece.z+snakeSize/2>2)
		        res=true;
		    else if(piece.z-snakeSize/2<-2)
		        res=true;
		    var tmp=piece.next;
		    var r=null;
		    while(tmp!=null)// && !res)
		    {
		        r=getSnakePieceRect(tmp);
		        /*console.log("x: ",r.x,"<",piece.x,"<",r.x+r.width);
		        console.log("y: ",r.y,"<",piece.y,"<",r.y+r.height);
		        console.log("z: ",r.z,"<",piece.z,"<",r.z+r.depth);
		        console.log("--------------");*/
		        if (piece.x>r.x && piece.x<r.x+r.width && 
		            piece.y>r.y && piece.y<r.y+r.height &&
		            piece.z>r.z && piece.z<r.z+r.depth)
		            {
		                res=true;
		            }
		        tmp=tmp.next;
		    }
		    return res;
		}
		function getSnakePieceRect(piece)
		{
		    var res=new Object();
		    var size=snakeSize;
		    if(piece.direction==8)//top
		    {
		        res.x=piece.x-size/2;
		        res.y=piece.y-piece.meat-size;
		        res.z=piece.z-size/2;
		        res.width=size;
		        res.height=piece.meat;
		        res.depth=size;
		    }
		    else if(piece.direction==2)//bottom
		    {
		        res.x=piece.x-size/2;
		        res.y=piece.y;
		        res.z=piece.z-size/2;
		        res.width=size;
		        res.height=piece.meat;
		        res.depth=size;
		    }
		    else if(piece.direction==4)//left
		    {
		        res.x=piece.x;
		        res.y=piece.y-size/2;
		        res.z=piece.z-size/2;
		        res.width=piece.meat;
		        res.height=size;
		        res.depth=size;
		    }
		    else if(piece.direction==6)//right
		    {
		        res.x=piece.x-piece.meat-size;
		        res.y=piece.y-size/2;
		        res.z=piece.z-size/2;
		        res.width=piece.meat;
		        res.height=size;
		        res.depth=size;
		    }
		    else if(piece.direction==5)//allontana
		    {
		        res.x=piece.x-size/2;
		        res.y=piece.y-size/2;
		        res.z=piece.z-piece.meat-size;
		        res.width=size;
		        res.height=size;
		        res.depth=piece.meat;
		    }
		    else if(piece.direction==7)//avvicina
		    {
		        res.x=piece.x-size/2;
		        res.y=piece.y-size/2;
		        res.z=piece.z;
		        res.width=size;
		        res.height=size;
		        res.depth=piece.meat;
		    }

		    return res;
		}
		//3d Functions
		function init() {
			scene = new THREE.Scene();
			scene.background = new THREE.Color( 0x101010 );
			camera = new THREE.PerspectiveCamera( 70, window.innerWidth / window.innerHeight, 0.1, 10 );
			room = new THREE.LineSegments(
				new BoxLineGeometry( 4, 4, 4, 10, 10, 10 ),
				new THREE.LineBasicMaterial( { color: 0x204020 } )
			);
			room.geometry.translate( 0, 2, 0 );
			scene.add( room );
			var light = new THREE.HemisphereLight( 0xffffff, 0x101010 );
			light.position.set( 1, 1, 1 );
			scene.add( light );
			renderer = new THREE.WebGLRenderer( { antialias: true } );
			renderer.setPixelRatio( window.devicePixelRatio );
			renderer.setSize( window.innerWidth, window.innerHeight );
			renderer.vr.enabled = true;
			document.body.appendChild( renderer.domElement );
			//
			document.body.appendChild( THREE.WEBVR.createButton( renderer ) );
			// controllers (snake functions)
			function onSelectStart() {
				this.userData.isSelecting = true;
				this.userData.startPx=this.position.x;
				this.userData.startPy=this.position.y;
				this.userData.startPz=this.position.z;
				var material = new THREE.MeshLambertMaterial( {color: 0x00ff00} );
				this.remove(this.userData.sphere);
				this.userData.sphere=new THREE.Mesh( this.userData.geometry, material );
				this.add(this.userData.sphere);
				vibrate(0.9,5,this);
			}
			function onSelectEnd() {
				this.userData.isSelecting = false;
				this.userData.endPx=this.position.x;
				this.userData.endPy=this.position.y;
				this.userData.endPz=this.position.z;
				lastActiveController=this;
				var material = new THREE.MeshLambertMaterial( {color: 0xffffff} );
				this.remove(this.userData.sphere);
				this.userData.sphere=new THREE.Mesh( this.userData.geometry, material );
				this.add(this.userData.sphere);
				changeDirection(getChosenDirection(this.userData.startPx-this.userData.endPx,this.userData.startPy-this.userData.endPy,this.userData.startPz-this.userData.endPz));
			}
			controller1 = renderer.vr.getController( 0 );
			controller1.addEventListener( 'selectstart', onSelectStart );
			controller1.addEventListener( 'selectend', onSelectEnd );
			scene.add( controller1 );
			controller2 = renderer.vr.getController( 1 );
			controller2.addEventListener( 'selectstart', onSelectStart );
			controller2.addEventListener( 'selectend', onSelectEnd );
			scene.add( controller2 );
			// helpers
			var lineGeometry = new THREE.BufferGeometry();
			lineGeometry.addAttribute( 'position', new THREE.Float32BufferAttribute( [ 0, 0, 0, 0, 0, - 1 ], 3 ) );
			lineGeometry.addAttribute( 'color', new THREE.Float32BufferAttribute( [ 0.5, 0.5, 0.5, 0, 0, 0 ], 3 ) );
			var material = new THREE.LineBasicMaterial( { vertexColors: true, blending: THREE.AdditiveBlending } );
			controller1.add( new THREE.Line( lineGeometry, material ) );
			controller2.add( new THREE.Line( lineGeometry, material ) );

			controller1.userData.geometry = new THREE.SphereGeometry( 0.04, 32, 32 );
			var material = new THREE.MeshLambertMaterial( {color: 0xffffff} );
			controller1.userData.sphere=new THREE.Mesh( controller1.userData.geometry, material );
			controller1.add(controller1.userData.sphere);
			controller2.userData.geometry = new THREE.SphereGeometry( 0.04, 32, 32 );
			controller2.userData.sphere=new THREE.Mesh( controller2.userData.geometry, material );
			controller2.add(controller2.userData.sphere);
			//
			window.addEventListener( 'resize', onWindowResize, false );
			//load font
			const text_loader = new THREE.FontLoader()
	        	text_loader.load('fonts/helvetiker_regular.typeface.json', function (fontf) {
	        	font=fontf;
	            refreshText();
	        });
        	//haptic
        	controller1.haptic=null;
        	controller2.haptic=null;
        	//sounds
        	var listener = new THREE.AudioListener();
			camera.add(listener);
        	sound = new THREE.PositionalAudio(listener);
        	appleSound = new THREE.PositionalAudio(listener);
        	//particles
        	var tmp=null;
        	for(var i=0;i<100;i++)
        	{
        		tmp=new THREE.Mesh( geometry, new THREE.MeshBasicMaterial( { color: 0xffffff , opacity: 0.3,transparent: true } ) );
        		tmp.userData.ttl=0;
			    tmp.scale.x=0.003;
			    tmp.scale.y=0.003;
			    tmp.scale.z=0.003;
			    tmp.userData.dx=0;
			    tmp.userData.dy=-0.001;
			    tmp.userData.dz=0;
			    particles.push(tmp);
			    room.add(tmp);
        	}
			generateLevel();
		}
		function onWindowResize() {
			camera.aspect = window.innerWidth / window.innerHeight;
			camera.updateProjectionMatrix();
			renderer.setSize( window.innerWidth, window.innerHeight );
		}
		//
		function animate() {
			renderer.setAnimationLoop( render );
		}
		function render()
		{
			if(!soundLoaded && renderer.vr.isPresenting())
				loadSound();
			//stop time
			if(controller1.userData.isSelecting && controller2.userData.isSelecting)
			{
				level=1;
			}
			else if(level!=2) 
				level=0;
			//snake functions
			if(level==0)
			{
				//we move snake only in VR mode
				if(renderer.vr.isPresenting())
				{
					moveSnake();
					//move particles
					for(var i=0;i<particles.length;i++)
					{
						//particles[i].position.x+=particles[i].userData.dx;
						particles[i].position.y+=particles[i].userData.dy;
						//particles[i].position.z+=particles[i].userData.dz;
						particles[i].material.opacity-=0.001;
						if(particles[i].userData.ttl--<0 || particles[i].position.y<0)
						{
						    particles[i].position.x=rand(-2000,2000)*0.0009;
						    particles[i].position.y=rand(200,4000)*0.0009;
						    particles[i].position.z=rand(-2000,2000)*0.0009;
						    particles[i].userData.ttl=rand(300,3000);
						    particles[i].material.opacity=particles[i].userData.ttl/5000;
						}
					}
					for(var i=0;i<foods.length;i++)
					{
						//eat an apple
						if(distanceFrom(snakeHead,foods[i])<snakeSize/2+foods[i].size/2)
			            {
			            	updateScore(50);
			                snakeGrowing=foods[i].nutriment;
			                room.remove(foods[i].tdObject);
			                foods.splice(i,1);
			                i=i-1;
			                snakeSpeed+=0.001;//slightly increase speedd
			                appleSound.play();
			                continue;
			            }
			            //animazione di spawn mele
						if(foods[i].growth<=1)
						{
		                    foods[i].growth+=0.01;
		                    foods[i].tdObject.scale.x=foods[i].size*foods[i].growth;
						    foods[i].tdObject.scale.y=foods[i].size*foods[i].growth;
						    foods[i].tdObject.scale.z=foods[i].size*foods[i].growth;
		                }
		            }
			        if(newFoodCooldown--<0)
			        {
			            generateApple();
			            newFoodCooldown=rand(200,900)+foods.length*10;
			        }
			        if(checkCollisions())
			        {
			        	gameOver();
			        }
			    }
			}
			else if(level==2)
			{
				//cibo
				for(var i=0;i<foods.length;i++)
				if(foods[i].growth>0)
				{
                    foods[i].growth-=0.1;
                    foods[i].tdObject.scale.x=foods[i].size*foods[i].growth;
				    foods[i].tdObject.scale.y=foods[i].size*foods[i].growth;
				    foods[i].tdObject.scale.z=foods[i].size*foods[i].growth;
                }
                else room.remove(foods[i].tdObject);
                var tmp=snakeHead;
			    while(tmp!=null)
			    {
			    	if(tmp.growth>0)
			    	{
			    		tmp.growth-=0.1;
	                    tmp.tdObject.scale.x=snakeSize*tmp.growth;
					    tmp.tdObject.scale.y=snakeSize*tmp.growth;
					    tmp.tdObject.scale.z=snakeSize*tmp.growth;
			    	}
			    	else room.remove(tmp.tdObject);
			        tmp=tmp.next;
			    }
			    if(gameOverCoooldown--<0)
			    {
			    	generateLevel();
			    }
			}
			

			renderer.render( scene, camera );
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
		</script>
	</body>
</html>
