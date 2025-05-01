$(document).ready(function () {
        $('.menubar-section .sidebar ul li a[href*=#]').bind('click', function (e) {
                // e.preventDefault(); 
                var target = $(this).attr("href");
                // console.log(target);
                $('html, body').stop().animate({
                        scrollTop: $(target).offset().top - 89
                }, 600
                        // location.hash = target; 
                );

                // return false;
        });


        //Call Sweet alert on delete click
        
        jQuery('.delete_help_item').click(function(e){
                e.preventDefault();
                // console.log('ff');
                Swal.fire({
                        title: "Are you sure?",
                        showDenyButton: true,
                        // showCancelButton: true,
                        confirmButtonText: "Yes",
                        // denyButtonText: `Cancel`
                      }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                          //Swal.fire("Saved!", "", "success");
                          window.location.href = jQuery(this).attr('href');
                          return true;
                        } else if (result.isDenied) {
                                return false;
                          //Swal.fire("Changes are not saved", "", "info");
                        }
                      });
        });
});

$(window).scroll(function () {
        var scrollDistance = $(window).scrollTop();
        $('.content-main .content').each(function (i) {
                if ($(this).position().top <= scrollDistance) {
                        $('.sidebar a.active').removeClass('active');
                        $('.sidebar a').eq(i).addClass('active');
                }
        });
}).scroll();
document.addEventListener("DOMContentLoaded", function () {
        const links = document.querySelectorAll('a[href^="#"]');

        links.forEach(link => {
                link.addEventListener("click", function (event) {
                        event.preventDefault();
                        const hash = this.getAttribute("href");
                        document.querySelector(hash).scrollIntoView({
                                behavior: "smooth"
                        });
                });
        });
});