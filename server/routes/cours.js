const Express = require("express");

const CoursController = require("../controllers/cours");

const router = Express.Router();

router.get('/', CoursController.get_index);

module.exports = router;
