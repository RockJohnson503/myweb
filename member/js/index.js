/*调节头部边框速度*/
var speed=100
$(function(){
	$(".search input").focus(function(){
		$(".left_border").stop().animate({height:'40px'},speed)
		setTimeout(function(){
			$(".top_border").stop().animate({width:'465px'},speed)
			setTimeout(function(){
				$(".right_border").stop().animate({height:'32px'},speed)
			},speed)	
		},speed)		
	})
	$(".search input").blur(function(){
		$(".right_border").stop().animate({height:'0'},speed)
		setTimeout(function(){
			$(".top_border").stop().animate({width:'0'},speed)
			setTimeout(function(){
				$(".left_border").stop().animate({height:'0'},speed)
			},speed)	
		},speed)		
	})
	
	
	
	
	
	
	
//=========================================================================================

var spinner = document.querySelector('#spinner');

        var angle = 0;

        var numpics = $('figure#spinner figure').length;

        degInt = 360 / numpics;

        var start = 0;

        var current = 1;

        $(document).ready(function () {

            $('figure#spinner figure').each(function () {

                $(this).css('-webkit-transform', 'rotateY(-' + start + 'deg)');

                $(this).css('transform', 'rotateY(-' + start + 'deg)');

                start = start + degInt;

            });

        });

        function setCurrent(current) {

            $('figure#spinner figure:nth-child(' + current + ')').addClass('current');

        }

        function galleryspin(sign) {

            $('figure#spinner figure').removeClass('current focus caption');

            if (!sign) {

                angle = angle + degInt;

                current = current + 1;

                if (current > numpics) {

                    current = 1;

                }

            } else {

                angle = angle - degInt;

                current = current - 1;

                if (current == 0) {

                    current = numpics;

                }

            }

            spinner.setAttribute('style', '-webkit-transform: rotateY(' + angle + 'deg); -moz-transform: rotateY(' + angle + 'deg); transform: rotateY(' + angle + 'deg)');

            setCurrent(current);

        }

        $('figure#spinner figure').click(function () {

            if ($(this).hasClass('current')) {

                $(this).toggleClass('focus');

            }

        });

        setCurrent(1);

        $(document).keydown(function (e) {

            switch (e.which) {

                case 37:

                    galleryspin('-');

                    break;

                case 39:

                    galleryspin('');

                    break;

                case 90:

                    $('figure#spinner figure.current').toggleClass('focus');

                    break;

                case 67:

                    $('figure#spinner figure.current').toggleClass('caption');

                    break;

                default:

                    return;

            }

            e.preventDefault();

        });
	
	
	
	
	
})




