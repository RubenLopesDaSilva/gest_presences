const express = require("express");
const mongoose = require("mongoose");
const authRoutes = require("./routes/auth");
const coursRoutes = require("./routes/cours");


const app = express();
app.use(express.json())

app.use('/auth', authRoutes);
const dbUri = "mongodb+srv://Evomew:Leroy2606@cluster0.amlr0fi.mongodb.net/?appName=Cluster0";
app.use('/cour', coursRoutes);
app.get('/', (req, res) => {
    res.redirect('/auth');
});
mongoose.connect(dbUri).then(result => {
    app.listen('3000', () => {
        console.log("Server is Up");
    });
}).catch(err => { console.error(err) })

app.use((error, req, res, next) => { 
   const status = error.status || 500 
   const message = error.data[0]['msg'] 
   const data = error.data 
   res.status(status).json({ message: message, data: data }) 
 })