/*
 * @author John Snook
 * @date May 25, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 * Description of dvote
 */


(function () {
    var q = [];
    $("button[data-click-id='downvote']").each(function () {
        var that = this;
        var f = function (index) {
            $(that).trigger('click');
            setTimeout(function () {
                if (q[index]) {
                    q[index](index + 1);
                } else {
                    if (downVoteTimer) {
                        window.clearTimeout(downVoteTimer);
                    }
                }
            }, 1100);
        };
        q.push(f);
    });
    var downVoteTimer = window.setTimeout(function () {
        q[0](1);
    }, 50);
}());