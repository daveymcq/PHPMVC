window.onload = function()
{
    var clicked = false;
    var dropdownMenu = document.getElementsByClassName("dropdown-menu")[0];
    var logo = document.getElementsByClassName('logo')[0];
    var logoBackground = logo.style.background;
    var mediaQueryCondition = window.matchMedia('(max-width: 1000px)');

    mediaQueryCondition.addListener(function()
    {
        if(this.matches)
        {
            dropdownMenu.style.display = "none";
            clicked = false;
        }
        else
        {
            logo.style.background = logoBackground;
        }
    });

    logo.getElementsByClassName('mobile')[0].onclick = function()
    {
        if(mediaQueryCondition.matches)
        {
            clicked = !clicked;
            dropdownMenu.style.display = (clicked) ? "block" : "none";
            logo.style.background = (clicked) ? '#333' : logoBackground;

            if(clicked)
            {
                document.getElementById("content-wrapper").onclick = function()
                {
                    dropdownMenu.style.display = "none";
                    logo.style.background = logoBackground;
                    clicked = false;
                    return;
                };
            }
        }
    };
};
