function showLoadingAndRun(callback){
    showLoader();                
    setTimeout(() => {          
        hideLoader();            
        callback();           
    }, 500);
}

function showLoader () { document.getElementById('loadingAnimation').style.display = 'flex'; }
function hideLoader () { document.getElementById('loadingAnimation').style.display = 'none'; }

window.addEventListener('pageshow', hideLoader);

function goToStepTwo(){
    document.getElementById('stepOne'      ).style.display = 'none';
    document.getElementById('personalInfo' ).style.display = 'none';
    document.getElementById('buttonFirstN' ).style.display = 'none';

    document.getElementById('stepTwo'      ).style.display = 'flex';
    document.getElementById('familyBackground').style.display = 'flex';
    document.getElementById('buttonSecondN').style.display = 'flex';
    document.getElementById('buttonSecondB').style.display = 'flex';

    document.getElementById('stepThree'      ).style.display = 'none';
    document.getElementById('EducBG_WorkExp').style.display = 'none';
    document.getElementById('buttonThirdN').style.display = 'none';
    document.getElementById('buttonThirdB').style.display = 'none';

    document.getElementById('stepFour'      ).style.display = 'none';
    document.getElementById('Others').style.display = 'none';
    document.getElementById('updateButtonEBG').style.display = 'none';
    document.getElementById('buttonFourthB').style.display = 'none';
}
function goToStepOne(){
    document.getElementById('stepOne'      ).style.display = 'flex';
    document.getElementById('personalInfo' ).style.display = 'flex';
    document.getElementById('buttonFirstN' ).style.display = 'flex';

    document.getElementById('stepTwo'      ).style.display = 'none';
    document.getElementById('familyBackground').style.display = 'none';
    document.getElementById('buttonSecondN').style.display = 'none';
    document.getElementById('buttonSecondB').style.display = 'none';

    document.getElementById('stepThree'      ).style.display = 'none';
    document.getElementById('EducBG_WorkExp').style.display = 'none';
    document.getElementById('buttonThirdN').style.display = 'none';
    document.getElementById('buttonThirdB').style.display = 'none';

    document.getElementById('stepFour'      ).style.display = 'none';
    document.getElementById('Others').style.display = 'none';
    document.getElementById('updateButtonEBG').style.display = 'none';
    document.getElementById('buttonFourthB').style.display = 'none';
}
function goToStepThree(){
    document.getElementById('stepOne'      ).style.display = 'none';
    document.getElementById('personalInfo' ).style.display = 'none';
    document.getElementById('buttonFirstN' ).style.display = 'none';

    document.getElementById('stepTwo'      ).style.display = 'none';
    document.getElementById('familyBackground').style.display = 'none';
    document.getElementById('buttonSecondN').style.display = 'none';
    document.getElementById('buttonSecondB').style.display = 'none';

    document.getElementById('stepThree'      ).style.display = 'flex';
    document.getElementById('EducBG_WorkExp').style.display = 'flex';
    document.getElementById('buttonThirdN').style.display = 'flex';
    document.getElementById('buttonThirdB').style.display = 'flex';

    document.getElementById('stepFour'      ).style.display = 'none';
    document.getElementById('Others').style.display = 'none';
    document.getElementById('buttonFourthB').style.display = 'none';
    document.getElementById('updateButtonEBG').style.display = 'none';
}
function goToStepFour(){
    document.getElementById('stepOne'      ).style.display = 'none';
    document.getElementById('personalInfo' ).style.display = 'none';
    document.getElementById('buttonFirstN' ).style.display = 'none';

    document.getElementById('stepTwo'      ).style.display = 'none';
    document.getElementById('familyBackground').style.display = 'none';
    document.getElementById('buttonSecondN').style.display = 'none';
    document.getElementById('buttonSecondB').style.display = 'none';

    document.getElementById('stepThree'      ).style.display = 'none';
    document.getElementById('EducBG_WorkExp').style.display = 'none';
    document.getElementById('buttonThirdN').style.display = 'none';
    document.getElementById('buttonThirdB').style.display = 'none';

    document.getElementById('stepFour'      ).style.display = 'flex';
    document.getElementById('Others').style.display = 'flex';
    document.getElementById('buttonFourthB').style.display = 'flex';
    document.getElementById('updateButtonEBG').style.display = 'flex';
}
function buttonFirstN(){
    showLoadingAndRun(goToStepTwo);
}
function buttonSecondN(){
    showLoadingAndRun(goToStepThree);
}
function buttonThirdN(){
    showLoadingAndRun(goToStepFour);
}
function buttonSecondB(){
    showLoadingAndRun(goToStepOne);
}
function buttonThirdB(){
    showLoadingAndRun(goToStepTwo);
}
function buttonFourthB(){
    showLoadingAndRun(goToStepThree);
}