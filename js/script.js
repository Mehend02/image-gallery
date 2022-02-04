// function to show or hide password when user clicks the link next to the form label
function showPassword() {
    const passwordField = document.querySelector("#password")
    const showPassword = document.querySelector("#showPassword")

    if (showPassword.innerText == "Show Password") {
        showPassword.innerText = "Hide Password"
        passwordField.type = "text"
    } else if (showPassword.innerText == "Hide Password") {
        showPassword.innerText = "Show Password"
        passwordField.type = "password"
    }
}