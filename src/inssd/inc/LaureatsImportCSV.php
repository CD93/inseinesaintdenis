<?php
class LaureatsImportCSV {

    // Types supportés
    const allowed_types = array(
        'application/octet-stream',
        'text/csv',
    );

    const csv_header = array(
        'Nom du projet',
        'Nom de l\'association',
        'Thématique',
        'Sous-thématique',
        'Zone de rayonnement',
        'Descriptif du projet',
        'Ambassadeur',
        'Nom du Président',
        'Mail',
        'Facebook',
        'Twitter',
        'Instagram',
        'Lien',
    );

    public function __construct() {
        add_action('admin_menu', array($this, 'addInMenu'));
    }

    // INIT
    function addInMenu() {
        add_menu_page(
            'Import Lauréats',
            'Import Lauréats',
            'edit_pages',
            'import_laureat',
            array($this, 'getImportPage'),
            'dashicons-update',
            30
        );
    }

    function fileParser($file){

        $row = 1;
        $csvArray = array();

        if (($handle = fopen($file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {

                if(1 === $row){
                    if(self::csv_header !== $data){
                        return 'Le fichier csv ne respecte pas la structure définie.';
                    }
                }else{
                    if( count($data) === 13 ){
                        $laureatArray = array(
                            'project_name' => $data[0],
                            'organism_name' => $data[1],
                            'thematique' => $data[2],
                            'sub_thematique' => $data[3],
                            'zone' => $data[4],
                            'text' => $data[5],
                            'ambassador' => $data[6],
                            'director_name' => $data[7],
                            'mail' => $data[8],
                            'facebook' => $data[9],
                            'twitter' => $data[10],
                            'instagram' => $data[11],
                            'website' => $data[12],
                        );
                        $csvArray[] = $laureatArray;
                    }else{
                        return 'Erreur ligne n° ' . $row . ' dans Le fichier csv.';
                    }
                }
                $row++;
            }
            fclose($handle);
        }
        return $csvArray;
    }

    function addDataInBackEnd($csvArray){

        foreach( $csvArray as $laureat){

            $themTermID = term_exists( $laureat['thematique'], 'laureat_thematique' );
            $subThemTermID = term_exists( $laureat['sub_thematique'], 'laureat_sub_thematique' );
            $zoneTermID = term_exists( $laureat['zone'], 'laureat_zone' );

            // Create post object
            $laureatPostArgs = array(
                'post_title'    => wp_strip_all_tags( 'Import : ' . $laureat['project_name'] ),
                'post_content'  => '',
                'post_type'  => 'laureat',
                'post_status'   => 'pending',
                'post_author'   => 1,
            );

            // Insert the post into the database
            $postID = wp_insert_post( $laureatPostArgs );

            if( !empty($laureat['organism_name'])){
                update_field('laureat_organism_name', $laureat['organism_name'], $postID);
            }
            if( !empty($laureat['director_name'])){
                update_field('laureat_director_name', $laureat['director_name'], $postID);
            }
            if( !empty($laureat['text'])) {
                update_field('laureat_text', $laureat['text'], $postID);
            }
            if( !empty($laureat['mail'])) {
                update_field('laureat_email', $laureat['mail'], $postID);
            }
            if( !empty($laureat['ambassador'])) {
                $ambassadorID = intval($laureat['ambassador']);
                if( !empty($ambassadorID) ){
                    $ambassadorPost = get_post($ambassadorID);
                    if( !empty($ambassadorPost) ){
                        update_field('laureat_ambassador', array($ambassadorID), $postID);
                    }
                }
            }
            if( !empty($laureat['website'])) {
                update_field('laureat_website', $laureat['website'], $postID);
            }

            if( !empty($laureat['facebook'] || !empty($laureat['twitter'] ) || !empty($laureat['instagram']) ) ) {
                $socialNetworkArray = array(
                    'facebook' => $laureat['facebook'],
                    'twitter' => $laureat['twitter'],
                    'instagram' => $laureat['instagram'],
                );
                update_field('laureat_social_network', $socialNetworkArray, $postID);
            }

            if( !empty($themTermID)){
                wp_set_object_terms( $postID, array($laureat['thematique']), 'laureat_thematique', true );
            }

            if( !empty($subThemTermID)){
                wp_set_object_terms( $postID, array($laureat['sub_thematique']), 'laureat_sub_thematique', true );
            }

            if( !empty($zoneTermID)){
                wp_set_object_terms( $postID, array($laureat['zone']), 'laureat_zone', true );
            }

        }
    }

    function getImportPage() {
        $errors = null;
        $lines = 0;

        if (isset($_FILES) && isset($_FILES['file']) && $_FILES['file'] != null) {
           $data = $this->fileParser($_FILES['file']['tmp_name']);
           $lines = count($data);
           $this->addDataInBackEnd($data);
        }

        ob_start();
        ?>
        <div class="wrap">
            <?php acf_form(array('')); ?>

            <h1 class="wp-heading-inline">Importer fichier CSV des Lauréats.</h1>

            <?php
            if ( !empty($data) && !is_array($data) ){
                ?>
                <div class="notice notice-error">
                    <p><strong><?php echo $data; ?></strong>
                </div>
                <?php
            }

            if (0 !== $lines) {
                ?>
                <div class="notice notice-success">
                    <p><strong><?php echo $lines; ?> lignes ont été importées !</strong>
                </div>
                <?php
            } else {
                ?>
                <div class="notice notice-warning">
                    <p><strong>Attention : l'upload du fichier remplacera TOUTES les fiches lauréats.</strong>
                </div>
                <hr class="wp-header-end">
                <form action="" method="POST" enctype="multipart/form-data">
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <th scope="row">Fichier CSV d'import</th>
                            <td id="front-static-pages">
                                <input type="file" name="file" />
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="submit">
                        <input type="submit" class="button button-primary" value="Envoyer le fichier" />
                    </div>
                </form>
                <?php
            }
            ?>

            <br class="clear">
        </div>


        <?php
        $content = ob_get_contents();
        ob_end_clean();

        echo $content;
    }
}

new LaureatsImportCSV();
