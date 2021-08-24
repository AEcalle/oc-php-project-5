<?php

ob_start();

?>
<!-- Page Header-->
<header class="masthead" style="background-image: url('../../public/assets/img/home-bg.jpg')">
    <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="site-heading">
                    <h1>Créer un Post</h1>                  
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main Content-->
<div class="container px-4 px-lg-5">    
    <div class="row gx-4 gx-lg-5 py-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">           
            <form id="contactForm" method="post">
                <div class="form-floating">
                    <input class="form-control" id="author" type="text" placeholder="Auteur" required />
                    <label for="author">Auteur</label>                            
                </div>
                <div class="form-floating">
                    <input class="form-control" id="title" type="text" placeholder="Titre" required />
                    <label for="title">Titre</label>                            
                </div>
                <div class="form-floating">
                    <textarea class="form-control" id="standfirst" placeholder="Chapô" style="height: 12rem" required></textarea>
                    <label for="standfirst">Chapô</label>                            
                </div>                      
                <div class="form-floating">
                    <textarea class="form-control" id="content" placeholder="Contenu" style="height: 24rem" required></textarea>
                    <label for="content">Contenu</label>                            
                </div>                                                            
                <button class="btn btn-primary my-5 text-uppercase" id="submitButton" type="submit">Envoyer</button>
            </form>
        </div>
    </div>
</div>

<?php 

$content = ob_get_clean();

require('template.php');