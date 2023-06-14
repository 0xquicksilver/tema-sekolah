<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
add_theme_support('post-thumbnails');

// function my_theme_enqueue_styles()
// {
//     wp_enqueue_style(
//         'style',
//         get_template_directory_uri() . '/assets/tailwindcss.css'
//     );
//     wp_enqueue_script(
//         'main',
//         get_template_directory_uri() . '/assets/main.js',
//         ['jquery'],
//         '1.0.0',
//         true
//     );
// }
// add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');

function my_theme_register_menus()
{
    register_nav_menus([
        'primary' => __('Primary Menu', 'my_theme'),
    ]);
}
add_action('after_setup_theme', 'my_theme_register_menus');

function my_excerpt_length($length)
{
    return 30;
}
add_filter('excerpt_length', 'my_excerpt_length');

function get_guru_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'guru';
    $results = $wpdb->get_results("SELECT * FROM $table_name");
    return $results;
}

function get_sekolahan()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'sekolahan';
    $results = $wpdb->get_results("SELECT * FROM $table_name");
    return $results;
}

function pendaftaran_form_handler()
{
    // Cek apakah form telah disubmit
    if (isset($_POST['submit'])) {
        // Cek apakah semua field sudah diisi
        if (!empty($_POST['nama_lengkap_siswa'])) {
            // Input data ke dalam tabel kustom
            global $wpdb;

            $columns = [
                'status_anak_dalam_keluarga',
                'nama_lengkap_siswa',
                'nama_panggilan_siswa',
                'nomor_induk_asal',
                'nisn',
                'jenis_kelamin',
                'agama',
                'tempat_tanggal_lahir',
                'anak_ke',
                'alamat_siswa',
                'ra_tk_asal_nama_sekolah',
                'ra_tk_asal_alamat_sekolah',
                'nama_lengkap_ayah_kandung',
                'nama_lengkap_ibu_kandung',
                'alamat_ayah_kandung',
                'alamat_ibu_kandung',
                'pekerjaan_ayah_kandung',
                'pekerjaan_ibu_kandung',
                'pendidikan_ayah_kandung',
                'pendidikan_ibu_kandung',
                'penghasilan_ayah_kandung',
                'penghasilan_ibu_kandung',
                'telp_kandung',
                'nama_lengkap_ayah_wali',
                'nama_lengkap_ibu_wali',
                'alamat_ayah_wali',
                'alamat_ibu_wali',
                'pekerjaan_ayah_wali',
                'pekerjaan_ibu_wali',
                'pendidikan_ayah_wali',
                'pendidikan_ibu_wali',
                'penghasilan_ayah_wali',
                'penghasilan_ibu_wali',
                'telp_wali',
            ];

            $values = [];
            foreach ($columns as $col) {
                $values[] = isset($_POST[$col]) ? $_POST[$col] : '';
            }

            $table_name = $wpdb->prefix . 'pendaftaran';
            $result = $wpdb->insert(
                $table_name,
                array_combine($columns, $values)
            );

            // Redirect ke halaman sukses
            // $redirect_url = add_query_arg( 'status', 'sukses' );
            // wp_redirect( $redirect_url );
            // $wpdb->last_error
            $redirect_url = add_query_arg('status', 'sukses');
            if ($result === false) {
                echo 'Terjadi error saat melakukan operasi insert: ' .
                    $wpdb->last_error;
            } else {
                wp_redirect($redirect_url);
                exit();
            }
            exit();
        } else {
            // Tampilkan pesan error jika field belum diisi semua
            echo '<div class="error">Silahkan isi semua field</div>';
        }
    }
}

function register_my_menu()
{
    register_nav_menu('home-menu', __('Home Menu'));
}
add_action('init', 'register_my_menu');

function formatTanggalWaktu($tanggalWaktu)
{
    $options = [
        'year' => 'numeric',
        'month' => 'long',
        'day' => 'numeric',
        'hour' => 'numeric',
        'minute' => 'numeric',
    ];
    $tanggal = new DateTime($tanggalWaktu);
    return $tanggal->format('d F Y H:i');
}

function get_image_attachments()
{
    $args = [
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'posts_per_page' => -1,
        'post_status' => 'any',
    ];

    $attachments_query = new WP_Query($args);

    $attachments = [];

    if ($attachments_query->have_posts()) {
        while ($attachments_query->have_posts()) {
            $attachments_query->the_post();
            $attachments[] = [
                'url' => wp_get_attachment_url(get_the_ID()),
                'title' => get_the_title(),
                'caption' => get_the_excerpt(),
                'alt' => get_post_meta(
                    get_the_ID(),
                    '_wp_attachment_image_alt',
                    true
                ),
            ];
        }
        wp_reset_postdata();
    }

    return $attachments;
}

// Fungsi untuk membuat menu saat tema diaktifkan
function create_custom_menus() {
    $menu_name = 'Menu Utama';
    $menu_id = wp_create_nav_menu($menu_name);

    $menu_name_home = 'Menu Home';
    $menu_id_home = wp_create_nav_menu($menu_name_home);

    $locations = get_theme_mod('nav_menu_locations');
    // var_dump($locations);
    $locations['primary'] = $menu_id;
    $locations['home-menu'] = $menu_id_home;
    set_theme_mod('nav_menu_locations', $locations);
}
add_action('after_switch_theme', 'create_custom_menus');

// Fungsi untuk menghapus menu saat tema dinonaktifkan
function delete_custom_menus() {
    $menu_name = 'Menu Utama';
    $menu = get_term_by('name', $menu_name, 'nav_menu');
    if ($menu) {
        wp_delete_nav_menu($menu->term_id);
    }

    $menu_name_home = 'Menu Home';
    $menu_home = get_term_by('name', $menu_name_home, 'nav_menu');
    if ($menu_home) {
        wp_delete_nav_menu($menu_home->term_id);
    }
}
add_action('switch_theme', 'delete_custom_menus');
