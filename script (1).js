/* JavaScript for Library Management */
const books = [
    { id: 1, title: "To Kill a Mockingbird", author: "Harper Lee", genre: "Fiction", available: true },
    { id: 2, title: "1984", author: "George Orwell", genre: "Dystopian", available: false },
    { id: 3, title: "Moby Dick", author: "Herman Melville", genre: "Adventure", available: true },
];
const validUser = {
    username: "admin",
    password: "password123"
};

function handleLogin(event) {
    event.preventDefault();
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    const errorElement = document.getElementById("login-error");

    if (username === validUser.username && password === validUser.password) {
        document.getElementById("login-screen").classList.add("hidden");
        document.getElementById("app-screen").classList.remove("hidden");
    } else {
        errorElement.textContent = "Invalid username or password.";
    }
}

function showSection(sectionId) {
    document.querySelectorAll(".section").forEach(section => {
        section.classList.remove("active");
    });
    document.getElementById(`${sectionId}-section`).classList.add("active");
}

const users = [
    { id: 1, name: "Emmarie Abayon", email: "alice@example.com" },
    { id: 2, name: "Jerson Payos", email: "bob@example.com" },
];

const genres = ["Fiction", "Dystopian", "Adventure", "Science Fiction"];

function renderBooks() {
    const bookList = document.getElementById("book-list");
    bookList.innerHTML = books.map((book) => `
        <tr>
            <td>${book.title}</td>
            <td>${book.author}</td>
            <td>${book.genre}</td>
            <td>${book.available ? "Available" : "Checked Out"}</td>
            <td>
                <button onclick="toggleAvailability(${book.id})">
                    ${book.available ? "Borrow" : "Return"}
                </button>
            </td>
        </tr>
    `).join("");
}

function renderUsers() {
    const userList = document.getElementById("user-list");
    userList.innerHTML = users.map((user) => `
        <tr>
            <td>${user.name}</td>
            <td>${user.email}</td>
            <td>
                <button onclick="removeUser(${user.id})">Remove</button>
            </td>
        </tr>
    `).join("");
}

function renderGenres() {
    const genreList = document.getElementById("genre-list");
    genreList.innerHTML = genres.map((genre) => `<li>${genre}</li>`).join("");
}

function toggleAvailability(id) {
    const book = books.find((b) => b.id === id);
    if (book) book.available = !book.available;
    renderBooks();
}

function removeUser(id) {
    const userIndex = users.findIndex((u) => u.id === id);
    if (userIndex !== -1) users.splice(userIndex, 1);
    renderUsers();
}

function filterItems() {
    const searchValue = document.getElementById("search").value.toLowerCase();
    const filteredBooks = books.filter((book) =>
        book.title.toLowerCase().includes(searchValue) ||
        book.author.toLowerCase().includes(searchValue)
    );

    const bookList = document.getElementById("book-list");
    bookList.innerHTML = filteredBooks.map((book) => `
        <tr>
            <td>${book.title}</td>
            <td>${book.author}</td>
            <td>${book.genre}</td>
            <td>${book.available ? "Available" : "Checked Out"}</td>
            <td>
                <button onclick="toggleAvailability(${book.id})">
                    ${book.available ? "Borrow" : "Return"}
                </button>
            </td>
        </tr>
    `).join("");
}

function showSection(sectionId) {
    document.querySelectorAll(".section").forEach((section) => {
        section.classList.remove("active");
    });
    document.getElementById(`${sectionId}-section`).classList.add("active");
}

// Initial Render
renderBooks();
renderUsers();
renderGenres();
