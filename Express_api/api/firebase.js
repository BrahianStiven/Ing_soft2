// firebase.js - MODO PRUEBA (sin credenciales reales)
module.exports = {
  ref: function(path) {
    return {
      push: function() { return { set: function(data) { return Promise.resolve(); } }; },
      once: function() { return Promise.resolve({ val: function() { return {}; } }); },
      update: function(data) { return Promise.resolve(); },
      remove: function() { return Promise.resolve(); }
    };
  }
};
