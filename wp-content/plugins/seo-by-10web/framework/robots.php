<?php
class WDSeo_Robots {
  /**
   * Options instance.
   *
   * @var WD_SEO_Options
   */
  public $options = null;
  
  /**
   * WDSeo_Site constructor.
   */
  public function __construct() {
    $this->options = new WD_SEO_Options();
    add_action('init', array( $this, 'robots_rewrite' ), 12); /*After options are set*/
    add_action('query_vars', array( $this, 'robots_query_vars' ));
    add_action('template_include', array( $this, 'robots_include_template' ));
    add_filter('redirect_canonical', array( $this, 'robots_canonical'), 10, 2 );
  }
  
  /**
   * Rewrite for robots.txt
   */
  public function robots_rewrite() {
    if (isset($this->options->enable_robots) && $this->options->enable_robots == '1') {
      add_rewrite_rule( '^robots\.txt', '?wdseo_robots=1', 'top' );
    }
  }

  /**
   * Filter the query variable
   */
  public function robots_query_vars($vars) {
    if (isset($this->options->enable_robots) && $this->options->enable_robots == '1') {
      $vars[] = 'wdseo_robots';
    }
    return $vars;
  }

  /**
   * Include template-robots.php
   */
  public function robots_include_template( $template ) {
    if( get_query_var( 'wdseo_robots' ) === '1' && isset($this->options->enable_robots) && $this->options->enable_robots == '1') {
      $wdseo_robots = WD_SEO_DIR . '/site/template-robots.php';
      if( file_exists( $wdseo_robots ) ) {
        return $wdseo_robots;
      }
    }
    return $template;
  }
  
  /**
   * Canonical redirect for robots.txt
   */
  public function robots_canonical($redirect_url, $requested_url) {
    if (isset($this->options->enable_robots) && $this->options->enable_robots == '1') {
      if ($redirect_url == get_home_url().'/robots.txt/') {
        return false;
      } else {
        return $redirect_url;
      }
    }
  }
	
}

$robots = new WDSeo_Robots();
