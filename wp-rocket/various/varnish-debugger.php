<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Varnish Debugger Form</title>
    <style>
        body { background: #D6DCE1; padding: 4rem; font-family: monospace;}
        p {margin-bottom: 2rem;}
        small {display: inline-block; margin-top: 0.6rem; color: #666;}
        label { display: inline-block; width: 100px; }
        input, select {font-size: 16px; border-radius: 4px; padding: 10px; font-family: monospace;  border: 2px solid #666;}
        input[type=submit] { color: #fff; background-color: #343a40;border-color: #343a40;cursor:pointer;}
        input[type=submit]:hover { opacity: 0.8;}
        .results {font-family: monospace;  word-wrap: break-word; background-color: #FFF; padding: 10px; border: 2px dashed #C00; border-radius: 10px; display: inline-block; margin-top: 2rem; font-size: 20px;	}
        .results.error {color: #C00;}
        .results.success {color: #0C0;border: 2px dashed #0C0;}
    </style>
</head>
<body>

<h2>Varnish Debugger</h2>

<form method="post" action="">
    <p>
    <label for="ip">IP:</label>
    <input type="text" id="ip" name="ip" placeholder="127.0.0.1" value="<?php echo $_POST['ip']?>" size="30"><br>
    <small>Standard IP is 127.0.0.1, if Cloudflare is used try the domain name instead</small>
    </p>
    <p>

    <label for="port">Port:</label>
    <input type="number" id="port" name="port" placeholder="80"  value="<?php if ($_POST['post']=='') { echo  "80"; } else { echo $_POST['post']; } ?>"><br>
    <small>Standard Ports (80 for HTTP, 443 for HTTPS)</small>
        </p>
    <label for="method">Method:</label>
    <select id="method" name="method">
        <option value="PURGE" <?php if ($_POST['method']=='PURGE') { echo  'selected="selected"'; }?> >PURGE</option>
        <option value="BAN" <?php if ($_POST['method']=='BAN') { echo  'selected="selected"'; }?>>BAN</option>
    </select><br>
      <small>Default method is PURGE, you can try BAN</small></p>
    <p>
    <label for="protocol">Protocol:</label>
    <select id="protocol" name="protocol">
        <option value="http" <?php if ($_POST['protocol']=='http') { echo  'selected="selected"'; }?> >HTTP</option>
        <option value="https" <?php if ($_POST['protocol']=='https') { echo  'selected="selected"'; }?>>HTTPS</option>
    </select>
        <br><small>Standard Protocol is HTTP, you can try HTTPS)</small>
</p>
    <p><label></label>
    <input type="submit" value="Send Purge to Varnish &rsaquo;&rsaquo;">
    </p>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Retrieve form data
    $ip = $_POST["ip"];
    $port = $_POST["port"];
    $method = $_POST["method"];
    $protocol = $_POST["protocol"];



    // Build the URL for the purge request
    $url = "{$protocol}://{$ip}:{$port}/";

    // Send the purge request (adjust as needed)
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Handle the response
    if ($httpCode == 200) {
        echo "<div class='results success'>Varnish purge request sent successfully</div>";
    } else {
        echo "<div class='results error'>Error sending Varnish purge request. HTTP code: {$httpCode}</div>";
    }
} 
?>

</body>
</html>
