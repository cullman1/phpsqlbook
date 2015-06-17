$(function () {
    $("#next").on("focus", Submit_Search);
});       
function Submit_Search() {
    var formData = new FormData($('form')[0]);
    var email = document.getElementById("email").value;
    $.ajax({
        url: 'get-users.php?email=' + email,
        type: 'GET',
        xhr: function () {
            var myXhr = $.ajaxSettings.xhr();
            return myXhr;
        },
        success: function (data, status) {
            data = data.replace("[", "");
            data = data.replace("]", "");
            data = data.trim();
            if (data != "") {
                obj = JSON.parse(data);
                var msg = document.getElementById("results-box");
                msg.innerHTML = "Email has already been registered";
            }
        },
        error: function (xhr, desc, err) {
            alert("Details: " + desc + "\nError:" + err);
        },
        data: formData
    });
}