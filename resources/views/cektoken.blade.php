<!DOCTYPE html>
<html>
<head>
    <title>Google Login Laravel</title>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>
<body>

<h2>Login dengan Google</h2>

<div id="g_id_onload"
     data-client_id="356586621367-diq0qqbn9rip489ga47tcal8mg09c2vo.apps.googleusercontent.com"
     data-callback="handleCredentialResponse"
     data-auto_prompt="false">
</div>

<div class="g_id_signin" data-type="standard"></div>

<pre id="output"></pre>

<script>
function handleCredentialResponse(response) {
    console.log("TOKEN:", response.credential);

    document.getElementById("output").innerText = response.credential;

    // OPTIONAL: kirim ke backend Laravel
    fetch('/google-login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            token: response.credential
        })
    });
}
</script>

</body>
</html>