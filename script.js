//faucet
var faucet=document.getElementById("faucet");
var waterIsOn=false;

faucet.addEventListener("click",function(){
    if(waterIsOn){
        return;
    }
    document.body.classList.add("water-on");
    setTimeout(function(){
        document.body.classList.add("floating");
    }, 5000);
    setTimeout(function(){
        document.body.classList.add("full");
    }, 10000);
});
function showForm(id){
    document.getElementById("login-box").classList.remove("active");
    document.getElementById("register-box").classList.remove("active");
    document.getElementById(id).classList.add("active");
}