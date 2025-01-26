// Function to get URL parameter
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

// Set the email when the page loads
document.addEventListener('DOMContentLoaded', function() {
    const userEmail = getUrlParameter('userEmail');
    document.getElementById('userEmail').textContent = userEmail;
});