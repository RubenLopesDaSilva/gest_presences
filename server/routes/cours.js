const Express = require("express");

const is_auth = require("../middlewares/is-auth");

const CoursController = require("../controllers/cours");

const router = Express.Router();

router.get('/', is_auth, CoursController.get_index);

router.post('/present', is_auth, CoursController.put_present);

module.exports = router;
