const express = require("express");

const authRoutes = require("./routes/auth");
const coursRoutes = require("./routes/cours");


const app = express();

app.use('/auth', authRoutes);
app.use('/cour', coursRoutes);

app.get('/', (req, res) => {
    res.redirect('/auth');
});

app.listen('3000', () => {
    console.log("\nServer is Up\n");
});