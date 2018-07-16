let mysql = require('mysql');

const con = mysql.createConnection({
    host: "13.58.124.205",
    user: "guest",
    password: "pass",
    database: "girls",
});

var $connect = function(){

    return new Promise(function(resolve, reject){

        con.connect(function(err){

            if(err) reject(err);

            resolve(con);

        });

    });

};

module.exports.$connect = $connect();
