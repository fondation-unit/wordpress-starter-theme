<?php
/**
 * Class for rendering Wordpress navigation in Bootstrap style
 */

class Pagination
{
	public function __construct() { }

	public static function render($paged, $max_num_pages, $echo = true)
	{
		$largerInt = 999999999; // need an unlikely integer
		$pages = paginate_links([
			'base'      => str_replace($largerInt, '%#%', esc_url(get_pagenum_link($largerInt))),
			'format'    => '?paged=%#%',
			'current'   => max(1, $paged),
			'total'     => $max_num_pages,
			'type'      => 'array',
			'prev_next' => false,
		]);
		if (is_array($pages)) {
			$paged = ($paged == 0) ? 1 : $paged;
			$pagination = '<ul class="pagination d-flex justify-content-center">';
			foreach ($pages as $page) {
				//$page = strip_tags($page);
				$pagination .= '<li class="page-item">'  . str_replace('page-numbers',
						'page-link', $page) . '</li>';
			}
			$pagination .= '</ul>';
			if ($echo) {
				echo $pagination;
			} else {
				return $pagination;
			}
		}
	}
}
