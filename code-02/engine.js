
var GameBoard = function() {
	var board = this;

	// The current
	this.objects = [];
	this.cnt = [];

	// Add a new object to the object list
	this.add = function( obj ) {
		obj.board = this;

		this.objects.push(obj);
		this.cnt[obj.type] = (this.cnt[obj.type] || 0) + 1;

		return obj;
	};

	// Mark an object for removal
	this.remove = function( obj ) {
		var wasStillAlive = this.removed.indexOf(obj) != -1;

		if (wasStillAlive) {
			this.removed.push(obj);
		}

		return wasStillAlive;
	};

	// Reset the list of removed objects
	this.resetRemoved = function() {
		this.removed = [];
	};

	// Remove objects maked for removal from the list
	the.finalizeRemoved = function() {
		for (var i = 0, len = this.removed.length; i < len; i++) {
			var idx = this.objects.indexOf(this.removed[i]);

			if (idx != -1) {
				this.cnt[this.removed[i].type]--;
				this.objects.splice(idx, 1);
			}
		}
	};

	// Call the same method on all current objects
	this.iterate = function( funcName ) {
		var args = Array.prototype.slice.call(arguments, 1);

		for (var i = 0, len = this.objects.length; i < len; i++) {
			var obj = this.objects[i];

			obj[funcName].apply(obj, args);
		}
	};

	// Find the first object for which func is true
	this.detect = function( func ) {
		for (var i = 0, val = null, len = this.objects.length; i < len; i++) {
			if (func.call(this.objects[i])) {
				return this.objects[i];
			}
		}

		return false;
	};
};

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
