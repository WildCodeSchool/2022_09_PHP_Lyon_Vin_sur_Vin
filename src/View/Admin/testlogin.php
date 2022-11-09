        <div class="row">
    <div class="col-md-6 offset-md-3">
        <h1>Log in</h1>
        <p>Enter credentials below to be connected.</p>
        <form method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" >
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" >
            </div>
            <button type="submit" class="btn btn-success">Log me in</button>
            <a role="button" class="btn btn-danger align-self-center" href="/register">Première inscription</i></a>
        </form>
    </div>
</div>

<?php
session_start();
    if (isset($_SESSION['admin_id'])) {
        $id = $_SESSION['admin_id'];
        $adminManager = new AdminManager();
        $admin = $adminManager->getUserById($id);
        echo 'Welcome ' . $admin['name'];
    } else {
        echo 'Click here to log in (link to login form)';
    }