import Users from "./Users.js";

const users = new Users();

const form = document.querySelector(".form");

form.addEventListener("submit", async (event) => {
    event.preventDefault();
    const formData = new FormData(form);
    const data = {
        email: formData.get("email"),
        password: formData.get("password")
    }
    console.log(data);
})