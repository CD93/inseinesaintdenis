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
        $headings = array( 'Nom', 'Prenom', 'Email', 'Téléphone', 'Ville');
        // output the column headings
        fputcsv($output, $headings );
        // get all simple products where stock is managed
        $args = array(
            'post_type'			=> 'tribe_organizer',
            'post_status' 		=> 'publish',
            'posts_per_page' 	=> -1,
            'orderby'			=> 'name',
            'order'				=> 'ASC',
        );

        $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post();
            $name = get_field('nom_amb');
            $firstName = get_field('prenom_ambassadeur');
            $email = get_field('mail_amb');

            if( !empty($name) || !empty($firstName) || !empty($email) ){
                $row = array( $name, $firstName, $email, get_field('tel_amb'), get_field('ville_amb') );
                fputcsv($output, $row);
            }
        endwhile;
    }

}
new ExcelAmbassadors();