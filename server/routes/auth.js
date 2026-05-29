const Express = require("express");
const authController = require("../controllers/auth")

const router = Express.Router();

router.get('/', authController.getAllUsers);

router.post('/signup', [body('email').custom((value, { req }) => {
    return UserActivation.findOne({ email: value }).then(userDoc => {
        if (userDoc) {
            return Promise.reject('E-mail address already exists !')
        }
    })
}).normalizeEmail()], authController.signup)

router.post('/login', authController.login)

module.exports = router;
