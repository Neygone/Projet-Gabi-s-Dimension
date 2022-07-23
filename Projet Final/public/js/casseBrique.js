'use strict';

let platform = 
{
    length: 100,
    height: 20,
    x: 440,
    y: 1200,
    directionX: 1,
    directionY: 1,
    color: '#fff',
};

let ball = 
{
    radius: 25,
    length: 100,
    x: Math.random() * (900 - 80) + 80,
    y: 875,
    directionX: 2,
    directionY: -2,
    color: '#afece7',
    speedX: 0.5,
    speedY: -0.5,
};

let obstacle =
{
    length: 200,
    height: 50,
    x: 0,
    y: 600,
    directionX: 2,
    directionY: -2,
    color: '#000',
};

let brickRowCount = 7;
let brickColumnCount = 3;
let brickLength = 122.5;
let brickHeight = 40;
let bricks = [];

let canvas;
let ctx;

let leftButton;
let rightButton;

let loserMessage;
let loserButton;
let loserPopUp;
let inputValue;
let score_input;
let quitButton;
let quitPopUp;

let casse_brique_score;
let score;
let nb_games;
let inputNbGames;

const width = window.innerWidth;
const height = window.innerHeight;

document.addEventListener('DOMContentLoaded', function()
{
    canvas = document.querySelector( '#canvas' );
    ctx = canvas.getContext( '2d' );
    
    leftButton = document.querySelector( '#leftButton' );
    rightButton = document.querySelector( '#rightButton' );
    
    loserMessage = document.querySelector( '#loserMessage' );
    loserButton = document.querySelector( '#loserButton' );
    loserPopUp = document.querySelector( '#loserPopUp' );
    inputValue = document.querySelector( '#casse_brique_input' );
    score_input = document.querySelector('#score_input');
    quitButton = document.querySelector('#quitButton');
    quitPopUp = document.querySelector('#quitPopUp');
    
    casse_brique_score = document.querySelector( '#casse_brique_score' );
    score = 0;
    
    function movePlatformToRight()
    {
        if( platform.x + platform.length < canvas.width )
            {
                platform.x += 50;
            }
        
        displayPlatform();
    }
    
    function movePlatformToLeft()
    {
        if ( platform.x > 0 )
            {
                platform.x -= 50;
            }
         
        displayPlatform();
    }
    
    function displayPlatform() 
    {
        ctx.beginPath();
        ctx.rect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = platform.color;
        ctx.fillRect(platform.x, platform.y, platform.length, platform.height);
        ctx.closePath();
    }
    
    function movePlatformWithArrows(e) 
    {
        switch( e.key )
        {
            case 'ArrowRight':
                if ( platform.x + platform.length < canvas.width )
                {
                    platform.x += 50;
                    break;
                }
                
            case 'ArrowLeft':
                if ( platform.x > 0 )
                {
                    platform.x -= 50;
                    break;
                }
        }
            
        displayPlatform();
    }
    
    function obstacleBallCollision()
    {   
        // Si la balle touche le dessous de l'obstacle.
        if(ball.y + ball.directionY - ball.radius > canvas.height - (obstacle.y + obstacle.height) && ball.y + ball.directionY - ball.radius < canvas.height - (obstacle.y + obstacle.height) + ball.radius)
        {
            // Si le x de la balle est égal au x de l'obstacle.
            if(ball.x + ball.radius > obstacle.x && ball.x + ball.radius < obstacle.x + obstacle.length)
            {
                console.log('Je descends');
                ball.directionY = -ball.directionY;
            }
        }
        
        // Si la balle touche le dessus de l'obstacle.
        else if(ball.y + ball.directionY + ball.radius > obstacle.y - obstacle.height)
        {
            
            // Si le x de la balle est égal au x de l'obstacle.
            if(ball.x + ball.directionX > obstacle.x - ball.radius && ball.x + ball.radius < obstacle.x + obstacle.length)
            {
                
                console.log('Je monte');
                
            }
        }
    }
    
    function displayObstacle()
    {
        ctx.beginPath();
        ctx.rect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = obstacle.color;
        ctx.fillRect(obstacle.x, obstacle.y, obstacle.length, obstacle.height);
        ctx.closePath();
    }
    
    function moveObstacle()
    {
        // ctx.clearRect(0, 0, canvas.width, canvas.height);
        displayObstacle();
        
        // Si l'obstacle touche le bord droit du canvas.
        if(obstacle.x + obstacle.directionX > canvas.width - obstacle.length)
        {
            obstacle.directionX = -obstacle.directionX;
        }
        
        // Si l'obstacle touche le bord gauche du canvas.
        else if(obstacle.x + obstacle.directionX < obstacle.length - 200)
        {
            obstacle.directionX = -obstacle.directionX;
        }
        
        obstacle.x += obstacle.directionX;
    }
    
    function displayBall() 
    {
        ctx.beginPath();
        ctx.arc(ball.x, ball.y, ball.radius, 0, 2 * Math.PI, false);
        ctx.fillStyle = ball.color;
        ctx.fill();
        ctx.closePath();
    }
    
    function displayLeftButton()
    {
        ctx.fillStyle = leftButton.color;
        ctx.fillRect(leftButton.x, leftButton.y, leftButton.length, leftButton.length);
    }
    
    function displayRightButton()
    {
        ctx.fillStyle = rightButton.color;
        ctx.fillRect(rightButton.x, rightButton.y, rightButton.length, rightButton.length);
    }
    
    for(let i = 0; i < brickColumnCount; i++)
    {
        bricks[i] = [];
        for(let j = 0; j < brickRowCount; j++)
        {
            bricks[i][j] = { x: 0, y: 0, status: 1 };
        }
    }
    
    function destroyBricks()
    {
        for(let i = 0; i < brickColumnCount; i++)
        {
            for(let j = 0; j < brickRowCount; j++)
            {
                let b = bricks[i][j];
                if(b.status == 1)
                {
                    if(ball.x + ball.directionX > b.x && ball.x < b.x+brickLength && ball.y + ball.directionY > b.y && ball.y < b.y+brickHeight)
                    {
                        ball.directionX = -ball.directionX - ball.speedY;
                        ball.directionY = -ball.directionY - ball.speedY;
                        // Faire disparaître les briques une fois détruites.
                        b.status = 0;
                        score++;
                        // Faire réapparaître les briques détruites au bout de 20s.
                        window.setTimeout(function(){
                            b.status = 1;  
                        },20000);
                    }
                
                }
            
            }

        }
    }
    
    function displayBricks() 
    {
        for(let i = 0; i < brickColumnCount; i++)
        {
            for(let j = 0; j < brickRowCount; j++)
            {
                if(bricks[i][j].status == 1)
                {
                    let brickX = (j*(brickLength + 10)) + 30;
                    let brickY = (i*(brickHeight + 30)) + 30;
                    bricks[i][j].x = brickX;
                    bricks[i][j].y = brickY;
                    ctx.beginPath();
                    ctx.rect(brickX, brickY, brickLength, brickHeight);
                    ctx.fillStyle = "#5c3c92";
                    ctx.fill();
                    ctx.closePath();
                }
            }
        }
    }
    
    // Démarrer le jeu.
    function moveBall()
    {
        // Faire rebondir la balle sur le mur du haut.
        if(ball.y + ball.directionY < ball.radius)
        {
            ball.directionY = -ball.directionY;
        }   
        
        
        else if(ball.y + ball.directionY > canvas.height - (ball.radius + platform.height))
        {
            
            // Faire rebondir la balle sur la plateforme.
            if(ball.x > platform.x && ball.x - (ball.radius / 2) < platform.x + platform.length)
            {
                ball.directionY = -ball.directionY;
                ball.directionX = ball.directionX;
            }
            
            // Mettre fin au jeu si la balle touche le mur du bas.
            else
            {
                gameOver();
            }
        }
        
        // Faire rebondir la balle sur les murs de gauche et de droite.
        else if(ball.x + ball.directionX > canvas.width - ball.radius || ball.x + ball.directionX < ball.radius)
        {
            ball.directionX = -ball.directionX;
        }
        
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        displayBall();
        displayPlatform();
        displayObstacle();
        displayBricks();
        destroyBricks();
        obstacleBallCollision();
        moveObstacle();
        document.addEventListener( 'keydown', movePlatformWithArrows );
        rightButton.addEventListener( 'touchstart', movePlatformToRight );
        leftButton.addEventListener( 'touchstart', movePlatformToLeft );

        casse_brique_score.innerHTML = score;
        ball.x += ball.directionX;
        ball.y += ball.directionY;
        
    }
    
    // Si le joueur appuie sur le bouton 'REJOUER'.
    function restart() 
    {
        // On recharge la page.
        document.location.reload();
    }
    
    // Si la balle touche le bas du canvas :
    function gameOver()
    {
        loserPopUp.classList.add("displayLoserPopUp");
        loserMessage.classList.add("displayLoserMessage");
        loserMessage.innerHTML = "Perdu ! Ton score est : <br><br> " + score;
        loserButton.classList.add("displayLoserButton");
        quitButton.classList.add("displayQuitButton");
        loserButton.innerHTML = "SAUVEGARDER ET REJOUER";
        quitButton.innerHTML = "SAUVEGARDER ET QUITTER";
        
        window.clearTimeout(timeOutBall);
        window.clearTimeout(timeOutObstacle);
        document.removeEventListener('keydown', movePlatformWithArrows);
        document.removeEventListener('touchstart', movePlatformToLeft);
        document.removeEventListener('touchstart', movePlatformToRight);
        
        inputValue.value = score;
        score_input.value = score;
        loserButton.addEventListener( 'click', restart );
        loserButton.addEventListener( 'touchstart', restart );
        
        window.clearInterval(intervalBall);
        window.clearInterval(intervalObstacle);
    }
    
    // Faire bouger la balle toutes les 10ms.
    let intervalBall = setInterval(moveBall, 10);
    
    // Faire bouger l'obstacle toutes les 10ms.
    let intervalObstacle = setInterval(moveObstacle, 10);
    
    let timeOutBall = setTimeout(moveBall, 10);
    
    let timeOutObstacle = setTimeout(moveObstacle, 10);
    
});