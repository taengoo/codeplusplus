
var Game = new function() {
	this.initialize = function( canvasElementId, spriteData, callback ) {
		this.canvas = document.getElementById(canvasElementId);
		this.width  = this.canvas.width;
		this.height = this.canvas.height;

		// Set up rendering context
		this.ctx = this.canvas.getContext && this.canvas.getContext('2d');
		if (!this.ctx) {
			return alert('Please update your browser to play');
		}

		// Set up input
		this.setupInput();

		// Start the game loop
		this.loop();

		// Load the sprite sheet and pass forward the callback
		SpriteSheet.load(spriteData,callback);
	};

	// Handle input
	var KEY_CODES = { 37: 'left', 39: 'right', 32: 'fire'};

	this.keys = { };

	this.setupInput = function() {
		window.addEventListener('keydown', function(e){
			if (KEY_CODES[e.keyCode]) {
				Game.keys[KEY_CODES[e.keyCode]] = true;
				e.preventDefault();
			}
		}, false);

		window.addEventListener('keyup', function(e){
			if (KEY_CODES[e.keyCode]) {
				Game.keys[KEY_CODES[e.keyCode]] = false;
				e.preventDefault();
			}
		}, false);
	};

	var boards = [];

	// Game loop
	this.loop = function() {
		var dt = 30/1000;
		for (var i=0, len = boards.length; i < len; i++) {
			if (boards[i]) {
				boards[i].step(dt);
				boards[i] && boards[i].draw(Game.ctx);
			}
		}

		setTimeout(Game.loop,30);
	};

	this.setBoard = function( num, board ) { boards[num] = board };
};

var SpriteSheet = new function() {
	this.map = { };
	this.load = function( spriteData, callback ) {
		this.map = spriteData;
		this.image = new Image();
		this.image.onload = callback;
		this.image.src = 'images/sprites.png';
	};

	this.draw = function( ctx, sprite, x, y, frame ) {
		var s = this.map[sprite];

		if (!frame) {
			frame = 0;
		}

		ctx.drawImage(this.image,
			s.sx + frame * s.w,
			s.sy,
			s.w, s.h,
			x, y,
			s.w, s.h
		);
	};
};

var TitleScreen = function ( title, subtitle, callback ) {
	this.step = function (dt) {
		if (Game.keys['fire'] && callback) {
			callback();
		}
	};

	this.draw = function (ctx) {
		ctx.fillStyle = "#FFFFFF";
		ctx.textAlign = "center";

		ctx.font = "bold 40px bangers";
		ctx.fillText(title,Game.width/2,Game.height/2);

		ctx.font = "bold 40px bangers";
		ctx.fillText(subtitle,Game.width/2,Game.height/2 + 40);
	};
};
