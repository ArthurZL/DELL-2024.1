
window.onload = function() {
    var xhr = new XMLHttpRequest();
    xhr.onload = function() {
        if (this.status == 200) {
            var response = JSON.parse(this.responseText);
            if ( ! response.authorized) {
                window.location.href = '../index.php';
            }
        }
    };
    xhr.open("GET", "../PHP/auth.php", true);
    xhr.send();
};
