var url = window.location.href;
var username = getParameterValue(url, "username");
var userLink = document.getElementById("userLink");
userLink.href += "?username=" + username;
function getParameterValue(url, parameterName) {
    var paramIndex = url.indexOf(parameterName + "=");
    if (paramIndex === -1) return "";
    var startIndex = paramIndex + parameterName.length + 1;
    var endIndex = url.indexOf("&", startIndex);
    if (endIndex === -1) endIndex = url.length;
    return decodeURIComponent(url.substring(startIndex, endIndex));
}