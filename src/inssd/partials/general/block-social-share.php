<?php
$pageTitle = get_the_title();
$pageLink = get_the_permalink();
?>
<div class="toolbox-share">
    <h2 class="title-h2 toolbox-share__title">Partager sur les réseaux sociaux</h2>

    <ul class="toolbox-share__list">
        <li class="toolbox-share__item">
            <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $pageLink; ?>&amp;t=<?php echo $pageTitle; ?>" class="toolbox-share__btn"><i class="fab fa-facebook-f"></i></a>
        </li>
        <li class="toolbox-share__item">
            <a target="_blank" href="http://twitter.com/share?url=<?php echo $pageLink; ?>&amp;text=<?php echo $pageTitle; ?>" class="toolbox-share__btn"><i class="fab fa-twitter"></i></a>
        </li>
        <li class="toolbox-share__item">
            <a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $pageLink; ?>&amp;title=<?php echo $pageTitle; ?>&amp;summary=" class="toolbox-share__btn"><i class="fab fa-linkedin"></i></a>
        </li>
        <li class="toolbox-share__item">
            <a href="mailto:?subject=<?php echo $pageTitle; ?>&amp;body=<?php echo $pageLink; ?>" class="toolbox-share__btn"><i class="far fa-envelope"></i></a>
        </li>
    </ul>
</div>