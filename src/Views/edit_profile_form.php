<form action="/profile-change" method="POST">
    <a href="/profile" method="GET">Back to profile</a>
    <div class="container">
        <h1>Change profile</h1>
        <p>Please fill in this form to change profile.</p>
        <hr>

        <label for="name"><b>New name</b></label>
        <?php if (isset($errors['name'])): ?>
            <label style="color: red"> <?php echo $errors['name']; ?> </label>
        <?php endif; ?>
        <input type="text" name="name" id="name" value="<?php echo $user['name'];?>" required>

        <label for="email"><b>New email</b></label>
        <?php if (isset($errors['email'])): ?>
            <label style="color: red"> <?php echo $errors['email']; ?> </label>
        <?php endif; ?>
        <input type="text" name="email" id="email" value="<?php echo $user['email'];?>" required>

        <hr>

        <button type="submit" class="changebtn">Change</button>
    </div>
</form>

<style>
    * {box-sizing: border-box}

    /* Add padding to containers */
    .container {
        padding: 16px;
    }

    /* Full-width input fields */
    input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus, input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }

    /* Overwrite default styles of hr */
    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    /* Set a style for the submit/register button */
    .registerbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    .registerbtn:hover {
        opacity:1;
    }

    /* Add a blue text color to links */
    a {
        color: dodgerblue;
    }

    /* Set a grey background color and center the text of the "sign in" section */
    .signin {
        background-color: #f1f1f1;
        text-align: center;
    }
</style>
