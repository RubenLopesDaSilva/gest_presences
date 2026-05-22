const mongoose = require("mongoose")

const userSchema = mongoose.Schema({
    _id: { type: String, required: true },
    email: { type: String, required: true },
    password: { type: String, required: true },
    lname: { type: String, required: true },
    fname: { type: String, required: true },
    role: { type: String, required: true },
}, { versionKey: false });

module.exports = mongoose.model('User', userSchema);