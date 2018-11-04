<div class="jumbotron">
    <h1>Dashboard</h1>
</div>

<div class="container-fluid">
    <!-- Shows any relevant messages, e.g., if the user has successfully logged in -->
    <?php if (isset($data['messages']['system'])) { echo $data['messages']['system']; } ?>  
    <h2>Hello <?=$data['name']?></h2>
    <p>Welcome to your home page.</p>

</div>