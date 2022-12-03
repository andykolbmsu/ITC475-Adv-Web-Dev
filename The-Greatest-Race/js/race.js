//      Andy Kolb           
//      The Greatest Race      
//      activities.js          
//      09/29/2022          


//  Initialize character information array
let char = []
char['captain-britain'] = {
    index: 'captain-britain',
    name: 'Captain Britain',
};
char['mystique'] = {
    index: 'mystique',
    name: 'Mystique',
}
char['cyclops'] = {
    index: 'cyclops',
    name: 'Cyclops',
}
char['magneto'] = {
    index: 'magneto',
    name: 'Magneto',
}
char['polaris'] = {
    index: 'polaris',
    name: 'Polaris',
}

let players = [];



//      HOME SCREEN

// Character box onclick
$('.charItem').click(function() {
    let max = 2;
    let index = $(this).attr('data-index');

    if($(this).hasClass('charSelect')) {
        removeCharacter(index);
        $(this).removeClass('charSelect');
    } else {
        if(players.length < 2) {
            players.push(index)
            $(this).addClass('charSelect');
        } else {
            $('#msgContainer').addClass('msgAlert');
            $('#msgText').html('Only two players per game.');
        }
    }

    if(players.length == 2) {
        $('.startBtn').addClass('startBtnActive');
    } else {
        $('.startBtn').removeClass('startBtnActive');
    }

    console.log(players)    
});


$('.startBtn').click(function() {

    if($(this).hasClass('startBtnActive')) {

        $('#homeScreen').css('min-height','0');
        $('#homeScreen').css('height','0');
    
        //  Load players into player tokens
        for(let i=0; i<2; i++) {
            let index = char[players[i]].index;
            let name = char[players[i]].name;
            console.log(name);
            $('#player' + (i+1)).attr('data-index',index).css('background-image','url("images/token/'+index+'.png")');
        }
    
        $('#winnerVsPlayers').html(players[0]+'_versus_'+players[1]);
        $('#winnerBg').addClass('winnerBgLoad');
        $('#winnerImg').addClass('winnerImgLoad');

    }

});

function removeCharacter(index) {
    let newArr = [];
    for(let i=0;i<players.length;i++) {
        if(players[i] != index) {
            newArr.push(players[i]);
        }
    }
    players = newArr;
}


//      PLAY SCREEN

let interval;

$('.buttonStop').click(function() {
    $(this).removeClass('buttonsStop').addClass('buttonStart');
    startRace();
});

function startRace() {
    interval = setInterval(run, 500);
}

function run() {
    let p1, p2, p1move, p2move, finishLine, winnerName,winnerIndex;
    
    p1 = parseInt($('#player1').css('left'));
    p2 = parseInt($('#player2').css('left'));
    finishLine = window.innerWidth - 200;

    p1move = (p1 + (Math.floor(Math.random() * 49)) + 21) + 'px';
    p2move = (p2 + (Math.floor(Math.random() * 49)) + 21) + 'px';


    $('#player1').css('left', p1move);
    $('#player2').css('left', p2move);


    if(parseInt(p1move) >= finishLine || parseInt(p2move) >= finishLine) {
        clearInterval(interval);

        console.log(players[0] + ' ' + p1move)
        console.log(players[1] + ' ' + p2move)

        let winner;
        if(p1move > p2move) {
            winnerName = char[$('#player1').attr('data-index')].name;
            winnerIndex = $('#player1').attr('data-index');
        } else if(p2move > p1move) {
            winnerName = char[$('#player2').attr('data-index')].name;
            winnerIndex = $('#player2').attr('data-index');
        } else {

        }

        $.ajax({
            url: "submit.php",
            method: "POST",
            cache: false,
            data: { player1: players[0], player2: players[1], winner: winnerIndex }
        })

        $('#winnerMsg').html(winnerName + ' wins');
        $('#winnerScreen').show();

        $('#winnerBg').addClass('winnerBgLoad');
        $('#winnerImg').css('background-image','url("images/hero/'+winnerIndex+'.png")').addClass('winnerImgLoad');

    }

}


//      WINNER SCREEN

$('#winnerImg').click(function() {
    raceReset();
});
$('#winnerBg').click(function() {
    raceReset();
});

function raceReset() {
    $('#button').removeClass('buttonStart').addClass('buttonStop');

    $('#player1').css('left','20px');
    $('#player2').css('left','20px');

    $('#winnerScreen').hide();
    $('#winnerBg').removeClass('winnerBgLoad');
    $('#winnerImg').removeClass('winnerImgLoad');
}


//      STATISTICS SCREEN

$('#searchPlayer1').change(function() {
    searchRaces()
});

$('#searchPlayer2').change(function() {
    searchRaces()
});

function searchRaces() {
    let searchPlayer1 = $('#searchPlayer1').val();
    let searchPlayer2 = $('#searchPlayer2').val();

    $('#searchErrorMsg').html('');
    if(searchPlayer1 == searchPlayer2) {
        $('#searchErrorMsg').html('Please select two different players.');
        return;
    }

    if(searchPlayer1 && searchPlayer2) {
        console.log('search')
        $.ajax({
            url: "search.php",
            method: "POST",
            cache: false,
            data: { player1: searchPlayer1, player2: searchPlayer2 }
        })
        .done(function( html ) {
            $('#statsSearchPlayers tbody').html(html);
        });

    }

}