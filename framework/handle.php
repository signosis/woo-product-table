<?php 

use CA_Framework\App\Notice as Notice;
use CA_Framework\App\Require_Control as Require_Control;

include_once __DIR__ . '/ca-framework/framework.php';

if( ! class_exists( 'WPT_Required' ) ){

    class WPT_Required
    {
        public static $stop_next = 0;
        public function __construct()
        {
            
        }
        public static function fail()
        {

            /**
             * Getting help from configure
             * $config = get_option( WPT_OPTION_KEY );
        $disable_plugin_noti = !isset( $config['disable_plugin_noti'] ) ? true : false;
             */

            $r_slug = 'woocommerce/woocommerce.php';
            $t_slug = WPT_PLUGIN_BASE_FILE; //'woo-product-table/woo-product-table.php';
            $req_wc = new Require_Control($r_slug,$t_slug);
            $req_wc->set_args(['Name'=>'WooCommerce'])
            ->set_download_link('https://wordpress.org/plugins/woocommerce/')
            ->set_this_download_link('https://wordpress.org/plugins/woo-product-table/')
            // ->set_message("this sis is  sdisd sdodso")
            ->set_required()
            ->run();
            $req_wc_next = $req_wc->stop_next();
            self::$stop_next += $req_wc_next;
            
            if( ! $req_wc_next ){
                self::display_notice();
                self::display_common_notice();
            }

            return self::$stop_next;
        }

        /**
         * Normal Notice for Only Free version
         *
         * @return void
         */
        public static function display_notice()
        {
                if( defined( 'WPT_PRO_DEV_VERSION' ) ) return;
                /**
                 * small notice for pro plugin,
                 * charect:
                 * 10 din por por
                 * 
                 */

                $small_notc = new Notice('small2');
                $small_notc->set_message(sprintf( __( '<b>Product Table for Woocommerce (Woo Product Table)</b>: lots of special feature waiting for you. %s.', 'wpt_pro' ), "<a href='https://wooproducttable.com/pricing/'>Get Premium</a>" ));
                $small_notc->set_diff_limit(7);
                $small_notc->show();


                
                // $my_message = 'Discount for <b>Product Table for WooCommerce (Woo Product Table)</b> Plugin. Limited Time.';
                // $offerNc = new Notice('offerapr23');
                // $offerNc->set_title( 'Special Discount' )
                // ->set_diff_limit(10)
                // ->set_type('error')
                // ->set_message( $my_message )
                // ->add_button([
                //     'text' => 'Get Premium',
                //     'type' => 'danager',
                //     'link' => 'https://wooproducttable.com/pricing/'
                // ])
                // ->add_button([
                //     'text' => 'Documentation',
                //     'type' => 'error',
                //     'link' => 'https://wooproducttable.com/documentation/'
                // ])
                // ->show();
                
                

        }

        /**
         * Common Notice for Product table, where no need Pro version.
         *
         * @return void
         */
        private static function display_common_notice()
        {

            /**
             * Notice for UltraAddons
             */
            if ( did_action( 'elementor/loaded' ) ) {
            
                $notc_ua = new Notice('ultraaddons');
                $notc_ua->set_message( sprintf( __( 'There is a special Widget for Product Table at %s. You can try it.', 'wpt_pro' ), "<a href='https://wordpress.org/plugins/ultraaddons-elementor-lite/'>UltraAddons</a>" ) )
                // ->add_button([
                //     'type' => 'warning',
                //     'text' => __( 'Download UltraAddons Elementor', 'wpt_pro' ),
                //     'link' => 'https://wordpress.org/plugins/ultraaddons-elementor-lite/'
                // ])
                ->show();    

            }
        }
    }
}

