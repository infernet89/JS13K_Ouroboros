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
		var snakeSpeed=0.001;
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
		var controller1, controller2;
		var room;
		var count = 0;
		var normal = new THREE.Vector3();
		var relativeVelocity = new THREE.Vector3();
		var clock = new THREE.Clock();
		init();
		animate();

		//Snake functions
		function generateLevel()
		{
		    snakeHead=new Object();
		    snakeHead.x=0;
		    snakeHead.y=1;
		    snakeHead.z=0;
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
		    var geometry = new THREE.BoxGeometry( 1, 1, 1 );
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
		}
		function moveSnake(piece)
		{
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

		    //aggiusta il tdObject in base alla crescita
		    if(piece.direction==8)//top
		    {
		        piece.tdObject.scale.y=snakeSize+piece.meat;
		        piece.tdObject.position.y-=piece.meat/2;
		    }
		    else if(piece.direction==2)//bottom
		    {
		        piece.tdObject.scale.y=snakeSize+piece.meat;
		        piece.tdObject.position.y+=piece.meat/2;
		    }
		    else if(piece.direction==4)//left
		    {
		        piece.tdObject.scale.x=snakeSize+piece.meat;
		        piece.tdObject.position.x+=piece.meat/2;
		    }
		    else if(piece.direction==6)//right
		    {
		        piece.tdObject.scale.x=snakeSize+piece.meat;
		        piece.tdObject.position.x-=piece.meat/2;
		    }
		    else if(piece.direction==5)//allontana
		    {
		        piece.tdObject.scale.z=snakeSize+piece.meat;
		        piece.tdObject.position.z-=piece.meat/2;
		    }
		    else if(piece.direction==7)//avvicina
		    {
		        piece.tdObject.scale.z=snakeSize+piece.meat;
		        piece.tdObject.position.z+=piece.meat/2;
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
		//3d Functions
		function init() {
			scene = new THREE.Scene();
			scene.background = new THREE.Color( 0x101010 );
			camera = new THREE.PerspectiveCamera( 70, window.innerWidth / window.innerHeight, 0.1, 10 );
			room = new THREE.LineSegments(
				new BoxLineGeometry( 4, 4, 4, 10, 10, 10 ),
				new THREE.LineBasicMaterial( { color: 0xB0F0B0 } )
			);
			room.geometry.translate( 0, 2, 0 );
			scene.add( room );
			var light = new THREE.HemisphereLight( 0xffffff, 0x444444 );
			light.position.set( 1, 1, 1 );
			scene.add( light );
			//var geometry = new THREE.IcosahedronBufferGeometry( radius, 2 );
			var geometry = new THREE.BoxGeometry( 0.1, 0.1, 0.1 );
			for ( var i = 0; i < 100; i ++ ) {
				var object = new THREE.Mesh( geometry, new THREE.MeshLambertMaterial( { color: Math.random() * 0xffffff } ) );
				object.position.x = 0;//Math.random() * 4 - 2;
				object.position.y = 0;//Math.random() * 4;
				object.position.z = 0;//Math.random() * 4 - 2;
				/*object.userData.velocity = new THREE.Vector3();
				object.userData.velocity.x = Math.random() * 0.01 - 0.005;
				object.userData.velocity.y = Math.random() * 0.01 - 0.005;
				object.userData.velocity.z = Math.random() * 0.01 - 0.005;*/
				room.add( object );
			}
			//
			renderer = new THREE.WebGLRenderer( { antialias: true } );
			renderer.setPixelRatio( window.devicePixelRatio );
			renderer.setSize( window.innerWidth, window.innerHeight );
			renderer.vr.enabled = true;
			document.body.appendChild( renderer.domElement );
			//
			document.body.appendChild( THREE.WEBVR.createButton( renderer ) );
			// controllers
			function onSelectStart() {
				this.userData.isSelecting = true;
				this.userData.startPx=this.position.x;
				this.userData.startPy=this.position.y;
				this.userData.startPz=this.position.z;
			}
			function onSelectEnd() {
				this.userData.isSelecting = false;
				this.userData.endPx=this.position.x;
				this.userData.endPy=this.position.y;
				this.userData.endPz=this.position.z;
				snakeHead.direction=getChosenDirection(this.userData.startPx-this.userData.endPx,this.userData.startPy-this.userData.endPy,this.userData.startPz-this.userData.endPz);
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
			var geometry = new THREE.BufferGeometry();
			geometry.addAttribute( 'position', new THREE.Float32BufferAttribute( [ 0, 0, 0, 0, 0, - 1 ], 3 ) );
			geometry.addAttribute( 'color', new THREE.Float32BufferAttribute( [ 0.5, 0.5, 0.5, 0, 0, 0 ], 3 ) );
			var material = new THREE.LineBasicMaterial( { vertexColors: true, blending: THREE.AdditiveBlending } );
			controller1.add( new THREE.Line( geometry, material ) );
			controller2.add( new THREE.Line( geometry, material ) );
			//
			window.addEventListener( 'resize', onWindowResize, false );

			generateLevel();
		}
		function onWindowResize() {
			camera.aspect = window.innerWidth / window.innerHeight;
			camera.updateProjectionMatrix();
			renderer.setSize( window.innerWidth, window.innerHeight );
		}
		function handleController( controller ) {
			if ( controller.userData.isSelecting ) {
				var object = room.children[ count ++ ];
				object.position.copy( controller.position );
				/*object.userData.velocity.x = ( Math.random() - 0.5 ) * 3;
				object.userData.velocity.y = ( Math.random() - 0.5 ) * 3;
				object.userData.velocity.z = ( Math.random() - 9 );
				object.userData.velocity.applyQuaternion( controller.quaternion );*/
				if ( count === room.children.length ) count = 0;
			}
		}
		//
		function animate() {
			renderer.setAnimationLoop( render );
		}
		function render() {
			/*handleController( controller1 );
			handleController( controller2 );*/
			//snake functions
			moveSnake(snakeHead);
			//
			var delta = clock.getDelta() * 0.8; // slow down simulation
			for ( var i = 0; i < room.children.length; i ++ ) {
				var object = room.children[ i ];
				/*object.position.x += object.userData.velocity.x * delta;
				object.position.y += object.userData.velocity.y * delta;
				object.position.z += object.userData.velocity.z * delta;*/
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
