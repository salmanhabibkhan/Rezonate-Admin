/*
 * Passwor complaxity meter  
 */
function passwordStrengthMeter(a){function b(){let a=c();d(a)}function c(){let a=0,b=/(?=.*[a-z])/,c=/(?=.*[A-Z])/,d=/(?=.*[0-9])/,e=new RegExp("(?=.{"+j+",})");return i.match(b)&&++a,i.match(c)&&++a,i.match(d)&&++a,i.match(e)&&++a,0==a&&0<i.length&&++a,a}function d(a){1===a?(g.className="password-strength-meter-score psms-25",k&&(k.textContent=l[1]||"Too simple"),f.dispatchEvent(new Event("onScore1",{bubbles:!0}))):2===a?(g.className="password-strength-meter-score psms-50",k&&(k.textContent=l[2]||"Simple"),f.dispatchEvent(new Event("onScore2",{bubbles:!0}))):3===a?(g.className="password-strength-meter-score psms-75",k&&(k.textContent=l[3]||"That's OK"),f.dispatchEvent(new Event("onScore3",{bubbles:!0}))):4===a?(g.className="password-strength-meter-score psms-100",k&&(k.textContent=l[4]||"Great password!"),f.dispatchEvent(new Event("onScore4",{bubbles:!0}))):(g.className="password-strength-meter-score",k&&(k.textContent=l[0]||"No data"),f.dispatchEvent(new Event("onScore0",{bubbles:!0})))}const e=document.createElement("style");document.body.prepend(e),e.innerHTML=`
    ${a.containerElement} {
      height: ${a.height||4}px;
      background-color: #eee;
      position: relative;
      overflow: hidden;
      border-radius: ${a.borderRadius.toString()||2}px;
    }
    ${a.containerElement} .password-strength-meter-score {
      height: inherit;
      width: 0%;
      transition: .3s ease-in-out;
      background: ${a.colorScore1||"#ff7700"};
    }
    ${a.containerElement} .password-strength-meter-score.psms-25 {width: 25%; background: ${a.colorScore1||"#ff7700"};}
    ${a.containerElement} .password-strength-meter-score.psms-50 {width: 50%; background: ${a.colorScore2||"#ffff00"};}
    ${a.containerElement} .password-strength-meter-score.psms-75 {width: 75%; background: ${a.colorScore3||"#aeff00"};}
    ${a.containerElement} .password-strength-meter-score.psms-100 {width: 100%; background: ${a.colorScore4||"#00ff00"};}`;const f=document.getElementById(a.containerElement.slice(1));f.classList.add("password-strength-meter");let g=document.createElement("div");g.classList.add("password-strength-meter-score"),f.appendChild(g);const h=document.getElementById(a.passwordInput.slice(1));let i="";h.addEventListener("keyup",function(){i=this.value,b()});let j=a.pswMinLength||8,k=a.showMessage?document.getElementById(a.messageContainer.slice(1)):null,l=void 0===a.messagesList?["No data","Too simple","Simple","That's OK","Great password!"]:a.messagesList;return k&&(k.textContent=l[0]||"No data"),{containerElement:f,getScore:c}}
//==========================================

function initializePasswordStrengthMeter() {
    if (document.querySelector('#psw-input')) {
        const myPassMeter = passwordStrengthMeter({
            containerElement: '#pswmeter',
            passwordInput: '#psw-input',
            showMessage: true,
            messageContainer: '#pswmeter-message',
            messagesList: [
                'Write your password...',
                'Easy peasy!',
                'That is a simple one',
                'That is better',
                'Yeah! that password rocks ;)'
            ],
            height: 8,
            borderRadius: 4,
            pswMinLength: 8,
            colorScore1: '#dc3545',
            colorScore2: '#f7c32e',
            colorScore3: '#4f9ef8',
            colorScore4: '#0cbc87'
        });
    }
}


$(document).ready(function() {
    $.validator.addMethod("datebeforefifteenyear", function(value, element) {
        // Convert the value to a JavaScript Date object
        var dob = new Date(value);
        // Calculate the date 15 years ago
        var fifteenYearsAgo = new Date();
        fifteenYearsAgo.setFullYear(fifteenYearsAgo.getFullYear() - 15);
        // Check if the date of birth is before 15 years ago
        return dob < fifteenYearsAgo;
    }, "To use LinkOn, you must be 15 years old or above.");

    $(".register_form").validate({
        rules: {
            first_name: "required",
            last_name: "required",
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            },
            password_confirm: {
                required: true,
                equalTo: ".password"
            },
            gender: "required",
            date_of_birth: {
                required: true,
                date: true,
                datebeforefifteenyear: true // Use the custom validation method
            }
        },
        messages: {
            first_name: "Please enter your first name",
            last_name: "Please enter your last name",
            email: {
                required: "Please enter your email address",
                email: "Please enter a valid email address"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            password_confirm: {
                required: "Please confirm your password",
                equalTo: "Please enter the same password as above"
            },
            gender: "Please select your gender",
            date_of_birth: {
                required: "Please enter your date of birth",
                date: "Please enter a valid date",
                datebeforefifteenyear: "To use LinkOn, you must be 15 years old or above."
            }
        },
        errorElement: "div",
        errorPlacement: function(error, element) {
            error.addClass("alert text-danger  m-0 p-0");
            error.insertAfter(element);
        }
    });

    $(".login_form").validate({
        rules: {
            email: {
                required: true,
            },
            password: {
                required: true,
                minlength: 6
            }
        },
        messages: {
          
            email: {
                required: "Please enter your email address/username",
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            }
        },
        errorElement: "div",
        errorPlacement: function(error, element) {
            error.addClass("alert text-danger  m-0 p-0");
            error.insertAfter(element);
        }
    })

    $(".forgot_form").validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            email: {
                required: "Please enter your email address",
                email: "Please enter a valid email address"
            }
        },
        errorElement: "div",
        errorPlacement: function(error, element) {
            error.addClass("alert alert-danger mt-2");
            error.insertAfter(element);
        }
    });

    // Call the function to initialize the password strength meter if applicable
initializePasswordStrengthMeter();


});