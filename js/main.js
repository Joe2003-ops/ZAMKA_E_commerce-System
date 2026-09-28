// to-top btn
const scrolltp = document.querySelector('#scrolltp');
const totopbtn = document.querySelector('#to-topbtn');

const navbar = document.querySelector('#navb');

scrolltp.addEventListener('click', function(){
    window.scrollTo({
        top:0,
        left:0,
        behavior:'smooth',
    });   
});
window.addEventListener('scroll',function(){
    if(window.scrollY >= 700){
        totopbtn.style.opacity = 1;
    }
    else{
        totopbtn.style.opacity = 0;
    }
});

//  changing the background of the navigation bar after scroll
window.addEventListener('scroll',function(){
    if(window.scrollY >= 100){
        navbar.style.background = red;
    }
    else{
        navbar.style.background = gold;
    }
});
//to -top btn code end here


// search box
function myFunction() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("search-input");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");

    err = document.getElementById("err");

    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }

}



    // SHOW HIDE FEATURE IN LOGIN FORM
    function myshowhidefunc(){
        let p = document.getElementById('password');
        if (p.type === "password") {
            p.type = "text";
            document.getElementById('hide').style.display = "inline-block";
            document.getElementById('show').style.display = "none";
        } else {
            p.type = "password";
            document.getElementById('hide').style.display = "none";
            document.getElementById('show').style.display = "inline-block";
        }
    }

    // SHOW HIDE FEATURE IN SIGN UP FORM
    function myshowhideconfpassfunc(){
        let m = document.getElementById('password2');
        if (m.type === "password") {
            m.type = "text";
            document.getElementById('hidee').style.display = "inline-block";
            document.getElementById('showw').style.display = "none";
        } else {
            m.type = "password";
            document.getElementById('hidee').style.display = "none";
            document.getElementById('showw').style.display = "inline-block";
        }
    }

        // SHOW HIDE FEATURE IN registet FORM
        function myshowhidefuncx(){
            let q = document.getElementById('password1');
            if (q.type === "password") {
                q.type = "text";
    
                document.getElementById('hidep').style.display = "inline-block";
                document.getElementById('showp').style.display = "none";
            } else {
                q.type = "password";
                document.getElementById('hidep').style.display = "none";
                document.getElementById('showp').style.display = "inline-block";
            }
        }

