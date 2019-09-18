<?php

/**
 * Plugin name: KD Social Share
 * Description: Social Share
 * Author: Felföldi László
 * Version: 0.0.2
 */

class KDSocialShare {

	private static $instance;
	public static function getInstance() {
		if ( !( self::$instance instanceof KDSocialShare ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
		add_shortcode( 'kd_social_share', [ $this, 'shortcode' ] );

	}

	public function enqueue() {

		wp_register_style( 'kd_social_share_style', plugins_url( 'assets/css/style.css', __FILE__ ) );
		wp_register_script( 'kd_social_share_script', plugins_url( 'assets/js/script.js', __FILE__ ), [ 'jquery' ], true );

	}

	public function shortcode( $atts ) {

		$include = isset( $atts['include'] ) ? explode( ',', $atts['include'] ) : [];
		$exclude = isset( $atts['exclude'] ) ? explode( ',', $atts['exclude'] ) : [];

		global $wp;
		$url = site_url( $wp->request );

		wp_enqueue_style( 'kd_social_share_style' );
		wp_enqueue_script( 'kd_social_share_script' );

		ob_start();

		$links = [
			'facebook' => 'https://www.facebook.com/sharer.php?u=' . $url,
			'twitter' => 'https://twitter.com/intent/tweet?url=' . $url,
			'linkedin' => 'https://www.linkedin.com/shareArticle?mini=true&url=' . $url,
			'pinterest' => 'http://pinterest.com/pin/create/link/?url=' . $url,
			'tumblr' => 'https://www.tumblr.com/widgets/share/tool?canonicalUrl=' . $url,
			'email' => 'mailto:?body=' . $url
		];

		?>

			<div class="kd_social_share">
				<?php foreach( $links as $social => $link ) { ?>

					<?php if ( empty( $include ) && empty( $exclude ) || in_array( $social, $include ) || empty( $include ) && !in_array( $social, $exclude ) ) { ?>
						<a href="<?php echo $link ?>" class="<?php echo $social ?>"></a>
					<?php } ?>

				<?php } ?>
			</div>

		<?php

		return ob_get_clean();

	}

}

KDSocialShare::getInstance();