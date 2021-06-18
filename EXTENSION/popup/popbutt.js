



setInterval(StripeCheck, 200)


function StripeCheck(){
    var checkbox = document.querySelector("input[id=checkStripe]");

    checkbox.addEventListener('change', function() {

        if (checkbox.checked) {
            console.log("Checkbox is checked..");
            chrome.storage.local.set({StripeCheckbox:1})
        } else {
            console.log("Checkbox is not checked..");
            chrome.storage.local.set({StripeCheckbox:0})
        }



    });

// document.getElementById('checkStripe').addEventListener('changer', function(){
//     if(document.getElementById('checkStripe').checked){
//         alert("IS CHECKED")
//     }
// })
}