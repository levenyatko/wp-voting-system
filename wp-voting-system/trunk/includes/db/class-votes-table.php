<?php
	/**
	 * Votes table class.
	 *
	 * @package WP_Voting_System\DB
	 */

	namespace WP_Voting_System\DB;

	use WP_Voting_System\Interfaces\DB_Table_Interface;

	defined( 'ABSPATH' ) || exit;

	/**
	 * Class Votes_Table
	 */
class Votes_Table implements DB_Table_Interface {

	/**
	 * DB connection object.
	 *
	 * @var \wpdb $wpdb
	 */
	private $wpdb;

	/**
	 * DB charset collate.
	 *
	 * @var string $charset_collate
	 */
	public $charset_collate;

	/**
	 * Current plugin db version.
	 *
	 * @var string $db_version
	 */
	public $db_version;

	/**
	 * Class construct.
	 *
	 * @param \wpdb  $wpdb_object DB connect object.
	 * @param string $db_version DB version.
	 */
	public function __construct( $wpdb_object, $db_version ) {
		$this->wpdb            = $wpdb_object;
		$this->charset_collate = $this->wpdb->get_charset_collate();
		$this->db_version      = $db_version;
	}

	/**
	 * Get table name.
	 *
	 * @return string
	 */
	public function get_table_name() {
		return $this->wpdb->prefix . 'wpvs_votes';
	}

	/**
	 * Create table.
	 *
	 * @return void
	 */
	public function create() {
		$table_name = $this->get_table_name();

		if ( $this->wpdb->get_var( "show tables like '$table_name'" ) !== $table_name ) {
			$sql
				= "CREATE TABLE IF NOT EXISTS $table_name (
                   		id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                   		post_id bigint(20) NOT NULL,
                   		user_id bigint(20) NOT NULL default '0',
                   		vote INT(2) NOT NULL,
                   		timestamp TIMESTAMP NOT NULL,
                   		voting_ip VARCHAR(40) NOT NULL,
                   		PRIMARY KEY (id),
                   		KEY wpvs_post_id (post_id)
                   	) $this->charset_collate;";

			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			dbDelta( $sql );
		}
	}

	/**
	 * Insert new row.
	 *
	 * @param array $data Data to insert.
	 *
	 * @return bool
	 */
	public function insert( $data ) {
		$insert_data = array(
			'post_id'   => intval( $data['post_id'] ),
			'user_id'   => intval( $data['user_id'] ),
			'vote'      => $data['vote'],
			'voting_ip' => $data['user_ip'],
			'timestamp' => $data['time'],
		);

		$result = $this->wpdb->insert(
			self::get_table_name(),
			$insert_data
		);

		return (bool) $result;
	}

	/**
	 * Get filtered data.
	 *
	 * @param array $filter Filter for voting log.
	 * @param int   $limit Limit response.
	 *
	 * @return array
	 */
	public function filter( $filter, $limit = 0 ) {
		$sql        = 'SELECT * FROM %i WHERE ';
		$where      = array();
		$parameters = array(
			self::get_table_name(),
		);

		if ( ! empty( $filter['post_id'] ) ) {
			$where[]      = 'post_id=%d';
			$parameters[] = intval( $filter['post_id'] );
		}

		if ( ! empty( $filter['ip'] ) ) {
			$where[]      = 'voting_ip=%s';
			$parameters[] = $filter['ip'];
		}

		$where_query = implode( ' AND ', $where );
		$sql        .= $where_query;

		if ( ! empty( $limit ) ) {
			$sql         .= ' LIMIT %d';
			$parameters[] = $limit;
		}

		return $this->wpdb->get_results( $this->wpdb->prepare( $sql, $parameters ), ARRAY_A ); //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
	}

	/**
	 * Get filtered data count.
	 *
	 * @param array $filter Filter for voting log.
	 *
	 * @return int
	 */
	public function get_count( $filter ) {
		$sql        = 'SELECT COUNT(id) FROM %i';
		$where      = array();
		$parameters = array(
			self::get_table_name(),
		);

		if ( ! empty( $filter['post_id'] ) ) {
			$where[]      = 'post_id=%d';
			$parameters[] = intval( $filter['post_id'] );
		}

		if ( ! empty( $filter['positive'] ) ) {
			$where[] = 'vote>0';
		}

		if ( ! empty( $filter['negative'] ) ) {
			$where[] = 'vote<0';
		}

		if ( ! empty( $where ) ) {
			$where_query = implode( ' AND ', $where );
			$sql        .= ' WHERE ' . $where_query;
		}

		return $this->wpdb->get_var( $this->wpdb->prepare( $sql, $parameters ) ); //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
	}
}
