const express = require("express");

const authRoutes = require("./routes/auth");

const app = express();

app.use('/auth', authRoutes);

app.get('/', (req, res) => {
    res.redirect('/auth');
});

app.listen('3000', () => {
    console.log("\nServer is Up\n");
});