<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$usersFile = 'users.json';

// Ensure the JSON file exists
if (!file_exists($usersFile)) {
    file_put_contents($usersFile, json_encode([]));
}

// Load users from JSON file
function loadUsers() {
    global $usersFile;
    return json_decode(file_get_contents($usersFile), true);
}

// Save users to JSON file
function saveUsers($users) {
    global $usersFile;
    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
}

// Handle requests
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == 'POST') {
    $path = explode("/", trim($_SERVER['REQUEST_URI'], "/"));
    
    // Read input JSON
    $input = json_decode(file_get_contents("php://input"), true);

    if ($path[0] === 'register') {
        registerUser($input);
    } elseif ($path[0] === 'login') {
        loginUser($input);
    } else {
        http_response_code(404);
        echo json_encode(["message" => "Endpoint not found"]);
    }
}

// Register user
function registerUser($data) {
    if (!isset($data['username']) || !isset($data['password'])) {
        http_response_code(400);
        echo json_encode(["message" => "Username and password required"]);
        return;
    }

    $users = loadUsers();
    foreach ($users as $user) {
        if ($user['username'] === $data['username']) {
            http_response_code(400);
            echo json_encode(["message" => "Username already exists!"]);
            return;
        }
    }

    $users[] = [
        "username" => $data['username'],
        "password" => $data['password']  // In real applications, use password hashing!
    ];

    saveUsers($users);
    http_response_code(201);
    echo json_encode(["message" => "User registered successfully!"]);
}

// Login user
function loginUser($data) {
    if (!isset($data['username']) || !isset($data['password'])) {
        http_response_code(400);
        echo json_encode(["message" => "Username and password required"]);
        return;
    }

    $users = loadUsers();
    foreach ($users as $user) {
        if ($user['username'] === $data['username'] && $user['password'] === $data['password']) {
            http_response_code(200);
            echo json_encode(["message" => "Login successful!"]);
            return;
        }
    }

    http_response_code(401);
    echo json_encode(["message" => "Invalid username or password!"]);
}
?>
