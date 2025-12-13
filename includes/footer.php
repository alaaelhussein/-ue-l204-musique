<?php
// AS: shared footer layout
// AS: keeps links stable by targeting project-root paths
$rootUrl = rtrim(dirname($_SERVER['SCRIPT_NAME'], 2), '/\\');
?>
        </div> <!-- .container -->
    </main>

    <footer class="site-footer">
        <div class="container site-footer-inner">
            <div class="site-footer-title">
                Médiathèque musicale
            </div>

            <div class="site-footer-text">
                Mini projet étudiant — Gestion d’un catalogue de CD
            </div>

            <nav class="site-footer-nav">
                <a href="<?php echo $rootUrl; ?>/index.php" class="site-footer-link">Accueil</a>
                <a href="<?php echo $rootUrl; ?>/pages/login.php" class="site-footer-link">Connexion</a>
                <a href="<?php echo $rootUrl; ?>/pages/liste_albums.php" class="site-footer-link">Catalogue</a>
            </nav>

            <div class="site-footer-copy">
                © <?= date('Y'); ?> — Tous droits réservés.
            </div>
        </div>
    </footer>
</div> <!-- .main-wrapper -->
</body>
</html>

