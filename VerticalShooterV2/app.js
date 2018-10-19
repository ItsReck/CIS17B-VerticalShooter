var game = new Phaser.Game(800, 600, Phaser.CANVAS, '2d vertical shooter',
{
    preload: preload,
    create: create,
    update: update,
    render: render
});

var cursors;
var fireButton;
var shields;
var score = 0;
var scoreText;
var gameOver;
var shooterLaunched = false;
//var bossLaunched = false;

var fighter = new Fighter(game);
var enemyShip = new EnemyShip(game);
var shooter = new Shooter(game);
//var boss = new Boss(game);

//load assets
function preload() {
    game.load.image('starfield', 'assets/starfield.gif');
    game.load.image('fighter', 'assets/fighter.png');
    game.load.image('bullet', 'assets/bullet.png');
    game.load.image('enemyShip', 'assets/enemyShip.png');
    game.load.image('shooter', 'assets/shooter.png');
    game.load.image('shooterBullet', 'assets/enemyBullet.png');
    game.load.spritesheet('explosion', 'assets/explode.png', 128, 128);
    game.load.bitmapFont('spacefont', 'assets/spacefont/spacefont.png', 'assets/spacefont/spacefont.xml');
    game.load.image('boss', 'assets/boss.png');
    game.load.image('deathRay', 'assets/deathRay.png');
}

function create() {
    //background
    starfield = game.add.tileSprite(0, 0, 800, 600, 'starfield');

    //create game entities
    fighter.create();
    enemyShip.create();

    //shields HUD
    shields = game.add.bitmapText(game.world.width - 250, 10, 'spacefont', '' + fighter.getHealth() + '%', 50);
    
    //score HUD
    scoreText = game.add.bitmapText(10, 10, 'spacefont', '', 50);
    scoreText.render = function() {
        scoreText.text = 'Score: ' + score;
    };
    scoreText.render();  

    //gameOver HUD
    gameOver = game.add.bitmapText(game.world.centerX, game.world.centerY, 'spacefont', 'GAME OVER!', 110);
    gameOver.x = gameOver.x - gameOver.textWidth / 2;
    gameOver.y = gameOver.y - gameOver.textHeight / 3;
    gameOver.visible = false;

    //add game input controls
    cursors = game.input.keyboard.createCursorKeys();
    fireButton = game.input.keyboard.addKey(Phaser.Keyboard.SPACEBAR);        
}

function update() {
    //background scrolled vertically 2 px every frame
    starfield.tilePosition.y += 2;

    fighter.update(cursors, fireButton);
    //shooter enemies spawns at a score threshold of 1000
    if (!shooterLaunched && score > 1000) {   
       shooter.create();
       shooterLaunched = true;
    }

    //upgrade fighter weapons - nned to fix
    if (score > 2000 && fighter.getWeaponLevel() < 2) {
        fighter.weaponLevel = 2;
    }
    //boss enemy spawns at a score threshold of 5000
    /*
    if (!bossLaunched && score > 2000) {
        boss.create(); 
        bossLaunched = true;   
    }
    */
   
    //test for collisions
    game.physics.arcade.overlap(fighter.getFighter(), enemyShip.getEnemyShipGroup(), fighter.fighterHit, null, this);
    game.physics.arcade.overlap(fighter.getBullets(), enemyShip.getEnemyShipGroup(), fighter.hitEnemyShip, null, this);
    game.physics.arcade.overlap(fighter.getFighter(), shooter.getShooters(), fighter.fighterHit, null, this);
    
    //shields HUD
    shields.render = function() {
        var fighterHealth = fighter.getHealth();
        shields.text = 'Shields: ' + Math.max(fighterHealth, 0) + '%';
    };   
    shields.render();

    //check if game over
    if (! fighter.getAlive() && gameOver.visible === false) {
        gameOver.visible = true;
        gameOver.alpha = 0;

        var fadeInGameOver = game.add.tween(gameOver);
        fadeInGameOver.to({alpha: 1.0}, 1000, Phaser.Easing.Quintic.Out);
        //fadeInGameOver.onComplete.add(setResetHandlers);
        fadeInGameOver.start();
    }
}

function render() {

}


