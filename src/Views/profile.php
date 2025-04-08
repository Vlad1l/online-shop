<div class="container">
    <a href="/catalog" method="GET">Catalog</a>
    <h1> </h1>
    <a href="/logout" method="GET">Logout</a>
    <h1> </h1>
    <a href="/profile-change" method="GET">Change profile</a>
    <h3>Profile</h3>
        <a href="#">
            <?php if (isset($user['image_url'])): ?>
                <img class="card-img-top" src="<?php echo $user['image_url'] ?>" alt="Card image">
            <?php endif; ?>
            <div class="card-body">
                <p class="card-text text-muted"> <?php echo $user['name']; ?> </p>
                <a href="#"><h5 class="card-title"> <?php echo $user['email']; ?> </h5></a>
            </div>
        </a>
</div>

<style>
    body {
        font-style: sans-serif;
    }

    a {
        text-decoration: none;
    }

    a:hover {
        text-decoration: none;
    }

    h3 {
        line-height: 3em;
    }

    .card {
        max-width: 16rem;
    }

    .card:hover {
        box-shadow: 1px 2px 10px lightgray;
        transition: 0.2s;
    }

    .card-header {
        font-size: 13px;
        color: gray;
        background-color: white;
    }

    .text-muted {
        font-size: 11px;
    }

    .card-footer{
        font-weight: bold;
        font-size: 18px;
        background-color: white;
    }
</style>
