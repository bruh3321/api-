import sqlite3
import jwt
import datetime
from flask import Flask, request, jsonify
from flask_cors import CORS
from flask_jwt_extended import JWTManager, create_access_token, jwt_required, get_jwt_identity

app = Flask(__name__)
CORS(app, origins="https://bruh3321.github.io")


app.config['JWT_SECRET_KEY'] = 'pipi'
jwt = JWTManager(app)

def init_db():
    conn = sqlite3.connect('users.db')
    cursor = conn.cursor()
    cursor.execute('''
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL
        )
    ''')
    conn.commit()

    try:
        cursor.execute('INSERT INTO users (username, password) VALUES (?, ?)', ("admin", "admin"))
        conn.commit()
    except sqlite3.IntegrityError:
        print("Admin user already exists.")
    finally:
        conn.close()

@app.route('/register', methods=['POST'])
def register():
    data = request.get_json()
    username = data.get('username')
    password = data.get('password')

    try:
        conn = sqlite3.connect('users.db')
        cursor = conn.cursor()
        cursor.execute('INSERT INTO users (username, password) VALUES (?, ?)', (username, password))
        conn.commit()
        conn.close()
        return jsonify({"message": "User registered successfully!"}), 201
    except sqlite3.IntegrityError:
        return jsonify({"message": "Username already exists!"}), 400

@app.route('/login', methods=['POST'])
def login():
    data = request.get_json()
    username = data.get('username')
    password = data.get('password')

    conn = sqlite3.connect('users.db')
    cursor = conn.cursor()
    cursor.execute('SELECT password FROM users WHERE username = ?', (username,))
    user = cursor.fetchone()
    conn.close()

    if user and user[0] == password:
        access_token = create_access_token(identity=username, expires_delta=datetime.timedelta(hours=1))
        return jsonify({"message": "Login successful!", "token": access_token}), 200
    else:
        return jsonify({"message": "Invalid username or password!"}), 401

@app.route('/protected', methods=['GET'])
@jwt_required()
def protected():
    current_user = get_jwt_identity()
    return jsonify({"message": f"Hello, {current_user}! This is a protected route."}), 200

if __name__ == '__main__':
    init_db()
    app.run(debug=True)
