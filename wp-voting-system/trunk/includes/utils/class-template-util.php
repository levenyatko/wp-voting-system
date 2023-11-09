<?php
	/**
	 * Util to load template files.
	 *
	 * @package WP_Voting_System\Utils
	 */

	namespace WP_Voting_System\Utils;

	defined( 'ABSPATH' ) || exit;

	/**
	 * Class Template_Util
	 */
class Template_Util {

	/**
	 * Include plugin template file.
	 *
	 * @param string $template_name Template name to include.
	 * @param string $context Template context.
	 * @param array  $args Passed args.
	 *
	 * @return void
	 */
	public static function include_template( $template_name, $context, $args = array() ) {

		if ( 'admin' === $context ) {
			include_once WP_VS_PLUGIN_DIR . "templates/admin/{$template_name}.php";
			return;
		}

		if ( 'public' === $context ) {
			$file_path = self::search_template_path( $template_name );
			include_once $file_path;
		}
	}

	/**
	 * Get template content as string.
	 *
	 * @param string $template_name Template name to include.
	 * @param string $context Template context.
	 * @param array  $args Passed args.
	 *
	 * @return string
	 */
	public static function get_template_html( $template_name, $context, $args = array() ) {
		ob_start();
		self::include_template( $template_name, $context, $args );
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}

	/**
	 * Search template in theme and plugin folders.
	 *
	 * @param string $template_name Public template name we need to find.
	 *
	 * @return string
	 */
	private static function search_template_path( $template_name ) {
		$file_path = $template_name . '.php';

		$template_name = 'wpvs/' . $file_path;
		$template_loc  = locate_template( array( $template_name ) );

		$template_def = 'templates/public/' . $file_path;

		return ( '' !== $template_loc && file_exists( $template_loc ) ) ? $template_loc : WP_VS_PLUGIN_DIR . $template_def;
	}
}
