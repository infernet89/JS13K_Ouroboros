<!DOCTYPE html>
<html lang="en">
	<head>
		<title>5 TEST</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	
	</head>
	<body>

	

		<script type="module">
			//import * as THREE from 'https://threejs.org/examples/../build/three.module.js';
			import * as THREE from './three.module.js';
			import { BoxLineGeometry } from './BoxLineGeometry.js';
			var camera, scene, renderer;
			var controller1, controller2;
			var room;
			var count = 0;
			var radius = 0.08;
			var normal = new THREE.Vector3();
			var relativeVelocity = new THREE.Vector3();
			var clock = new THREE.Clock();
			init();
			animate();
			//<BoxLineGeometry>

			//<BoxLineGeometry>
			function init() {
				scene = new THREE.Scene();
				scene.background = new THREE.Color( 0x505050 );
				camera = new THREE.PerspectiveCamera( 70, window.innerWidth / window.innerHeight, 0.1, 10 );
				room = new THREE.LineSegments(
					new BoxLineGeometry( 6, 6, 6, 10, 10, 10 ),
					new THREE.LineBasicMaterial( { color: 0x808080 } )
				);
				room.geometry.translate( 0, 3, 0 );
				scene.add( room );
				var light = new THREE.HemisphereLight( 0xffffff, 0x444444 );
				light.position.set( 1, 1, 1 );
				scene.add( light );
				//var geometry = new THREE.IcosahedronBufferGeometry( radius, 2 );
				var geometry = new THREE.BoxGeometry( radius, radius, radius );
				for ( var i = 0; i < 200; i ++ ) {
					var object = new THREE.Mesh( geometry, new THREE.MeshLambertMaterial( { color: Math.random() * 0xffffff } ) );
					object.position.x = Math.random() * 4 - 2;
					object.position.y = Math.random() * 4;
					object.position.z = Math.random() * 4 - 2;
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
				}
				function onSelectEnd() {
					this.userData.isSelecting = false;
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
				handleController( controller1 );
				handleController( controller2 );
				//
				var delta = clock.getDelta() * 0.8; // slow down simulation
				var range = 3 - radius;
				for ( var i = 0; i < room.children.length; i ++ ) {
					var object = room.children[ i ];
					/*object.position.x += object.userData.velocity.x * delta;
					object.position.y += object.userData.velocity.y * delta;
					object.position.z += object.userData.velocity.z * delta;*/
				}
				renderer.render( scene, camera );
			}
		</script>
	</body>
</html>
