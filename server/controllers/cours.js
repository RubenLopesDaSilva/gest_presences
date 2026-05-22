const Cour = require('../model/cours');

const get_index = async (req, res, next)  => {
    const userId = req.uid;

    var prof = null;

    var result = await  Cour.find({ $in: prof._id });

    var data = result.json();

    return res.json(data);
}

const put_present = async  (req, res, next)  => {
    const userId = req.uid;

    const studentId = req.body.studentId;
    const courId = req.body.studentId;

    var prof = null;

    var result = await Cour.find({ $in: prof._id });

    var data = result.json();

    return res.json({
        success: true
    });
}

module.exports = { get_index, };