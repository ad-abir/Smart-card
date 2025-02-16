document.querySelector('.resend-link').addEventListener('click', function(e) {
    e.preventDefault();
    
    fetch('resend.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'resend=true'
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            alert('New verification code has been sent to your email');
        } else {
            alert(data.message || 'Failed to resend verification code');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while resending the code');
    });
});