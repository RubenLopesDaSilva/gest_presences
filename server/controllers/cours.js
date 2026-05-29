const { json } = require('express');
const Cour = require('../model/cours');
const User = require('../model/user');

const get_index = async (req, res, next)  => {
    const userId = req.uid;

    var prof = User.findById(userId);

    var result = await Cour.find({ prof: { $in: prof._id }});

    var data = result.json();

    return res.json(data);
}

const put_present = async  (req, res, next)  => {
    const userId = req.uid;

    const studentId = req.body.studentId;
    const courId = req.body.studentId;

    var prof = User.findById(userId);

    var result = await Cour.find({ $in: prof._id });

    var data = result.json();

    return res.json({
        success: true
    });
}

module.exports = { get_index, put_present };