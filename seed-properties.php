<?php
/**
 * Seed sample properties for the Ofogh theme.
 * Run via: wp eval-file seed-properties.php
 */

$properties = array(
    array(
        'slug'    => 'sample-villa',
        'title'   => 'ویلای مدرن در نیاوران',
        'content' => 'ویلای مدرن با نمای سنگی، پارکینگ دوخيله و باغ کوچک. پلان باز و نورگیر بزرگ.',
        'meta'    => array(
            '_property_price'   => 8500000000,
            '_property_beds'    => 4,
            '_property_baths'   => 3,
            '_property_area'    => 320,
            '_property_land'    => 500,
            '_property_year'    => 1402,
            '_property_city'    => 'تهران',
            '_property_region'  => 'نیاوران',
            '_property_country' => 'ایران',
            '_property_type'    => 'ویلا',
            '_property_status'  => 'برای فروش',
            '_property_featured' => '1',
        ),
    ),
    array(
        'slug'    => 'apartment-elahieh',
        'title'   => 'آپارتمان لوکس الهیه',
        'content' => 'آپارتمان تمام‌ساخت با کف پارکت بلوط، آشپزخانهٔ اپن و ویوی پانوراما.',
        'meta'    => array(
            '_property_price'   => 4200000000,
            '_property_beds'    => 3,
            '_property_baths'   => 2,
            '_property_area'    => 180,
            '_property_land'    => 0,
            '_property_year'    => 1401,
            '_property_city'    => 'تهران',
            '_property_region'  => 'الهیه',
            '_property_country' => 'ایران',
            '_property_type'    => 'آپارتمان',
            '_property_status'  => 'برای فروش',
            '_property_featured' => '0',
        ),
    ),
    array(
        'slug'    => 'penthouse-elahieh',
        'title'   => 'پنت‌هاوس الهیه',
        'content' => 'پنت‌هاوس دوبلکس با تراس بزرگ و ویوی شهر. طراحی داخلی مدرن.',
        'meta'    => array(
            '_property_price'   => 12000000000,
            '_property_beds'    => 5,
            '_property_baths'   => 4,
            '_property_area'    => 450,
            '_property_land'    => 0,
            '_property_year'    => 1403,
            '_property_city'    => 'تهران',
            '_property_region'  => 'الهیه',
            '_property_country' => 'ایران',
            '_property_type'    => 'پنت‌هاوس',
            '_property_status'  => 'برای فروش',
            '_property_featured' => '1',
        ),
    ),
);

foreach ($properties as $prop) {
    if (get_page_by_path($prop['slug'])) {
        continue;
    }

    $id = wp_insert_post(array(
        'post_type'    => 'property',
        'post_title'   => $prop['title'],
        'post_content' => $prop['content'],
        'post_status'  => 'publish',
        'post_name'    => $prop['slug'],
    ));

    if ($id && !is_wp_error($id)) {
        foreach ($prop['meta'] as $key => $value) {
            update_post_meta($id, $key, $value);
        }
    }
}
