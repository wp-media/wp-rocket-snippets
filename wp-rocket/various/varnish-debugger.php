<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Varnish Purge Form</title>
</head>
<body>

<h2>Varnish Purge Form</h2>

<form method="post" action="">
    <label for="ip">IP:</label>
    <input type="text" id="ip" name="ip" value="<?php echo $_POST['ip']?>"><br>

    <label for="port">Port:</label>
    <input type="number" id="port" name="port"  value="<?php echo $_POST['port']?>"><br>

    <label for="protocol">Protocol:</label>
    <select id="protocol" name="protocol">
        <option value="http">HTTP</option>
        <option value="https">HTTPS</option>
    </select><br>

    <input type="submit" value="Purge Varnish">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
    // Retrieve form data
    $ip = $_POST["ip"];
    $port = $_POST["port"];
    $protocol = $_POST["protocol"];


    // Build the URL for the purge request
    $url = "{$protocol}://{$ip}:{$port}/";

    // Send the purge request (adjust as needed)
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PURGE');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Handle the response
    if ($httpCode == 200) {
        echo "Varnish purge request sent successfully.";
    } else {
        echo "Error sending Varnish purge request. HTTP code: {$httpCode}";
    }
} 
?>

</body>
</html>


