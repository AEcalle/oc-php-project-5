<?php

ob_start();

?>
<!-- Page Header-->
<header class="masthead" style="background-image: url('../../public/assets/img/home-bg.jpg')">
    <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="site-heading">
                    <h1>Liste des Posts</h1>                  
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main Content-->
<div class="container px-4 px-lg-5">    
    <div class="row gx-4 gx-lg-5 py-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">           
        <table class="table">
            <thead>
                <tr>              
                <th scope="col">Titre</th>
                <th scope="col">Créé le</th>
                <th scope="col">Modifier / Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <tr>                
                <td>Mon premier Post</td>
                <td>16/08/2021</td>
                <td><a href="updatePost.php">Modifier / Supprimer</a></td>
                </tr> 
                <tr>                
                <td>Mon premier Post</td>
                <td>16/08/2021</td>
                <td><a href="updatePost.php"> Modifier / Supprimer</a></td>
                </tr>                
            </tbody>
            </table>
        </div>
    </div>
</div>

<?php 

$content = ob_get_clean();

require('template.php');