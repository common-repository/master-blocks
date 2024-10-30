<?php

namespace Master_Blocks\components\GoogleMap;

use const Master_Blocks\core\MARKERS_DIR;

use function Master_Blocks\core\get_config;
use function Master_Blocks\core\get_plugin_url;

class GoogleMap {
	public function __construct() {
		add_shortcode( 'google_map', [ $this, 'create_map_shortcode' ] );
	}

	public function get_styles( $styles ) {
		$config = get_config( 'components/GoogleMap/styles.json' );

		return json_encode( $config[ $styles ]['value'] );
	}

	public function create_map_shortcode( $atts ) {
		if ( ! get_option( 'master_blocks_google_api_key' ) ) {
			return '<p class="warning">' . esc_html__( "You don't have an API or it not work!", 'master-blocks' ) . '</p>';
		}

		$info_title     = $atts['info1'] ? : '';
		$info_content   = $atts['info2'] ? : '';
		$info_max_width = $atts['info3'] ? : 400;

		ob_start();
		?>
		<div id="master-blocks-google-map" style="height: <?php echo $atts['height'] . 'px' ?>;"></div>
		<script>
			const center = {
				lat:<?php echo $atts['lat'] ?>,
				lng: <?php echo $atts['lng'] ?>
			};

			const config = {
				center,
				zoom: <?php echo $atts['zoomlevel'] ?>,
				styles: <?php echo $this->get_styles( $atts['styles'] ) ?>,
				zoomControl: <?php echo $atts['zoom'] ?>,
				streetViewControl: <?php echo $atts['streetview'] ?>,
				fullscreenControl: <?php echo $atts['fullscreen'] ?>,
				mapTypeControl: <?php echo $atts['maptype'] ?>,
				gestureHandling: "cooperative"
			};

			const map = new google.maps.Map(document.getElementById("master-blocks-google-map"), config);

			const marker = new google.maps.Marker({
				position: center,
				map: map,
				icon: "<?php echo get_plugin_url( MARKERS_DIR . $atts['icon'] ) ?>"
			});

			const contentString = `<div id="content" class="master-blocks-info-window"> <div id="siteNotice"> </div> <h5 class="master-blocks-info-window__title"><?php echo $info_title ?></h5> <div id="bodyContent" class="master-blocks-info-window__content"> <?php echo $info_content ?> </div> </div>`;

			const info = new google.maps.InfoWindow({
				content: contentString,
				maxWidth: <?php echo $info_max_width ?>
			});

			marker.addListener("click", function() {
				return info.open(map, marker);
			});
		</script>
		<?php
		return ob_get_clean();
	}
}
