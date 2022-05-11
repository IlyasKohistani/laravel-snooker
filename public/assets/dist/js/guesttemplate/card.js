(function () {
    $(window).load(function () {
        var walkthrough;
        walkthrough = {
            index: 0,
            nextScreen: function () {
                if (this.index < this.indexMax()) {
                    this.index++;
                    carousel();
                    return this.updateScreen();
                }
            },
            prevScreen: function () {
                if (this.index > 0) {
                    this.index--;
                    carousel();
                    return this.updateScreen();
                }
            },
            updateScreen: function () {
                this.reset();
                this.goTo(this.index);
                carousel();
                return this.setBtns();
            },
            setBtns: function () {
                var $lastBtn, $nextBtn, $prevBtn;
                $nextBtn = $('.next-screen');
                $prevBtn = $('.prev-screen');
                $lastBtn = $('.finish');
                if (walkthrough.index === walkthrough.indexMax()) {
                    $nextBtn.prop('disabled', true);
                    $prevBtn.prop('disabled', false);
                    return $lastBtn.addClass('active').prop('disabled', false);
                } else if (walkthrough.index === 0) {
                    $nextBtn.prop('disabled', false);
                    $prevBtn.prop('disabled', true);
                    return $lastBtn.removeClass('active').prop('disabled', true);
                } else {
                    $nextBtn.prop('disabled', false);
                    $prevBtn.prop('disabled', false);
                    return $lastBtn.removeClass('active').prop('disabled', true);
                }
            },
            goTo: function (index) {
                $('.screen').eq(index).addClass('active');
                return $('.dot').eq(index).addClass('active');
            },
            reset: function () {
                return $('.screen, .dot').removeClass('active');
            },
            indexMax: function () {
                return $('.screen').length - 1;
            },
            closeModal: function () {
                $('.walkthrough, .shade').removeClass('reveal');
                return setTimeout(() => {
                    $('.walkthrough, .shade').removeClass('show');
                    this.index = 0;
                    return this.updateScreen();
                }, 200);
            },
            openModal: function () {
                $('.walkthrough, .shade').addClass('show');
                setTimeout(() => {
                    return $('.walkthrough, .shade').addClass('reveal');
                }, 200);
                return this.updateScreen();
            }
        };

        $('.next-screen').click(function () {
            return walkthrough.nextScreen();
        });
        $('.prev-screen').click(function () {
            return walkthrough.prevScreen();
        });
        $('.close').click(function () {
            return walkthrough.closeModal();
        });
        $('.open-walkthrough').click(function () {
            return walkthrough.openModal();
        });
        var lastCall = 0;
        var firstCall = 0;
        var delay = 0;
        function carousel() {
            if (firstCall == 1 && lastCall >= (Date.now() - delay)) { return; }
            if (firstCall == 0) { delay = 3000; firstCall = 1; } else { delay = 8000; };
            lastCall = Date.now();
            setTimeout(() => {
                if (walkthrough.index == walkthrough.indexMax()) {
                    walkthrough.index = 0;
                    return walkthrough.updateScreen();
                } else {
                    return walkthrough.nextScreen();
                }
            }, delay);
        }
        carousel();

        walkthrough.openModal();

        // Optionally use arrow keys to navigate walkthrough
        return $(document).keydown(function (e) {
            switch (e.which) {
                case 37:
                    // left
                    walkthrough.prevScreen();
                    break;
                case 38:
                    // up
                    // walkthrough.openModal();
                    break;
                case 39:
                    // right
                    walkthrough.nextScreen();
                    break;
                case 40:
                    // down
                    // walkthrough.closeModal();
                    break;
                default:
                    return;
            }

            e.preventDefault();
        });
    });




}).call(this);




  //# sourceURL=coffeescript