const mongoose = require("mongoose");
const User = require("../model/user");
const { validationResult } = require("express-validator")
const jwt = require("jsonwebtoken")
const bcrypt = require("bcryptjs");
const user = require("../model/user");
const { use } = require("react");

exports.getAllUsers = async (req, res, next) => {
    await User
        .find()
        .then(result => {
            res.status(200).json(result)
        }).catch(err => {
            if (err.statusCode) {
                err.statusCode = 500
            }
            next(err);
        })
}

exports.signup = async (req, res, next) => {
    const errors = validationResult(req);
    if (!errors.isEmpty()) {
        const error = new Error('Validation failed');
        error.statusCode = 422;
        error.data = errors.array();
        return next(error);
    }
    const email = req.body.email
    const fname = req.body.fname
    const lname = req.body.lname;
    const password = req.body.password;
    const cp = fname.substring(0, 1).toLowerCase() + "-" + Date.setFullYear(2026).toString() + lname.at(0).toLowerCase();

    await bcrypt
        .hash(password, 12)
        .then(hashedPw => {
            const user = new User({
                _id: cp,
                email: email,
                fname: fname,
                lname: lname,
                password: hashedPw,
            })
            return user.save();
        })
        .then(result => {
            res.status(201).json({
                message: 'User created succesfully',
                user: { _id: result._id, email: result.email, fname: result.fname, lname: result.lname }
            })
            const token = jwt.sign({
                email: loadedUser.email,
                name: loadedUser.name,
                sub: loadedUser._id.toString()
            }, 'somesupersecretsecret', { expiresIn: '1h' })
            res.status(200).json({ token: token })
        })
        .catch(err => {
            if (!err.statusCode) {
                err.statusCode = 500
            }
            next(err);
        })
}

exports.login = async (req, res, next) => {
    const email = req.body.email
    const password = req.body.password
    User.findOne({ email: email })
        .then(user => {
            if (!user) {
                const error = new Error('User unknown')
                error.statusCode = 401
                throw error
            }
            loadedUser = user
            return bcrypt.compare(password, user.password)
        })
        .then(isEqual => {
            if (!isEqual) {
                const error = new Error('Wrong password')
                error.statusCode = 401
                throw error
            }
        })
        .catch(err => {
            if (!err.statusCode) {
                err.statusCode = 500
            }
            next(err)
        })
}