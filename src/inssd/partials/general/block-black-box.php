<?php $customFields = get_query_var('box-fields'); ?>
<div class="push-more push-more--<?php echo $customFields['type_de_black_box']; ?> push-more--black">
    <img class="push-more__picto" src="<?php echo get_template_directory_uri(); ?>/img/common/picto-<?php echo $customFields['type_de_black_box']; ?>.svg" />
    <div class="push-more__text">
        <h2 class="push-more__title title-h2"><?php echo $customFields['titre_black_box']; ?></h2>
        <p class="push-more__specs"><?php echo $customFields['sous-titre_black_box']; ?></p>
    </div>

    <p class="push-more__desc"><?php echo $customFields['texte_de_la_black_box']; ?></p>
    <a href="<?php echo $customFields['lien_de_la_black_box']; ?>" class="btn btn--round push-more__btn"><?php echo $customFields['texte_bouton_black_box']; ?></a>
</div>