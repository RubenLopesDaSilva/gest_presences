const Express = require("express");

const router = Express.Router();

router.get('/', (req, res) => {
    res.send("Auth Router");
});

module.exports = router;
