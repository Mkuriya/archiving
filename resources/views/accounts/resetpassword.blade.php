<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Email</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div style="background-color: #f7f7f7; color:black; max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); overflow: hidden;">
        <div style="background-color: #701d0b; color: #ffffff; padding: 16px;">
            <div style="display: flex; align-items: center;">
                <div>
                    <h1 style="font-size: 20px; font-weight: bold;">Lib_Arch: Manuscript Archiving with Comprehensive Learning</h1>
                </div>
            </div>
        </div>
        <div style="padding: 24px;">
            <p style="margin-bottom: 16px; ">We received a request to reset your password.</p>
            <p style="margin-bottom: 16px;">
                Please click the <a href="{{route('resetpassword', ['token' => $token, 'email' => $email])}}" style="color: #3182ce; text-decoration: none;">here</a> 
                to reset your password and regain access to your account.
            </p>
            <p style="margin-bottom: 16px; ">If you did not request a password reset, please ignore this email.</p>
            <p style="margin-bottom: 24px; ">Thank you very much.</p>
            <p style="margin-bottom: 24px;">Regards,<br>
            <strong>Lib-Arch Developer</strong></p>
        </div>
        <div style="background-color: #701d0b; color:#ffffff; padding: 16px; text-align: center;">
            <p style="font-size: 12px;">Lib-Arch<br>
            Email: lib.arch.03@gmail.com </p>
        </div>
    </div>

</body>
</html>