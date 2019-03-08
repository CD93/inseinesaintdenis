<?php
class ExcelAmbassadors {
    public function __construct() {
        add_action('admin_menu', array($this, 'addInMenu'));
        add_action('admin_init',  array($this, 'export_admin_init'));
    }

    function addInMenu() {
        add_menu_page(
            'Excel',
            'Export Ambassadeurs',
            'edit_pages',
            'inssd-export',
            array($this, 'getMainPage'),
            'dashicons-update',
            30
        );

    }

    function getMainPage() {
        ?>
        <div class="wrap">

            <h2>Exportateur d'ambassadeurs</h2>
            <p>Cliquer sur le bouton pour exporter, dans un fichier CSV, la liste des ambassadeurs avec leur information.</p>

            <form method="post" id="export-form" action="">
                <?php submit_button('Exporter', 'primary', 'download_csv' ); ?>
            </form>

        </div>
        <?php
    }

    function export_admin_init() {
        global $plugin_page;
        if ( isset($_POST['download_csv']) && $plugin_page == 'inssd-export' ) {

            $this->generate_file_csv();

            die();
        }
    }

    function generate_file_csv() {
        // output headers so that the file is downloaded rather than displayed
        header('Content-Type: text/csv; charset=utf-8');
        // set file name with current date
        header('Content-Disposition: attachment; filename=ambassadeurs-inssd-' . date('d-m-Y') . '.csv');
        // create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');
        // set the column headers for the csv
        $headings = array('Genre', 'Nom', 'Prénom', 'Email', 'Téléphone', 'Rue', 'Ville', 'Type adhésion', 'Fonction', 'Société/Organisme', 'Domaine', 'Facebook', 'Twitter', 'Instagram', 'Linkedin');
        // output the column headings
        fputcsv($output, $headings );
        // get all simple products where stock is managed
        $args = array(
            'post_type'			=> 'tribe_organizer',
            'post_status' 		=> 'publish',
            'posts_per_page' 	=> -1,
            'orderby'			=> 'date',
            'order'				=> 'DESC',
        );

        $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post();

            $genre = get_field('genre');
            if( empty($genre)){
                $genre = 'Non binaire';
            }

            $name = get_field('nom_amb');
            $firstName = get_field('prenom_ambassadeur');
            $email = get_field('mail_amb');
            $tel = get_field('tel_amb');

            if( empty($tel)){
                $tel = 'Non communiqué';
            }

            $street = get_field('rue_amb');
            if( empty($street)){
                $street = 'Non communiqué';
            }

            $city = get_field('ville_amb');
            if( empty($city)){
                $city = 'Non communiqué';
            }

            $facebook = get_field('amb_facebook');
            if( empty($facebook)){
                $facebook = 'Non communiqué';
            }

            $twitter = get_field('amb_twitter');
            if( empty($twitter)){
                $twitter = 'Non communiqué';
            }

            $instagram = get_field('amb_instagram');
            if( empty($instagram)){
                $instagram = 'Non communiqué';
            }

            $linkedin = get_field('amb_linkedin');
            if( empty($linkedin)){
                $linkedin = 'Non communiqué';
            }

            $adhere = get_field('adhere');
            if( !empty($adhere)){
                if( $adhere === 'ad_struct'){
                    $adhere = 'au titre d’une structure privée ou publique, d’une association, d’une institution';
                }else if( $adhere === 'ad_perso'){
                    $adhere = 'à titre personnel';
                }
            }else{
                $adhere = 'Non communiqué';
            }

            $fonction = get_field('fonction');
            if( empty($fonction)){
                $fonction = 'Non communiqué';
            }

            $company = get_field('soc_org');
            if( empty($company)){
                $company = 'Non communiqué';
            }

            $sector = get_field('sec_act');
            if( !empty($sector)){
                $sector = getDomains($sector);
            }else{
                $sector = 'Non communiqué';
            }

            if( !empty($name) || !empty($firstName) || !empty($email) ){
                $row = array($genre, $name, $firstName, $email, $tel, $street, $city, $adhere, $fonction, $company, $sector, $facebook, $twitter, $instagram, $linkedin );
                fputcsv($output, $row);
            }
        endwhile;
    }

}
new ExcelAmbassadors();