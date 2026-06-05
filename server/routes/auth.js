const Express = require("express");
const authController = require("../controllers/auth")
const User = require("../model/user")

const router = Express.Router();

router.get('/', authController.getAllUsers);

router.post('/signup', authController.signup)

router.post('/login', authController.login)

// [body('email').custom((value, { req }) => {
//     return User.findOne({ email: value }).then(userDoc => {
//         if (userDoc) {
//             return Promise.reject('E-mail address already exists !')
//         }
//     })
// }).normalizeEmail()],

module.exports = router;
