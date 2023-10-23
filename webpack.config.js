const path = require('path');

module.exports = {
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
            '@public': path.resolve(__dirname, 'public/')
        },
    },
};
