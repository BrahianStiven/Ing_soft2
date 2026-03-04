from flask import Flask
from flask_migrate import Migrate
from flask_cors import CORS
from config import Config
from models import db

app=Flask(__name__)
app.config.from_object(Config)

db.init_app(app)
migrate = Migrate(app, db)
CORS(app)

import models
import routes
routes.register_routes(app)

if __name__ == '__main__':
    app.run(host='127.0.0.1', port=8002, debug=True) # Se configura el puerto a 8002 para evitar conflictos con otros microservicios que puedan estar corriendo en el mismo entorno 
