const mongoose = require('mongoose');

const Schema = mongoose.Schema;

const courSchema = new Schema({
    module: String,
    salle: String,
    prof: String,
    debut: Date,
    fin: Date,
    eleves: { 
        dates: [Date]
    },
});

module.exports = mongoose.model('Cour', courSchema);