const admin=require('firebase-admin');
const svrcAcc=require('./serviceAccountKey.json');

admin.initializeApp({
    credential:admin.credential.cert(svrcAcc),
    databaseURL:"https://clase-77746-default-rtdb.firebaseio.com/"
});

const db=admin.database();

module.exports=db;


