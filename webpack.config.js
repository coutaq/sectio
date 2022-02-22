const path = require("path");

module.exports = {
    resolve: {
        alias: {
            "@": path.resolve("resources/js"),
            "~@": path.resolve("node_modules"),
        },
    },
};
