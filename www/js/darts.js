(function () {
    'use strict';

    window.D = {};
    D.init = function () {
        $('.selector a.player').on('click', D.playerClicked);
        $('.selector a.winner').on('click', D.winnerClicked);
        $('.submit-game a').on('click', D.submitGame);
    };
    D.playerClicked = function (e) {
        var $selector = $(this).closest('.selector');
        e.preventDefault();
        $('.submit-game').css({ 'visibility': 'visible' });
        $selector.toggleClass('selected');
        if (!$selector.hasClass('selected')) {
            $selector.find('.winner').removeClass('selected').html('LOSER');
        }
        D.showPotentialResult();
    };
    D.winnerClicked = function (e) {
        e.preventDefault();
        if ($(this).hasClass('selected')) {
            return;
        }
        $(this).addClass('selected');
        $('a.winner').html('LOSER');
        $(this).html('WINNER');
        $('a.winner').not($(this)).removeClass('selected');
        D.showPotentialResult();
    };
    D.submitGame = function (e) {
        var players, winner;
        e.preventDefault();
        if (!D.validGame()) {
            alert('Game must have 2+ players and 1 winner.');
            return;
        }
        $(this).off('click');
        $(this).on('click', D.doNothing);
        $(this).html('SUBMITTING ...');
        $.post(D.u('/api/game/'), D.gameSummary(), D.gameSubmitted, 'json');
        $(this).html('SUBMITTED');
    };
    D.showPotentialResult = function () {
        $('.potential-result').html('');
        if (D.validGame()) {
            $.post(D.u('/api/result/'), D.gameSummary(), D.potentialResultCallback, 'json');
        }
    };
    D.potentialResultCallback = function (data) {
        console.dir(data);
        $('.potential-result').html(data.result);
    };
    D.gameSummary = function () {
        var players = $('.selector.selected a.player').get().map(function (player) { return $(player).data('id'); });
        var winner = $($('.winner.selected').closest('.selector').find('.player').get(0)).data('id');
        return { 'winner': winner, 'players': players };
    };
    D.validGame = function () {
        var numPlayers = $('.selector.selected a.player').size();
        var numWinners = $('.selector.selected a.winner.selected').size();
        return numPlayers > 1 && numWinners === 1;
    };
    D.gameSubmitted = function () {
        window.location.assign(D.u('/'));
    };
    D.doNothing = function (e) {
        e.preventDefault();
    };
    // Pass a string path as the first arg, or true to use current path
    D.u = function (path, absolute, querystringParams) {
        var s = (path === true ? window.location.pathname : path);
        if (absolute) {
            s = window.location.protocol + "//" + window.location.host + s;
        } else {
            s = $('body').data('urlPrefix') + s;
        }
        if (querystringParams) {
            s = $.param.querystring(s, querystringParams);
        }
        return s;
    };
    $(document).ready(window.D.init);
})();
