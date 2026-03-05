from functools import wraps
from flask import request, jsonify
from models import User 
from models import db, User


TOKEN_SECRETO = "miclave123"

def require_token(f):
    @wraps(f)
    def decorated(*args, **kwargs):
        token = request.headers.get("Authorization")
        if token != f"Token {TOKEN_SECRETO}":
            return jsonify({"error": "No autorizado"}), 401
        return f(*args, **kwargs)
    return decorated

def register_routes(app):

    @app.route("/api/health", methods=["GET"])
    def health():
        return jsonify({"status": "ok"}), 200

    @app.route("/api/users", methods=["GET"])
    @require_token
    def get_users():
        users = User.query.all()
        return jsonify([{"id": u.id, "name": u.name, "email": u.email} for u in users]), 200
    
    @app.route("/api/users", methods=["POST"])
    @require_token
    def create_user():
        data = request.get_json()  # leer JSON del body [web:519]
        name = data.get("name")
        email = data.get("email")

        user = User(name=name, email=email)
        db.session.add(user)
        db.session.commit()  # guardar en BD [web:515]

        return jsonify({"id": user.id, "name": user.name, "email": user.email}), 201
