// i have no idea what to even do in here lmfao


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST);

    $username = $_POST["username"];
    $password = $_POST["password"];

    list = []
    if (password in list && username in list) {
        $response = 201;
    }else{
        $response = 401;
    }
}