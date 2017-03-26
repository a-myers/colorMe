function checkEmail(field)
{
    //What To Check Againt
    var inputParam = /(\S[^\.]*)(\.(\S*))?@(\S*)/;
    //What Were Checking
    var valCheck = document.getElementById(field);
    if(valCheck.value.match(inputParam))
    {
        //Set Green Boarder
        goodField(field);
        return true;
    }
    else
    {
        //Set Red Boarder
        badField(field);
        return false;
    }
}
function checkPassword(field)
{
    //What To Check Againt
    var inputParam = /\S{8,64}/;
    //What Were Checking
    var valCheck = document.getElementById(field);
    if(valCheck.value.match(inputParam))
    {
        //Set Green Boarder
        goodField(field);
        return true;
    }
    else
    {
        //Set Red Boarder
        badField(field);
        return false;
    }
}
function vCheckPassword(oPassword,vPassword)
{
	var oPasswordt = document.getElementById(oPassword);
    var vPasswordt = document.getElementById(vPassword);
    if( oPasswordt.value.match(vPasswordt.value))
    {
        //Set Green Boarder
        goodField(vPassword);
        return true;
    }
    else
    {
        //Set Red Boarder
        badField(vPassword);
        return false;
    }
}
function checkFname(field)
{
    //What To Check Againt
    var inputParam = /[a-z A-Z]/;
    //What Were Checking
    var valCheck = document.getElementById(field);
    if(valCheck.value.match(inputParam))
    {
        //Set Green Boarder
        goodField(field);
        return true;
    }
    else
    {
        //Set Red Boarder
        badField(field);
        return false;
    }
}
function checkLname(field)
{
    //What To Check Againt
    var inputParam = /\S{8,64}/;
    //What Were Checking
    var valCheck = document.getElementById(field);
    if(valCheck.value.match(inputParam))
    {
        //Set Green Boarder
        goodField(field);
        return true;
    }
    else
    {
        //Set Red Boarder
        badField(field);
        return false;
    }
}
function checkPhone(field)
{
    //What To Check Againt
    var inputParam = /(?:(\+?\d{1,3}) )?(?:([\(]?\d+[\)]?)[ -])?(\d{1,5}[\- ]?\d{1,5})/;
    //What Were Checking
    var valCheck = document.getElementById(field);
    if(valCheck.value.match(inputParam))
    {
        //Set Green Boarder
        goodField(field);
        return true;
    }
    else
    {
        //Set Red Boarder
        badField(field);
        return false;
    }
}
function goodField(id)
{
    document.getElementById(id).style.backgroundColor = "#FFFFFF";
}
function badField(id)
{
    document.getElementById(id).style.backgroundColor = "#ffc6c6";
}
function submissionCheck(email,p1,p2,name,uname,phone)
{
	if(!(checkEmail('email') && checkPassword('p1') && vChekPassword('p1','p2') && checkFname('name') && checkLname('uname') && checkPhone('phone') ))
	{
		alert("There seems to be an issue, check your Input and make sure you agree to both satements.");
	}
	else
	{
		document.forms['main_form'].submit();
	}
}